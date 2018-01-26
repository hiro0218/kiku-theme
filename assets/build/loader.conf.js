const config = require('./config');

const jsLoaders = [
  { loader: 'cache' },
  { loader: 'babel' },
];

const cssLoaders = [
  { loader: 'cache' },
  { loader: 'css', options: { sourceMap: config.enabled.sourceMaps } },
  {
    loader: 'postcss', options: {
      config: { path: __dirname, ctx: config },
      sourceMap: config.enabled.sourceMaps,
    },
  },
];

const sassLoaders = [
  { loader: 'cache' },
  { loader: 'css', options: { sourceMap: config.enabled.sourceMaps } },
  {
    loader: 'postcss', options: {
      config: { path: __dirname, ctx: config },
      sourceMap: config.enabled.sourceMaps,
    },
  },
  { loader: 'resolve-url', options: { sourceMap: config.enabled.sourceMaps } },
  { loader: 'sass', options: { sourceMap: config.enabled.sourceMaps } },
];

module.exports = {
  jsLoaders,
  cssLoaders,
  sassLoaders,
}
