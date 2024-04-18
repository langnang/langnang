"use strict";
(function (define) {
  define(function (require, exports, module) {
    const Mock = require("mockjs");
    module.exports = {
      template: require("text!../../../../../views/static/mock/index.hbs"),
      run: function ({render, route}) {
        render(route);
      },
    };
  });
})(define);
