import localforage from 'localforage';
import { setupCache } from 'axios-cache-adapter';

export default {
  api: null,
  settings: {
    baseURL: '/wp-json/wp/v2',
    headers: { 'X-WP-Nonce': WP.nonce },
    params: {},
  },
  setupCacheAdapter() {
    if (WP.is_preview) {
      return;
    }

    const cache = setupCache({
      store: localforage.createInstance({
        driver: [localforage.INDEXEDDB, localforage.LOCALSTORAGE],
        name: 'kiku-cache',
      }),
      maxAge: 15 * 60 * 1000, // 15 minutes
      key: request => {
        let stringParams = '';
        if (Object.keys(request.params).length) {
          stringParams = request.params ? JSON.stringify(request.params) : '';
        }
        return request.url + stringParams;
      },
      exclude: {
        query: false,
      },
    });

    this.settings.adapter = cache.adapter;
  },
  setupProgress() {
    // setupUpdateProgress
    axios.defaults.onDownloadProgress = e => {
      const percentage = Math.floor(e.loaded * 1.0) / e.total;
      NProgress.set(percentage);
    };

    // setupStopProgress
    axios.interceptors.response.use(response => {
      NProgress.done(true);
      return response;
    });
  },
  preparedParams() {
    this.settings.params = Object.assign(
      {},
      WP.per_page && { per_page: WP.per_page },
      WP.search && { search: WP.search },
      WP.categories_exclude && { categories_exclude: WP.categories_exclude },
    );
  },
  getInstance() {
    if (!this.api) {
      this.setupProgress();
      this.preparedParams();
      this.setupCacheAdapter();
      this.api = axios.create(this.settings);
    }

    return this.api;
  },
  getNavigation() {
    var client = this.getInstance();

    return client.get('/wp-json/kiku/v1/navigation', {
      baseURL: '/',
      params: '',
    });
  },
  getAttachData(post_id) {
    var client = this.getInstance();

    return client.get(`/wp-json/kiku/v1/post/${post_id}`, {
      baseURL: '/',
      params: '',
    });
  },
  getAds() {
    var client = this.getInstance();

    return client.get('/wp-json/kiku/v1/advertise', {
      baseURL: '/',
      params: '',
    });
  },
  getPostList({ meta, params }) {
    var client = this.getInstance();

    return client.get('/posts/?list', {
      params: Object.assign(
        this.settings.params,
        { orderby: 'modified' },
        meta.type === 'post_tag' && meta.id && { tags: meta.id },
        meta.type === 'category' && meta.id && { categories: meta.id },
        params.page_number && { page: params.page_number },
      ),
    });
  },
  getPosts(post_id) {
    var client = this.getInstance();
    let path = `/posts/${post_id}`;
    if (WP.is_preview) {
      path += '/revisions';
    }

    return client.get(path).then(res => {
      if (WP.is_preview) {
        res.data = res.data[0];
      }
      return res;
    });
  },
  getPages(post_id) {
    var client = this.getInstance();
    let path = `/pages/${post_id}`;
    if (WP.is_preview) {
      path += '/revisions';
    }

    return client.get(path).then(res => {
      if (WP.is_preview) {
        res.data = res.data[0];
      }
      return res;
    });
  },
};
