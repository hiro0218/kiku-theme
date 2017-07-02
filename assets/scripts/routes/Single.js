import mokuji from '../module/mokuji';
import common from '../module/common';

export default {
  init() {
    var article = document.getElementsByTagName('article')[0];
    var entry = article.getElementsByClassName('entry-content')[0];
    common.addExternalLink(entry);
    common.zoomImage(entry);
    mokuji.init(entry);
  },
  finalize() {

  }
};
