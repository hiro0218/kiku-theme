import headerScroll from 'header-scroll-up';

export default {
  init() {
    headerScroll.setScrollableHeader('.header-navigation', {
      topOffset: 100,
    });
  },
};
