"use strict";
(function (define) {
  define(function (require, exports, module) {
    const template = require("text!./../../../views/static/masonry.hbs");
    const Masonry = require("masonry");
    module.exports = function (options) {
      console.log(options);

      options.template = template;
      options.render();
      new Masonry("#static-masonry-wrapper", {
        // options
        itemSelector: '.col-md-3',
      });
    };
  });
})(define);
