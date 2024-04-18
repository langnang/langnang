"use strict";
(function (define) {
  define(function (require, exports, module) {
    module.exports = {
      template: require("text!./../../../../views/static/component/radio/index.hbs"),
      run: function ({render, route, template}) {
        console.log(template);
        render({...route});
      },
    };
  });
})(define);
