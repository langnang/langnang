"use strict";
(function (define) {
  define(function (require, exports, module) {
    const ace = require("ace/ace");
    module.exports = function () {
      require(["ace/theme-monokai", "ace/mode-javascript"], function () {
        const editor = ace.edit("ace-wrapper");
        editor.setTheme("ace/theme/monokai");
        editor.session.setMode("ace/mode/javascript");
      });
    };
  });
})(define);
