let mix = require('laravel-mix')
let distPath = 'public/front'

const tailwindcss = require('tailwindcss')
require('laravel-mix-purgecss')

mix.webpackConfig({ target: 'node' })
    .setPublicPath(distPath)
    .setResourceRoot('/')
    .js('resources/js/app-front.js', distPath + '/js')
    .extract(['vue', 'axios'])
    .sass('resources/sass/app-front.scss', distPath + '/css')
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('./tailwind.config.js')]
    })

if (mix.inProduction()) {
    mix.purgeCss(require('./purgecss.config.js')).version()
}
