// import load from '../module/load';
import fixedHeader from '../module/fixedHeader';
import drawer from '../module/drawer';

export default {
  init() {
    // JavaScript to be fired on all pages
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
    // load.checkLoaded();

    // header fixed
    fixedHeader.init();

    // drawer
    drawer.init();
  }
};
