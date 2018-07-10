import VueRouter from 'vue-router';
import VueMeta from 'vue-meta';
import routes from './routes.js';

Vue.use(VueRouter);
Vue.use(VueMeta);

const router = new VueRouter({
  mode: 'history',
  routes: routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition;
    } else {
      return { x: 0, y: 0 };
    }
  },
  linkActiveClass: '',
  linkExactActiveClass: '',
});

export default router;
