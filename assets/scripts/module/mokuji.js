const Mokuji = require('mokuji.js');

module.exports = {
  init(entry) {
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
  }
};
