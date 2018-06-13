const config = require('./config');
const enablesourceMap = config.enabled.sourceMaps;

const commonLoader = {
  css: {
    loader: 'css-loader',
    options: {
      output: { path: config.paths.dist },
      context: config.paths.src,
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
  commonLoader.css,
  commonLoader.postcss,
];

const sassLoaders = [
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
      output: { path: config.paths.dist },
      context: config.paths.src,
      sourceMap: enablesourceMap,
    },
  },
];

module.exports = {
  cssLoaders,
  sassLoaders,
}
