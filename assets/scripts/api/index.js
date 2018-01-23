export default {
  api: null,
  settings: {
    baseURL: '/wp-json/wp/v2',
    params: {
      per_page: WP.per_page,
      page: WP.paged,
      orderby: 'modified',
      search: WP.search,
      tags: WP.tag,
      categories: WP.category,
      categories_exclude: WP.categories_exclude,
    },
  },
  getInstance() {
    if (!this.api) {
      this.api = axios.create(this.settings);
    }

    return this.api;
  },
  getNavigation() {
    var client = this.getInstance();
    return client.get('/wp-json/kiku/v1/navigation', { baseURL: '/' });
  },
  getPosts(post_id) {
    var client = this.getInstance();
    var id = post_id || '';

    return client.get(`/posts/${id}`);
  },
  getPages(post_id) {
    var client = this.getInstance();
    var id = post_id || '';

    return client.get(`/pages/${id}`);
  },
  getAttachData(post_id) {
    var client = this.getInstance();

    return client.get(`/wp-json/kiku/v1/post/${post_id}`, { baseURL: '/' });
  },
};
