"use strict";
(function (define) {
  define(function (require, exports, module) {
    const echarts = require("echarts");
    const request = require("./../utils/request");
    module.exports = function (params) {
      const myChart = echarts.init(
        document.getElementById("template-echarts-wrapper")
      );
      if (!params.route._path) {
        return;
      }
      myChart.showLoading();
      request({
        method: "get",
        url: "https://3dqx3.sse.codesandbox.io/proxy",
        params: {
          proxy_url: `https://echarts.apache.org/examples/data${params.route._path}.js?_v_1624430965835`,
        },
      })
        .then((res) => {
          let option = {};
          if (/ROOT_PATH/g.test(res)) {
            res = res.replace(
              "ROOT_PATH",
              "'https://3dqx3.sse.codesandbox.io/proxy?proxy_url=https://echarts.apache.org/examples'"
            );
          }
          eval(res);
          // console.log(option);
          // console.log(JSON.stringify(option));
          myChart.setOption(option);
        })
        .finally(() => {
          myChart.hideLoading();
        });
      // require([`./../static/echarts${params.route._path}`], function (
      //   option
      // ) {
      //   console.log(typeof option);
      //   console.log(Object.prototype.toString.call(option));
      //   switch (Object.prototype.toString.call(option)) {
      //     case "[object Function]":
      //       option(myChart);
      //       break;
      //     default:
      //       myChart.setOption(option);
      //       break;
      //   }
      // });
    };
  });
})(define);
