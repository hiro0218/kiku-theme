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
  _setClickEvent(event, element) {
    event.preventDefault();
    var title = element.getElementsByTagName('a')[0];
    if (title) {
      var permalink = title.getAttribute('href');
      location.href = permalink;
    }
  }

}
