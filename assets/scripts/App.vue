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
import layoutHeader from '@components/layout-header.vue';
import layoutFooter from '@components/layout-footer.vue';
import layoutSidebar from '@components/layout-sidebar.vue';
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
    '$route': function (to, from) {
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
    }
  },
  created: function() {
    this.$store.dispatch('requestNavigation');
    this.$store.dispatch('requestAdvertise');
  },
};
</script>

<style>

</style>
