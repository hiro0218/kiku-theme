import VueRouter from 'vue-router';
import routes from './routes.js';

Vue.use(VueRouter);

export default new VueRouter({
  mode: 'history',
  routes: routes,
});
