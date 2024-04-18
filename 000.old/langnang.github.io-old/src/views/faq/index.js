"use strict";
(function (define) {
	document.title = "FAQ’s - Langnang";
	define(function (require, exports, module) {
		module.exports = {
			template: require("text!./index.hbs"),
			run: function ({ config, render, route, template, Handlebars }) {
				Handlebars.registerHelper("index", function (index, page = 1, size = 10) {
					return (page - 1) * size + index + 1;
				});
				Handlebars.registerHelper("pagination", function (total, size, page, options) {
					// 最小页码
					const eMin = 1;
					// 最大页码
					const eMax = Math.ceil(total / size);
					// 显示的最小页码
					const min = eMin > page - 5 ? eMin : page - 5;
					// 显示的最大页码
					const max = eMax > page + 5 ? page + 5 : eMax;
					let res = `<ul class="pagination" data-view="faq">`;
					res += `<li><span aria-hidden="true">&laquo;</span></li>`;
					for (let index = min; index <= max; index++) {
						res += `<li> <span data-page="${index}" style="cursor: pointer;">${index}</span> </li>`;
					}
					res += `<li><span aria-hidden="true">&raquo;</span></li>`;
					res += `</ul>`;
					return res;
				});
				// 分页按钮点击事件
				$(document).on("click", ".pagination[data-view=faq] li span", function (e) {
					const prefix = $(this).parent().parent().parent().parent().attr("data-prefix");
					$.ajax({
						method: "post",
						url: `${config.api_php_url}/typecho/post/list`,
						data: {
							title: getUrlParams()["kw"],
							prefix,
							page: $(this).attr("data-page"),
						},
						success: function (res) {
							$(`#faq_${prefix}`).html(
								Handlebars.compile(`
							<div class="row">
								<div class="col-md-9">
									{{#each data.rows}}
										<div class="single-faq">
											<h2><span>{{index @index @root.data.page @root.data.size}}</span>{{title}}</h2>
											<p>{{abstract}}</p>
										</div>
									{{/each}}
								</div>
								<div class="col-md-3">
									<div class="faq-sidebar-wrap">
										<ul class="faq-sidebar">
											{{#each data.rows}}
												<li>
													<span>{{index @index @root.data.page  @root.data.size}}.</span>{{title}}
												</li>
											{{/each}}
										</ul>
									</div>
								</div>
							</div>

							<div class="row" style="text-align: center;">
								{{#pagination data.total data.size data.page}}{{/pagination}}
							</div>`)(res)
							);
						},
					});
				});

				$.ajax({
					method: "post",
					url: `${config.api_php_url}/typecho/post/list`,
					data: {
						prefix: getUrlParams()["prefix"] || "*",
						title: getUrlParams()["kw"],
					},
					success: function (res) {
						render(Handlebars.compile(template)(res.data));
					},
				});
			},
		};
	});
})(define);
