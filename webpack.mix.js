require('mix-tailwindcss')

const config = require('./webpack.config')
const mix = require('laravel-mix')
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

mix.autoload({
  jquery: ['$', 'window.jQuery', 'jQuery'],
})

mix.js('resources/js/app.js', 'public/js').sass('resources/scss/app.scss', 'public/css').tailwind()
mix.js('resources/js/vue.js', 'public/js').vue()
mix.js('resources/js/admin.js', 'public/js').sass('resources/scss/admin.scss', 'public/css')

mix.copy('resources/images/', 'public/images/')
mix.copy('resources/vendor/', 'public/vendor/')

mix.webpackConfig(config)
mix.version()

if (!mix.inProduction()) {
  mix.sourceMaps()
  mix.webpackConfig({ devtool: 'inline-source-map' })
}
