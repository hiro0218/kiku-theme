import Router  from './util/router';
import common  from './routes/Common';
import home    from './routes/Home';
import archive from './routes/Home';   // same home
import search  from './routes/Home';   // same home
import single  from './routes/Single';
import page    from './routes/Single'; // same single

import './vendor/prism.js';
import './vendor/mdl.js';

// Use this variable to set up the common and page specific functions. If you
// rename this variable, you will also need to rename the namespace below.
const routes = {
  common,
  home, archive, search,
  single, page,
};

// Load Events
document.addEventListener("DOMContentLoaded", new Router(routes).loadEvents(), false);
