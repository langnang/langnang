"use strict";

(function (requirejs) {
  if (window.location.hash === "") {
    window.location.hash = "#/";
  }
  define(["./app.config"], function (config) {
    requirejs(config.requirejsConfig);
    if (config.env === "dev") {
      require(["css!https://langnang.github.io/assets/css/main.css"]);
    } else {
      require(["css!./../assets/css/main.css"]);
    }
    require([
      "jquery",
      "handlebars",
      "bootstrap",
      "holderjs",
      "css!./assets/css/main.css",
      "css!./styles/index.css",
    ], function ($, Handlebars) {
      require(["./routes/index"])
      Promise.all([
        new Promise(function (resolve, reject) {
          $.ajax({
            method: "get",
            url: "https://langnang.github.io/layout/component/header.hbs",
            success: resolve,
          });
        }),
        new Promise(function (resolve, reject) {
          $.ajax({
            method: "get",
            url: "https://langnang.github.io/layout/component/footer.hbs",
            success: resolve,
          });
        }),
      ]).then((res) => {
        $("body>header").html(Handlebars.compile(res[0])(config));
        $("body>footer").html(Handlebars.compile(res[1])(config));
        $(document).ready(function () {
          $(".loading").fadeOut(1000);
        });
      });
    });
  });
})(requirejs);
