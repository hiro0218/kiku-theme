import './polyfill.js';
import './app.js';

import Router from './util/router';
// import common from './routes/Common';
import home from './routes/Home';
import single from './routes/Single';
import error404 from './routes/Error404';

// Use this variable to set up the common and page specific functions. If you
// rename this variable, you will also need to rename the namespace below.
const routes = new Router({
  // All pages
  // common,
  // Home page
  home,
  category: home,
  search: home,
  tag: home,
  // Singular
  single,
  page: single,
  // 404
  error404,
});

// Load Events
document.addEventListener('DOMContentLoaded', routes.loadEvents(), false);
