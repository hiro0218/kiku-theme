module.exports = {
  ua: navigator.userAgent.toLowerCase(),
  isSmartPhone() {
    return ((this.isiPhone()) || (this.isiPod()) || (this.isAndroid())) && (this.isMobile());
  },
  isiPhone() {
    return this.ua.indexOf('iphone') > 0;
  },
  isiPod() {
    return this.ua.indexOf('ipod') > 0;
  },
  isAndroid() {
    return this.ua.indexOf('android') > 0;
  },
  isMobile() {
    return this.ua.indexOf('mobile') > 0;
  }
};
