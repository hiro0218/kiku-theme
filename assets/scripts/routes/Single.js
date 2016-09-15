import common from '../module/common.js';

export default {
  init() {
    var article = document.getElementsByTagName('article')[0];
    var entry = article.getElementsByClassName('entry-content')[0];
    common.addExternalLink(entry);
    common.zoomImage(entry);
  },
  finalize() {

  }
};
