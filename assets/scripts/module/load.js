import common from '../module/common.js';

module.exports = {
  checkLoaded: function () {
    var self = this;
    document.addEventListener('mdl-componentupgraded', function (e) {
      if (typeof e.target.MaterialLayout !== 'undefined') {
        common.delay()(function () {
          var loader = document.getElementsByClassName('loader')[0];
          loader.classList.add('is-loaded');
          self.moveAnchorTagPosition();
        }, 250);
      }
    });
  },
  moveAnchorTagPosition: function () {
    var anchor = this.removeFristSharpString(window.location.hash);

    if (!anchor) {
      return;
    }

    location.hash = anchor;
  },
  removeFristSharpString: function (str) {
    var url = str.split('#');

    if (url.length !== 2) {
      return '';
    }

    return url[1];
  }
};
