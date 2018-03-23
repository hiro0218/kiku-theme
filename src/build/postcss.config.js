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

module.exports = ({ file, options }) => {
  return {
    parser: options.enabled.optimize ? 'postcss-safe-parser' : undefined,
    plugins: {
      cssnano: options.enabled.optimize ? cssnanoConfig : false,
      'postcss-cssnext': {
        browsers: config.browsers,
      },
    },
  };
};
