"use strict";
(function (define) {
  define(function (require, exports, module) {
    require("css!./../../../../styles/component/scrollbar/index.css");

    module.exports = {
      template: require("text!./../../../../views/static/component/scrollbar/index.hbs"),
      run: function ({render, route}) {
        console.log(route);
        render({...route});
      },
    };
  });
})(define);
