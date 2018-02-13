import { mapState } from 'vuex';
import once from 'lodash-es/once';

import api from '@scripts/api';
import store from '@scripts/store';
import router from '@scripts/router';

// Vue components
import layoutHeader from '@components/layout-header.vue';
import layoutFooter from '@components/layout-footer.vue';
import layoutSidebar from '@components/layout-sidebar.vue';

// Vue global mixin
Vue.mixin({
  store,
  router,
  components: {
    layoutHeader,
    layoutFooter,
    layoutSidebar,
  },
  filters: {
    escapeBrackets: function(text) {
      return text.replace(/</g, '&lt;').replace(/>/g, '&gt;');
    },
    zeroPadding: function(number) {
      return ('0' + number).slice(-2);
    },
    formatDate: function(date) {
      if (!date) {
        return;
      }
      if (typeof date === 'string') {
        date = new Date(date);
      }
      return date
        .toISOString()
        .split('T')[0]
        .replace(/-/g, '/');
    },
  },
  computed: mapState(['navigation', 'isOpenSidebar']),
  created: function() {
    this.$_fetchNavigation();
  },
  methods: {
    $_fetchNavigation: once(function() {
      if (this.navigation) {
        return;
      }

      api.getNavigation().then(response => {
        this.$store.commit('setNavigation', response.data);
      });
    }),
  },
});
