import VueRouter from 'vue-router';
import routes from './routes.js';

Vue.use(VueRouter);

const router = new VueRouter({
  mode: 'history',
  routes: routes,
  scrollBehavior(to, from, savedPosition) {
    if (to.hash) {
      return {
        selector: to.hash,
      };
    }

    if (savedPosition) {
      return savedPosition;
    } else {
      return { x: 0, y: 0 };
    }
  },
});

export default router;
