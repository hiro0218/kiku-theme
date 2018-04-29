<template>
  <main :class="{ 'open-drawer': isOpenSidebar }" class="main">
    <layout-header/>
    <section class="main-container">
      <router-view class="container"/>
    </section>
    <layout-footer/>
    <layout-sidebar/>
    <loading/>
  </main>
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
  computed: mapState(['isOpenSidebar', 'pageTitle']),
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
    this.$store.dispatch('requestAdvertise');
  },
  methods: {
    setTitle: function(afterTitle, beforeTitle) {
      if (!WP.site.name || afterTitle === beforeTitle) {
        return;
      }

      if (this.$route.path === '/' || !afterTitle) {
        document.title = WP.site.name;
      } else {
        let pageTitle = htmlentities.decode(afterTitle);
        document.title = `${pageTitle} - ${WP.site.name}`;
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

<style lang="scss" scoped>
.main {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

// nav min-height from bulma = 3.5rem
// for header's position:fixed
.main-container {
  flex: 1 0 auto;
  min-height: calc(100vh - #{$header-nav-height});
  margin-top: $header-nav-height; // for header
}
</style>
