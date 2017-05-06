export default {
  init() {
    this._setThumbnailImage();
  },
  finalize() {},
  _setThumbnailImage() {
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
          // remove no image icon
          var icon = element.getElementsByClassName('icon')[0];
          icon.remove();
        };
      }

      var img = new Image();
      img.onload = _loadImage(sheet, imageUrl);
      img.src = imageUrl;
    }
  }
};
