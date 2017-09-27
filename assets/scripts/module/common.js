import Zooming from 'zooming';

module.exports = {
  setThumbnailImage() {
    var tmbContainer = document.getElementsByClassName('entry-image');
    var length = tmbContainer.length;
    if (length === 0) {
      return;
    }

    for (var i = 0; i < length; i += 1) {
      var container = tmbContainer[i];
      var imageUrl = container.dataset.thumbnailImage;
      if (!imageUrl) {
        continue;
      }

      var sheet = container.getElementsByClassName('image-sheet')[0];

      function _loadImage(element, url) {
        return function () {
          // set background image
          element.style.backgroundImage = 'url(' + url + ')';
        };
      }

      var img = new Image();
      img.onload = _loadImage(sheet, imageUrl);
      img.src = imageUrl;
    }
  },
  addExternalLink(entry) {
    var self = this;
    var icon = document.createElement('i');
    icon.classList.add('icon-open_in_new');

    [].forEach.call(entry.getElementsByTagName('a'), function (element) {
      self.setExternalLinkIcon(element, icon);
    });
  },
  setExternalLinkIcon(element, icon) {
    if (typeof element.origin === 'undefined') {
      return;
    }

    var href = element.getAttribute('href');
    // exclude javascript and anchor
    if ((href.substring(0, 10).toLowerCase() === 'javascript') || (href.substring(0, 1) === '#')) {
      return;
    }

    // check hostname
    if (element.hostname === location.hostname) {
      return;
    }

    // set target and rel
    element.setAttribute('target', '_blank');
    element.setAttribute('rel', 'nofollow');

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
      scaleBase: .8
    });

    for (var i = 0; i < length; i += 1) {
      // parentNode is <a> Tag
      if (entryImg[i].getAttribute('data-zoom-disabled') === 'true' || entryImg[i].parentNode.nodeName === 'A') {
        continue;
      }
      entryImg[i].style.cursor = 'zoom-in';
      zoom.listen(entryImg[i]);
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
      tables[i].before(wrapper);
      wrapper.append(tables[i]);
    }
  },
  getStyleSheetValue(element, property) {
    if (!element || !property) {
      return null;
    }

    var style = window.getComputedStyle(element);
    var value = style.getPropertyValue(property);

    return value;
  }
};
