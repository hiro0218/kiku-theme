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
      per_page: WP.per_page,
      page: WP.paged,
      orderby: 'modified',
      search: WP.search,
      tags: WP.tag,
      categories: WP.category,
      categories_exclude: WP.categories_exclude,
    },
    adapter: cache.adapter,
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
