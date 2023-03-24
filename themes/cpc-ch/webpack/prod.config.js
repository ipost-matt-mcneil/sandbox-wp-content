const path = require('path');
const webpack = require('webpack');
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');
const WebpackCleanPlugin = require('webpack-clean');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const ExtractTextPlugin = require("extract-text-webpack-plugin");

module.exports = env => {

  const extractSass = new ExtractTextPlugin({
    filename: 'style.[name].css'
  });

  const ret = {
    context: path.join(process.cwd(), './'),
    entry: {
      'min': './js/app.js',
      'amp': './js/app.amp.js'
    } ,
    output: {
      path: path.join(process.cwd(), 'dist'),
      filename: 'script.[name].js'
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
                minimize: true
              }
            }, {
              loader: "sass-loader",
              options: {
                url: false
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
            emitWarning: true
          }
        }
      }),
      new webpack.ContextReplacementPlugin(/moment[\/\\]locale$/, /en-ca|fr-ca/),
      new WebpackCleanPlugin([
        '../dist/script.amp.min.js'
      ]),
      extractSass
    ]
  };

  {
    ret.plugins.push(
      new UglifyJSPlugin({
        test: /\.js$/,
        parallel: true
      })
    )
  }
  return ret;
};
