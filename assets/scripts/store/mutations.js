import { cloneDeep } from 'lodash-es';
import { MODEL_POST, MODEL_ADS } from '@scripts/models';

export default {
  changeLoading(state, payload) {
    state.isLoading = payload;
  },
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
    state.post.attach.relateds = relateds || cloneDeep(MODEL_POST.attach.relateds);
    state.post.attach.pagers = pagers || cloneDeep(MODEL_POST.attach.pagers);
  },
  setAdvertise(state, { ads1, ads2, ads3 }) {
    state.advertise = Object.assign(MODEL_ADS, ads1 && { ads1 }, ads2 && { ads2 }, ads3 && { ads3 });
  },
};
