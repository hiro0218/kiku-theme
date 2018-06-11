const config = require('./config');
const enablesourceMap = config.enabled.sourceMaps;

const commonLoader = {
  css: {
    loader: 'css-loader',
    options: {
      sourceMap: enablesourceMap,
    },
  },
  postcss: {
    loader: 'postcss-loader',
    options: {
      config: { path: __dirname, ctx: config },
      sourceMap: enablesourceMap,
    },
  },
};

const cssLoaders = [
  { loader: 'cache-loader' },
  commonLoader.css,
  commonLoader.postcss,
];

const sassLoaders = [
  { loader: 'cache-loader' },
  commonLoader.css,
  { loader: 'svg-transform-loader/encode-query-loader' },
  commonLoader.postcss,
  {
    loader: 'resolve-url-loader',
    options: {
      keepQuery: true,
      sourceMap: enablesourceMap,
    }
  },
  {
    loader: 'sass-loader',
    options: {
      sourceMap: enablesourceMap,
    },
  },
];

module.exports = {
  cssLoaders,
  sassLoaders,
}
