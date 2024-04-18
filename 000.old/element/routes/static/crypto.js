"use strict";
// 静态页面
(function (define) {
  define(function (require, exports, module) {
    module.exports = {
      name: "Crypto",
      description: "加密",
      path: "/crypto",
      children: [
        {
          name: "Base64",
          path: "/base64",
          component: "views/static/crypto/base64/index",
        },
        {
          name: "MD5",
          path: "/md5",
          component: "views/static/crypto/md5/index",
        },
        {
          name: "SHA1",
          path: "/sha1",
          component: "views/static/crypto/sha1/index",
        },
        {
          name: "SHA256",
          path: "/SHA256",
          component: "views/static/crypto/sha256/index",
        },
        {
          name: "SHA512",
          path: "/SHA512",
          component: "views/static/crypto/sha512/index",
        },
      ],
    };
  });
})(define);
