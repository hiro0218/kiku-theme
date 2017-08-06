/* global Prism */
import Promise from 'promise-polyfill';
if (!window.Promise) {
  window.Promise = Promise;
}
import 'whatwg-fetch';
import Vue from 'vue';
import NProgress from 'nprogress/nprogress.js';
import ago from 's-ago';
import mokuji from '../module/mokuji';
import common from '../module/common';

module.exports = {
  init() {
    var article = document.getElementsByTagName('article')[0];
    var post_id = article.dataset.pageId;
    var page_type = common.getSingularType();
    if (!post_id) {
      return;
    }

    var app = new Vue({
      el: '.main-container',
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
        this.fetchPostData(post_id, page_type);
        NProgress.inc();
      },
      mounted: function() {
        this.fetchCategoryData(post_id);
        this.fetchTagData(post_id);
        NProgress.inc();
      },
      watch: {
        loaded: function (data) {
          // After displaying DOM
          this.$nextTick(function() {
            var entry = this.$el.getElementsByClassName('entry-content')[0];
            if (entry) {
              common.addExternalLink(entry);
              common.zoomImage(entry);
              mokuji.init(entry);
              Prism.highlightAll();
            }
          });
          NProgress.done();
        }
      },
      methods: {
        fetchAPI: function(url) {
          return fetch(url, {
            method: 'GET'
          }).then(function(response) {
            return response.json();
          });
        },
        fetchPostData: function (post_id, page_type) {
          var self = this;
          self.fetchAPI(`/wp-json/wp/v2/${page_type}/${post_id}`)
          .then(function(json) {
            self.setDatetime(json);
            self.amazon_product = json.content.amazon_product;
            self.relateds = json.related;
            self.pagers = json.pager;
            self.loaded = true;
          });
        },
        fetchCategoryData: function (post_id) {
          var self = this;
          self.fetchAPI(`/wp-json/wp/v2/categories?post=${post_id}`)
          .then(function(json) {
            self.categories = json;
          });
        },
        fetchTagData: function (post_id) {
          var self = this;
          self.fetchAPI(`/wp-json/wp/v2/tags?post=${post_id}`)
          .then(function(json) {
            self.tags = json;
          });
        },
        setDatetime: function (json) {
          this.date.publish = json.date;
          this.date.modified = (json.date !== json.modified) ? json.modified : null;
          this.date.timeAgo = ago(new Date(json.modified));
        }
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
        }
      }
    });
  },
};
