<template>
  <div class="container">
    <entry-list :page-title="pageTitle"/>
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
  computed: {
    ...mapState(['requestHeader', 'postLists', 'advertise']),
    pageTitle() {
      let type = this.$route.meta.type;
      let title = this.$route.meta.title || this.$route.params.search_query;

      // archive
      if (type === 'category') {
        return `Category: ${title}`;
      }
      if (type === 'post_tag') {
        return `Tag: ${title}`;
      }
      // search
      if (type === 'search') {
        return `Search results: '${title}'`;
      }

      return 'Recent Posts';
    },
  },
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
  beforeRouteEnter(to, from, next) {
    next(vm => {
      const query = vm.$route.query;

      if (Object.keys(query).length > 0) {
        if (query.preview) {
          vm.$router.replace({ path: '/preview', query });
        }
      }
    });
  },
};
</script>
