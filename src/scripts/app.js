import store from '@scripts/store';
import router from '@scripts/router';
import App from './App.vue';
import pagination from 'vuejs-uib-pagination';
import { escapeBrackets, dateToISOString, formatBaseLink, formatDate } from '@scripts/utils';
import titleMixin from '@scripts/utils/title';

Vue.use(pagination);

// Vue global mixin
Vue.mixin({
  ...titleMixin,
  filters: {
    escapeBrackets,
    dateToISOString,
    formatBaseLink,
    formatDate,
  },
});

new Vue({
  el: '#app',
  store,
  router,
  render: h => h(App),
});
