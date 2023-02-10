# JavaScript Package Template

JavaScript 初始化打包

`package.js`

```js
(function (global, factory) {
  typeof exports === "object" && typeof module !== "undefined"
    ? (module.exports = factory())
    : typeof define === "function" && define.amd
    ? define(factory)
    : ((global =
        typeof globalThis !== "undefined" ? globalThis : global || self),
      (global.Package = factory()));
})(this, function () {});
```
