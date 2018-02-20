<template>
  <div class="contents" :class="{ 'open-drawer': isOpenSidebar }">
    <layout-header/>
    <main class="main-container">
      <router-view/>
    </main>
    <layout-footer/>
    <layout-sidebar/>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import layoutHeader from '@components/layout-header.vue';
import layoutFooter from '@components/layout-footer.vue';
import layoutSidebar from '@components/layout-sidebar.vue';

export default {
  components: {
    layoutHeader,
    layoutFooter,
    layoutSidebar,
  },
  computed: mapState(['isOpenSidebar']),
  created: function() {
    this.$store.dispatch('requestNavigation');
    this.$store.dispatch('requestAdvertise');
  },
};
</script>

<style>

</style>
