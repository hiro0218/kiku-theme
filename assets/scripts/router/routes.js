import pageHome from '@/pages/home.vue';
import pageSingular from '@/pages/singular.vue';
import pageNotFound from '@/pages/notFound.vue';

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
      title: route.title,
      slug: route.slug,
    },
  };

  if (route.type === 'post' || route.type === 'page') {
    temp.component = pageSingular;
  } else {
    // category, post_tag, etc
    temp.component = pageHome;
    temp.children = [
      {
        path: 'page/:page_number',
        name: `${route.type}_${route.id}_paged`,
        meta: {
          id: route.id,
          type: route.type,
          title: route.title,
          slug: route.slug,
        },
        component: pageHome,
      },
    ];
  }

  routes.push(temp);
}

routes.push(
  {
    path: '/',
    name: 'home',
    component: pageHome,
    children: [
      {
        path: 'page/:page_number',
        name: 'paged',
        component: pageHome,
      },
    ],
  },
  {
    path: '/search/:search_query',
    name: 'search',
    component: pageHome,
    meta: {
      type: 'search',
    },
    children: [
      {
        path: 'page/:page_number',
        name: 'search_paged',
        component: pageHome,
        meta: {
          type: 'search',
        },
      },
    ],
  },
  {
    path: '*',
    name: 'notFound',
    component: pageNotFound,
  },
);

export default routes;
