"use strict";
(function (define) {
  define(function (require, exports, module) {
    const echo = require("echo-js");

    module.exports = {
      template: require("text!../../../../../views/static/dev/home/index.hbs"),
      run: function ({ render, route }) {
        render(route);
        echo.init({
          offset: 100,
          throttle: 150,
          unload: false,
          callback: function (element, op) {
            // console.log(element, "has been", op + "ed");
          },
        });
      },
    };
  });
})(define);
