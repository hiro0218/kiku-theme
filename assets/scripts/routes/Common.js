import load from '../module/load';

export default {
  init() {
    // JavaScript to be fired on all pages
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
    load.checkLoaded();

    // drawer
    var trigger = document.getElementsByClassName('off-canvas-checkbox')[0];
    if (trigger) {
      var body = document.body;
      var className = 'open-drawer';
      trigger.addEventListener('change', function (e) {
        if (trigger.checked) {
          body.classList.add(className);
        } else {
          body.classList.remove(className);
        }
      });
    }
  }
};
