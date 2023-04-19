const mix = require('laravel-mix');

const config = require(`${__dirname}/webpack.config`);
mix.webpackConfig(config);

require('dotenv').config();


/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

const {env} = require('minimist')(process.argv.slice(2))


//
if (mix.inProduction()) {
    mix.version()
}


if (env && env.admin) {
    //后台项目的构建规则
    require(`${__dirname}/webpack.admin.js`)
    return
} else if (env && env.h5) {
    console.log(env)
    //后台项目的构建规则
    require(`${__dirname}/webpack.h5.js`)
    return
} else {
    //前台项目的构建规则
    const mix = require('laravel-mix')

    // Mix.listen('configReady', (webpackConfig) => {
    //   // Exclude 'svg' folder from font loader
    //   let fontLoaderConfig = webpackConfig.module.rules.find(rule => String(rule.test) === String(/(\.(png|jpe?g|gif|webp)$|^((?!font).)*\.svg$)/));
    //   fontLoaderConfig.exclude = /(resources\/admin\/icons)/;
    // });

    if (mix.inProduction()) {
        mix.version()
    }

    mix.webpackConfig({
        output: {
            publicPath: '/frontend/', // 设置默认打包目录
        }
    })

    mix.js('resources/frontend/main.js', 'public/frontend/js') // 打包后台js
        .extract(['vue', 'element-ui', 'vuex', 'js-cookie'
        ])
        .setResourceRoot('/frontend/') // 设置资源目录
        .setPublicPath('public/frontend') // 设置 mix-manifest.json 目录
}
