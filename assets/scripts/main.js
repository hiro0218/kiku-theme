import Router from './util/router';
import common from './module/common.js';
import './module/prism.js';
import 'material-design-lite/material.js';


// Use this variable to set up the common and page specific functions. If you
// rename this variable, you will also need to rename the namespace below.
var Sage = {
  // All pages
  'common': {
    init: function() {
      // JavaScript to be fired on all pages
    },
    finalize: function() {
      // JavaScript to be fired on all pages, after page specific JS is fired
    }
  },
  // Home page
  'home': {
    init: function() {
      // JavaScript to be fired on the home page
    },
    finalize: function() {
      // JavaScript to be fired on the home page, after the init JS
      var entry = document.getElementsByTagName('article');
      common.clickableElement(entry);
    }
  },
  // single
  'single': {
    init: function() {
      var entry = document.getElementsByTagName('article').getElementsByClassName('entry-content')[0];
      common.addExternalLink(entry);
    }
  },
  // page
  'page': {
    init: function() {
      Sage.single.init();
    }
  },
  'archive': {
    init: function() {
      var entry = document.getElementsByTagName('article');
      common.clickableElement(entry);
    }
  },
  'search': {
    init: function() {
      var entry = document.getElementsByTagName('article');
      common.clickableElement(entry);
    }
  },
  // About us page, note the change from about-us to about_us.
  'about_us': {
    init: function() {
      // JavaScript to be fired on the about us page
    }
  }
};

// Load Events
document.addEventListener("DOMContentLoaded", new Router(Sage).loadEvents(), false);
