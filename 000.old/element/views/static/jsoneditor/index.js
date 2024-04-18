"use strict";
(function (define) {
  define(function (require, exports, module) {
    const JSONEditor = require("jsoneditor");
    module.exports = {
      template: require("text!./../../../views/static/jsoneditor/index.hbs"),
      initCodeEditor: () =>
        new JSONEditor(document.getElementById("jsoneditor-code"), {
          mode: "code",
        }),
      initTreeEditor: () =>
        new JSONEditor(document.getElementById("jsoneditor-tree"), {}),
      run: function ({ render, route, initCodeEditor, initTreeEditor }) {
        render(route);
        const codeEditor = initCodeEditor();
        const treeEditor = initTreeEditor();
        // set json
        const initialJson = {
          Array: [1, 2, 3],
          Boolean: true,
          Null: null,
          Number: 123,
          Object: { a: "b", c: "d" },
          String: "Hello World",
        };
        codeEditor.set(initialJson);
        treeEditor.set(initialJson);

        $("#code-2-tree").click(function () {
          const json = codeEditor.get();
          treeEditor.set(json);
        });
        $("#tree-2-code").click(function () {
          const json = treeEditor.get();
          codeEditor.set(json);
        });
      },
    };
  });
})(define);
