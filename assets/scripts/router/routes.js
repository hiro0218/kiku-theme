import entryHome from '@components/entry-home.vue';
import entrySingular from '@components/entry-singular.vue';

let routes = [];

for (let key in WP.routes) {
  let route = WP.routes[key];
  let temp = {};

  temp = {
    name: `${route.type}_${route.id}`,
    path: route.path,
    meta: {
      id: route.id,
      type: route.type,
    },
  };

  if (route.type === 'post' || route.type === 'page') {
    temp.component = entrySingular;
  } else {
    temp.component = entryHome;
  }

  if (route.type === 'category') {
    temp.children = [
      {
        path: 'page/:page_number',
        name: `${route.type}_${route.id}_paged`,
        meta: {
          id: route.id,
          type: route.type,
        },
        component: entryHome,
      },
    ];
  }

  routes.push(temp);
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
    path: '*',
    component: entryHome,
  },
);

export default routes;
