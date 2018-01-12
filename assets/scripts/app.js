// polyfill
import 'intersection-observer';
import * as es6Promise from 'es6-promise';
if (!window.Promise) {
  es6Promise.polyfill();
}

// Vue global mixin
Vue.mixin({
  methods: {},
  filters: {
    escapeBrackets: function(text) {
      return text.replace(/</g, '&lt;').replace(/>/g, '&gt;');
    },
    zeroPadding: function(number) {
      return ('0' + number).slice(-2);
    },
  },
});
