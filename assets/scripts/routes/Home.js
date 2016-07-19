import animation from '../module/animation.js';

export default {
  init() {
    var article = document.getElementsByTagName('article');
    animation.show(article, 'showIn');
  },
  finalize() {
    
  }
};
