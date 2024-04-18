"use strict";
(function (define) {
  define(function (require, exports, module) {
    const request = require("./../../utils/request");
    let option;

    $.ajax({
      method: "get",
      async: false,
      url: "https://3dqx3.sse.codesandbox.io/proxy",
      data: {
        proxy_url:
          "https://echarts.apache.org/examples/data/line-simple.js?_v_1624430965835",
      },
    }).then((res) => {
      console.log(res);
      eval(res);
      console.log(option);
    });
    module.exports = option;
  });
})(define);
