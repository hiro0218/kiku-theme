<template>
  <div class="container">
    <entry-list/>
    <advertise :id-name="'ads3'" :content="ads.content" :script="ads.script" />
    <entry-pagination/>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import entryList from '@components/entry-list.vue';
import advertise from '@components/advertise.vue';
import entryPagination from '@components/entry-pagination.vue';

export default {
  name: 'PageHome',
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
    '$route.path': 'requestPostData',
    postLists: function() {
      this.ads = this.advertise.ads3;
    },
  },
  created: function() {
    this.requestPostData();
  },
  methods: {
    requestPostData: function() {
      this.$store.dispatch('requestPostList', this.$route);
    },
  },
};
</script>
