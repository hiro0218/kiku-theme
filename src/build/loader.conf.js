const config = require('./config');
const enablesourceMap = config.enabled.sourceMaps;

const commonLoader = {
  css: {
    loader: 'css',
    options: {
      sourceMap: enablesourceMap,
    },
  },
  postcss: {
    loader: 'postcss',
    options: {
      config: { path: __dirname, ctx: config },
      sourceMap: enablesourceMap,
    },
  },
};

const cssLoaders = [
  { loader: 'cache' },
  commonLoader.css,
  commonLoader.postcss,
];

const sassLoaders = [
  { loader: 'cache' },
  commonLoader.css,
  { loader: 'svg-transform-loader/encode-query-loader' },
  commonLoader.postcss,
  {
    loader: 'resolve-url',
    options: {
      keepQuery: true,
      sourceMap: enablesourceMap,
    }
  },
  {
    loader: 'sass',
    options: {
      sourceMap: enablesourceMap,
    },
  },
];

module.exports = {
  cssLoaders,
  sassLoaders,
}
