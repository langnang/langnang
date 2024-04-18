const fs = require('fs');
const path = require('path');
/**
 * 读取目录下文件并转为URL路径
 * @param {*} dirpath 
 * @param {*} routepath 
 * @returns 
 */
const readdirSync = (dirpath, routepath) => fs.readdirSync(`./docs/${dirpath}`, (err, data) => err ? [] : data).filter(v => v != 'README.md').map(v => `${routepath}/${v}`)
module.exports = {
  ...require('./../52010/sidebar.js'),
  // ...require('./../52040/sidebar.js'),
  '/52040/': [
    {
      title: '软件理论',
      path: '5204010/',
    },
    {
      title: '操作系统与操作环境',
      path: '5204020/',
    },
    {
      title: '程序设计及其语言',
      path: '5204030/',
    },
    {
      title: '数据库',
      path: '5204050/',
    },
    {
      title: '软件开发环境与开发技术',
      children: [
        '5204060/HTML/',
        {
          title: "CSS",
          path: '/52040/5204060/CSS/',
          children: [
            {
              title: '面试题',
              children: readdirSync('52040/5204060/CSS/Interview', '5204060/CSS/Interview')
            },
            {
              title: '参考手册',
              children: [
                {
                  title: 'W3school',
                  children: readdirSync('52040/5204060/CSS/Reference/W3school', '5204060/CSS/Reference/W3school')
                }
              ],
            }
          ]
        },
        {
          title: "JavaScript",
          path: '/52040/5204060/JavaScript/',
          children: [
            {
              title: '面试题',
              children: readdirSync('52040/5204060/JavaScript/Interview', '5204060/JavaScript/Interview')
            },
            {
              title: '名词解释',
              children: readdirSync('52040/5204060/JavaScript/Noun', '5204060/JavaScript/Noun')
            },
          ]
        },
        {
          title: "ES2015/ES6",
          path: '/52040/5204060/ECMAScript/ES6/',
          children: [
            {
              title: '面试题',
              children: readdirSync('52040/5204060/ECMAScript/ES6/Interview', '5204060/ECMAScript/ES6/Interview')
            },
            {
              title: '参考手册',
              children: [
                {
                  title: 'ECMAScript 6 入门教程',
                  children: readdirSync('52040/5204060/ECMAScript/ES6/Reference/ECMAScript 6 入门教程', '5204060/ECMAScript/ES6/Reference/ECMAScript 6 入门教程')
                }
              ],
            }
          ]
        },
        {
          title: "NodeJs",
          path: '/52040/5204060/NodeJs/',
          children: [
            {
              title: '参考手册',
              children: [
                {
                  title: 'Manual',
                  children: readdirSync('52040/5204060/NodeJs/Reference/Manual', '5204060/NodeJs/Reference/Manual')
                }
              ],
            }
          ]
        },
        '5204060/React/',
        {
          title: "Vue",
          path: '/52040/5204060/Vue/',
          children: [
            {
              title: "面试题",
              children: [],
            },
            {
              title: '参考手册',
              children: [
                {
                  title: 'Manual',
                  children: readdirSync('52040/5204060/Vue/Reference/Manual', '5204060/Vue/Reference/Manual')
                }
              ],
            }
          ]
        },
        '5204060/TypeScript/',
        '5204060/WeChat/',
        {
          title: "NPM Packages",
          children: [
            '5204060/NPM Packages/Boostrap v3/'
          ],
        },
      ],
    },
    {
      title: '软件工程',
      path: '5204070/',
      children: [
      ],
    }
  ]
}