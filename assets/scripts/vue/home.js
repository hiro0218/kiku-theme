/* global WP */
import 'whatwg-fetch';
import Vue from 'vue';
import NProgress from 'nprogress/nprogress.js';
import ago from 's-ago';
import common from '../module/common';

module.exports = {
  view(api_url) {
    var app = new Vue({
      el: '.main-container',
      data: {
        loaded: false,
        headers: {
          total: 0,
          totalpages: 0,
        },
        pagination: {
          active: 0,
          first: 0,
          prev: 0,
          next: 0,
          last: 0,
          pages: [],
        },
        posts: [],
      },
      beforeCreate: function () {
        NProgress.start();
      },
      created: function () {
        this.fetchPostData();
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
        'headers.totalpages': function () {
          if (this.headers.totalpages <= 1) {
            return;
          }

          var range = 3;
          var paged = WP.paged;
          var totalpages = this.headers.totalpages;
          var ceil  = Math.ceil(range / 2);
          var min = 0;
          var max = 0;

          if (totalpages > range) {
            if (paged <= range) {
              min = 1;
              max = range + 1;
            } else if (paged >= (totalpages - ceil)) {
              min = totalpages - range;
              max = totalpages;
            } else if (paged >= range && paged < (totalpages - ceil)) {
              min = paged - ceil;
              max = paged + ceil;
            }
          } else {
            min = 1;
            max = totalpages;
          }

          var prev = paged - 1;
          var first = 1;
          if (first && (1 != paged)) {
            this.pagination.first = first;
          }
          if (prev && (1 != paged)) {
            this.pagination.prev = prev;
          }

          if (min && max) {
            for (var i = min; i <= max; i++) {
              if (paged == i) {
                this.pagination.active = i;
              }
              this.pagination.pages.push(i);
            }
          }

          if (totalpages != paged) {
            var next = paged + 1;
            var last = totalpages;
            if (next) {
              this.pagination.next = next;
            }
            if (last) {
              this.pagination.last = last;
            }
          }
        },
      },
      methods: {
        fetchAPI: function(url) {
          var self = this;
          return fetch(url, {
            method: 'GET'
          }).then(function(response) {
            self.getWpTotalValue(response);
            return response.json();
          });
        },
        fetchPostData: function () {
          var self = this;
          self.fetchAPI(api_url)
          .then(function(jsons) {
            for (var key in jsons) {
              var json = jsons[key];
              var post = {
                title: null,
                link: null,
                excerpt: null,
                thumbnail: null,
                date: {
                  timeAgo: null,
                },
              };
              post.title = json.title.rendered;
              post.excerpt = json.excerpt.rendered;
              post.link = json.link;
              post.thumbnail = json.thumbnail;
              post.date.timeAgo = ago(new Date(json.modified));
              self.posts.push(post);
            }
            if (self.posts) {
              self.loaded = true;
            }
          });
        },
        getWpTotalValue: function (response) {
          var self = this;
          response.headers.forEach(function(value, key) {
            if (key === 'x-wp-total') {
              self.headers.total = Number(value);
            }
            if (key === 'x-wp-totalpages') {
              self.headers.totalpages = Number(value);
            }
          });
        },
      },
      filters: {
        zeroPadding: function(number) {
          return ("0" + number).slice(-2);
        }
      },
    });
  },
};
