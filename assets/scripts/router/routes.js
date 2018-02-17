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
      id: route.id,
      type: route.type,
    },
  });
}

routes.push(
  {
    path: '/',
    name: 'home',
    component: entryHome,
    children: [
      {
        path: 'page/:page_number',
        name: 'paged',
        component: entryHome,
      },
    ],
  },
  {
    path: '/tag/:tag_id',
    name: 'tag',
    component: entryHome,
    children: [
      {
        path: 'page/:page_number',
        name: 'tag_paged',
        component: entryHome,
      },
    ],
  },
  {
    path: '/search/:search_query',
    name: 'search',
    component: entryHome,
    children: [
      {
        path: 'page/:page_number',
        name: 'search_paged',
        component: entryHome,
      },
    ],
  },
  {
    path: '/category/:category_id',
    name: 'category',
    component: entryHome,
    children: [
      {
        path: 'page/:page_number',
        name: 'category_paged',
        component: entryHome,
      },
    ],
  },
  {
    path: '*',
    component: entryHome,
  },
);

export default routes;
