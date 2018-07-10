<template>
  <div class="container">
    <h1 class="page-header" v-html="$options.filters.escapeBrackets(pageHeading)"/>
    <list/>
    <advertise :id-name="ads.id" :content="ads.content" :script="ads.script" />
    <pagination v-show="postLists.length !== 0"/>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import list from '@components/home/list.vue';
import advertise from '@components/advertise.vue';
import pagination from '@components/home/pagination.vue';

export default {
  name: 'Home',
  metaInfo() {
    return {
      title: this.pageTitle,
    };
  },
  beforeRouteLeave(to, from, next) {
    if (to.path !== from.path) {
      this.$store.dispatch('resetPostList');
    }
    next();
  },
  components: {
    list,
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
      pageHeading: '',
    };
  },
  computed: {
    ...mapState(['pageTitle', 'postLists', 'advertise']),
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
  },
  created: function() {
    this.requestPostData();
  },
  methods: {
    requestPostData: function() {
      this.setPageHeading();
      this.$store.dispatch('requestPostList', this.$route);
    },
    setPageHeading: function() {
      let type = this.$route.meta.type;
      let title = this.$route.meta.title || this.$route.params.search_query;

      switch (type) {
        case 'category':
          this.pageHeading = `Category: ${title}`;
          this.$store.commit('setPageTitle', this.pageHeading);
          break;
        case 'post_tag':
          this.pageHeading = `Tag: ${title}`;
          this.$store.commit('setPageTitle', this.pageHeading);
          break;
        case 'search':
          this.pageHeading = `Search results: '${title}'`;
          this.$store.commit('setPageTitle', this.pageHeading);
          break;
        default:
          this.pageHeading = 'Recent Posts';
          this.$store.commit('setPageTitle', '');
          break;
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

<style lang="scss" scoped>
.page-header {
  text-align: center;
  overflow-wrap: break-word;
}
</style>
