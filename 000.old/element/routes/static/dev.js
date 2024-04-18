"use strict";
// 静态页面
(function (define) {
  define(function (require, exports, module) {
    module.exports = {
      name: "Dev",
      path: "/dev",
      component: "../../../views/static/dev/home/index",
      children: [
        {
          children: [
            {
              name: "Mock",
              description: "生成随机数据 & 拦截 Ajax 请求",
              path: "/mock",
              component: "../../../views/static/mock/index",
              npm:"mockjs",
              github:{
                user:"nuysoft",
                repo:"Mock"
              }
            },
            {
              name: "jsoneditor",
              description:
                "A web-based tool to view, edit, format, and validate JSON",
              github: {
                user: "josdejong",
                repo: "jsoneditor",
              },
              npm: "jsoneditor",
              org: "http://jsoneditoronline.org/",
              path: "/jsoneditor",
            },
            {
              name: "Crypto",
              description: "JavaScript library of crypto standards.",
              icon: "fas fa-award",
              path: "/crypto",
              github: {
                user: "brix",
                repo: "crypto-js",
              },
              npm: "crypto-js",
              meta: {},
            },
            {
              name: "Echo.js",
              icon: "fas fa-award",
              description: "Lazy-loading images with data-* attributes",
              github: {user: "toddmotto", repo: "echo"},
              npm: "echo-js",
            },
            {
              name: "Masonry",
              description: "Cascading grid layout library",
              "icon-src": "https://masonry.desandro.com/favicon.ico",
              github: {user: "desandro", repo: "masonry"},
              npm: "masonry-layout",
              org: "https://masonry.desandro.com/",
              path: "/masonry",
            },
            {
              name: "FFmpeg",
              description:
                "A complete, cross-platform solution to record, convert and stream audio and video.",
              icon: null,
              "icon-src":
                "https://cdn.jsdelivr.net/npm/simple-icons@5.3.0/icons/ffmpeg.svg",
              path: "/ffmpeg",
              github: {
                user: "ffmpeg",
                repo: "ffmpeg",
              },
              org: "https://ffmpeg.org/",
            },
          ],
        },
        {
          name: "数据结构",
          children: [
            {
              name: "Immutable",
              icon: "fas fa-award",
              description:
                "Immutable Data Collections including Sequence, Range, Repeat, Map, OrderedMap, Set and a sparse Vector.",
              github: {
                user: "immutable-js",
                repo: "immutable-js",
              },
              npm: "immutable",
            },
            {
              name: "Mori",
              icon: "fas fa-award",
              description:
                "A library for using ClojureScript's persistent data structures and supporting API from the comfort of vanilla JavaScript.",
              github: {
                user: "swannodette",
                repo: "mori",
              },
              npm: "mori",
            },
            {
              name: "Buckets",
              icon: "fas fa-award",
              description:
                "A complete, fully tested and documented data structure library written in JavaScript.",
              github: {
                user: "mauriciosantos",
                repo: "Buckets-JS",
              },
              npm: "bucketsjs",
            },
            {
              name: "HashMap",
              icon: "fas fa-award",
              description:
                "Simple hashmap implementation that supports any kind of keys.",
              github: {
                user: "flesler",
                repo: "hashmap",
              },
              npm: "hashmap",
            },
          ],
        },
        {
          name: "模板引擎",
          children: [
            {
              name: "Swig",
              icon: "fas fa-award",
              description:
                "Swig is an awesome, Django/Jinja-like template engine for node.js.",
              github: {user: "paularmstrong", repo: "swig"},
              npm: "swig",
            },
            {
              name: "Marko",
              icon: "fas fa-award",
              description:
                "A declarative, HTML-based language that makes building web apps fun",
              github: {user: "marko-js", repo: "marko"},
              npm: "marko",
            },
            {
              name: "ejs",
              icon: "fas fa-award",
              description: "Embedded JavaScript templates",
              github: {user: "mde", repo: "ejs"},
              npm: "ejs",
            },
            {
              name: "Pug",
              icon: "fas fa-award",
              description:
                "Pug – robust, elegant, feature rich template engine for Node.js",
              github: {user: "pugjs", repo: "pug"},
              npm: "pug",
            },
            {
              name: "Hogan.js",
              icon: "fas fa-award",
              description: "A compiler for the Mustache templating language",
              github: {user: "twitter", repo: "hogan.js"},
              npm: "hogan.js",
            },
            {
              name: "Nunjucks",
              icon: "fas fa-award",
              description:
                "A powerful templating engine with inheritance, asynchronous control, and more (jinja2 inspired)",
              github: {user: "mozilla", repo: "nunjucks"},
              npm: "nunjucks",
            },
            {
              name: "Handlebars.js",
              icon: "fas fa-award",
              description: "An extension to the Mustache templating language.",
              github: {user: "handlebars-lang", repo: "handlebars.js"},
              npm: "handlebars",
              org: "https://handlebarsjs.com/",
            },
            {
              name: "mustache.js",
              icon: "fas fa-award",
              description:
                "Minimal templating with {{mustaches}} in JavaScript",
              github: {user: "janl", repo: "mustache.js"},
              npm: "mustache",
            },
          ],
        },
        {
          name: "编辑器",
          children: [
            {
              name: "Ace",
              description:
                "Ace is a standalone code editor written in JavaScript.",
              icon: null,
              "icon-src": "https://ace.c9.io/doc/site/images/favicon.ico",
              path: "/ace",
              github: {
                user: "ajaxorg",
                repo: "ace-builds",
              },
              npm: "ace-builds",
            },
          ],
        },
        {
          name: "音频/视频",
          children: [
            {
              name: "Audio",
              description: "",
              icon: "fa fa-headphones-alt",
              path: "/audiojs",
            },
            {
              name: "video.js",
              description:
                "An HTML5 video player that supports HLS and DASH with a common API and skin.",
              icon: "fa fa-film",
              path: "/video.js",
              github: {
                user: "videojs",
                repo: "video.js",
              },
              npm: "video.js",
            },
            {
              name: "flowplayer",
              description: "The HTML5 video player for the web",
              icon: "fa fa-film",
              path: "/flowplayer",
              percent: 0,
              github: {
                user: "flowplayer",
                repo: "flowplayer",
              },
              npm: "flowplayer",
            },
            {
              name: "mediaelement",
              description:
                "HTML5 &lt;audio> or &lt;video> player with support for MP4, WebM, and MP3 as well as HLS, Dash, YouTube, Facebook, SoundCloud and others with a common HTML5 MediaElement API, enabling a consistent UI in all browsers.",
              icon: "fa fa-film",
              path: "/flowplayer",
              percent: 0,
              github: {
                user: "mediaelement",
                repo: "mediaelement",
              },
              npm: "mediaelement",
            },
            {
              name: "SoundJS",
              description:
                "A Javascript library for working with Audio. It provides a consistent API for loading and playing audio on different browsers and devices. Currently supports WebAudio, HTML5 Audio, Cordova / PhoneGap, and a Flash fallback.",
              icon: "fa fa-film",
              path: "/flowplayer",
              percent: 0,
              github: {
                user: "CreateJS",
                repo: "SoundJS",
              },
              npm: "soundjs",
            },
            {
              name: "FitVids.js",
              description:
                "A lightweight, easy-to-use jQuery plugin for fluid width video embeds.",
              icon: "fa fa-film",
              path: "/flowplayer",
              percent: 0,
              github: {
                user: "davatron5000",
                repo: "FitVids.js",
              },
              npm: "fitvids.js",
            },
            {
              name: "clappr",
              description:
                "\uD83C\uDFAC An extensible media player for the web.",
              icon: "fa fa-film",
              path: "/flowplayer",
              percent: 0,
              github: {
                user: "clappr",
                repo: "clappr",
              },
              npm: "clappr",
            },
            {
              name: "amplitudejs",
              description:
                "AmplitudeJS: Open Source HTML5 Web Audio Library. Design your web audio player, the way you want. No dependencies required.",
              icon: "fa fa-film",
              path: "/flowplayer",
              percent: 0,
              github: {
                user: "serversideup",
                repo: "amplitudejs",
              },
              mpm: "amplitudejs",
            },
          ],
        },
        {
          name: "文件",
          path: "",
          children: [
            {
              name: "jsPDF",
              description: "A library to generate PDFs in JavaScript.",
              icon: "fa fa-file-pdf",
              npm: "jspdf",
              github: {
                user: "MrRio",
                repo: "jsPDF",
              },
            },
            {
              name: "PDF.js",
              description:
                "a Portable Document Format (PDF) viewer that is built with HTML5.",
              icon: "fa fa-file-pdf",
              npm: "pdfjs-dist",
              github: {
                user: "mozilla",
                repo: "pdf.js",
              },
            },
          ],
        },
        {
          name: "颜色",
          path: "",
          children: [
            {
              name: "randomColor",
              description: "A color generator for JavaScript.",
              "icon-src": "./assets/svg/random-color.svg",
              path: "/random-color",
              npm: "randomColor",
              github: {
                user: "davidmerfield",
                repo: "randomColor",
              },
            },
            {
              name: "Vibrant.js",
              description: "Extract prominent colors from an image.",
              icon: "fa fa-image",
              percent: 0,
              path: "/vibrant",
              npm: "node-vibrant",
              github: {
                user: "jariz",
                repo: "vibrant.js",
              },
            },
          ],
        },
        {
          name: "电子表格",
          path: "",
          children: [
            {
              name: "Handsontable",
              description:
                "a JavaScript component that combines data grid features with spreadsheet-like UX.",
              "icon-src":
                "https://handsontable.com/static/images/template/ModCommon/favicon-32x32.png",
              path: "/handsontable",
              npm: "handsontable",
              github: {
                user: "handsontable",
                repo: "handsontable",
              },
            },
          ],
        },
        {
          name: "浏览器检测",
          path: "",
          children: [
            {
              name: "Bowser",
              description:
                "A small, fast and rich-API browser/platform/engine detector for both browser and node.",
              icon: "fab fa-internet-explorer",
              "icon-src": null,
              path: "/bowser",
              npm: "bowser",
              github: {
                user: "bower",
                repo: "bower",
              },
            },
          ],
        },
        {
          name: "数据可视化",
          path: "",
          children: [
            require("./echarts"),
            {
              name: "D3",
              description:
                "Bring data to life with SVG, Canvas and HTML. 📊📈🎉",
              icon: null,
              "icon-src":
                "https://cdn.jsdelivr.net/npm/simple-icons@5.3.0/icons/d3dotjs.svg",
              path: "/d3",
              npm: "d3",
              github: {
                user: "d3",
                repo: "d3",
              },
            },
            {
              name: "mxGraph",
              description:
                "Diagramming library that enables interactive graph and charting applications to be quickly created that run natively in any major browser that is supported by its vendor.",
              icon: "fa fa-chart-pie",
              "icon-src": null,
              path: "/mxgraph",
              npm: "mxgraph",
              github: {
                user: "jgraph",
                repo: "mxgraph",
              },
            },
          ],
        },
        {
          name: "地图",
          path: "",
          children: [
            {
              name: "gmaps.js",
              description:
                "gmaps.js allows you to use the potential of Google Maps in a simple way.",
              icon: "fa fa-map-marked",
              "icon-src": null,
              percent: 0,
              path: "/gmaps",
              npm: "gmaps",
              github: {
                user: "HPNeo",
                repo: "gmaps",
              },
            },
            {
              name: "Leaflet",
              description:
                "an open-source JavaScript library for mobile-friendly interactive maps.",
              icon: null,
              "icon-src":
                "https://cdn.jsdelivr.net/npm/simple-icons@5.3.0/icons/leaflet.svg",
              path: "/leaflet",
              npm: "leaflet",
              github: {
                user: "Leaflet",
                repo: "Leaflet",
              },
            },
            {
              name: "JQVMap",
              description:
                "a jQuery plugin that renders Interactive, Clickable Vector Maps.",
              icon: null,
              "icon-src": "https://www.10bestdesign.com/jqvmap/favicon.png",
              path: "/jqvmap",
              npm: "jqvmap",
              github: {
                user: "manifestinteractive",
                repo: "jqvmap",
              },
            },
            {
              name: "OpenLayers",
              description:
                "A high-performance, feature-packed library for all your mapping needs.",
              icon: null,
              "icon-src":
                "https://cdn.jsdelivr.net/npm/simple-icons@5.3.0/icons/openlayers.svg",
              path: "/openlayers",
              npm: "openlayers",
              github: {
                user: "openlayers",
                repo: "openlayers",
              },
            },
          ],
        },
        {
          name: "图标",
          children: [
            {
              name: "FontAwesome",
              description: "The iconic SVG, font, and CSS toolkit",
              icon: null,
              "icon-src":
                "https://cdn.jsdelivr.net/npm/simple-icons@5.3.0/icons/fontawesome.svg",
              percent: 0,
              path: "/",
              npm: "@fortawesome/fontawesome-free",
              github: {
                user: "FortAwesome",
                repo: "Font-Awesome",
              },
              org: "https://fontawesome.com/v5.15/icons?d=gallery&p=2&m=free",
            },
            {
              name: "Material Design icons",
              description: "Material Design icons by Google",
              icon: null,
              "icon-src":
                "https://cdn.jsdelivr.net/npm/simple-icons@5.3.0/icons/materialdesignicons.svg",
              percent: 0,
              path: "/",
              npm: "material-design-icons",
              github: {
                user: "google",
                repo: "material-design-icons",
              },
            },
            {
              name: "Simple Icons",
              description: "SVG icons for popular brands",
              icon: null,
              "icon-src":
                "https://cdn.jsdelivr.net/npm/simple-icons@5.3.0/icons/simpleicons.svg",
              percent: 100,
              path: "/simple-icons",
              npm: "simple-icons",
              github: {
                user: "simple-icons",
                repo: "simple-icons",
              },
              org: "https://simpleicons.org/",
            },
            {
              name: "SuperTinyIcons",
              description:
                "Under 1KB each! Super Tiny Icons are miniscule SVG versions of your favourite website and app logos",
              github: {user: "edent", repo: "SuperTinyIcons"},
              npm: "super-tiny-icons",
              org: "https://www.iconfinder.com/",
            },
            {
              name: "",
              github: {
                user: "ryanoasis",
                repo: "nerd-fonts",
              },
            },
          ],
        },
        {
          name: "路由",
          children: [
            {
              name: "director",
              description: "a tiny and isomorphic URL router for JavaScript",
              icon: "fas fa-route",
              "icon-src": null,
              path: "/",
              npm: "director",
              github: {
                user: "flatiron",
                repo: "director",
              },
            },
          ],
        },
        {
          name: "机器学习",
          children: [
            {
              name: "ConvNetJS",
              description:
                "Deep Learning in JavaScript. Train Convolutional Neural Networks (or ordinary ones) in your browser.",
              icon: null,
              "icon-src": null,
              path: "/",
              percent: 0,
              npm: "convnetjs",
              github: {
                user: "karpathy",
                repo: "convnetjs",
              },
            },
          ],
        },
      ],
    };
  });
})(define);
