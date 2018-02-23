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
      slug: route.slug,
    },
  };

  if (route.type === 'post' || route.type === 'page') {
    temp.component = entrySingular;
  } else {
    // category, post_tag, etc
    temp.component = entryHome;
    temp.children = [
      {
        path: 'page/:page_number',
        name: `${route.type}_${route.id}_paged`,
        meta: {
          id: route.id,
          type: route.type,
          slug: route.slug,
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
    meta: {
      type: 'search',
    },
    children: [
      {
        path: 'page/:page_number',
        name: 'search_paged',
        component: entryHome,
        meta: {
          type: 'search',
        },
      },
    ],
  },
  {
    path: '*',
    component: entryHome,
  },
);

export default routes;
