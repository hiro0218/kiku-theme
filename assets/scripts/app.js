import api from '@scripts/api';

// Vue components
import kikuFooter from '@components/kiku-footer.vue';

// Vue global mixin
Vue.mixin({
  components: {
    kikuFooter,
  },
  data() {
    return {
      navigation: {},
    };
  },
  beforeMount: function() {
    this.$_fetchNavigation();
  },
  methods: {
    $_fetchNavigation: function() {
      api.getNavigation().then(response => {
        this.navigation = response.data;
      });
    },
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
