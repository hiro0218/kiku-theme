import localforage from 'localforage';
import { setupCache } from 'axios-cache-adapter';

const cache = setupCache({
  store: localforage.createInstance({
    driver: [localforage.INDEXEDDB, localforage.LOCALSTORAGE],
    name: 'kiku-cache',
  }),
  maxAge: 30 * 60 * 1000, // half an hour
  key: request => {
    return request.url + JSON.stringify(request.params);
  },
  exclude: {
    query: false,
  },
});

export default {
  api: null,
  settings: {
    baseURL: '/wp-json/wp/v2',
    params: {
      orderby: 'modified',
    },
    adapter: cache.adapter,
  },
  preparedParams() {
    this.settings.params = Object.assign(
      this.settings.params,
      WP.per_page && { per_page: WP.per_page },
      WP.paged && { page: WP.paged },
      WP.search && { search: WP.search },
      WP.tag && { tags: WP.tag },
      WP.category && { categories: WP.category },
      WP.categories_exclude && { categories_exclude: WP.categories_exclude },
    );
  },
  getInstance() {
    if (!this.api) {
      this.preparedParams();
      this.api = axios.create(this.settings);
    }

    return this.api;
  },
  getNavigation() {
    var client = this.getInstance();

    return client.get('/wp-json/kiku/v1/navigation', { baseURL: '/' });
  },
  getPostList() {
    var client = this.getInstance();

    return client.get('/posts/?list');
  },
  getPosts(post_id) {
    var client = this.getInstance();

    return client.get(`/posts/${post_id}`);
  },
  getPages(post_id) {
    var client = this.getInstance();

    return client.get(`/pages/${post_id}`);
  },
  getAttachData(post_id) {
    var client = this.getInstance();

    return client.get(`/wp-json/kiku/v1/post/${post_id}`, { baseURL: '/' });
  },
};
