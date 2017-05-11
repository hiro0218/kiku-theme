const config = require('./config.js');
const sortingOption = {
  order: [
    'custom-properties',
    'dollar-variables',
    'declarations',
    'at-rules',
    {
      type: 'at-rule',
      name: 'include'
    },
    {
      type: 'at-rule',
      name: 'include',
      parameter: 'icon'
    },
    'rules'
  ],
  'properties-order': [
    {
      emptyLineBefore: true,
      properties: [
        'margin',
        'padding'
      ]
    },
    {
      emptyLineBefore: true,
      properties: [
        'border',
        'background'
      ]
    }
  ],
  'unspecified-properties-position': 'bottom'
};


module.exports = {
  plugins: [
    require('postcss-smart-import'),
    require('css-mqpacker')({
      sort: true
    }),
    require('cssnano')({
      options: {
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
      }
    }),
    require('postcss-will-change'),
    require('postcss-sorting')(sortingOption),
    require('postcss-cssnext')({
      browsers: config.browsers,
    }),
    require('postcss-zindex'),
  ],
  options: {
    output: { path: config.paths.dist },
    context: config.paths.assets,
    sourceMap: 'inline',
  },
};
