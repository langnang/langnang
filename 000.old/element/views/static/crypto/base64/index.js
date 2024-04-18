"use strict";
(function (define) {
  define(function (require, exports, module) {
    const CryptoJS = require("crypto-js");
    module.exports = {
      template: require("text!./../../../../views/static/crypto/index.hbs"),
      // 加密
      encrypt: function (val = "0") {
        return CryptoJS.enc.Base64.stringify(CryptoJS.enc.Utf8.parse(val));
      },
      // 解密
      decrypt: function (val = "MA==") {
        return CryptoJS.enc.Base64.parse(val).toString(CryptoJS.enc.Utf8);
      },
      run: function ({ render, route, encrypt, decrypt }) {
        render({ ...route, encrypt, decrypt });
        $("#encrypt").click(function () {
          $("textarea[name='output']").val(
            encrypt($("textarea[name='input']").val())
          );
        });
        $("#decrypt").click(function () {
          $("textarea[name='input']").val(
            decrypt($("textarea[name='output']").val())
          );
        });
      },
    };
  });
})(define);
