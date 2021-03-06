const config = require('./config.js');
const cssnanoConfig = {
    autoprefixer: false,
    colormin: true,
    convertValues: true,
    cssDeclarationSorter: true,
    discardComments: { removeAll: true },
    discardDuplicates: true,
    discardEmpty: true,
    discardOverridden: true,
    mergeLonghand: true,
    mergeRules: true,
    minifyFontValues: true,
    minifySelectors: true,
    uniqueSelectors: true,
    svgo: true,
};

module.exports = ctx => ({
  parser: require('postcss-safe-parser'),
  plugins: [
    require('cssnano')({
      preset: ['default', cssnanoConfig],
    }),
    require('postcss-zindex'),
    require('postcss-flexbugs-fixes'),
    require('postcss-preset-env')({
      browsers: config.browsers,
      stage: 3,
    }),
    require('css-mqpacker'),
    ctx.env === 'production' && require('csswring'),
  ],
});
