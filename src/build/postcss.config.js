/* eslint-disable */

const config = require('./config.js');
const cssnanoConfig = {
    autoprefixer: false,
    colormin: true,
    convertValues: true,
    discardComments: { removeAll: true },
    discardDuplicates: true,
    discardEmpty: true,
    discardOverridden: true,
    mergeLonghand: true,
    mergeRules: true,
    minifyFontValues: true,
    minifySelectors: true,
    uniqueSelectors: true,
};

module.exports = ctx => ({
  parser: require('postcss-safe-parser'),
  plugins: {
    cssnano: cssnanoConfig,
    'postcss-flexbugs-fixes': require('postcss-flexbugs-fixes'),
    'postcss-cssnext': {
      browsers: config.browsers,
      cascade: false,
    },
    'css-mqpacker': require('css-mqpacker'),
    csswring: ctx.env === 'production',
  },
});
