import './polyfill.js';
import './app.js';

import Router from './util/router';
// import common from './routes/Common';
import home from './routes/Home';
import category from './routes/Category';
import search from './routes/Search';
import tag from './routes/Tag';
import single from './routes/Single';
import page from './routes/Page';
import error404 from './routes/Error404';

// Use this variable to set up the common and page specific functions. If you
// rename this variable, you will also need to rename the namespace below.
const routes = new Router({
  // All pages
  // common,
  // Home page
  home,
  category,
  search,
  tag,
  // Singular
  single,
  page,
  // 404
  error404,
});

// Load Events
document.addEventListener('DOMContentLoaded', routes.loadEvents(), false);
