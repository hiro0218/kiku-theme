// polyfill

// https://caniuse.com/#feat=promises
import * as es6Promise from 'es6-promise';
if (!window.Promise) {
  es6Promise.polyfill();
}
