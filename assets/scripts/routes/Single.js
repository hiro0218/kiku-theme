import 'whatwg-fetch';
import Vue from 'vue';
import mokuji from '../module/mokuji';
import common from '../module/common';

export default {
  init() {
    var app = new Vue({
      el: '.main-container',
      data: {
        amazon_product: null,
        relateds: null,
        pagers: null,
      },
      created: function () {
        var article = document.getElementsByTagName('article')[0];
        var post_id = article.dataset.pageId;
        this.fetchPostData(post_id);
      },
      mounted: function () {
        var entry = this.$el.getElementsByClassName('entry-content')[0];
        common.addExternalLink(entry);
        common.zoomImage(entry);
        mokuji.init(entry);
      },
      methods: {
        fetchPostData: function (post_id) {
          if (!post_id) {
            return;
          }
          var self = this;
          fetch(`/wp-json/wp/v2/posts/${post_id}`).then(function(response) {
            return response.json();
          }).then(function(json) {
            self.amazon_product = json.content.amazon_product;
            self.relateds = json.related;
            self.pagers = json.pager;
          });
        }
      }
    });
  },
  finalize() {}
};
