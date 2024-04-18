"use strict";
(function (define) {
  define(function (require, exports, module) {
    module.exports = function () {
      require(["json!https://cdn.jsdelivr.net/npm/simple-icons@5.3.0/_data/simple-icons.json"], function (icons) {
        console.log(icons);
        document.getElementById("simple-icons-wrapper").innerHTML = icons.icons.reduce((total, item) => {
          return total + `
<div class="col-sm-3 col-md-2">
  <div class="thumbnail">
    <div class="caption">
      ${item.title}
    </div>
  </div>
</div>
`
        }, ``)
      })
    };
  });
})(define);
