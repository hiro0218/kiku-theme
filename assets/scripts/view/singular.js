import api from '@scripts/api';
import mokuji from '@scripts/module/mokuji';
import common from '@scripts/module/common';

// vue components
import amazonProduct from '@components/amazon-product.vue';
import entryRelated from '@components/entry-related.vue';
import entryPager from '@components/entry-pager.vue';

export default {
  init() {
    var entry = document.querySelector('.entry-content');
    common.addExternalLink(entry);
    common.setTableContainer(entry);
    mokuji.init(entry);
    Prism.highlightAll();

    new Vue({
      el: '#app',
      components: {
        amazonProduct,
        entryRelated,
        entryPager,
      },
      data: {
        loaded: false,
        date: {
          publish: null,
          modified: null,
          timeAgo: null,
        },
        categories: null,
        amazon_product: null,
        tags: null,
        relateds: null,
        pagers: null,
      },
      beforeCreate: function() {
        NProgress.start();
      },
      created: function() {
        this.requestPostData();
        NProgress.inc();
      },
      mounted: function() {
        NProgress.done();
      },
      watch: {
        loaded: function() {
          // After displaying DOM
          this.$nextTick(function() {
            var element = this.$el.querySelector('.entry-content');
            common.zoomImage(element);
            this.viewAttachedInfo();
          });
        },
      },
      methods: {
        requestPostData: function() {
          var response = WP.page_type === 'posts' ? api.getPosts(WP.page_id) : api.getPages(WP.page_id);

          response
            .then(response => {
              let json = response.data;

              this.setDatetime(json);
              this.categories = json.categories;
              this.tags = json.tags;
              this.amazon_product = json.amazon_product;

              return true;
            })
            .then(result => {
              this.loaded = result;
            });
        },
        requestAttachedData: function(target) {
          NProgress.start();
          var response = api.getAttachData(`/wp-json/kiku/v1/post/${WP.page_id}`);

          response
            .then(response => {
              let json = response.data;

              if (json.related.length !== 0) {
                this.relateds = json.related;
              } else {
                var related = target.querySelector('.related');
                related.classList.add('element-hide');
              }

              if (json.pager.length !== 0) {
                this.pagers = json.pager;
              } else {
                var pager = target.querySelector('.pager');
                pager.classList.add('element-hide');
              }

              return true;
            })
            .then(result => {
              NProgress.done();
            });
        },
        setDatetime: function(json) {
          this.date.publish = json.date;
          this.date.modified = this.isSameDay(json.date, json.modified) ? null : json.modified;
        },
        isSameDay: function(publish, modified) {
          return new Date(publish).toDateString() === new Date(modified).toDateString();
        },
        viewAttachedInfo: function() {
          if (WP.page_type !== 'posts') {
            return;
          }

          var clientHeight = document.documentElement.clientHeight;
          var observer = new IntersectionObserver(changes => {
            changes.forEach(change => {
              var rect = change.target.getBoundingClientRect();
              var isShow =
                (0 < rect.top && rect.top < clientHeight) ||
                (0 < rect.bottom && rect.bottom < clientHeight) ||
                (0 > rect.top && rect.bottom > clientHeight);
              if (isShow) {
                this.requestAttachedData(change.target);
                observer.unobserve(change.target);
              }
            });
          });
          var target = document.querySelector('.attached-info');
          observer.observe(target);
        },
      },
      filters: {
        formatDate: function(date) {
          if (!date) {
            return;
          }
          if (typeof date === 'string') {
            date = new Date(date);
          }
          return date
            .toISOString()
            .split('T')[0]
            .replace(/-/g, '/');
        },
      },
    });
  },
};
