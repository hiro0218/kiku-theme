/* global Prism WP */
import Vue from 'vue';
import NProgress from 'nprogress/nprogress.js';
import inView from 'in-view';
import mokuji from '../module/mokuji';
import common from '../module/common';

// vue components
import entryRelated from '../../../components/entry-related.vue';

module.exports = {
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
        entryRelated,
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
        requestXHR: function(url, callback) {
          var xhr = new XMLHttpRequest();
          xhr.onreadystatechange = function(){
            if (this.readyState === 4 && this.status === 200) {
              var response = this.response;

              if (typeof(response) === 'string') {
                response = JSON.parse(response);
              }

              callback(response);
            }
          };
          xhr.open('GET', url, true);
          xhr.responseType = 'json';
          xhr.send();
        },
        requestPostData: function (post_id, page_type) {
          var self = this;
          self.requestXHR(`/wp-json/wp/v2/${page_type}/${post_id}`, function(json) {
            self.setDatetime(json);
            if (json.hasOwnProperty('categories') && json.categories.length !== 0) {
              self.categories = json.categories;
            }
            if (json.hasOwnProperty('tags') && json.tags.length !== 0) {
              self.tags = json.tags;
            }
            self.amazon_product = json.amazon_product;
            self.loaded = true;
          });
        },
        requestAttachedData: function (post_id, page_type) {
          if (page_type !== 'posts') {
            return;
          }

          var self = this;
          NProgress.start();
          self.requestXHR(`/wp-json/kiku/v1/post/${post_id}`, function(json) {
            if (json.hasOwnProperty('related') && json.related.length !== 0) {
              self.relateds = json.related;
            }
            self.pagers = json.pager;
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
          inView('#article-attached-info').once('enter', function() {
            self.requestAttachedData(post_id, page_type);
          });
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
