import { mapState } from 'vuex';
import { MODEL_POST } from '@scripts/models';
import api from '@scripts/api';
import mokuji from '@scripts/module/mokuji';
import common from '@scripts/module/common';

// vue components
import entrySingular from '@components/entry-singular.vue';

export default {
  init() {
    new Vue({
      el: '#app',
      components: {
        entrySingular,
      },
      data() {
        return {
          page_type: WP.page_type,
        };
      },
      computed: mapState(['post', 'advertise']),
      created: function() {
        this.requestAds();
        this.requestPostData();
      },
      methods: {
        requestPostData: function() {
          var response = WP.page_type === 'post' ? api.getPosts(WP.page_id) : api.getPages(WP.page_id);

          response
            .then(response => {
              let json = response.data;
              let post = MODEL_POST;

              post.link = json.link;
              post.title = json.title.rendered;
              post.date.publish = json.date;
              post.date.modified = this.isSameDay(json.date, json.modified) ? null : json.modified;
              post.content = json.content.rendered;
              post.categories = json.categories || post.categories;
              post.tags = json.tags || post.tags;
              post.amazon_product = json.amazon_product || post.amazon_product;

              this.$store.commit('setPost', post);
            })
            .then(() => {
              this.$nextTick().then(() => {
                var element = this.$el.querySelector('.entry-content');
                mokuji.init(element);
                common.addExternalLink(element);
                common.setTableContainer(element);
                common.zoomImage(element);
                Prism.highlightAll();
                this.viewAttachedInfo();
                const ads = element.querySelector('#ads1');
                if (ads) {
                  this.insertArticleAds(ads);
                }
              });
            });
        },
        requestAds: function() {
          api.getAds().then(response => this.setAds(response));
        },
        requestAttachedData: function(target) {
          var response = api.getAttachData(WP.page_id);

          response.then(response => {
            let json = response.data;

            this.$store.commit('setPostAttach', {
              relateds: json.related || MODEL_POST.attach.relateds,
              pagers: json.pager || MODEL_POST.attach.pagers,
            });
          });
        },
        setAds: function(response) {
          let data = response.data;
          let ads1 = {};
          if (data.ads1.display.split(',').includes(WP.page_type)) {
            ads1 = {
              content: data.ads1.content,
              script: data.ads1.script,
            };
          }

          let ads2 = {};
          if (data.ads2.display.split(',').includes(WP.page_type)) {
            ads2 = {
              content: data.ads2.content,
              script: data.ads2.script,
            };
          }

          this.$store.commit('setAdvertise', { ads1, ads2 });
        },
        insertArticleAds: function(ads) {
          ads.innerHTML = this.advertise.ads1.content;
          eval(this.advertise.ads1.script);
        },
        isSameDay: function(publish, modified) {
          return new Date(publish).toDateString() === new Date(modified).toDateString();
        },
        viewAttachedInfo: function() {
          if (WP.page_type !== 'post') {
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
