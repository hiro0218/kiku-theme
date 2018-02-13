import VueRouter from 'vue-router';

Vue.use(VueRouter);

export default new VueRouter({
  base: '',
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Home',
      component: { template: '<div>Home</div>' },
    },
    {
      path: '/page/:page_number',
      name: 'paged',
      component: { template: '<div>page</div>' },
    },
    {
      path: '/tag/:tag_id',
      name: 'tag',
      component: { template: '<div>tag</div>' },
    },
    {
      path: '/search/:search_query',
      name: 'search',
      component: { template: '<div>search</div>' },
    },
    {
      path: '/category/:category_id',
      name: 'category',
      component: { template: '<div>category</div>' },
    },
    {
      path: '*',
      name: 'post',
      component: { template: '<div>post</div>' },
    },
  ],
});
