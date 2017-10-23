/* global WP */
import Vue from 'vue';
import NProgress from 'nprogress/nprogress.js';
import ago from 's-ago';
import common from '../module/common';

// vue components
import entryList from '../../../components/entry-list.vue';
import pagination from '../../../components/pagination.vue';

module.exports = {
  view(api_url) {
    var app = new Vue({
      el: '#app',
      components: {
        entryList,
        pagination,
      },
      data: {
        loaded: false,
        headers: {},
        lists: [],
      },
      beforeCreate: function () {
        NProgress.start();
      },
      created: function () {
        this.requestPostData();
        NProgress.inc();
      },
      watch: {
        loaded: function (data) {
          // After displaying DOM
          this.$nextTick(function() {
            common.setThumbnailImage();
          });
          NProgress.done();
        },
      },
      methods: {
        requestPostData: function () {
          var self = this;
          common.fetch(api_url, function(response, header) {
            self.setHeader(header);
            for (var key in response) {
              var json = response[key];
              self.lists.push({
                title: json.title.rendered,
                link: json.link,
                excerpt: json.excerpt.rendered,
                thumbnail: json.thumbnail,
                date: {
                  timeAgo: ago(new Date(json.modified)),
                },
              });
            }
            if (self.lists) {
              self.loaded = true;
            }
          });
        },
        setHeader: function (header) {
          this.headers = header;
        },
      },
    });
  },
};
