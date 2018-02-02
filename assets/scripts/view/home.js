import api from '@scripts/api';

// vue components
import entryHome from '@components/entry-home.vue';
Vue.component('home-content', {
  template: '#home-content',
});

export default {
  view() {
    new Vue({
      el: '#app',
      components: {
        entryHome,
      },
      created: function() {
        this.requestPostData();
      },
      methods: {
        requestPostData: function() {
          api
            .getPostList()
            .then(response => this.setResponseHeaders(response))
            .then(data => this.setPosts(data));
        },
        setResponseHeaders: function(response) {
          let requestHeader = {
            total: Number(response.headers['x-wp-total']),
            totalpages: Number(response.headers['x-wp-totalpages']),
          };
          this.$store.commit('setReqestHeader', requestHeader);

          return response.data;
        },
        setPosts: function(data) {
          let postLists = [];

          for (let json of data) {
            let post = {};

            post.title = json.title.rendered;
            post.link = json.link;
            post.excerpt = json.excerpt.rendered;
            post.thumbnail = json.thumbnail;
            post.date = json.modified;

            postLists.push(post);
          }

          this.$store.commit('setPostLists', postLists);
        },
      },
    });
  },
};
