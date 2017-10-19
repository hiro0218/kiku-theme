'use strict'; // eslint-disable-line

const webpack = require('webpack');
const merge = require('webpack-merge');
const CleanPlugin = require('clean-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

const CopyGlobsPlugin = require('copy-globs-webpack-plugin');
const config = require('./config');

const assetsFilenames = (config.enabled.cacheBusting) ? config.cacheBusting : '[name]';

let webpackConfig = {
  context: config.paths.assets,
  entry: config.entry,
  devtool: (config.enabled.sourceMaps ? '#source-map' : undefined),
  output: {
    path: config.paths.dist,
    publicPath: config.publicPath,
    filename: `scripts/${assetsFilenames}.js`,
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
        test: /\.js?$/,
        include: config.paths.assets,
        loader: 'babel',
      },
      {
        test: /\.js$/,
        exclude: [/(node_modules|bower_components)(?![/|\\](bootstrap|foundation-sites))/],
        use: [
          { loader: 'cache-loader' },
          { loader: 'thread-loader' },
          { loader: 'buble', options: { objectAssign: 'Object.assign' } },
        ],
      },
      {
        test: /\.(sass|scss|css)$/,
        include: config.paths.assets,
        loader: ExtractTextPlugin.extract({
          fallback: 'style',
          use: [
            { loader: 'cache-loader' },
            { loader: 'thread-loader' },
            { loader: 'css', options: { sourceMap: config.enabled.sourceMaps } },
            { loader: 'postcss-loader',
              options: {
                sourceMap: config.enabled.sourceMaps,
                config: {
                  ctx: config,
                  path: __dirname,
                },
              },
            },
            { loader: 'resolve-url', options: { sourceMap: config.enabled.sourceMaps } },
            { loader: 'sass', options: { sourceMap: config.enabled.sourceMaps } },
          ],
        }),
      },
      {
        test: /\.vue$/,
        loader: 'vue-loader',
        options: {
          loaders: {
            js: 'buble-loader',
          },
        },
      },
      {
        test: /\.(ttf|eot|woff2?|png|jpe?g|gif|svg|ico)$/,
        include: config.paths.assets,
        loader: 'url',
        options: {
          limit: 4096,
          name: `[path]${assetsFilenames}.[ext]`,
        },
      },
      {
        test: /\.(ttf|eot|woff2?|png|jpe?g|gif|svg|ico)$/,
        include: /node_modules|bower_components/,
        loader: 'url',
        options: {
          limit: 4096,
          outputPath: 'vendor/',
          name: `${config.cacheBusting}.[ext]`,
        },
      },
    ],
  },
  resolve: {
    alias: {
      'vue$': 'vue/dist/vue.esm.js',
    },
    modules: [
      config.paths.assets,
      'node_modules',
    ],
    enforceExtension: false,
  },
  resolveLoader: {
    moduleExtensions: ['-loader'],
  },
  plugins: [
    new CleanPlugin([config.paths.dist], {
      root: config.paths.root,
      verbose: false,
    }),
    new CopyGlobsPlugin({
      pattern: config.copy,
      output: `[path]${assetsFilenames}.[ext]`,
      manifest: config.manifest,
    }),
    new ExtractTextPlugin({
      filename: `styles/${assetsFilenames}.css`,
      allChunks: true,
    }),
    new webpack.DefinePlugin({
      WEBPACK_PUBLIC_PATH: false,
    }),
    new webpack.LoaderOptionsPlugin({
      minimize: config.enabled.optimize,
      stats: { colors: true },
    }),
    new webpack.LoaderOptionsPlugin({
      test: /\.js$/,
      options: {
        eslint: { failOnWarning: false, failOnError: true },
      },
    }),
  ],
};

/* eslint-disable global-require */ /** Let's only load dependencies as needed */

if (config.enabled.optimize) {
  webpackConfig = merge(webpackConfig, require('./webpack.config.optimize'));
}

if (config.env.production) {
  webpackConfig.plugins.push(new webpack.NoEmitOnErrorsPlugin());
  webpackConfig.plugins.push(new webpack.optimize.ModuleConcatenationPlugin());
  webpackConfig.plugins.push(new webpack.optimize.AggressiveMergingPlugin());
}

if (config.enabled.cacheBusting) {
  const WebpackAssetsManifest = require('webpack-assets-manifest');

  webpackConfig.plugins.push(
    new WebpackAssetsManifest({
      output: 'assets.json',
      space: 2,
      writeToDisk: false,
      assets: config.manifest,
      replacer: require('./util/assetManifestsFormatter'),
    })
  );
}

module.exports = webpackConfig;
