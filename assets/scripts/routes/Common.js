import common from '../module/common.js';

export default {
  init() {
    // JavaScript to be fired on all pages
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired

    document.addEventListener('mdl-componentupgraded', function (e) {
      if (typeof e.target.MaterialLayout !== 'undefined') {
        common.delay()(function () {
          var loader = document.getElementsByClassName('loader')[0];
          loader.classList.add('is-loaded');
        }, 250);
      }
    });
  }
};
