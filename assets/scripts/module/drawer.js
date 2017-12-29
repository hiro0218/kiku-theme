export default {
  init() {
    var trigger = document.getElementsByClassName('drawer-checkbox')[0];
    if (!trigger) {
      return;
    }

    var self = this;
    trigger.addEventListener('change', function(e) {
      if (trigger.checked) {
        self.focusSearchInput();
      }
      document.body.classList.toggle('open-drawer');
    });
  },
  focusSearchInput() {
    var search = document.getElementById('widget_searchform');
    if (!search) {
      return;
    }
    search.focus();
  },
};
