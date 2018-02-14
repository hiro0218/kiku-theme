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
import api from '@scripts/api';
import layoutHeader from '@components/layout-header.vue';
import layoutFooter from '@components/layout-footer.vue';
import layoutSidebar from '@components/layout-sidebar.vue';

export default {
  components: {
    layoutHeader,
    layoutFooter,
    layoutSidebar,
  },
  computed: mapState(['navigation', 'isOpenSidebar']),
  created: function() {
    this.fetchNavigation();
  },
  methods: {
    fetchNavigation: function() {
      if (this.navigation) {
        return;
      }

      api.getNavigation().then(response => {
        this.$store.commit('setNavigation', response.data);
      });
    },
  },
};
</script>

<style lang="scss">

</style>
