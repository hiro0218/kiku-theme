import common from '../module/common.js';
import animation from '../module/animation.js';

export default {
  init() {
    if ( !common.isSmartPhone() ) {
      var article = document.getElementsByTagName('article');
      animation.show(article, 'showIn');
    }
  },
  finalize() {

  }
};
