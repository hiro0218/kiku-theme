import api from '@scripts/api';

// vue components
import entryList from '@components/entry-list.vue';
import entryPagination from '@components/entry-pagination.vue';

export default {
  view() {
    // component
    Vue.component('home-content', {
      template: '#home-content',
    });

    new Vue({
      el: '#app',
      components: {
        entryList,
        entryPagination,
      },
      data: {
        headers: {},
        page_title: WP.page_title,
        posts: [],
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
            .getPostList()
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
            let post = {};

            post.title = json.title.rendered;
            post.link = json.link;
            post.excerpt = json.excerpt.rendered;
            post.thumbnail = json.thumbnail;
            post.date = json.modified;

            this.posts.push(post);
          }
        },
      },
    });
  },
};
