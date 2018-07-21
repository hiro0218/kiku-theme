import mediumZoom from 'medium-zoom';
import * as Mokuji from 'mokuji.js';

export default {
  init(target) {
    this.addExternalLinkIcon(target);
    this.setTableContainer(target);
    this.setupSyntaxHighligh(target);
    this.setupZoomImage(target);
    this.setupMokuji(target);
  },
  addExternalLinkIcon(entry) {
    var aTags = entry.getElementsByTagName('a');
    var length = aTags.length;

    for (var i = 0; i < length; i++) {
      this.setExternalLinkIcon(aTags[i]);
    }
  },
  setExternalLinkIcon(element) {
    var href = element.getAttribute('href');
    // exclude javascript and anchor
    if (href.substring(0, 10).toLowerCase() === 'javascript' || href.substring(0, 1) === '#') {
      return;
    }

    // check hostname
    if (element.hostname === location.hostname) {
      return;
    }

    // set target and rel
    element.setAttribute('target', '_blank');
    element.setAttribute('rel', 'nofollow');
    element.setAttribute('rel', 'noopener');

    // set icon when childNode is text
    if (element.hasChildNodes()) {
      if (element.childNodes[0].nodeType === 3) {
        // add icon class
        element.classList.add('icon-open_in_new');
      }
    }
  },
  setTableContainer(entry) {
    var tables = entry.querySelectorAll('table');
    var length = tables.length;

    if (length === 0) {
      return;
    }

    var div = document.createElement('div');
    div.classList.add('table-container');

    for (var i = 0; i < length; i += 1) {
      var wrapper = div.cloneNode(false);
      tables[i].parentNode.insertBefore(wrapper, tables[i]);
      wrapper.appendChild(tables[i]);
    }
  },
  setupSyntaxHighligh(entry) {
    const pre = entry.getElementsByTagName('pre');
    if (pre.length > 0) {
      Prism.highlightAll();
    }
  },
  setupZoomImage(entry) {
    var entryImg = entry.getElementsByTagName('img');
    var length = entryImg.length;

    for (var i = 0; i < length; i += 1) {
      // parentNode is <a> Tag
      if (entryImg[i].getAttribute('data-zoom-disabled') === 'true' || entryImg[i].parentNode.nodeName === 'A') {
        continue;
      }

      mediumZoom(entryImg[i]);
    }
  },
  setupMokuji(entry) {
    var mokujiContent = entry.getElementsByClassName('mokuji-content')[0];
    if (mokujiContent) {
      var mokuji = new Mokuji.init(entry, {
        anchorType: true,
        anchorLink: true,
        anchorLinkSymbol: '#',
        anchorLinkBefore: false,
        anchorLinkClassName: 'anchor',
      });
      mokujiContent.appendChild(mokuji);
    }
  },
};
