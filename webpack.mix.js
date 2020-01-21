const mix = require('laravel-mix');

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

mix
    .sass('resources/sass/app.scss', 'css')
    .copyDirectory('node_modules/font-awesome/fonts', 'public/fonts/font-awesome')
    .js('resources/js/dashmix/app.js', 'public/js/app.js')