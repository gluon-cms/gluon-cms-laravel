let mix = require('laravel-mix')
let distPath = 'public/back'

mix.webpackConfig({ target: 'node' })
    .setPublicPath(distPath)
    .setResourceRoot('/')
    .js('resources/js/app-back.js', distPath + '/js')
    .extract(['vue', 'axios', 'jquery'])
    .sass('resources/sass/app-back.scss', distPath + '/css')

if (mix.inProduction()) {
    mix.version()
}
