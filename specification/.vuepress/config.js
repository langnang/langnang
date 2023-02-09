/** @format */

// THIS IS FILE IS OPTIONAL, you can delete it if you don't want to use it

// config.js is the entry file for your VuePress app configuration
// It can also be written in yml or toml instead of js
// See the documentation for more information on how to use it
// https://v1.vuepress.vuejs.org/config/

const config = require("./../../.vuepress/config");

config.base = "/" + __dirname.split("\\").slice(-2, -1)[0] + "/";

config.title = "Specification";
config.description = "规范";

config.themeConfig.nav.splice(
  2,
  0,
  ...[
    { text: "编码风格", link: "/style/" },
    { text: "代码检查", link: "/inspection/" },
    { text: "开发规范", link: "/develop/" },
    { text: "部署规范", link: "/deploy/" },
  ]
);

module.exports = config;
