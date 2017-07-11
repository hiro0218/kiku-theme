import 'whatwg-fetch';
import Vue from 'vue';
import mokuji from '../module/mokuji';
import common from '../module/common';

export default {
  init() {
    var app = new Vue({
      el: '.main-container',
      data: {
        categories: null,
        amazon_product: null,
        tags: null,
        relateds: null,
        pagers: null,
      },
      created: function () {
        var article = document.getElementsByTagName('article')[0];
        var post_id = article.dataset.pageId;
        if (post_id) {
          this.fetchPostData(post_id);
          this.fetchCategoryData(post_id);
          this.fetchTagData(post_id);
        }
      },
      mounted: function () {
        var entry = this.$el.getElementsByClassName('entry-content')[0];
        common.addExternalLink(entry);
        common.zoomImage(entry);
        mokuji.init(entry);
      },
      methods: {
        fetchAPI: function(url) {
          return fetch(url, {
            method: 'GET'
          }).then(function(response) {
            return response.json();
          });
        },
        fetchPostData: function (post_id) {
          var self = this;
          self.fetchAPI(`/wp-json/wp/v2/posts/${post_id}`)
          .then(function(json) {
            self.amazon_product = json.content.amazon_product;
            self.relateds = json.related;
            self.pagers = json.pager;
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
        }
      }
    });
  },
  finalize() {}
};
