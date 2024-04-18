"use strict";
(function (define) {
  define(function (require, exports, module) {
    const GMaps = require("gmaps/gmaps.min");
    module.exports = function () {
      var map = new GMaps({
        el: '#gamps-wrapper',
        lat: -12.043333,
        lng: -77.028333
      });
    };
  });
})(define);
