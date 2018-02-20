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
    requestNavigation({ commit }) {
      api.getNavigation().then(response => {
        commit('setNavigation', response.data);
      });
    },
    requestAdvertise({ commit }) {
      api.getAds().then(response => {
        let data = response.data;

        let ads1 = {
          display: data.ads1.display,
          content: data.ads1.content,
          script: data.ads1.script,
        };

        let ads2 = {
          display: data.ads2.display,
          content: data.ads2.content,
          script: data.ads2.script,
        };

        let ads3 = {
          content: data.ads3.content,
          script: data.ads3.script,
        };

        commit('setAdvertise', { ads1, ads2, ads3 });
      });
    },
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
    requestSinglePost({ commit }, route) {
      const response = route.meta.type === 'post' ? api.getPosts(route.meta.id) : api.getPages(route.meta.id);

      return response.then(response => {
        let json = response.data;
        let post = MODEL_POST;

        post.link = json.link;
        post.title = json.title.rendered;
        post.date.publish = json.date;
        post.date.modified =
          new Date(json.date).toDateString() === new Date(json.modified).toDateString() ? null : json.modified;
        post.content = json.content.rendered;
        post.categories = json.categories || post.categories;
        post.tags = json.tags || post.tags;
        post.amazon_product = json.amazon_product || post.amazon_product;

        commit('setPost', post);
      });
    },
    requestPostAttach({ commit }, route) {
      return api.getAttachData(route.meta.id).then(response => {
        commit('setPostAttach', {
          relateds: response.data.related || MODEL_POST.attach.relateds,
          pagers: response.data.pager || MODEL_POST.attach.pagers,
        });
      });
    },
  },
});
