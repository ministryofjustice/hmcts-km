const mix_ = require('laravel-mix')

var _asset = './assets/'

mix_.setPublicPath('./dist')
  .js([
    _asset + 'scripts/components/hidden-text.js',
    _asset + 'scripts/components/password-field.js',
    _asset + 'scripts/main.js'
  ], 'scripts/main.min.js')
  .js(_asset + 'scripts/jj-gtm.js', 'scripts/jj-gtm.js')
  .copy(_asset + 'scripts/*.min.js', 'dist/scripts/')
  .options({ processCssUrls: false })
  .less(_asset + 'styles/editor-style.less', 'styles/')
  .less(_asset + 'styles/main.less', 'styles/')
  .copy(_asset + 'fonts/*', 'dist/fonts/')
  .copy(_asset + 'images/*', 'dist/images/')

if (mix_.inProduction()) {
  mix_.version()
} else {
  mix_.sourceMaps()
}
