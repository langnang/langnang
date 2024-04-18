/** @format */

// THIS IS FILE IS OPTIONAL, you can delete it if you don't want to use it

// config.js is the entry file for your VuePress app configuration
// It can also be written in yml or toml instead of js
// See the documentation for more information on how to use it
// https://v1.vuepress.vuejs.org/config/

const config = require("./../../.vuepress/config");

config.title = "Computer Science";

config.themeConfig.nav.splice(
  2,
  0,
  ...[
    { text: "算法理论", link: "/52010/5201040/" },
    { text: "数据结构", link: "/52010/5201050/" },
    { text: "数据库", link: "/52040/5204050/" },
    { text: "开发技术", link: "/52040/5204060/" },
  ]
);

module.exports = config;
