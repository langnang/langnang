"use strict";

require.config({
	baseUrl: "/resources/vendor/",// 所有模块的查找根路径
	paths: {// path映射那些不直接放置于baseUrl下的模块名
		"ace":"ace/1.3.3/src-min-noconflict/ace",// 富文本编辑器
		"angular":"angular/1.5.8/angular.min",// Angular 是一个开发平台,它能帮你更轻松的构建 Web 应用
		"backbone":"backbone/1.1.2/backbone.min",// Backbone 为复杂 Javascript 应用程序提供模型(models)、集合(collections)、视图(views)的结构
		"bootstrap":"bootstrap/3.3.7/js/bootstrap.min",// Bootstrap 是全球最受欢迎的前端组件库
		"echarts":"echarts/3.8.5/echarts.min",// ECharts 是一个使用 JavaScript 实现的开源可视化库
		"holder":"holder/2.9.4/holder.min",// Holder uses SVG to render image placeholders entirely in browser.
		"ip-sohu":"http://pv.sohu.com/cityjson?ie=utf-8",// 搜狐IP
		"jquery": "jquery/3.3.1/jquery.min",// jQuery 是一个高效、精简并且功能丰富的 JavaScript 工具库
		"jquery-ui":"jquery-ui/1.12.1/jquery-ui.min",// jQuery UI 是建立在 jQuery JavaScript 库上的一组用户界面交互、特效、小部件及主题。
		"layer":"layer/3.1.1/layer",// Cross-end web layer tool
		"less":"less/2.5.3/less.min",// Leaner CSS
		"lodash":"lodash/4.17.10/lodash.min",// Lodash 是一个具有一致接口、模块化、高性能等特性的 JavaScript 工具库
		"marked":"marked/0.5.0/marked",// A markdown parser built for speed
		"masonry":"masonry/4.2.2/masonry.pkgd.min",// Masonry 是一个瀑布流布局工具库。
		"nunjucks":"nunjucks/3.1.3/nunjucks.min",// JavaScript 专用的功能丰富、强大的模板引擎。
		"react":"",// React 是用于构建用户界面的 JavaScript 工具库
		"showdown":"showdown/2.0/showdown.min",// A Markdown to HTML converter written in Javascript
		"vue":"vue/2.5.16/vue.min",// Vue 是一套用于构建用户界面的渐进式框架
		"xlsx":"xlsx/0.14.0/xlsx.full.min"// Excel (XLSB/XLSX/XLSM/XLS/XML) and ODS spreadsheet parser and writer
	},
	shim: {// 为那些没有使用define()来声明依赖关系、设置模块的"浏览器全局变量注入"型脚本做依赖和导出配置。
	"angular":{
		exports:"angular"
	},
	"bootstrap":{
			// 指定要加载的一个依赖数组。
			deps:[
			"css!/resources/vendor/bootstrap/3.3.7/css/bootstrap.min.css",
			"css!/resources/vendor/bootstrap/3.3.7/css/bootstrap-theme.min.css",
			"css!/resources/vendor/font-awesome/4.7.0/css/font-awesome.min.css",
			"css!/resources/src/css/bootstrap-cus.css",
			"jquery"
			],
			exports:"bootstrap"
		},
		"jquery":{
			exports:"$"
		},
		"lodash":{
			exports:"_"
		},
		"masonry":{
			exports:"Masonry"
		},
		"vue":{
			exports:"Vue"
		}
	},
	map: {
		'*': {
			"css":"require-css/0.1.10/require-css.min",
			"text":"require-text/2.0.12/require-text.min"//加载文本资源的AMD加载器插件
		}
	},
})
/**
* 页面加载后获取页面地址
* 链接数据库：提取数据库中file表中数据-->进行比较
* 1. 获取文件库中存储的信息
* 2. 提取文件信息
*/
/*****************************页面配置初始化****************************************/
// 基本配置
define("initialize",function(require){

	require("layout");
	require("bootstrap");
	require("/resources/src/js/javascript.js");
	require("/resources/src/js/jquery.js");

	var config={};
	return config;
})


