import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    navigation: null,
  },
  mutations: {
    setNavigation(state, payload) {
      state.navigation = payload;
    },
  },
  getters: {
    navigation(state) {
      return state.navigation;
    },
  },
  actions: {},
  plugins: [
    createPersistedState({
      key: 'kiku',
      paths: ['navigation'],
      storage: window.sessionStorage,
    }),
  ],
});
