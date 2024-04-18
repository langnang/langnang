"use strict";

(function (define) {
  define(function (require, exports, module) {
    const echartsRoutes = require("json!./../../assets/json/echarts.json").map(
      (v) => {
        return {
          name: v.name,
          children: v.children.map((v) => {
            return {
              ...v,
              component: "/templates/echarts",
              script: "/templates/echarts",
            };
          }),
        };
      }
    );
    module.exports = {
      name: "Echarts",
      description:
        "Apache ECharts is a powerful, interactive charting and data visualization library for browser",
      icon: null,
      "icon-src":
        "https://cdn.jsdelivr.net/npm/simple-icons@5.3.0/icons/apacheecharts.svg",
      path: "/echarts",
      npm: "echarts",
      github: {
        user: "apache",
        repo: "echarts",
      },
      theme: "card",
      children: [...echartsRoutes],
    };
  });
})(define);