define("layout",function(require){
	require("jquery");
	var nunjucks=require("nunjucks");
	nunjucks.configure('../../../../../',{ autoescape: true });
	// 加载navbar导航栏
	$("body").prepend(nunjucks.render("/resources/template/html/navbar.html"));
	// 加载footer底部布局
	$("body").append(nunjucks.render("/resources/template/html/footer.html"));
	// // 判断加载底部布局
	// if(config.showFooter=="true"){
	// 	if(config.showReport==true){
	// 		$("i.fa.fa-info-circle").eq(0).attr({"data-toggle":"modal","data-target":"#reportModal"});

	// 		config.fileInfo=$.parseJSON(callAPI("res","getfileinfo",config.fileUrl))[0];
	
	// 		if(config.fileInfo!==undefined && config.fileInfo.report!==""){
	// 			config.fileInfo.report=$.parseJSON(config.fileInfo.report);
	// 		}
	
	// 		$("body").append(nunjucks.render("/resources/template/html/report.njk",config.fileInfo));
	// 		// console.log(report);
	// 	}
	// }
	// 加载alert提示布局
	$("body").append('<div style="width:500px;position:absolute; z-index:1000;right: 40px; top: 60px;" id="alertArea"></div>');

	// // 判断加载提示布局
	// if(config.showAlert==true){
	// 	config.alert={};
	
	// }
	

	
	// config.loadAlertTemplate=function(type,content){
	// 	if(config.showAlert==true){
	// 		config.alert={"type":type,"content":content};
	// 		$("#alertArea").append(nunjucks.render("/resources/template/html/alert.njk",config.alert));
	// 		setTimeout(function(){
	// 			$("#alertArea>div").eq(0).remove();
	// 		},3000)
	// 	}
	// }
})



/********************************jQuery方法****************************/


// 显隐逻辑思路
function toggleThinking(){
	$("[role='logicalThinking']").toggle();
}
// 显隐开发报告
function toggleDevelopment(){
	$("[role='developmentReport']").toggle();
}
// 显隐BUG反馈
function toggleFeedback(){
	$("[role='bugFeedback']").toggle();
}
function getSetting(){
	var config;
	$.ajax({
		type:"get", 
		url:"/resources/setting.ini", 
		async:false, 
		success:function(data){
			config=data;
		} 
	})
	config=cleanEmptyLine(config);
	config=cleanCommentLine(config);
	config=convertToJSON(config);
	config.fileUrl=getFileUrl(config.fileBaseUrl);
	return config;
}
// 综合型ajax
// function callAPI(project,act,data){
// 	var ajaxType,ajaxUrl,ajaxData,ajaxResult;
// 	switch(project){
// 		case "res":{
// 			ajaxUrl="/resources/action/api/res/default.php";
// 			switch(act){

// 				case "getfileinfo":{
// 					ajaxData={code:`echo selectFileInfo($link,"`+data+`");`};
// 					break;
// 				};
// 				case "getallfileurl":{
// 					ajaxData={code:`echo selectAllFileUrl($link);`};
// 					break;
// 				};
// 				case "insertfileinfo":{
// 					ajaxData={code:`echo insertFileData($link,'`+data+`');`};
// 					break;
// 				};
// 				case "updatefileinfo":{
// 					ajaxData={code:`echo updateFileData($link,'`+data+`');`};
// 					break;
// 				};
// 				default:break;
// 			}
// 			break;

// 		};
// 		case "fie":{
// 			ajaxUrl="/resources/action/api/eval.php";
// 			switch(act){
// 				case "openfolder":{
// 					ajaxData={code:`echo openFolder($_SERVER['DOCUMENT_ROOT']."`+data+`");`};
// 					break;
// 				};
// 				case "openfile":{
// 					ajaxData={code:`echo openFile($_SERVER['DOCUMENT_ROOT']."`+data+`");`};
// 					break;
// 				};
// 				case "readfilecontent":{
// 					ajaxData={code:`echo readFileContent($_SERVER['DOCUMENT_ROOT']."`+data+`");`};
// 					break;
// 				};
// 				default:break;
// 			}
// 			break;
// 		};
// 		case "gpd":{
// 			break;
// 		};
// 		case "bkg":{
// 			break;
// 		};
// 		case "tol":{
// 			break;
// 		};
// 		default:break;
// 	}
// 	// console.log(ajaxData);
// 	$.ajax({
// 		type:"post",
// 		async:false,
// 		url:ajaxUrl,
// 		data:ajaxData,
// 		success:function(data){
// 			// console.log(data);
// 			ajaxResult=data;
// 		}
// 	})
// 	return ajaxResult;
// }

function callAPI(url,data){
	var API_PATH="/resources/action/api/index.php";
	var result;
	if(data==undefined){data='{}'};
	$.ajax({
		type:"post",
		async:false,
		url:API_PATH+url,
		data:{"data":data},
		dataType:"json",
		success:function(data){
			result=data;
		}
	})
	return result;
}
