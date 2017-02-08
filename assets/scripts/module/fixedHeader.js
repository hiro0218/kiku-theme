const Headroom = require('headroom.js/dist/headroom.js');

module.exports = {
  init() {
    var headerNav = document.getElementsByClassName('header-navigation')[0];
    if (headerNav) {
      var headroom = new Headroom(headerNav);
      headroom.init();
    }
  }
};
