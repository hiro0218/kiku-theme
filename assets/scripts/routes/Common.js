import headroom from 'scripts/module/headroom';
import drawer from 'scripts/module/drawer';

export default {
  init() {},
  finalize() {
    // header fixed
    headroom.init();

    // drawer
    drawer.init();
  }
};
