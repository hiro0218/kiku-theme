/* global WP */
import home from '@scripts/view/home';

export default {
  init() {
    home.view(`/wp-json/wp/v2/posts?per_page=${WP.per_page}&page=${WP.paged}&orderby=modified&search=${WP.search}`);
  },
  finalize() {},
};
