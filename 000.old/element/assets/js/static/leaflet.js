"use strict";
(function (define) {
  define(function (require, exports, module) {
    const L = require("leaflet");
    const access_token = "pk.eyJ1IjoibGFuZ25hbmciLCJhIjoiY2txNmRvOXh2MGdmazJ1bW1iOGNzNWZlayJ9.fZa1EFmkwcnwn7rq-3x6Bg";
    module.exports = function () {
      var mymap = L.map('leaflet-wrapper').setView([51.505, -0.09], 13);
      L.tileLayer(`https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=${access_token}`, {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'your.mapbox.access.token'
      }).addTo(mymap);
      var marker = L.marker([51.5, -0.09]).addTo(mymap);
      var circle = L.circle([51.508, -0.11], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 500
      }).addTo(mymap);
      var polygon = L.polygon([
        [51.509, -0.08],
        [51.503, -0.06],
        [51.51, -0.047]
      ]).addTo(mymap);
    };
  });
})(define);
