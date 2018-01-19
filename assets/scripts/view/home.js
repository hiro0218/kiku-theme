import api from '@scripts/api';

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
      methods: {
        requestPostData: function() {
          api
            .getPosts()
            .then(response => this.setResponseHeaders(response))
            .then(data => this.setPosts(data))
            .then(() => NProgress.done());
        },
        setResponseHeaders: function(response) {
          this.headers.total = Number(response.headers['x-wp-total']);
          this.headers.totalpages = Number(response.headers['x-wp-totalpages']);

          return response.data;
        },
        setPosts: function(data) {
          for (let json of data) {
            let list = {};

            list.title = json.title.rendered;
            list.link = json.link;
            list.excerpt = json.excerpt.rendered;
            list.thumbnail = json.thumbnail;
            list.date = json.modified;

            this.lists.push(list);
          }
        },
      },
    });
  },
};
