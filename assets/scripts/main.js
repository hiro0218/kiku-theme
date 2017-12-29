import 'intersection-observer';
import * as es6Promise from 'es6-promise';
if (!window.Promise) {
  es6Promise.polyfill();
}

import Router from './util/router';

import common from './routes/Common';
import home from './routes/Home';
import category from './routes/Category';
import search from './routes/Search';
import tag from './routes/Tag';
import single from './routes/Single';
import page from './routes/Page';

// Use this variable to set up the common and page specific functions. If you
// rename this variable, you will also need to rename the namespace below.
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  category,
  search,
  tag,
  // Singular
  single,
  page,
});

// Load Events
document.addEventListener('DOMContentLoaded', routes.loadEvents(), false);
