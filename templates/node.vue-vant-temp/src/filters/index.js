const path = require('path')
const files = require.context('@/filters', false, /\.js$/)
files.keys().forEach(key => {
  const name = path.basename(key, '.js')
  if (name === 'index') return;
  // console.log(name);
  require('./' + name)
})