module.exports = {
  clickableElement: function(entry) {
    var self = this;
    var length = entry.length;
    for (var i = 0; i < length; i++) {
      entry[i].addEventListener('click', function(event) {
        self._setClickEvent(event, this)
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
  _setClickEvent(event, element) {
    event.preventDefault();
    var title = element.getElementsByTagName('a')[0];
    if (title) {
      var permalink = title.getAttribute('href');
      location.href = permalink;
    }
  }

}
