"use strict";
(function (define) {
  define(function (require, exports, module) {
    const echarts = require("echarts");
    module.exports = function () {
      var myChart = echarts.init(document.getElementById('echarts-wrapper'));

      // specify chart configuration item and data
      var option = {
        title: {
          text: 'ECharts entry example'
        },
        tooltip: {},
        legend: {
          data:['Sales']
        },
        xAxis: {
          data: ["shirt","cardign","chiffon shirt","pants","heels","socks"]
        },
        yAxis: {},
        series: [{
          name: 'Sales',
          type: 'bar',
          data: [5, 20, 36, 10, 10, 20]
        }]
      };

      // use configuration item and data specified to show chart
      myChart.setOption(option);
    };
  });
})(define);
