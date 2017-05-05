import common from '../module/common';
const Headroom = require('headroom.js/dist/headroom.js');

module.exports = {
  init() {
    var headerNav = document.getElementsByClassName('header-navigation')[0];
    if (headerNav) {
      var mainContainer = document.getElementsByClassName('main-container')[0];
      var headroomOffset = common.getStyleSheetValue(mainContainer, 'padding-top') || 0;

      var headroom = new Headroom(headerNav, {
        offset: 100
      });

      headroom.init();
    }
  }
};
