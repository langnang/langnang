"use strict";

(function (requirejs) {
  requirejs.config({
    paths: {
      ace: "https://cdn.jsdelivr.net/npm/ace-builds@1.4.12/src-min",
      amplitudejs:
        "https://cdn.jsdelivr.net/npm/amplitudejs@{{version-number}}/dist/amplitude",
      audiojs: "audiojs/audiojs/audio",
      axios: "https://cdn.jsdelivr.net/npm/axios@0.21.1/dist/axios.min",
      bootstrap:
        "https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min",
      bowser: "https://cdn.jsdelivr.net/npm/bowser@2.8.1/es5.min",
      clipboard:
        "https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min",
      "crypto-js": "https://cdn.jsdelivr.net/npm/crypto-js@4.0.0/crypto-js.min",
      d3: "https://cdn.jsdelivr.net/npm/d3@3.5.6/d3.min",
      downloadjs: "https://cdn.jsdelivr.net/npm/downloadjs@1.4.7/download.min",
      dragula: ["dragula/dist/dragula", "css!dragula/dist/dragula.css"],
      director:
        "https://cdn.jsdelivr.net/npm/director@1.2.8/build/director.min",
      echarts: "https://cdn.jsdelivr.net/npm/echarts@5.1.2/dist/echarts.min",
      "echo-js": "https://cdn.jsdelivr.net/npm/echo-js@1.7.3/src/echo.min",
      gmaps: "https://cdn.jsdelivr.net/npm/gmaps@0.4.24/gmaps.min",
      handlebars:
        "https://cdn.jsdelivr.net/npm/handlebars@4.7.7/dist/handlebars.min",
      Handsontable:
        "https://cdn.jsdelivr.net/npm/handsontable@6.2.2/dist/handsontable.min",
      holderjs: "https://cdn.jsdelivr.net/npm/holderjs@2.9.4/holder.min",
      jquery: "https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min",
      jqvmap: "jqvmap/dist",
      jsoneditor:
        "https://cdn.jsdelivr.net/npm/jsoneditor@9.2.0/dist/jsoneditor.min",
      leaflet: "https://cdn.jsdelivr.net/npm/leaflet@1.0.3/dist/leaflet",
      "markdown-it":
        "https://cdn.jsdelivr.net/npm/markdown-it@10.0.0/dist/markdown-it.min",
      masonry:
        "https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min",
      mockjs: "https://cdn.jsdelivr.net/npm/mockjs@1.1.0/dist/mock.min",
      mxgraph:
        "https://cdn.jsdelivr.net/npm/mxgraph@4.2.2/javascript/mxClient.min",
      openlayers:
        "https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol",
      randomColor:
        "https://cdn.jsdelivr.net/npm/randomcolor@0.6.2/randomColor.min",
      slicknav:
        "https://cdn.jsdelivr.net/npm/slicknav@0.1/dist/jquery.slicknav.min",
      vibrant:
        "https://cdn.jsdelivr.net/npm/node-vibrant@3.2.1-alpha.1/dist/vibrant.min",
      "video-js": "https://cdn.jsdelivr.net/npm/video.js@7.10.2/dist/video.min",
      vue: "https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min",
      "vue-demi":
        "https://cdn.jsdelivr.net/npm/vue-demi@0.9.1/lib/index.iife.min",
      "vue-echarts":
        "https://cdn.jsdelivr.net/npm/vue-echarts@6.0.0-rc.6/dist/index.umd.min",
    },
    map: {
      "*": {
        css: "https://cdn.jsdelivr.net/npm/require-css@0.1.10/css.min.js",
        text: "https://cdn.jsdelivr.net/npm/requirejs-text@2.0.15/text.min.js",
        async:
          "https://cdn.jsdelivr.net/npm/requirejs-plugins@1.0.2/src/async.js",
        font: "https://cdn.jsdelivr.net/npm/requirejs-plugins@1.0.2/src/font.js",
        goog: "https://cdn.jsdelivr.net/npm/requirejs-plugins@1.0.2/src/goog.js",
        image:
          "https://cdn.jsdelivr.net/npm/requirejs-plugins@1.0.2/src/image.js",
        json: "https://cdn.jsdelivr.net/npm/requirejs-plugins@1.0.2/src/json.js",
        noext:
          "https://cdn.jsdelivr.net/npm/requirejs-plugins@1.0.2/src/noext.js",
        mdown:
          "https://cdn.jsdelivr.net/npm/requirejs-plugins@1.0.2/src/mdown.js",
        propertyParser:
          "https://cdn.jsdelivr.net/npm/requirejs-plugins@1.0.2/src/propertyParser.js",
        markdownConverter:
          "https://cdn.jsdelivr.net/npm/requirejs-plugins@1.0.2/lib/Markdown.Converter.js",
      },
    },
    config: {},
    shim: {
      bootstrap: {
        deps: [
          "css!https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i",
          "css!https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css",
          "css!https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css",
          "css!https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/all.min.css",
          "css!/../../assets/css/main.css",
        ],
      },
      gmaps: {
        deps: ["http://maps.google.com/maps/api/js?v=3&sensor=false"],
        exports: "GMaps",
      },
      Handsontable: {
        deps: ["css!handsontable/dist/handsontable.full.min.css"],
      },
      jquery: {},
      jqvmap: {
        deps: [
          "css!jqvmap/../../dist/jqvmap.min.css",
          "jqvmap/maps/jquery.vmap.world",
          // "jqvmap/maps/jquery.vmap.sampledata"
        ],
      },
      jsoneditor: {
        deps: [
          "css!https://cdn.jsdelivr.net/npm/jsoneditor@9.2.0/dist/jsoneditor.min.css",
        ],
      },
      leaflet: {
        deps: [
          "css!https://cdn.jsdelivr.net/npm/leaflet@1.0.3/dist/leaflet.css",
        ],
      },
      openlayers: {
        deps: [
          "css!https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/css/ol.css",
        ],
      },
      slicknav: {
        deps: [],
      },
      "vue-demi": {
        deps: ["vue"],
      },
      "vue-echarts": {
        deps: [
          "vue",
          "echarts",
          "https://cdn.jsdelivr.net/npm/@vue/composition-api@1.0.0-rc.10/dist/vue-composition-api.prod.min.js",
        ],
      },
    },
  });

  define(function (require) {
    if (window.location.hash === "") {
      window.location.hash = "#/";
    }
    require("./../../routes/index");
    const flat = require("./utils/flat");
    const $ = require("jquery");
    require("handlebars");
    require("holderjs");
    // const router = require("./../assets/js/router");
    const headerHtml = require("text!../../layout/header.hbs");
    const footerHtml = require("text!../../layout/footer.hbs");
    require("bootstrap");

    $("body>header").html(headerHtml);
    $("body>footer").html(footerHtml);
    $(document).ready(flat.docReady);
    $(window).on("load", flat.winLoad);
  });
})(requirejs);
