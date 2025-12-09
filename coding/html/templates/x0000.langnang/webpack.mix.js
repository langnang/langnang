const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
  .postCss('resources/css/app.css', 'public/css', [
    //
  ]);

mix.copy('node_modules/normalize.css/normalize.css', 'public/css/normalize.css');

// Home
mix.js('resources/js/home.js', 'public/js')
  .postCss('resources/css/home.css', 'public/css', [
    //
  ]);

// Webstack
mix.js('resources/js/webstack.js', 'public/webstack.js')
  .postCss('resources/css/webstack.css', 'public/webstack.css', [
    //
  ]);
