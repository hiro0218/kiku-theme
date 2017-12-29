import Zooming from 'zooming';

export default {
  setThumbnailImage() {
    var container = document.getElementsByClassName('entry-image');
    var length = container.length;
    if (length === 0) {
      return;
    }

    for (var i = 0; i < length; i += 1) {
      var imageUrl = container[i].dataset.thumbnailImage;
      if (!imageUrl) {
        continue;
      }

      var sheet = container[i].getElementsByClassName('image-sheet')[0];
      var img = new Image();
      img.onload = (function(element, url) {
        // set background image
        element.style.backgroundImage = 'url(' + url + ')';
      })(sheet, imageUrl);
      img.src = imageUrl;
    }
  },
  addExternalLink(entry) {
    var aTags = entry.getElementsByTagName('a');
    var length = aTags.length;
    if (length === 0) {
      return;
    }

    var icon = document.createElement('i');
    icon.classList.add('icon-open_in_new');

    for (var i = 0; i < length; i++) {
      this.setExternalLinkIcon(aTags[i], icon.cloneNode(false));
    }
  },
  setExternalLinkIcon(element, icon) {
    var href = element.getAttribute('href');
    // exclude javascript and anchor
    if (
      href.substring(0, 10).toLowerCase() === 'javascript' ||
      href.substring(0, 1) === '#'
    ) {
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
        element.appendChild(icon.cloneNode(true));
      }
    }
  },
  zoomImage(element) {
    var entryImg = element.getElementsByTagName('img');
    var length = entryImg.length;

    // entry has no img
    if (length === 0) {
      return;
    }

    var zoom = new Zooming({
      scaleBase: 0.8,
    });

    for (var i = 0; i < length; i += 1) {
      // parentNode is <a> Tag
      if (
        entryImg[i].getAttribute('data-zoom-disabled') === 'true' ||
        entryImg[i].parentNode.nodeName === 'A'
      ) {
        continue;
      }
      entryImg[i].style.cursor = 'zoom-in';
      zoom.listen(entryImg[i]);
    }
  },
  wrap(element, wrapper) {
    element.parentNode.insertBefore(wrapper, element);
    wrapper.appendChild(element);
  },
  setTableContainer(entry) {
    var self = this;
    var tables = entry.querySelectorAll('table');
    var length = tables.length;

    if (length === 0) {
      return;
    }

    var div = document.createElement('div');
    div.classList.add('table-container');

    for (var i = 0; i < length; i += 1) {
      var wrapper = div.cloneNode(false);
      self.wrap(tables[i], wrapper);
    }
  },
  getStyleSheetValue(element, property) {
    if (!element || !property) {
      return null;
    }

    var style = window.getComputedStyle(element);
    var value = style.getPropertyValue(property);

    return value;
  },
};
