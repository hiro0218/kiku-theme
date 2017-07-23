import Router from './util/router';

import common from './routes/Common';
import home from './routes/Home';
import date from './routes/Date';
import category from './routes/Category';
import search from './routes/Home';
import single from './routes/Single';
import page from './routes/Page';


// Use this variable to set up the common and page specific functions. If you
// rename this variable, you will also need to rename the namespace below.
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  date,
  category,
  search,
  // Single
  single,
  page,
});

// Load Events
document.addEventListener('DOMContentLoaded', routes.loadEvents(), false);
