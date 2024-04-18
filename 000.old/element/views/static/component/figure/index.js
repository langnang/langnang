"use strict";
(function (define) {
  define(function (require, exports, module) {
    require("css!./../../../../styles/component/figure/index.css");
    module.exports = {
      template: require("text!./../../../../views/static/component/figure/index.hbs"),
      run: function ({render, route}) {
        console.log(route);
        render({...route});
      },
    };
  });
})(define);
