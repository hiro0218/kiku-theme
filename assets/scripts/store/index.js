import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';

Vue.use(Vuex);

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
