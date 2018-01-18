import { mapState } from 'vuex';
import { once } from 'lodash';

import api from '@scripts/api';
import store from '@scripts/store';

// Vue components
import kikuHeader from '@components/kiku-header.vue';
import kikuFooter from '@components/kiku-footer.vue';

// Vue global mixin
Vue.mixin({
  store,
  components: {
    kikuHeader,
    kikuFooter,
  },
  computed: mapState(['navigation']),
  created: function() {
    this.$_fetchNavigation();
  },
  methods: {
    $_fetchNavigation: once(function() {
      console.log(this.navigation);
      if (this.navigation) {
        return;
      }

      api.getNavigation().then(response => {
        this.$store.commit('setNavigation', response.data);
      });
    }),
  },
  filters: {
    escapeBrackets: function(text) {
      return text.replace(/</g, '&lt;').replace(/>/g, '&gt;');
    },
    zeroPadding: function(number) {
      return ('0' + number).slice(-2);
    },
  },
});
