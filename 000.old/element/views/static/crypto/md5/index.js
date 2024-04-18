"use strict";
(function (define) {
  define(function (require, exports, module) {
    const CryptoJS = require("crypto-js");
    module.exports = {
      template: require("text!./../../../../views/static/crypto/index.hbs"),
      // 加密
      encrypt: function (val) {
        return CryptoJS.MD5(val);
      },
      run: function ({ render, route, encrypt, decrypt }) {
        render({ ...route, encrypt, decrypt });
        $("#encrypt").click(function () {
          $("textarea[name='output']").val(
            encrypt($("textarea[name='input']").val())
          );
        });
      },
    };
  });
})(define);
