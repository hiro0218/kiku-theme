/* global WP */
import Vue from 'vue';
import axios from 'axios';
import NProgress from 'nprogress/nprogress.js';
import ago from 's-ago';
import common from '@scripts/module/common';

// vue components
import entryList from '@components/entry-list.vue';
import pagination from '@components/pagination.vue';

export default {
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

          axios.get(api_url)
            .then(function(response) {
              self.setHeader(response.headers);
              for (var key in response.data) {
                var json = response.data[key];
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

              return true;
            })
            .then(function(result) {
              if (self.lists) {
                self.loaded = true;
              }
            });
        },
        setHeader: function (headers) {
          this.headers = {
            total: Number(headers['x-wp-total']),
            totalpages: Number(headers['x-wp-totalpages']),
          };
        },
      },
    });
  },
};
