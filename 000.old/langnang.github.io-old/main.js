"use strict";

(function (requirejs) {
	// 默认路由地址
	if (window.location.hash === "") {
		window.location.hash = "#/";
	}
	define(["./app.config"], function (config) {
		requirejs(config.requirejsConfig);
		require([
			"jquery",
			"handlebars",
			`text!${config.publicPath}/src/components/header/index.hbs`,
			`text!${config.publicPath}/src/components/footer/index.hbs`,
			"css!src/assets/css/main.css",
			"bootstrap",
			"./src/routes/index", // 路由
		], function ($, Handlebars, headerHtml, footerHtml) {
			$("body>header").html(Handlebars.compile(headerHtml)(config));
			$("body>footer").html(Handlebars.compile(footerHtml)(config));

			$(document).on("click", ".search-icon", function (e) {
				const searchForm = $(".search-form");
				$(this).add(searchForm).toggleClass("active");
			});
			$(document).on("input", "input[type=search]", function (e) {
				console.log($(this).val());
			});
		});
	});
	// define("home", ["./app.config", "jquery", "handlebars", `text!/views/home.hbs`], function (config, $, Handlebars, view) {
	// 	document.title = "Home - Langnang";
	// 	$("#app").html(Handlebars.compile(view)(config));
	// 	$(".loading").fadeOut(500);
	// });

	// define("faq", ["./app.config", "jquery", "handlebars", `text!/views/faq.hbs`], function (config, $, Handlebars, view) {
	// 	document.title = "FAQ - Langnang";
	// 	Handlebars.registerHelper("index", function (index, page = 1, size = 10) {
	// 		return index + 1;
	// 	});
	// 	$.ajax({
	// 		method: "post",
	// 		url: `${config.api_php_url}/typecho/post/list`,
	// 		data: {
	// 			prefix: "*",
	// 			title: getUrlParams()["kw"],
	// 		},
	// 		success: function (res) {
	// 			$("#app").html(Handlebars.compile(view)(res.data));
	// 			$(".loading").fadeOut(500);
	// 		},
	// 	});
	// });

	// define("typecho", ["./app.config", "jquery", "handlebars", `text!/views/typecho.hbs`], function (config, $, Handlebars, view) {
	// 	document.title = "Typecho - Langnang";
	// 	$.ajax({
	// 		method: "post",
	// 		url: `${config.api_php_url}/typecho/list`,
	// 		data: {},
	// 		success: function (res) {
	// 			$("#app").html(Handlebars.compile(view)(res.data));
	// 			$(".loading").fadeOut(500);
	// 		},
	// 	});
	// });
})(requirejs);

function getUrlParams(url = window.location.href, key = null) {
	if (url.indexOf("?") === -1) {
		return false;
	}
	let start = url.indexOf("?");
	let end = url.indexOf("#");
	end = end === -1 ? url.length : end;
	end = end < start ? url.length : end;

	let arr = decodeURIComponent(url.substring(start, end)).split("?");
	arr = arr[1].split("&");
	let len = arr.length,
		obj = {};
	for (let i = 0; i < len; i++) {
		let a = arr[i].split("=");
		obj[a[0]] = a[1];
	}
	if (key) {
		return obj[key];
	}
	return obj;
}

function hashRouter(url = window.location.hash) {
	if (url.indexOf("#") === -1) {
		return "/";
	}
	let start = url.indexOf("#");
	let end = url.indexOf("?");
	// 未找到?
	end = end === -1 ? url.length : end;
	// #\? 顺序逆反
	end = end < start ? url.length : end;
	return url.substring(start + 1, end);
}

function routeMatch(routes) {
	let route = hashRouter();
	if (routes.has(route)) {
		return routes.get(route);
	}
	return routes.get("/");
}
