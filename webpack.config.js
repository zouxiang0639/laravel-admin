

const path = require('path');
const webpack = require('webpack')
const {env} = require('minimist')(process.argv.slice(2))

//const merge = require('webpack-merge')
let config = require(`${__dirname}/resources/js/index.config`);
let app = 'admin'

if (env && env.admin) {
  config = require(`${__dirname}/resources/admin/config/index.env`);
  app = 'admin'
}else if (env && env.h5) {

  config = require(`${__dirname}/resources/h5/config/index.env`);
  app = 'h5'
}else {
  config = require(`${__dirname}/resources/frontend/config/index.env`);
  app = 'frontend'
}

module.exports = {
  node: {
    // prevent webpack from injecting useless setImmediate polyfill because Vue
    // source contains it (although only uses it if it's native).
    setImmediate: false,
    // prevent webpack from injecting mocks to Node native modules
    // that does not make sense for the client
    dgram: 'empty',
    fs: 'empty',
    net: 'empty',
    tls: 'empty',
    child_process: 'empty'
  },
  resolve: {
    extensions: ['.js', '.vue', '.json'],
    alias: {
      '@': path.resolve(__dirname, 'resources/admin'),
      '@h5': path.resolve(__dirname, 'resources/h5'),
      '@f': path.resolve(__dirname, 'resources/frontend'),
    },
  },
  module: {
    rules: [
      {
        test: /\.svg$/,
        loader: 'svg-sprite-loader',
        include: [path.resolve(__dirname, 'resources/' + app + '/icons/svg')],
        options: {
          symbolId: 'icon-[name]'
        }
      },
    ],
  },
  plugins: [
    new webpack.DefinePlugin({
      'process.env': config
    }),


  ]
}
