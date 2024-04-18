"use strict";
(function (define) {
  define(function (require, exports, module) {
    "use strict";
    const config = require("https://langnang.github.io/app.config.js");
    module.exports = {
      ...config,
      env: location.hostname === "127.0.0.1" ? "dev" : "prod",
      publicPath: location.hostname === "127.0.0.1" ? "" : "/element",
    };
  });
})(define);
