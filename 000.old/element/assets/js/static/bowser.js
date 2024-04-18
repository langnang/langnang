"use strict";
(function (define) {
  define(function (require, exports, module) {
    const Bowser = require("bowser");
    module.exports = function () {
      $("#bowser-wrapper").html(JSON.stringify(Bowser.parse(window.navigator.userAgent)))
    };
  });
})(define);
