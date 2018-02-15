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
    this.fetchAds();
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
    fetchAds: function() {
      api.getAds().then(response => {
        let page_type = this.$route.meta.type;
        let data = response.data;
        let ads1 = {};
        if (data.ads1.display.split(',').includes(page_type)) {
          ads1 = {
            content: data.ads1.content,
            script: data.ads1.script,
          };
        }

        let ads2 = {};
        if (data.ads2.display.split(',').includes(page_type)) {
          ads2 = {
            content: data.ads2.content,
            script: data.ads2.script,
          };
        }

        let ads3 = {};
        if (!page_type) {
          ads3 = {
            content: data.ads3.content,
            script: data.ads3.script,
          };
        }

        this.$store.commit('setAdvertise', { ads1, ads2, ads3 });
      });
    },
  },
};
</script>

<style lang="scss">

</style>
