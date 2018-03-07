<template>
  <div class="container">
    <entry-list/>
    <advertise :id-name="ads.id" :content="ads.content" :script="ads.script" />
    <entry-pagination v-show="postLists.length !== 0"/>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import entryList from '@components/entry-list.vue';
import advertise from '@components/advertise.vue';
import entryPagination from '@components/entry-pagination.vue';

export default {
  name: 'Home',
  components: {
    entryList,
    advertise,
    entryPagination,
  },
  data() {
    return {
      ads: {
        id: 'ads3',
        content: '',
        script: '',
      },
    };
  },
  computed: mapState(['requestHeader', 'postLists', 'advertise']),
  watch: {
    '$route.path': 'requestPostData',
    postLists: function() {
      if (this.postLists.length === 0) {
        this.ads.content = '';
        return;
      }

      this.ads.content = this.advertise.ads3.content;
      this.ads.script = this.advertise.ads3.script;
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
