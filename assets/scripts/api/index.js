export default {
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
  getNavigation() {
    var client = axios.create({ baseURL: '/wp-json/kiku/v1/navigation' });
    return client.get();
  },
  getPosts(post_id) {
    var client = axios.create(this.settings);
    var id = post_id || '';

    return client.get(`/posts/${id}`);
  },
  getPages(post_id) {
    var client = axios.create(this.settings);
    var id = post_id || '';

    return client.get(`/pages/${id}`);
  },
  getAttachData(baseURL) {
    var option = Object.assign(this.settings, { baseURL });
    var client = axios.create(option);

    return client.get();
  },
};
