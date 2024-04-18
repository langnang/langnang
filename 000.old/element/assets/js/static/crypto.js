"use strict";
(function (define) {
  define(function (require, exports, module) {
    const $ = require("jquery");
    const CryptoJS = require("crypto-js");
    const MarkdownIt = require("markdown-it");
    const md = new MarkdownIt();

    let encrypt = "Base64";
    const cryptoMap = new Map();
    // Base64
    cryptoMap.set("Base64", {
      md: "# Base64",
      encrypt: (str) =>
        CryptoJS.enc.Base64.stringify(CryptoJS.enc.Utf8.parse(str)),
      decrypt: (str) =>
        CryptoJS.enc.Base64.parse(str).toString(CryptoJS.enc.Utf8),
    });
    // MD5
    cryptoMap.set("MD5", {
      md: "# MD5",
      encrypt: (str) => CryptoJS.MD5(str),
    });
    // SHA1
    cryptoMap.set("SHA1", {
      md: "# SHA1",
      encrypt: (str) => CryptoJS.SHA1(str),
    });
    cryptoMap.set("SHA256", {
      encrypt: (str) => CryptoJS.SHA256(str),
    });
    cryptoMap.set("SHA512", {
      encrypt: (str) => CryptoJS.SHA512(str),
    });
    cryptoMap.set("SHA3", {
      encrypt: (str) => CryptoJS.SHA3(str),
    });
    cryptoMap.set("RIPEMD160", {
      encrypt: (str) => CryptoJS.RIPEMD160(str),
    });
    cryptoMap.set("HmacMD5", {
      secret: true,
      encrypt: (str, secret) => CryptoJS.HmacMD5(str, secret),
    });
    cryptoMap.set("HmacSHA1", {
      secret: true,
      encrypt: (str, secret) => CryptoJS.HmacSHA1(str, secret),
    });
    cryptoMap.set("HmacSHA256", {
      secret: true,
      encrypt: (str, secret) => CryptoJS.HmacSHA256(str, secret),
    });
    cryptoMap.set("HmacSHA512", {
      secret: true,
      encrypt: (str, secret) => CryptoJS.HmacSHA512(str, secret),
    });
    cryptoMap.set("AES", {
      secret: true,
      encrypt: (str, secret) => CryptoJS.AES.encrypt(str, secret),
    });
    cryptoMap.set("DES", {
      secret: true,
      encrypt: (str, secret) => CryptoJS.DES.encrypt(str, secret),
    });
    cryptoMap.set("TripleDES", {
      secret: true,
      encrypt: (str, secret) => CryptoJS.TripleDES.encrypt(str, secret),
    });
    cryptoMap.set("Rabbit", {
      secret: true,
      encrypt: (str, secret) => CryptoJS.Rabbit.encrypt(str, secret),
    });
    cryptoMap.set("RC4", {
      secret: true,
      encrypt: (str, secret) => CryptoJS.RC4.encrypt(str, secret),
    });
    cryptoMap.set("RC4Drop", {
      secret: true,
      encrypt: (str, secret) => CryptoJS.RC4Drop.encrypt(str, secret),
    });

    module.exports = function () {
      // 初始化Tab
      let cryptoTabsHtml = "",
        cryptoTabContentHtml = "";
      [...cryptoMap.keys()].forEach(function (t) {
        cryptoTabsHtml += `<li role="presentation" class=""><a href="#${t.toLowerCase()}" role="tab" id="${t.toLowerCase()}-tab" data-toggle="tab" aria-controls="${t.toLowerCase()}" aria-expanded="false">${t}</a></li>`;
        const item = cryptoMap.get(t);
        item.md =
          `# ${t}\n\n` +
          `${
            item.encrypt
              ? `**加密方法**\n\n\`\`\`js\nconst CryptoJS = require("crypto-js");\nconst encrypt = ${item.encrypt.toString()}\n\`\`\``
              : ""
          }\n\n` +
          `${
            item.decrypt
              ? `**解密方法**\n\n\`\`\`js\nconst CryptoJS = require("crypto-js");\nconst decrypt = ${item.decrypt.toString()}\n\`\`\``
              : ""
          }\n\n` +
          (item.md || "");
        cryptoTabContentHtml += `<div role="tabpanel" class="tab-pane fade" id="${t.toLowerCase()}" aria-labelledby="home-tab">${md.render(
          item.md
        )}</div>`;
      });
      $("#cryptoTabs").html(cryptoTabsHtml);
      $("#cryptoTabContent").html(cryptoTabContentHtml);

      $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
        encrypt = e.target.innerText;
        $("#crypto-title").html(e.target.innerText);
      });

      $("#encrypt").click(function () {
        const input = $("input[name='input']").val();
        const secret = $("input[name='secret']").val();
        let output = "";
        if (cryptoMap.has(encrypt) && cryptoMap.get(encrypt)["encrypt"]) {
          output = cryptoMap.get(encrypt)["encrypt"](input, secret);
        } else {
          output = "未找到加密方法，加密失败。";
        }
        $("textarea[name='output']").val(output);
      });
      $("#decrypt").click(function () {
        const input = $("textarea[name='output']").val();
        const secret = $("input[name='secret']").val();
        let output = "";
        if (cryptoMap.has(encrypt) && cryptoMap.get(encrypt)["decrypt"]) {
          output = cryptoMap.get(encrypt)["decrypt"](input, secret);
        } else {
          output = "未找到解密方法，解密失败。";
        }
        $("input[name='input']").val(output);
      });

      $(".nav.nav-tabs>li:first-child a").click();
    };
  });
})(define);
