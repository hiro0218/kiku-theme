'use strict'; // eslint-disable-line

const { default: ImageminPlugin } = require('imagemin-webpack-plugin');
const imageminMozjpeg = require('imagemin-mozjpeg');

const config = require('./config');

module.exports = {
  plugins: [
    new ImageminPlugin({
      optipng: { optimizationLevel: 7 },
      gifsicle: { optimizationLevel: 3 },
      pngquant: { quality: '65-90', speed: 4 },
      svgo: {
        removeUnknownsAndDefaults: false,
        cleanupIDs: false,
        cleanupAttrs: true,
        removeDoctype: true,
        removeXMLProcInst: true,
        removeComments: true,
        removeMetadata: true,
        removeTitle: true,
        removeDesc: true,
        removeUselessDefs: true,
        removeXMLNS: true,
        removeEditorsNSData: true,
        removeEmptyAttrs: true,
        removeHiddenElems: true,
        removeEmptyText: true,
        removeEmptyContainers: true,
      },
      plugins: [imageminMozjpeg({ quality: 75 })],
      disable: (config.enabled.watcher),
    }),
  ],
};
