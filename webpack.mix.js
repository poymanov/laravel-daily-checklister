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

mix.setPublicPath('public/assets')
    .setResourceRoot('/assets/')
    .js('resources/js/app.js', 'js')
    .postCss('resources/css/app.css', 'css', [

    ])
    .copy('node_modules/@coreui/icons/sprites/free.svg', 'public/assets/icons/free.svg')
    .copy('node_modules/@coreui/icons/sprites/brand.svg', 'public/assets/icons/brand.svg')
    .copy('resources/icons/coreui.svg', 'public/assets/icons/coreui.svg');

