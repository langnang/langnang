const path = require('path')
const files = require.context('@/directives', false, /\.js$/)
files.keys().forEach(key => {
  const name = path.basename(key, '.js')
  if (name === 'index') return;
  require('./' + name)
})