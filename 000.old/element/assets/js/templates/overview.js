"use strict";
(function (define) {
  define(function (require, exports, module) {
    const template = require("text!./../../../views/templates/overview.hbs");
    const echo = require("echo-js");
    module.exports = function (options) {
      options.render(options.Handlebars.compile(template)(options.route));
      echo.init({
        offset: 100,
        throttle: 150,
        unload: false,
        callback: function (element, op) {
          // console.log(element, "has been", op + "ed");
        },
      });
    };
  });
})(define);
