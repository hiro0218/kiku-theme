<template>
  <div class="container">
    <entry-list/>
    <advertise :id-name="'ads3'" :content="ads.content" :script="ads.script" />
    <entry-pagination/>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import api from '@scripts/api';
import entryList from '@components/entry-list.vue';
import advertise from '@components/advertise.vue';
import entryPagination from '@components/entry-pagination.vue';

export default {
  name: 'EntryHome',
  components: {
    entryList,
    advertise,
    entryPagination,
  },
  data() {
    return {
      ads: {
        content: '',
        script: '',
      },
    };
  },
  computed: mapState(['requestHeader', 'postLists', 'advertise']),
  watch: {
    '$route.params.page_number': 'requestPostData',
    postLists: function() {
      this.ads = this.advertise.ads3;
    },
  },
  created: function() {
    this.requestPostData();
  },
  methods: {
    requestPostData: function() {
      api
        .getPostList({ meta: this.$route.meta, params: this.$route.params })
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
};
</script>
