import common from '@scripts/module/common';

export default {
  init() {
    var headerNav = document.getElementsByClassName('header-navigation')[0];
    if (headerNav) {
      var headroom = new Headroom(headerNav, {
        offset: 100,
        tolerance: 25,
      });

      headroom.init();
    }
  },
};
