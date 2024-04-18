"use strict";
(function (define) {
  define(function (require, exports, module) {
    const JSONEditor = require("jsoneditor");
    module.exports = {
      template: require("text!../../../../../views/static/script/index.hbs"),
      LoadJS: function (id, fileUrl) {
        var target = document.getElementById(id);
        var oScript = document.createElement("script");
        oScript.type = "text/javascript";
        oScript.src = fileUrl;
        target.appendChild(oScript);
      },
      run: function ({ render, route, LoadJS }) {
        console.log(route);
        render(route);
        require([
          "text!https://gist.githubusercontent.com//ab983446919896623f070fe45375295c/raw/b13a5306211cd68dc719e359e287254e8e8f2ed3/git-clone-a-repo.sh",
        ], function (text) {
          console.log(text);
        });
      },
    };
  });
})(define);
