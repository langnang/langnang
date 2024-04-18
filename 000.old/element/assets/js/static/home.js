"use strict";
(function (define) {
  define(function (require, exports, module) {
    const $ = require("jquery");

    module.exports = function (params) {
      const routes = require("json!../routes.json");
      let content = "";
      routes
        .find((v) => v.name == "static")
        .children.forEach((m) => {
          if (m.name) {
            content += `<h2 class="col-md-12 text-center"><b>${m.name}</b></h2>`;
          }
          if (m.children && m.children.length > 0) {
            m.children.forEach((item) => {
              const status =
                (item.percent && item.percent < 100) || item.percent === 0
                  ? false
                  : true;
              content +=
                `
<div class="col-lg-3 col-md-4 single-service">
  <div class="inner">
    <a href="#/static${item.path || ""}" style="${
                  !status ? "pointer-events: none;" : ""
                }">

    <div class="title">
      <div class="icon">
      ${item.icon ? `<i class="${item.icon}"></i>` : ``}
      ${item["icon-src"] ? `<img src="${item["icon-src"]}"/>` : ``}
      </div>
      <h4>${item.name}</h4>
    </div>
    <div class="content">
      <p class="description">${item.description || ""}</p>
    </div>
      </a>
    <div class="additional">
     ` +
                (item.github
                  ? `<a href="https://github.com/${item.github.user}/${item.github.repo}" target="_blank"> <img src="https://img.shields.io/github/stars/${item.github.user}/${item.github.repo}" /></a> `
                  : "") +
                (item.npm
                  ? `<a href="https://www.jsdelivr.com/package/npm/${item.npm}" target="_blank"> <img src="https://data.jsdelivr.com/v1/package/npm/${item.npm}/badge" /></a> `
                  : "") +
                `</div>
    <div class="progress" style="${status ? "display:none;" : ""}">
      <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="${
        item.percent || 100
      }" aria-valuemin="0" aria-valuemax="100" style="width: ${
                  item.percent
                }%"></div>
    </div>
  </div>
</div>
`;
            });
          }
        });
      $("#template-overview-wrapper").html(content);
    };
  });
})(define);
