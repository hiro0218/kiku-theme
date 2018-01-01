import * as HeadroomJs from 'headroom.js/dist/headroom.min.js';
import common from '@scripts/module/common';

export default {
  init() {
    var headerNav = document.getElementsByClassName('header-navigation')[0];
    if (headerNav) {
      var headroom = new HeadroomJs(headerNav, {
        offset: 100,
        tolerance: 25,
      });

      headroom.init();
    }
  },
};
