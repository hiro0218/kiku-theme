<template>
  <div :class="{ 'open-drawer': isOpenSidebar }" class="contents">
    <layout-header/>
    <main class="main-container">
      <router-view class="container"/>
    </main>
    <layout-footer/>
    <layout-sidebar/>
    <loading/>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import layoutHeader from '@/layouts/header.vue';
import layoutFooter from '@/layouts/footer.vue';
import layoutSidebar from '@/layouts/sidebar.vue';
import loading from '@components/loading.vue';
import { htmlentities } from '@scripts/utils';

export default {
  components: {
    layoutHeader,
    layoutFooter,
    layoutSidebar,
    loading,
  },
  computed: mapState(['isOpenSidebar', 'navigation', 'pageTitle']),
  watch: {
    $route: function(to, from) {
      // 同一ページ内の変更時は処理を行わない
      if (to.path === from.path) {
        return;
      }

      this.$store.dispatch('resetPost');
      this.$store.dispatch('resetPostList');
      this.sendPageview(to, from);
    },
    pageTitle: 'setTitle',
  },
  created: function() {
    this.$store.dispatch('requestNavigation');
    this.$store.dispatch('requestAdvertise');
  },
  methods: {
    setTitle: function(afterTitle, beforeTitle) {
      if (!this.navigation.site.name || afterTitle === beforeTitle) {
        return;
      }

      if (this.$route.path === '/' || !afterTitle) {
        document.title = this.navigation.site.name;
      } else {
        let pageTitle = htmlentities.decode(afterTitle);
        document.title = `${pageTitle} - ${this.navigation.site.name}`;
      }
    },
    sendPageview: function(to, from) {
      if (!window.ga) {
        return;
      }
      if (to.path !== from.path) {
        // Google Analytics
        window.ga('send', {
          hitType: 'pageview',
          location: to.path,
        });
      }
    },
  },
};
</script>

<style>
</style>
