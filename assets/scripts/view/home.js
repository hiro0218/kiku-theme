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
        headers: {
          total: 0,
          totalpages: 0,
        },
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
        requestXHR: function(url, callback) {
          var self = this;
          var xhr = new XMLHttpRequest();
          xhr.onreadystatechange = function(){
            if (this.readyState === 4 && this.status === 200) {
              self.headers.total = Number(this.getResponseHeader('X-WP-Total'));
              self.headers.totalpages = Number(this.getResponseHeader('X-WP-TotalPages'));
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
        requestPostData: function () {
          var self = this;
          self.requestXHR(api_url, function(jsons) {
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
              self.lists.push(post);
            }
            if (self.lists) {
              self.loaded = true;
            }
          });
        },
      },
    });
  },
};
