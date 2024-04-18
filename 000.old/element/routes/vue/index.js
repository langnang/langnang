"use strict";

(function (define) {
  define(function (require, exports, module) {
    module.exports = {
      name: "vue",
      path: "/vue",
      component: "/templates/overview",
      script: "/templates/overview",
      children: [
        {
          name: "Charts",
          children: [
            {
              name: "vue-echarts",
              description: "ECharts component for Vue.js.",
              icon: "fas fa-map",
              github: {
                user: "ecomfe",
                repo: "vue-echarts",
              },
              npm: "vue-echarts",
              path: "/vue-echarts",
              children: [
                {
                  name: "Line",
                  children: [
                    {
                      name: "Stacked Line Chart",
                      "icon-src":
                        "https://echarts.apache.org/examples/data/thumb/line-stack.webp?_v_=1624430965835",
                      path: "/line-stack",
                      component: "/templates/vue-echarts",
                    },
                  ],
                },
                {
                  name: "Map",
                  children: [],
                },
              ],
              component: "/templates/overview",
              script: "/templates/overview",
            },
          ],
        },
        {
          name: "Map",
          children: [
            {
              name: "vue2-leaflet",
              description: "Vue 2 components for Leaflet maps.",
              icon: "fas fa-map",
              github: {
                user: "vue-leaflet",
                repo: "Vue2Leaflet",
              },
              npm: "vue2-leaflet",
            },
          ],
        },
      ],
    };
  });
})(define);
