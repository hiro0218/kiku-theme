module.exports = {
  ua: navigator.userAgent.toLowerCase(),
  isSmartPhone: function () {
    return ((this.isiPhone()) || (this.isiPod()) || (this.isAndroid())) && (this.isMobile());
  },
  isiPhone: function () {
    return this.ua.indexOf('iphone') > 0;
  },
  isiPod: function () {
    return this.ua.indexOf('ipod') > 0;
  },
  isAndroid: function () {
    return this.ua.indexOf('android') > 0;
  },
  isMobile: function () {
    return this.ua.indexOf('mobile') > 0;
  }
};
