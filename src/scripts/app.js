import store from '@scripts/store';
import router from '@scripts/router';
import App from './App.vue';
import pagination from 'vuejs-uib-pagination';
import { escapeBrackets, dateToISOString, formatBaseLink } from '@scripts/utils';

Vue.use(pagination);

// Vue global mixin
Vue.mixin({
  filters: {
    escapeBrackets,
    dateToISOString,
    formatBaseLink,
  },
});

new Vue({
  el: '#app',
  store,
  router,
  render: h => h(App),
});
