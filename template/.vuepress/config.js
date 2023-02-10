/** @format */

// THIS IS FILE IS OPTIONAL, you can delete it if you don't want to use it

// config.js is the entry file for your VuePress app configuration
// It can also be written in yml or toml instead of js
// See the documentation for more information on how to use it
// https://v1.vuepress.vuejs.org/config/

const config = require("./../../.vuepress/config");

config.base = "/" + __dirname.split("\\").slice(-2, -1)[0] + "/";

config.title = "Template";

config.themeConfig.nav.splice(
  2,
  0,
  {
    text: "客户端",
    items: [
      {
        items: [
          // { text: "Vue" },
          // { text: "React" },
          { text: "VuePress", link: "/client/vuepress/" },
        ],
      },
      {
        items: [{ text: "Webpack", link: "/client/webpack/" }],
      },
    ],
  },
  { text: "服务端", link: "" }
);
module.exports = config;
