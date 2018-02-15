import entryHome from '@components/entry-home.vue';
import entrySingular from '@components/entry-singular.vue';

let routes = [];

for (let key in WP.routes) {
  let route = WP.routes[key];
  routes.push({
    name: route.id,
    path: route.path,
    component: entrySingular,
    meta: {
      type: route.type,
    },
  });
}

routes.push(
  {
    path: '',
    name: 'home',
    component: entryHome,
  },
  {
    path: 'tag/:tag_id',
    name: 'tag',
    component: entryHome,
  },
  {
    path: 'search/:search_query',
    name: 'search',
    component: entryHome,
  },
  {
    path: 'category/:category_id',
    name: 'category',
    component: entryHome,
  },
  {
    path: '*/page/:page_number',
    name: 'paged',
    component: entryHome,
  },
);

export default routes;
