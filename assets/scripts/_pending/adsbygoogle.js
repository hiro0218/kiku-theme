import 'babel-polyfill';

module.exports = {
  element: null,
  loaded: 0,
  init() {
    this.element = document.getElementsByClassName('adsbygoogle');
  },
  count() {
    return this.element ? this.element.length : 0;
  },
  isLoaded() {
    var self = this;
    self.init();

    return new Promise((resolve, reject) => {
      // without ads code
      if (self.count() === 0) {
        resolve(true);
      }

      // without ads script
      var hasAdsJs = false;
      var scripts = document.getElementsByTagName('script');
      [].forEach.call(scripts, (script) => {
        var adsjs = 'adsbygoogle.js';
        if (script.src.indexOf(adsjs) !== -1) {
          hasAdsJs = true;
        }
      });
      if (!hasAdsJs) {
        resolve(true);
      }

      // Create observer
      var observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
          // change attribute
          if (mutation.type === 'attributes') {
            // data-adsbygoogle-status="done"
            if (mutation.target.dataset.adsbygoogleStatus === 'done') {
              self.loaded += 1;
            }
          }
          // All loading is completed
          if (self.loaded === self.count()) {
            resolve(true);
          }
        });
      });
      // observer settings
      [].forEach.call(this.element, (_element) => {
        observer.observe(_element, { attributes: true });
      });
      // time over
      setTimeout(() => {
        if (window.adsbygoogle && window.adsbygoogle.length === 2) {  // is load failure
          resolve(true);
        }
      }, 2000);
    });
  }
};
