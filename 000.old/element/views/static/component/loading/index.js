"use strict";
(function (define) {
  define(function (require, exports, module) {
    module.exports = {
      template: require("text!./../../../../views/static/component/loading/index.hbs"),
      run: function ({render, route}) {
        render({...route});
      },
    };
  });
})(define);
