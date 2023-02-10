/** @format */

// THIS IS FILE IS OPTIONAL, you can delete it if you don't want to use it

// config.js is the entry file for your VuePress app configuration
// It can also be written in yml or toml instead of js
// See the documentation for more information on how to use it
// https://v1.vuepress.vuejs.org/config/

const config = require("./../../.vuepress/config");

config.title = "VuePress";

config.themeConfig.nav.splice(2, 0, ...[]);

module.exports = config;
