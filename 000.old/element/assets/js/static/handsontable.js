"use strict";
(function (define) {
  define(function (require, exports, module) {
    const Handsontable = require("Handsontable");
    module.exports = function () {
      const data = [
        ['', 'Tesla', 'Volvo', 'Toyota', 'Ford'],
        ['2019', 10, 11, 12, 13],
        ['2020', 20, 11, 14, 13],
        ['2021', 30, 15, 12, 13]
      ];

      const container = document.getElementById('handsontable-wrapper');
      const hot = new Handsontable(container, {
        data: data,
        rowHeaders: true,
        colHeaders: true
      });
    };
  });
})(define);
