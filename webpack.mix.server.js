const mix = require('laravel-mix');
const webpack = require('webpack');

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

// This is needed if you are using moment, but consider dayjs first
// var plugins = [ new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/) ];

mix.setPublicPath('./storage')
    .webpackConfig(() => ({ 
        target: 'node',
        plugins: [new webpack.EnvironmentPlugin(['NODE_ENV', 'SECURE', 'SERVER'])],
        externals: {
            'ssl-root-cas/latest': 'commonjs2 ssl-root-cas/latest'
        },
        resolve: { alias: {'vue$': 'vue/dist/vue.runtime.common.js'} } // Use runtime-only version of vue
    }))
    .options({
        extractVueStyles: true
    })
    .js('src/entry-server.js', 'app/ssr/server-prod.js');

