
module.exports = {
  init() {
    var trigger = document.getElementsByClassName('drawer-checkbox')[0];
    if (trigger) {
      var self = this;
      var className = 'open-drawer';
      trigger.addEventListener('change', function (e) {
        if (trigger.checked) {
          document.body.classList.add(className);
          self.focusSearchInput();
        } else {
          document.body.classList.remove(className);
        }
      });
    }
  },
  focusSearchInput() {
    var search = document.getElementById('widget_searchform');
    if (search) {
      search.focus();
    }
  }
};
