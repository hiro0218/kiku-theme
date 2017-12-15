/* global Prism WP */
import Vue from 'vue';
import axios from 'axios';
import NProgress from 'nprogress/nprogress.js';
import mokuji from '@scripts/module/mokuji';
import common from '@scripts/module/common';

// vue components
import amazonProduct from '@components/amazon-product.vue';
import entryRelated from '@components/entry-related.vue';
import entryPager from '@components/entry-pager.vue';

export default {
  init() {
    var post_id = WP.page_id;
    var page_type = WP.page_type;
    if (!post_id || !page_type) {
      return;
    }
    var entry = document.querySelector('.entry-content');
    common.addExternalLink(entry);
    common.setTableContainer(entry);
    mokuji.init(entry);
    Prism.highlightAll();

    var app = new Vue({
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
      beforeCreate: function () {
        NProgress.start();
      },
      created: function () {
        this.requestPostData(post_id, page_type);
        NProgress.inc();
      },
      mounted: function () {
        NProgress.done();
      },
      watch: {
        loaded: function (data) {
          var self = this;
          // After displaying DOM
          this.$nextTick(function() {
            var element = this.$el.querySelector('.entry-content');
            common.zoomImage(element);
            self.viewAttachedInfo();
          });
        }
      },
      methods: {
        requestPostData: function (post_id, page_type) {
          var self = this;

          axios.defaults.baseURL = `/wp-json/wp/v2/${page_type}/${post_id}`;
          axios.get()
            .then(function(response) {
              let json = response.data;

              self.setDatetime(json);
              if (json.hasOwnProperty('categories') && json.categories.length !== 0) {
                self.categories = json.categories;
              }
              if (json.hasOwnProperty('tags') && json.tags.length !== 0) {
                self.tags = json.tags;
              }
              self.amazon_product = json.amazon_product;

              return true;
            })
            .then(function(result) {
              self.loaded = true;
            });
        },
        requestAttachedData: function (post_id, page_type) {
          var self = this;
          NProgress.start();

          axios.defaults.baseURL = `/wp-json/kiku/v1/post/${post_id}`;
          axios.get()
            .then(function(response) {
              let json = response.data;

              if (json.hasOwnProperty('related') && json.related.length !== 0) {
                self.relateds = json.related;
              }
              self.pagers = json.pager;

              return true;
            })
            .then(function(result) {
              NProgress.done();
            });
        },
        setDatetime: function (json) {
          this.date.publish = json.date;
          this.date.modified = (this.isSameDay(json.date, json.modified)) ? null : json.modified;
        },
        isSameDay: function (publish, modified) {
          return new Date(publish).toDateString() == new Date(modified).toDateString();
        },
        viewAttachedInfo: function () {
          var self = this;
          if (page_type === 'posts') {
            var clientHeight = document.documentElement.clientHeight;
            var observer = new IntersectionObserver(function(changes) {
              changes.forEach(function(change) {
                var rect = change.target.getBoundingClientRect();
                if (0 < rect.top && rect.top < clientHeight) {
                  self.requestAttachedData(post_id, page_type);
                  observer.unobserve(change.target);
                }
              });
            });
            var target = document.querySelector('.attached-info');
            observer.observe(target);
          }
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
          return date.toISOString().split('T')[0].replace(/-/g , '/');
        },
        escapeBrackets: function(text) {
          return text.replace(/</g, '&lt;').replace(/>/g, '&gt;');
        },
      }
    });
  },
};
