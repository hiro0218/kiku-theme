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
      // without ads
      if (self.count() === 0) {
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
    });
  }
};
