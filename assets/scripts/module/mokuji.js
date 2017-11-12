import * as Mokuji from 'mokuji.js';

export default {
  init(entry) {
    var mokujiContent = entry.getElementsByClassName('mokuji-content')[0];
    if (mokujiContent) {
      var mokuji = new Mokuji.init(entry, {
        anchorType: true,
        anchorLink: true,
        anchorLinkSymbol: '#',
        anchorLinkBefore: false,
        anchorLinkClassName: 'anchor',
        smoothScroll: true
      });
      mokujiContent.appendChild(mokuji);
    }
  }
};
