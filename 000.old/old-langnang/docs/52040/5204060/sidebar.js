const path = require('path');
module.exports = {
  title: '软件开发环境与开发技术',
  children: [
    '5204060/HTML/',
    require('./CSS/sidebar'),
    '5204060/JavaScript/',
    require('./ECMAScript/ES6/sidebar'),
    '5204060/NodeJs/',
    '5204060/React/',
    require('./Vue/sidebar'),
    '5204060/TypeScript/',
    '5204060/WeChat/',
    {
      title: "NPM Packages",
      children: [
        '5204060/NPM Packages/Boostrap v3/'
      ],
    },
  ],
}
