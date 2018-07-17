import store from '@scripts/store';
import router from '@scripts/router';
import App from './App.vue';
import pagination from 'vuejs-uib-pagination';
import { checkSupportsPassive, escapeBrackets, dateToISOString, formatBaseLink, formatDate } from '@scripts/utils';

checkSupportsPassive();

Vue.use(pagination);

// Vue global mixin
Vue.mixin({
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
