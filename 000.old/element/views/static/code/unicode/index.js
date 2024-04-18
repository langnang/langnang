"use strict";
(function (define) {
  define(function (require, exports, module) {
    module.exports = {
      template: require("text!./../../../../views/static/code/index.hbs"),
      // 编码
      encode: function (val = "0") {
        return encodeURI(val);
      },
      run: function ({ render, route, encode, decode }) {
        render({ ...route, encode, decode });
        $("#encode").click(function () {
          $("textarea[name='output']").val(
            encode($("textarea[name='input']").val())
          );
        });
        $("#decode").click(function () {
          $("textarea[name='input']").val(
            decode($("textarea[name='output']").val())
          );
        });
      },
    };
  });
})(define);
