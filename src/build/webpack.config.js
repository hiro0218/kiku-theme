'use strict'; // eslint-disable-line

const path = require('path');
const webpack = require('webpack');
const merge = require('webpack-merge');
const CleanPlugin = require('clean-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const CopyGlobsPlugin = require('copy-globs-webpack-plugin');
const FriendlyErrorsWebpackPlugin = require('friendly-errors-webpack-plugin');
const HardSourceWebpackPlugin = require('hard-source-webpack-plugin');
const SpriteLoaderPlugin = require('svg-sprite-loader/plugin');

const config = require('./config');
const { jsLoaders, cssLoaders, sassLoaders } = require('./loader.conf');

const assetsFilenames = (config.enabled.cacheBusting) ? config.cacheBusting : '[name]';

let webpackConfig = {
  context: config.paths.src,
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
        use: jsLoaders,
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
              spriteFilename: 'sprite.svg',
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
        test: /\.(ttf|eot|woff2?|png|jpe?g|gif|ico)$/,
        include: config.paths.src,
        loader: 'url',
        options: {
          limit: 1024,
          name: `[path]${assetsFilenames}.[ext]`,
        },
      },
      {
        test: /\.(ttf|eot|woff2?|png|jpe?g|gif|ico)$/,
        include: /node_modules|bower_components/,
        loader: 'url',
        options: {
          limit: 1024,
          outputPath: 'vendor/',
          name: `${config.cacheBusting}.[ext]`,
        },
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
  plugins: [
    new SpriteLoaderPlugin(),
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
    new FriendlyErrorsWebpackPlugin(),
    new HardSourceWebpackPlugin({
      cacheDirectory: '../node_modules/.cache/hard-source/[confighash]',
    }),
  ],
};

/* eslint-disable global-require */ /** Let's only load dependencies as needed */

if (config.enabled.optimize) {
  webpackConfig = merge(webpackConfig, require('./webpack.config.optimize'));
}

if (config.env.production) {
  const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
  const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer');

  webpackConfig.plugins.push(new webpack.NoEmitOnErrorsPlugin());
  webpackConfig.plugins.push(new webpack.optimize.ModuleConcatenationPlugin());
  webpackConfig.plugins.push(new webpack.optimize.AggressiveMergingPlugin());
  webpackConfig.plugins.push(new UglifyJsPlugin({
    cache: true,
    uglifyOptions: {
      ecma: 8,
    },
  }));
  webpackConfig.plugins.push(new BundleAnalyzerPlugin({
    analyzerMode: 'static',
    reportFilename: path.resolve(__dirname, '../../.report/bundle-analyzer.html'),
    openAnalyzer: false,
  }));
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
