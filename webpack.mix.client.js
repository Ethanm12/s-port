const mix = require('laravel-mix');
const webpack = require('webpack');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
const purgeCss = require('@fullhuman/postcss-purgecss');
const fs = require('fs');
const path = require('path');

const rootPath = Mix.paths.root.bind(Mix.paths);

const purgeCssConfig = {
    content: [
        rootPath('app/**/*.php'),
        rootPath('resources/**/*.html'),
        rootPath('resources/**/*.js'),
        rootPath('resources/**/*.ts'),
        rootPath('resources/**/*.php'),
        rootPath('resources/**/*.vue'),
        rootPath('src/**/*.html'),
        rootPath('src/**/*.js'),
        rootPath('src/**/*.ts'),
        rootPath('src/**/*.vue')
    ],
    defaultExtractor: content => content.match(/[A-Za-z0-9-_:/]+/g) || [],
    whitelistPatterns: [/-active$/, /-enter$/, /-leave-to$/]
};

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
const plugins = [];

if (process.env.ANALYSE) {
    plugins.push(new BundleAnalyzerPlugin({
        defaultSizes: 'gzip'
    }));
}

if (mix.inProduction()) {
    mix.version();
} else {
    // Get the APP_URL from .env and remove protocol
    const host = process.env.APP_URL.replace(/(^\w+:|^)\/\//, '');
    mix.sourceMaps()
    .webpackConfig(() => ({ devtool: 'source-map' }))
    .browserSync(host);
    const homeDir = process.env.HOME;
    if (process.env.SECURE) {
        mix.options({
            hmrOptions: {
                host,
                port: 8080 // Can't use 443 here because address already in use
            }
        })
        .webpackConfig({
            devServer: {
                https: true,
                key: fs.readFileSync(path.resolve(homeDir, `.config/valet/Certificates/${host}.key`)),
                cert: fs.readFileSync(path.resolve(homeDir, `.config/valet/Certificates/${host}.crt`)),
            }
        })
    }
}

mix.webpackConfig(() => ({ 
        plugins,
        resolve: { alias: {'vue$': 'vue/dist/vue.runtime.common.js'} } // Use runtime-only version of vue
    }))
    .js('src/entry-client.js', 'public/js')
    .extract([
        'setimmediate', 'process', 'timers-browserify', // Included by webpack, would otherwise be in both bundles
        'vue-router', 'vue', 'vuex', 'axios' // Node modules not likely to change
    ])
    .sass('resources/assets/sass/app.scss', 'public/css', {
        sourceMap: true,
        sassOptions: {
            sourceMap: true,
            outFile: 'public/css/app.css'
        }
    })
    .options({
        postCss: [purgeCss(purgeCssConfig)],
        processCssUrls: false,
        extractVueStyles: true
    });

