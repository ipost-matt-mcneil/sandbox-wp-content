const path = require('path');
const webpack = require('webpack');
const WebpackCleanPlugin = require('webpack-clean');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

module.exports = env => {

  const extractSass = new ExtractTextPlugin({
    filename: 'style.[name].css'
  });

  const ret = {
    context: path.join(process.cwd(), './'),
    entry: {
      'dev': './js/app.js',
      'amp': './js/app.amp.js'
    },
    output: {
      path: path.join(process.cwd(), 'dist'),
      filename: 'script.[name].js'
    },
    devtool: 'source-map',
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
                sourceMap: false,
                minimize: true
              }
            }, {
              loader: "sass-loader",
              options: {
                url: false,
                sourceMap: false,
                minimize: true
              }
            },
              {
                loader: "postcss-loader",
                options: {
                  plugins: () => [require('autoprefixer')({
                    'browsers': ['> 1%', 'last 2 versions']
                  })],
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
            failOnWarning: false,
            failOnError: false,
            fix: true,
            emitWarning: true,
            css: {
              loaderOptions: {
                sass: {
                  prependData: '@import "@/scss/settings.scss";'
                }
              }
            }
          }
        }
      }),
      new webpack.ContextReplacementPlugin(/moment[\/\\]locale$/, /en-ca|fr-ca/),
      new CleanWebpackPlugin(['dist'], {root: process.cwd()}),
      new WebpackCleanPlugin([
        '../dist/script.amp.js',
        '../dist/script.amp.js.map'
      ]),
      extractSass
    ]
  };

  {
    ret.plugins.push(
      new BrowserSyncPlugin(
        {
          host: 'localhost',
          port: 8080,
          proxy: 'http://blogs.test',
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