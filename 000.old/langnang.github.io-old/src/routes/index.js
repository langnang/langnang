"use strict";

(function (define) {
	define(function (require, exports, module) {
		require("director");
		const Handlebars = require("handlebars");
		const $ = require("jquery");
		const config = require("./../../app.config");
		// 代理路由
		const proxyViews = {
			// "/": "/static/index",
			// "/vue": "/vue/index",
		};

		// 原始路由
		const routes = flattenRoutes([
			{
				name: "home",
				path: "/home",
				proxyPath: "/",
				component: "/home/index",
			},
			{
				name: "faq",
				path: "/faq",
				component: "/faq/index",
			},
		]);
		// 转换为符合 director 的路由格式
		const router = window
			.Router(
				Object.keys(routes).reduce((total, val) => {
					total[val] = [];
					return total;
				}, {})
			)
			.configure({
				on: function (...args) {
					$(document).ready(function () {
						$(".loading").fadeOut(2000);
					});
				},
				once: function (...args) {
					// console.log("once", args);
				},
				after: function (...args) {
					// console.log("after", args);
				},
				before: function (...args) {
					$(".loading").fadeIn(100);
					renderView({ routes, config, $ });
				},
			})
			.init();
		// 渲染视图
		function renderView(options) {
			options.path = options.path || window.location.hash.substr(1, window.location.hash.indexOf("?") === -1 ? window.location.hash.length : window.location.hash.indexOf("?") - 1);
			const route = options.routes[options.path];
			let callback = Object.assign(options, {
				route,
				Handlebars,
				template: `<div name="${options.path.substr(1).split("/").join("-")}-wrapper" class="row"></div>`,
				render: function (...args) {
					if (typeof args[0] == "string") {
						document.getElementById("app").innerHTML = args[0];
						return;
					}
					document.getElementById("app").innerHTML = Handlebars.compile(callback.template)(args[0]);
				},
				proxyViews,
				config,
				run() {
					this.render();
				},
			});
			// 当路由指定视图组件地址
			if (route.component) {
				require(["./../../src/views" + route.component + ".js"], function (res) {
					callback = Object.assign(callback, res);
					callback.run(callback);
				});
			} else {
				callback.run(callback);
			}
		}

		// 展平嵌套路由
		function flattenRoutes(routes, parent = "") {
			return routes.reduce((t0, t1) => {
				return {
					...(t1.children ? flattenRoutes(t1.children, parent + (t1.path || "")) : {}),
					...t0,
					[parent + (t1.proxyPath ? t1.proxyPath : t1.path || "")]: {
						...t1,
						_path: t1.path,
						path: parent + (t1.path || ""),
					},
				};
			}, {});
		}
	});
})(define);
