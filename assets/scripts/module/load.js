import 'babel-polyfill';
import common from '../module/common';
// import ua from '../module/useragent';
import adsbygoogle from '../module/adsbygoogle';

module.exports = {
  checkLoaded() {
    var self = this;
    (async () => {
      await adsbygoogle.isLoaded();
      await self.compleatedLoading();
    })();
  },
  compleatedLoading() {
    return new Promise((resolve, reject) => {
      var loader = document.getElementsByClassName('loader')[0];
      loader.classList.add('is-loaded');
      resolve(true);
    });
  },
  moveAnchorTagPosition() {
    /*
    // frist scroll position
    document.body.scrollTop = 0;

    var hash = this.removeFristSharp(window.location.hash);
    if (!hash) {
      return;
    }
    // hash reset for WebKit
    if (ua.info().getEngine() === 'WebKit') {
      window.location.hash = '';
    }
    window.location.hash = hash;
    */
  },
  removeFristSharp(str) {
    var url = str.split('#');

    if (url.length !== 2) {
      return '';
    }

    return url[1];
  }
};
