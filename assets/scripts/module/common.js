module.exports = {
  isSmartPhone: function() {
    var ua = navigator.userAgent.toLowerCase();
    if (ua.indexOf('iphone') > 0 || ua.indexOf('ipod') > 0 || ua.indexOf('android') > 0 && ua.indexOf('mobile') > 0){
        return true;
    }
    return false;
  },
  clickableElement: function(entry) {
    for (var i = 0, length = entry.length; i < length; i++) {
      entry[i].addEventListener('click', function(event) {
        event.preventDefault();
        var a = this.getElementsByTagName('a')[0];
        if (a) {
          location.href = a.getAttribute('href');
        }
      });
    }
  },
  addExternalLink: function(entry) {
    var icon = document.createElement('i');
    icon.appendChild(document.createTextNode('open_in_new'));
    icon.classList.add('material-icons', 'external-link');

    [].forEach.call(entry.getElementsByTagName('a'), function(element) {
      // ブックマークレットなどは除く
      if (element.getAttribute('href').substring(0, 10) == "javascript") {
        return false;
      }

      // 外部リンクだった場合
      if (element.origin !== location.origin && element.origin !== undefined) {
        element.setAttribute('target', '_blank');
        element.setAttribute('rel', 'nofollow');

        // 子要素がテキストならアイコン付与
        if (element.childNodes[0].nodeType === 3) { // is text
          element.appendChild(icon.cloneNode(true));
        }
      }

    });
  },
  zoomImage: function(entry) {
    var ImageZoom = require('image-zoom');
    var entryImg = entry.getElementsByTagName('img');

    // img none
    if (entryImg.length === 0) {
      return;
    }

    for (var i = 0, length = entryImg.length; i < length; i++) {
      // wrap Atag
      if (entryImg[i].parentNode.nodeName.toUpperCase() === "A") {
        continue;
      }

      // cursor zoom-in
      entryImg[i].style.cursor = 'zoom-in';

      entryImg[i].addEventListener('click', function(event) {
        event.stopPropagation();
        var zoom = new ImageZoom(this).overlay().padding(64);
        zoom.show();
      });
    }

  },
  delay: function(){
    var timer = 0;
    return function(callback, delay){
      clearTimeout(timer);
      timer = setTimeout(callback, delay);
    };
  }
}
