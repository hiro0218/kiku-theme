import common from '@scripts/module/common';
const HeadroomJs = require('headroom.js/dist/headroom.js');

export default {
  init() {
    var headerNav = document.getElementsByClassName('header-navigation')[0];
    if (headerNav) {
      var mainContainer = document.getElementsByClassName('main-container')[0];
      var headroomOffset = common.getStyleSheetValue(mainContainer, 'padding-top') || 0;
      headroomOffset = parseInt(headroomOffset, 10);

      var headroom = new HeadroomJs(headerNav, {
        offset: headroomOffset
      });

      headroom.init();
    }
  }
};
