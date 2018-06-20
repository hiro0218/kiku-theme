import pageHome from '@/pages/home.vue';
import pageSingular from '@/pages/singular.vue';
const pageNotFound = () => import(/* webpackChunkName: "pages" */ '@/pages/notFound.vue');
const pageArchive = () => import(/* webpackChunkName: "pages" */ '@/pages/archive.vue');

let routes = [];

for (let type in WP.routes) {
  let wp_route = WP.routes[type];

  for (let key in wp_route) {
    let route = wp_route[key];
    let temp = {};

    temp = {
      name: `${type}_${route.meta.id}`,
      path: route.path,
      meta: {
        type,
        ...route.meta,
      },
    };

    if (type === 'post' || type === 'page') {
      if (route.path === '/archive') {
        temp.name = 'archive';
        temp.component = pageArchive;
      } else {
        temp.component = pageSingular;
      }
    } else {
      // category, post_tag, etc
      temp.component = pageHome;
      temp.children = [
        {
          path: 'page/:page_number',
          name: `${type}_${route.meta.id}_paged`,
          meta: {
            type,
            ...route.meta,
          },
          component: pageHome,
        },
      ];
    }

    routes.push(temp);
  }
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
    path: '/preview',
    name: 'preview',
    component: pageSingular,
    meta: {
      type: 'preview',
    },
  },
  {
    path: '*',
    name: 'notFound',
    component: pageNotFound,
  },
);

// unset
WP.routes = null;

export default routes;
