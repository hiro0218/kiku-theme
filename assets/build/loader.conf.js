const config = require('./config');

const jsLoaders = [
  { loader: 'cache' },
  { loader: 'thread' },
  { loader: 'babel' },
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
  sassLoaders,
}
