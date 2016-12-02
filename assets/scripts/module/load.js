import 'babel-polyfill';
import common from '../module/common';
import adsbygoogle from '../module/adsbygoogle';

module.exports = {
  checkLoaded() {
    var self = this;
    document.addEventListener('mdl-componentupgraded', function (e) {
      if (typeof e.target.MaterialLayout !== 'undefined') {
        (async () => {
          await adsbygoogle.isLoaded();
          await self.compleatedLoading();
          self.moveAnchorTagPosition();
        })();
      }
    });
  },
  compleatedLoading() {
    return new Promise((resolve, reject) => {
      var loader = document.getElementsByClassName('loader')[0];
      loader.classList.add('is-loaded');
      resolve(true);
    });
  },
  moveAnchorTagPosition() {
    var hash = this.removeFristSharp(window.location.hash);
    if (!hash) {
      return;
    }
    window.location.hash = '';
    window.location.hash = hash;
  },
  removeFristSharp(str) {
    var url = str.split('#');

    if (url.length !== 2) {
      return '';
    }

    return url[1];
  }
};
