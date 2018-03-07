<template>
  <div :class="{ 'open-drawer': isOpenSidebar }" class="contents">
    <layout-header/>
    <main class="main-container">
      <router-view/>
    </main>
    <layout-footer/>
    <layout-sidebar/>
    <loading v-if="isLoading"/>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import layoutHeader from '@/layouts/header.vue';
import layoutFooter from '@/layouts/footer.vue';
import layoutSidebar from '@/layouts/sidebar.vue';
import loading from '@components/loading.vue';

export default {
  components: {
    layoutHeader,
    layoutFooter,
    layoutSidebar,
    loading,
  },
  computed: mapState(['isLoading', 'isOpenSidebar', 'navigation']),
  watch: {
    $route: function(to, from) {
      // 同一ページ内の変更時は処理を行わない
      if (to.path === from.path) {
        return;
      }

      this.restPostData(to, from);
      this.sendPageview(to, from);
    },
  },
  created: function() {
    this.$store.dispatch('requestNavigation');
    this.$store.dispatch('requestAdvertise');
  },
  methods: {
    restPostData: function(to, from) {
      if (to.meta.type === 'post' || to.meta.type === 'page') {
        this.$store.dispatch('resetPost');
      } else {
        this.$store.dispatch('resetPostList');
      }
    },
    sendPageview: function(to, from) {
      if (!window.ga) {
        return;
      }
      if (to.path !== from.path) {
        let title = to.meta.title || this.navigation.site.name;
        // Google Analytics
        window.ga('set', 'title', title);
        window.ga('set', 'page', to.path);
        window.ga('send', 'pageview');
      }
    },
  },
};
</script>

<style>
</style>
