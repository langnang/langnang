# Webpack Template

[官网](https://webpack.js.org/) | [中文网](https://webpack.docschina.org/) | [Awesome](https://webpack.js.org/awesome-webpack/)

`webpack.config.js`

```js
const path = require("path");

module.exports = {
  entry: "./src/index.js", // 入口
  // 输出
  output: {
    path: path.resolve(__dirname, "dist"),
    filename: "bundle.js",
  },
};
```
