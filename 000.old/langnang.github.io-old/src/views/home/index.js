"use strict";
(function (define) {
	document.title = "Home - Langnang";
	define(function (require, exports, module) {
		module.exports = {
			template: require("text!./index.hbs"),
		};
	});
})(define);
