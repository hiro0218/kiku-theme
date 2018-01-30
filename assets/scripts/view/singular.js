import api from '@scripts/api';
import mokuji from '@scripts/module/mokuji';
import common from '@scripts/module/common';

// vue components
import amazonProduct from '@components/amazon-product.vue';
import entryBreadcrumb from '@components/entry-breadcrumb.vue';
import entryCategory from '@components/entry-category.vue';
import entryTag from '@components/entry-tag.vue';
import entryTime from '@components/entry-time.vue';
import entryShare from '@components/entry-share.vue';
import entryRelated from '@components/entry-related.vue';
import entryPager from '@components/entry-pager.vue';

export default {
  init() {
    new Vue({
      el: '#app',
      components: {
        amazonProduct,
        entryCategory,
        entryTag,
        entryTime,
        entryBreadcrumb,
        entryShare,
        entryRelated,
        entryPager,
      },
      data: {
        loaded: false,
        link: '',
        title: '',
        content: '',
        date: {
          publish: null,
          modified: null,
        },
        categories: [],
        amazon_product: null,
        tags: [],
        relateds: [],
        pagers: {},
      },
      watch: {
        loaded: function() {
          this.$nextTick().then(() => {
            var element = this.$el.querySelector('.entry-content');
            mokuji.init(element);
            common.addExternalLink(element);
            common.setTableContainer(element);
            common.zoomImage(element);
            Prism.highlightAll();
            this.viewAttachedInfo();
            NProgress.done();
          });
        },
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
      methods: {
        requestPostData: function() {
          var response = WP.page_type === 'posts' ? api.getPosts(WP.page_id) : api.getPages(WP.page_id);

          response.then(response => {
            let json = response.data;

            this.setDatetime(json);
            this.link = json.link;
            this.title = json.title.rendered;
            this.content = json.content.rendered;
            this.categories = json.categories || this.categories;
            this.tags = json.tags || this.tags;
            this.amazon_product = json.amazon_product || this.amazon_product;
            this.loaded = true;
          });
        },
        requestAttachedData: function(target) {
          NProgress.start();
          var response = api.getAttachData(WP.page_id);

          response
            .then(response => {
              let json = response.data;
              this.relateds = json.related || this.relateds;
              this.pagers = json.pager || this.pagers;

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

          var target = this.$el.querySelector('.entry-footer');
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
          observer.observe(target);
        },
      },
    });
  },
};
