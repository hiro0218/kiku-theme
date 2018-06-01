'use strict'; // eslint-disable-line

const path = require('path');
const webpack = require('webpack');
const CleanPlugin = require('clean-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const CopyGlobsPlugin = require('copy-globs-webpack-plugin');
const FriendlyErrorsWebpackPlugin = require('friendly-errors-webpack-plugin');
const SpriteLoaderPlugin = require('svg-sprite-loader/plugin');
const LodashModuleReplacementPlugin = require('lodash-webpack-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const ScriptExtHtmlWebpackPlugin = require('script-ext-html-webpack-plugin');

const config = require('./config');
const { cssLoaders, sassLoaders } = require('./loader.conf');

let webpackConfig = {
  context: config.paths.src,
  entry: config.entry,
  devtool: (config.enabled.sourceMaps ? '#source-map' : undefined),
  output: {
    path: config.paths.dist,
    publicPath: config.publicPath,
    filename: `scripts/[name].js?[hash:8]`,
    chunkFilename: 'scripts/[name].bundle.js?[hash:8]',
  },
  stats: {
    hash: false,
    version: false,
    timings: false,
    children: false,
    errors: false,
    errorDetails: false,
    warnings: false,
    chunks: false,
    modules: false,
    reasons: false,
    source: false,
    publicPath: false,
  },
  module: {
    rules: [
      {
        enforce: 'pre',
        exclude: /node_modules/,
        test: /\.js$/,
        include: config.paths.src,
        use: 'eslint',
      },
      {
        enforce: 'pre',
        test: /\.(js|s?[ca]ss)$/,
        include: config.paths.src,
        loader: 'import-glob',
      },
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: [
          { loader: 'cache' },
          { loader: 'babel?cacheDirectory' },
        ],
      },
      {
        test: /\.css$/,
        include: config.paths.src,
        use: ExtractTextPlugin.extract({
          fallback: 'style',
          use: cssLoaders,
        }),
      },
      {
        test: /\.(sass|scss)$/,
        include: config.paths.src,
        use: ExtractTextPlugin.extract({
          fallback: 'style',
          use: sassLoaders,
        }),
      },
      {
        test: /\.vue$/,
        loader: 'vue',
        options: {
          extractCSS: true,
          loaders: {
            scss: ExtractTextPlugin.extract({
              fallback: 'vue-style',
              use: [
                ...sassLoaders,
                {
                  loader: 'sass-resources',
                  options: {
                    resources: [
                      path.resolve(__dirname, '../assets/styles/config/_colors.scss'),
                      path.resolve(__dirname, '../assets/styles/config/_variables.scss'),
                      path.resolve(__dirname, '../assets/styles/config/_mixins.scss'),
                    ]
                  },
                },
              ],
            }),
          }
        },
      },
      {
        test: /\.svg(\?.*)?$/,
        use: [
          {
            loader: 'svg-sprite-loader',
            options: {
              extract: true,
              spriteFilename: 'sprite_[hash:8].svg',
            },
          },
          'svg-transform-loader',
          {
            loader: 'svgo-loader',
            options: {
              plugins: [
                {removeTitle: true},
                {convertColors: {shorthex: false}},
                {convertPathData: false}
              ]
            }
          },
        ],
      },
      {
        test: /\.(woff2?|png|jpe?g|gif|ico)$/,
        include: config.paths.src,
        loader: 'url',
        options: {
          limit: 1024,
          name: `[path][name].[ext]?[hash:8]`,
        },
      },
      {
        test: /\.(ttf|eot|woff2?|png|jpe?g|gif|ico)$/,
        include: /node_modules/,
        loader: 'url',
        options: {
          limit: 1024,
          outputPath: 'vendor/',
          name: `[name].[ext]?[hash:8]`,
        },
      },
      {
        test: /\.php$/,
        loader: 'html-loader',
      },
    ],
  },
  resolve: {
    extensions: ['.js', '.vue', '.json'],
    alias: {
      'vue$': 'vue/dist/vue.esm.js',
      '@': path.resolve(__dirname, '../'),
      '@images': path.resolve(__dirname, '../assets/images'),
      '@scripts': path.resolve(__dirname, '../scripts'),
      '@components': path.resolve(__dirname, '../components'),
    },
    modules: [
      config.paths.src,
      'node_modules',
    ],
    enforceExtension: false,
  },
  resolveLoader: {
    moduleExtensions: ['-loader'],
  },
  optimization: {
    minimizer: [],
  },
  plugins: [
    new SpriteLoaderPlugin(),
    new LodashModuleReplacementPlugin({
      'caching': true,
    }),
    new webpack.ProvidePlugin({
      axios: 'axios',
      Vue: ['vue/dist/vue.esm.js', 'default'],
    }),
    new CleanPlugin([config.paths.dist], {
      root: config.paths.root,
      verbose: false,
    }),
    new CopyGlobsPlugin({
      pattern: config.copy,
      output: `[path][name].[ext]`,
      manifest: config.manifest,
    }),
    new ExtractTextPlugin({
      filename: `styles/[name].css?[hash:8]`,
      allChunks: true,
    }),
    new webpack.DefinePlugin({
      WEBPACK_PUBLIC_PATH: false,
    }),
    new webpack.LoaderOptionsPlugin({
      test: /\.s?css$/,
      options: {
        output: { path: config.paths.dist },
        context: config.paths.src,
      },
    }),
    new webpack.LoaderOptionsPlugin({
      test: /\.js$/,
      options: {
        eslint: { failOnWarning: false, failOnError: true },
      },
    }),
    new HtmlWebpackPlugin({
      template: path.resolve(__dirname, '../template/index.php'),
      filename: 'index.php',
      minify: config.env.production ? {
        collapseWhitespace: true,
        removeScriptTypeAttributes: true,
      } : false,
    }),
    new ScriptExtHtmlWebpackPlugin({
      defaultAttribute: 'async',
    }),
    new FriendlyErrorsWebpackPlugin(),
  ],
};

/* eslint-disable global-require */ /** Let's only load dependencies as needed */

if (config.env.production) {
  const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
  const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer');

  webpackConfig.optimization.minimizer.push(
    new UglifyJsPlugin({
      cache: true,
      parallel: true,
      uglifyOptions: {
        ecma: 8,
      },
    })
  );
  webpackConfig.plugins.push(new webpack.optimize.AggressiveMergingPlugin());
  webpackConfig.plugins.push(new BundleAnalyzerPlugin({
    analyzerMode: 'static',
    reportFilename: path.resolve(__dirname, '../../.report/bundle-analyzer.html'),
    openAnalyzer: false,
  }));
}

module.exports = webpackConfig;
