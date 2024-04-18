"use strict";
(function (define) {
  define(function (require, exports, module) {
    const randomColor = require("randomColor");
    module.exports = function () {
      let colors = "";
      randomColor({count: 12*6}).forEach(hex => {
        colors += `<div class="col-lg-1"><span class="random-color" style="background-color: ${hex};"></span></div>\n`;
      })
      $("#app>.row").html(colors);
    };
  });
})(define);
