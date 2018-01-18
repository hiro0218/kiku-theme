import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersistence from 'vuex-persist';

const vuexPersist = new VuexPersistence({
  key: 'kiku',
  storage: window.sessionStorage,
});

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
  plugins: [vuexPersist.plugin],
});
