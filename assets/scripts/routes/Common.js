import load from '../module/load';

export default {
  init() {
    // JavaScript to be fired on all pages
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
    load.checkLoaded();
  }
};
