<template>
  <div class="container">
    <entry-list :page-title="pageTitle"/>
    <advertise :id-name="ads.id" :content="ads.content" :script="ads.script" />
    <pagination v-show="postLists.length !== 0"/>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import entryList from '@components/entry-list.vue';
import advertise from '@components/advertise.vue';
import pagination from '@components/pagination.vue';

export default {
  name: 'Home',
  components: {
    entryList,
    advertise,
    pagination,
  },
  data() {
    return {
      ads: {
        id: 'ads3',
        content: '',
        script: '',
      },
      pageTitle: '',
    };
  },
  computed: {
    ...mapState(['requestHeader', 'postLists', 'advertise']),
  },
  watch: {
    '$route.path': 'requestPostData',
    postLists: function() {
      if (this.postLists.length === 0) {
        this.ads.content = '';
        this.ads.script = '';
        return;
      }

      this.ads.content = this.advertise.ads3.content;
      this.ads.script = this.advertise.ads3.script;
    },
    pageTitle: function(title) {
      this.$store.commit('setPageTitle', title);
    },
  },
  created: function() {
    this.requestPostData();
  },
  methods: {
    requestPostData: function() {
      this.setPageTitle();
      this.$store.dispatch('requestPostList', this.$route);
    },
    setPageTitle: function() {
      let type = this.$route.meta.type;
      let title = this.$route.meta.title || this.$route.params.search_query;

      // archive
      if (type === 'category') {
        this.pageTitle = `Category: ${title}`;
      } else if (type === 'post_tag') {
        this.pageTitle = `Tag: ${title}`;
      } else if (type === 'search') {
        this.pageTitle = `Search results: '${title}'`;
      } else {
        this.pageTitle = 'Recent Posts';
      }
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
