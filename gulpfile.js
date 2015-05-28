var elixir = require('laravel-elixir');


var assets= './resources/assets/';
var paths = {
    'jquery': assets + 'vendor/jquery/',
    'bootstrap': assets + 'vendor/bootstrap-sass/assets/',
    'fontAwesome': assets + 'vendor/font-awesome/',
    'appScripts': assets + 'js/'
};
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */
elixir.config.sourcemaps = false;
elixir(function (mix) {
    mix
        .sass("app.scss", 'public/css/', {includePaths: [paths.bootstrap + 'stylesheets', paths.fontAwesome + "scss"]})
        .scripts([
            paths.jquery + "dist/jquery.js",
            paths.bootstrap + "javascripts/bootstrap.js",
            paths.appScripts + "**"
        ], 'public/js/app.js', './');
    mix.version(["css/app.css", "js/app.js"]);
    mix
        .copy(paths.bootstrap + 'fonts/bootstrap/**', 'public/build/fonts')
        .copy(paths.fontAwesome + 'fonts/**', 'public/build/fonts')
});