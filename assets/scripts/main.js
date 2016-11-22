import Router from './util/router';

import common from './routes/Common';
import home from './routes/Home';
import archive from './routes/Home';
import search from './routes/Home';
import single from './routes/Single';
import page from './routes/Single';

import './vendor/prism';
import './vendor/mdl';

// Use this variable to set up the common and page specific functions. If you
// rename this variable, you will also need to rename the namespace below.
const routes = {
  // All pages
  common,
  // Home page
  home,
  archive,
  search,
  // Single
  single,
  page
};

// Load Events
document.addEventListener('DOMContentLoaded', new Router(routes).loadEvents(), false);
