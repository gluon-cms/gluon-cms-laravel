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

//front
mix.js('resources/js/app-front.js', 'public/js')
    .sass('resources/sass/app-front.scss', 'public/css');


//back
mix.js('resources/js/app-back.js', 'public/js')
    .sass('resources/sass/app-back.scss', 'public/css');
