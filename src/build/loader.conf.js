const path = require('path');
const config = require('./config');

const styleLoaders = [
  {
    loader: 'css-loader',
    options: {
      output: { path: config.paths.dist },
      context: config.paths.src,
      sourceMap: config.enabled.sourceMaps,
    },
  },
  { loader: 'svg-transform-loader/encode-query-loader' },
  {
    loader: 'postcss-loader',
    options: {
      config: { path: __dirname, ctx: config },
      sourceMap: config.enabled.sourceMaps,
    },
  },
  {
    loader: 'resolve-url-loader',
    options: {
      keepQuery: true,
      sourceMap: config.enabled.sourceMaps,
    }
  },
  {
    loader: 'sass-loader',
    options: {
      output: { path: config.paths.dist },
      context: config.paths.src,
      sourceMap: config.enabled.sourceMaps,
    },
  },
  {
    loader: 'sass-resources-loader',
    options: {
      resources: [
        path.resolve(__dirname, '../assets/styles/config/_colors.scss'),
        path.resolve(__dirname, '../assets/styles/config/_variables.scss'),
        path.resolve(__dirname, '../assets/styles/config/_mixins.scss'),
      ]
    },
  },
];

module.exports = {
  styleLoaders
}
