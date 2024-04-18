"use strict";
(function (define) {
  define(function (require, exports, module) {
    module.exports = {
      template: require("text!views/static/home/index.hbs"),
      run: function ({render, router, routes, $routes, route, template, Handlebars, $params, convertUrlParams}) {
        // console.log(router, routes, route, $routes);
        route.children = $routes.find(v => v.name == "static").children.reduce(
          (total, item) => {
            // 非 开发
            if (item.path === '/dev') return total;
            // 非 没有子类
            if (!item.children) return total;
            // 若 为数组
            if (item.children instanceof Array) {
              const children = item.children.filter(i => i.name && i.description && i.path && i.component);
              if (children.length == 0) {
                return total;
              } else {
                total.push({...item, children,})
                return total;
              }
            }
            // 则 为对象
            else {
              const children = Object.values(item.children).filter(i => i.name && i.description && i.path && i.component);
              if (children.length == 0) {
                return total;
              } else {
                total.push({...item, children,})
                return total;
              }
            }
            // return (item.children instanceof Array ? item.children.filter(i => i.name && i.description && i.path && i.component) : Object.values(item.children).filter(i => i.name && i.description && i.path && i.component)).length > 0
            return total;
          }, []
        );
        Handlebars.registerHelper(
          "link",
          /**
           * @param root 根
           * @param group 一级
           * @param item 二级
           * @param {String} link 外链
           * @param {Object} params 地址栏参数
           * @param {Object} options
           * @returns {String} 地址链接
           */
          function (root = "", group = "", item = "", link, params, options) {
            let href = "";
            if (link) {
              href = link;
            } else {
              href = "#" + root + group + item;
            }

            href += convertUrlParams({...$params, ...params});
            return href;
          }
        );
        const html = Handlebars.compile(template)(route);
        render(html);
      },
    };
  });
})(define);
