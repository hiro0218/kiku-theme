import store from '@scripts/store';
import router from '@scripts/router';
import App from './App.vue';

// Vue global mixin
Vue.mixin({
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
});

new Vue({
  el: '#app',
  store,
  router,
  render: h => h(App),
});
