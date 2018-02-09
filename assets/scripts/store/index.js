import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';

Vue.use(Vuex);

import { MODEL_POST } from '@scripts/models';

export default new Vuex.Store({
  state: {
    navigation: null,
    isOpenSidebar: false,
    requestHeader: {
      total: -1,
      totalpages: -1,
    },
    pageTitle: WP.page_title,
    postLists: [],
    post: MODEL_POST,
  },
  mutations: {
    setNavigation(state, payload) {
      state.navigation = payload;
    },
    toggleSidebar(state) {
      state.isOpenSidebar = !state.isOpenSidebar;
    },
    setReqestHeader(state, payload) {
      state.requestHeader = payload;
    },
    setPostLists(state, payload) {
      state.postLists = payload;
    },
    setPost(state, payload) {
      state.post = payload;
    },
  },
  // getters: {
  //   navigation(state) {
  //     return state.navigation;
  //   },
  // },
  actions: {},
  plugins: [
    createPersistedState({
      key: 'kiku',
      paths: ['navigation'],
      storage: window.sessionStorage,
    }),
  ],
});
