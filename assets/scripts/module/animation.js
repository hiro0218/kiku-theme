module.exports = {
  show: function (entry, animation) {
    var self = this;
    var length = entry.length;

    for (var i = 0; i < length; i += 1) {
      entry[i].style.visibility = 'hidden';
      (function (j) {
        var delayTime = j * 250;
        self.delay()(function () {
          entry[j].style.visibility = '';  // 'visible';
          entry[j].classList.add(animation);
        }, delayTime);
      })(i);
    }
  },
  delay: function () {
    var timer = 0;
    return function (callback, delay) {
      clearTimeout(timer);
      timer = setTimeout(callback, delay);
    };
  }
};
