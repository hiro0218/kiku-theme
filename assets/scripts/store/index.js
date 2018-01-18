import Vue from 'vue';
import Vuex from 'vuex';

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
});
