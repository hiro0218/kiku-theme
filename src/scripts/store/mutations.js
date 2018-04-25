import { MODEL_ADS } from '@scripts/models';

export default {
  changeLoading(state, payload) {
    state.isLoading = payload;
  },
  setPageTitle(state, title) {
    state.pageTitle = title;
  },
  setThemes(state, payload) {
    state.themes = payload;
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
  setAdvertise(state, { ads1, ads2, ads3 }) {
    state.advertise = Object.assign(MODEL_ADS, ads1 && { ads1 }, ads2 && { ads2 }, ads3 && { ads3 });
  },
};
