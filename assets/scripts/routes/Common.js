// import load from '../module/load';
import headroom from '../module/headroom';
import drawer from '../module/drawer';

export default {
  init() {},
  finalize() {
    // header fixed
    headroom.init();

    // drawer
    drawer.init();
  }
};
