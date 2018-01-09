import headerScroll from '@scripts/module/headerScroll';
import drawer from '@scripts/module/drawer';

export default {
  init() {},
  finalize() {
    // header fixed
    headerScroll.init();

    // drawer
    drawer.init();
  },
};
