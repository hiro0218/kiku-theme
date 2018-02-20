import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import api from '@scripts/api';
import { MODEL_POST, MODEL_ADS } from '@scripts/models';

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
    advertise: MODEL_ADS,
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
    setPostAttach(state, { relateds, pagers }) {
      state.post.attach.relateds = relateds;
      state.post.attach.pagers = pagers;
    },
    setAdvertise(state, { ads1, ads2, ads3 }) {
      state.advertise = Object.assign(MODEL_ADS, ads1 && { ads1 }, ads2 && { ads2 }, ads3 && { ads3 });
    },
  },
  // getters: {
  //   navigation(state) {
  //     return state.navigation;
  //   },
  // },
  actions: {
    requestPostList({ commit }, route) {
      return api
        .getPostList({ meta: route.meta, params: route.params })
        .then(response => {
          commit('setReqestHeader', {
            total: Number(response.headers['x-wp-total']),
            totalpages: Number(response.headers['x-wp-totalpages']),
          });

          return response.data;
        })
        .then(data => {
          let postLists = [];

          for (let json of data) {
            let post = {};

            post.title = json.title.rendered;
            post.link = json.link;
            post.excerpt = json.excerpt.rendered;
            post.thumbnail = json.thumbnail;
            post.date = json.modified;

            postLists.push(post);
          }

          commit('setPostLists', postLists);
        });
    },
  },
});
