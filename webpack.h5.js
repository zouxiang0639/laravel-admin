const mix = require('laravel-mix')

if (mix.inProduction()) {
  mix.version()
}

mix.webpackConfig({
  output: {
    publicPath: '/h5/', // 设置默认打包目录
  }
})

mix.js('resources/h5/main.js', 'public/h5/js') // 打包后台js
  .extract(['vue', 'vuex', 'js-cookie'])
  .setResourceRoot('/h5/') // 设置资源目录
  .setPublicPath('public/h5') // 设置 mix-manifest.json 目录

