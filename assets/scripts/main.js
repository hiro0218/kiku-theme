import Router from './util/router';
import common from './module/common.js';
import animation from './module/animation.js';
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
      var article = document.getElementsByTagName('article');
      common.clickableElement(article);
      animation.show(article, 'showIn');
    },
    finalize: function() {}
  },
  // single
  'single': {
    init: function() {
      var article = document.getElementsByTagName('article')[0];
      var entry = article.getElementsByClassName('entry-content')[0];
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
      Sage.home.init();
    }
  },
  'search': {
    init: function() {
      Sage.home.init();
    }
  }
};

// Load Events
document.addEventListener("DOMContentLoaded", new Router(Sage).loadEvents(), false);
