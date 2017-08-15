/* global WP */
import home from '../vue/home';

export default {
  init() {
    home.view(`/wp-json/wp/v2/posts?per_page=${WP.per_page}&page=${WP.paged}&orderby=modified&categories_exclude=${WP.categories_exclude}`);
  },
  finalize() {},
};
