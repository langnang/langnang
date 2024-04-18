"use strict";
(function (define) {
  define(function (require, exports, module) {
    const ol = require("openlayers");
    console.log(ol);
    module.exports = function () {
      var map = new ol.Map({
        layers: [
          new ol.layer.Tile({
            source: new ol.source.OSM(),
          })],
        target: 'openlayers-wrapper',
        view: new ol.View({
          center: [0, 0],
          zoom: 2,
        }),
      });
    };
  });
})(define);
