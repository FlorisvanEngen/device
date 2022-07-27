const mix = require('laravel-mix');

mix.options({
    processCssUrls: false
});

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/build/js/app.js')
    .js('resources/assets/js/editDeviceOrder.js', 'public/build/js/editDeviceOrder.js')
    .sass('resources/assets/css/app.scss', 'public/build/css/style.css')
    .copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/', 'public/build/fonts/bootstrap');
