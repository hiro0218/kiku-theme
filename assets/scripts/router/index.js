import VueRouter from 'vue-router';

import entryHome from '@components/entry-home.vue';
import entrySingular from '@components/entry-singular.vue';

Vue.use(VueRouter);

export default new VueRouter({
  base: '',
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'home',
      component: entryHome,
    },
    {
      path: '/tag/:tag_id',
      name: 'tag',
      component: entryHome,
    },
    {
      path: '/search/:search_query',
      name: 'search',
      component: entryHome,
    },
    {
      path: '/category/:category_id',
      name: 'category',
      component: entryHome,
    },
    {
      path: '*/page/:page_number',
      name: 'paged',
      component: entryHome,
    },
    {
      path: '/*',
      name: 'post',
      component: entrySingular,
    },
  ],
});
