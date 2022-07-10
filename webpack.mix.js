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
    ])
    .js('resources/js/index.js', 'public/js')
    .js('resources/js/writeDiary.js', 'public/js')
    .js('resources/js/createDiary.js', 'public/js')
    .js('resources/js/errorPopup.js', 'public/js')
    
    ;

mix.sass('resources/assets/sass/index.scss', 'public/css')
    .sass('resources/assets/sass/signup-login.scss', 'public/css')
    .sass('resources/assets/sass/createFirstDiary.scss', 'public/css')
    .sass('resources/assets/sass/writeDiary.scss', 'public/css')
    .sass('resources/assets/sass/createDiary.scss', 'public/css')
    .sass('resources/assets/sass/errorPopup.scss', 'public/css')
    ;
