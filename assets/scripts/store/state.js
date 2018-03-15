import { cloneDeep } from 'lodash-es';
import {
  MODEL_NAVIGATION,
  MODEL_THEMES,
  MODEL_POST,
  MODEL_POST_LIST,
  MODEL_REQUEST_HEADER,
  MODEL_ADS,
} from '@scripts/models';

export default {
  pageTitle: document.title,
  isOpenSidebar: false,
  isLoading: false,
  navigation: MODEL_NAVIGATION,
  themes: MODEL_THEMES,
  requestHeader: cloneDeep(MODEL_REQUEST_HEADER),
  postLists: MODEL_POST_LIST,
  post: cloneDeep(MODEL_POST),
  advertise: cloneDeep(MODEL_ADS),
};
