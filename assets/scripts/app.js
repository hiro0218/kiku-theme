import store from '@scripts/store';
import router from '@scripts/router';
import App from './App.vue';
import pagination from 'vuejs-uib-pagination';

Vue.use(pagination);

// Vue global mixin
Vue.mixin({
  filters: {
    escapeBrackets: function(text) {
      return text.replace(/</g, '&lt;').replace(/>/g, '&gt;');
    },
  },
});

new Vue({
  el: '#app',
  store,
  router,
  render: h => h(App),
});
