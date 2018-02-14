<template>
  <div class="container">
    <entry-list/>
    <advertise :id-name="'ads3'" :content="advertise.ads3.content" :script="advertise.ads3.script" />
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
  computed: mapState(['advertise']),
  created: function() {
    this.requestPostData();
    this.requestAds();
  },
  methods: {
    requestPostData: function() {
      api
        .getPostList()
        .then(response => this.setResponseHeaders(response))
        .then(data => this.setPosts(data));
    },
    requestAds: function() {
      api.getAds().then(response => this.setAds(response));
    },
    setResponseHeaders: function(response) {
      let requestHeader = {
        total: Number(response.headers['x-wp-total']),
        totalpages: Number(response.headers['x-wp-totalpages']),
      };
      this.$store.commit('setReqestHeader', requestHeader);

      return response.data;
    },
    setAds: function(response) {
      const ads3 = {
        content: response.data.ads3.content,
        script: response.data.ads3.script,
      };

      this.$store.commit('setAdvertise', { ads3 });
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
