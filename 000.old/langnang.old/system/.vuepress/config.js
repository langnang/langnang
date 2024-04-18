/** @format */

// THIS IS FILE IS OPTIONAL, you can delete it if you don't want to use it

// config.js is the entry file for your VuePress app configuration
// It can also be written in yml or toml instead of js
// See the documentation for more information on how to use it
// https://v1.vuepress.vuejs.org/config/

const config = require("./../../.vuepress/config");

config.title = "System";

config.themeConfig.nav.splice(
  2,
  0,
  ...[
    {
      text: "计算机科学技术",
      items: [
        {
          text: "计算机科学技术基础",
          link: "/520/52010/",
          items: [
            { text: "算法理论", link: "/520/52010/5201040/" },
            { text: "数据结构", link: "/520/52010/5201050/" },
            { text: "数据安全与计算机安全", link: "/520/52010/5201060/" },
          ],
        },
        {
          text: "计算机软件",
          link: "/52040/",
          items: [
            { text: "软件理论", link: "/520/52040/5204010/" },
            { text: "操作系统与操作环境", link: "/520/52040/5204020/" },
            { text: "程序设计及其语言", link: "/520/52040/5204030/" },
            { text: "数据库", link: "/520/52040/5204050/" },
            {
              text: "软件开发环境与开发技术",
              link: "/520/52040/5204060/HTML/",
            },
            { text: "软件工程", link: "/520/52040/5204070/" },
          ],
        },
      ],
    },
  ]
);

module.exports = config;
