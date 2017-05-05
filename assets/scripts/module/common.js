module.exports = {
  // clickableElement(entry) {
  //   for (var i = 0, length = entry.length; i < length; i += 1) {
  //     entry[i].addEventListener('click', function (event) {
  //       event.preventDefault();
  //       var a = this.getElementsByTagName('a')[0];
  //       if (a) {
  //         location.href = a.getAttribute('href');
  //       }
  //     });
  //   }
  // },
  addExternalLink(entry) {
    var self = this;
    var icon = document.createElement('i');
    icon.appendChild(document.createTextNode('open_in_new'));
    icon.classList.add('material-icons', 'external-link');
    [].forEach.call(entry.getElementsByTagName('a'), function (element) {
      self.setLinkIcon(element, icon);
    });
  },
  setLinkIcon(element, icon) {
    var href = element.getAttribute('href');
    // ブックマークレットなどは除く
    if ((href.substring(0, 10) !== 'javascript') && (href.substring(0, 1) !== '#')) {
      // 外部リンクだった場合
      if (element.origin !== location.origin && element.origin !== 'undefined') {
        element.setAttribute('target', '_blank');
        element.setAttribute('rel', 'nofollow');

        // 子要素がテキストならアイコン付与
        if (element.childNodes[0].nodeType === 3) { // is text
          element.appendChild(icon.cloneNode(true));
        }
      }
    }
  },
  zoomImage(entry) {
    var ImageZoom = require('image-zoom');
    var entryImg = entry.getElementsByTagName('img');

    // img none
    if (entryImg.length === 0) {
      return;
    }

    for (var i = 0, length = entryImg.length; i < length; i += 1) {
      // wrap Atag
      if (entryImg[i].getAttribute('data-zoom-disabled') === 'true' || entryImg[i].parentNode.nodeName.toUpperCase() === 'A') {
        continue;
      }

      // cursor zoom-in
      entryImg[i].style.cursor = 'zoom-in';

      entryImg[i].addEventListener('click', function (event) {
        event.stopPropagation();
        var zoom = new ImageZoom(this).overlay().padding(64);
        zoom.show();
      });
    }
  },
  /**
   * delay()(function(){console.log("hello1");}, 5000);
   */
  delay() {
    var timer = 0;
    return function (callback, delay) {
      clearTimeout(timer);
      timer = setTimeout(callback, delay);
    };
  },
  getStyleSheetValue(element, property) {
    if (!element || property) {
      return null;
    }

    var style = window.getComputedStyle(element);
    var value = style.getPropertyValue(property);

    return value;
  }
};
