import ago from 's-ago';

import api from '@scripts/api';
import common from '@scripts/module/common';

// vue components
import entryList from '@components/entry-list.vue';
import pagination from '@components/pagination.vue';

export default {
  view() {
    new Vue({
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
      beforeCreate: function() {
        NProgress.start();
      },
      created: function() {
        this.requestPostData();
        NProgress.inc();
      },
      watch: {
        loaded: function(data) {
          // After displaying DOM
          this.$nextTick()
            .then(() => {
              common.setThumbnailImage();
            })
            .then(() => {
              NProgress.done();
            });
        },
      },
      methods: {
        requestPostData: function() {
          api
            .getPosts()
            .then(response => {
              this.setRequestHeader(response.headers);
              return response.data;
            })
            .then(data => {
              this.setPosts(data);
              return this.lists.length > 0;
            })
            .then(result => {
              this.loaded = result;
            });
        },
        setRequestHeader: function(headers) {
          this.headers = {
            total: Number(headers['x-wp-total']),
            totalpages: Number(headers['x-wp-totalpages']),
          };
        },
        setPosts: function(data) {
          for (let json of data) {
            this.lists.push({
              title: json.title.rendered,
              link: json.link,
              excerpt: json.excerpt.rendered,
              thumbnail: json.thumbnail,
              date: {
                timeAgo: ago(new Date(json.modified)),
              },
            });
          }
        },
      },
    });
  },
};
