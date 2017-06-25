const Mokuji = require('mokuji.js');
import common from '../module/common';

export default {
  init() {
    var article = document.getElementsByTagName('article')[0];
    var entry = article.getElementsByClassName('entry-content')[0];
    common.addExternalLink(entry);
    common.zoomImage(entry);

    var mokujiContent = entry.getElementsByClassName('mokuji-content')[0];
    if (mokujiContent) {
      var mokuji = new Mokuji.init(entry, {
        anchorType: 'wikipedia',
        anchorLink: true,
        anchorLinkSymbol: '#',
        anchorLinkBefore: true,
        anchorLinkClassName: 'anchor',
        smoothScroll: true
      });
      mokujiContent.appendChild(mokuji);
    }
  },
  finalize() {

  }
};
