const path = require('path');
const webpack = require('webpack');
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const FileWatcherPlugin = require("file-watcher-webpack-plugin");
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

module.exports = env => {

  const isDevelopment = (env.type === 'amp-dev');

  const extractSass = new ExtractTextPlugin({
    filename: '[name].min.css'
  });

  const ret = {
    context: path.join(process.cwd(), './'),
    entry: {
      'script.dev': './js/app.js',
      'script.amp': './js/app.amp.js'
    },
    devtool: 'source-map',
    output: {
      path: path.join(process.cwd(), 'dist'),
      filename: '[name].js'
    },
    module: {
      rules: [
        {
          test: /\.js$/,
          exclude: '/node_modules/',
          enforce: 'pre',
          loader: 'eslint-loader'
        },
        {
          test: /\.js$/,
          use: {
            loader: 'babel-loader',
            options: {
              cacheDirectory: true,
              presets: ['env']
            }
          },
          exclude: [
            /node_modules/
          ]
        },
        {
          test: /\.html$/,
          use: [
            {
              loader: 'html-loader',
              options: {
                attrs: []
              }
            }
          ],
          exclude: [
            /node_modules/
          ]
        },        
        {
          test: /\.scss$/,
          use: extractSass.extract({
            use: [{
              loader: "css-loader",
              options: {
                url: false,
                sourceMap: true,
                minimize: true
              }
            }, {
              loader: "sass-loader",
              options: {
                url: false,
                sourceMap: true
              }
            }],
            // use style-loader in development
            fallback: "style-loader"
          })
        }
      ],
    },
    plugins: [
      new webpack.LoaderOptionsPlugin({
        options: {
          eslint: {
            configFile: '.eslintrc',
            failOnWarning: true,
            failOnError: true,
            fix: true
          }
        }
      }),
      new webpack.ContextReplacementPlugin(/moment[\/\\]locale$/, /en-ca|fr-ca/),
      new CleanWebpackPlugin(['dist'], {root: process.cwd()}),
      // new FileWatcherPlugin({
      //   root: path.join(process.cwd()),
      //   files: ['./js/**/*.js', './scss/**/*.scss']
      // }),
      extractSass
    ]
  };

  {
    ret.plugins.push(
      new BrowserSyncPlugin(
        {
          host: 'localhost',
          port: 8080,
          proxy: 'http://10.89.149.60:7888/blogs',
          files: [
            '**/*.php',
            './dist/*.css'
          ]
        },
        {
          reload: true
        }
      )
    )
  }
  return ret;
};
