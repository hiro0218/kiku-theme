
module.exports = {
  init() {
    var trigger = document.getElementsByClassName('drawer-checkbox')[0];
    if (trigger) {
      var body = document.body;
      var className = 'open-drawer';
      trigger.addEventListener('change', function (e) {
        if (trigger.checked) {
          body.classList.add(className);
        } else {
          body.classList.remove(className);
        }
      });
    }
  }
};
