"use strict";
(function (define) {
  define(function (require, exports, module) {
    const d3 = require("d3");
    module.exports = function () {
      const p = d3.select("#d3-wrapper").text("www.ourd3js.com");
      p.style("color", "red")
        .style("font-size", "72px");
    };
  });
})(define);
