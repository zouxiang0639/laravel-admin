const mix = require('laravel-mix')

Mix.listen('configReady', (webpackConfig) => {
  // Exclude 'svg' folder from font loader
  let fontLoaderConfig = webpackConfig.module.rules.find(rule => String(rule.test) === String(/(\.(png|jpe?g|gif|webp)$|^((?!font).)*\.svg$)/));
  fontLoaderConfig.exclude = /(resources\/admin\/icons)/;
});

if (mix.inProduction()) {
  mix.version()
}

mix.webpackConfig({
  output: {
    publicPath: '/back/', // 设置默认打包目录
  }
})

mix.js('resources/admin/main.js', 'public/back/js') // 打包后台js
  .sass('resources/admin/styles/app.scss', 'public/back/css') // 打包后台css
  .extract(['vue', 'element-ui', 'vuex', 'js-cookie'
  ])
  .setResourceRoot('/back/') // 设置资源目录
  .setPublicPath('public/back') // 设置 mix-manifest.json 目录

