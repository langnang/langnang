var htmlApp=angular.module("htmlApp",[]);

htmlApp.config(function($httpProvider){
	$httpProvider.defaults.headers.post = { 'Content-Type': 'application/x-www-form-urlencoded' }
})

htmlApp.controller("htmlCtrl",function($http,$scope,$sce){
	// 页面加载运行的方法
	// 获取项目目录
	// tree 代表树的深度
	$scope.get_poject_catalog=function(){

		$http({
			method:"post",
			url:"/back-stage/action/floder/select.php",
			data:$.param({"url":"/","tree":"0"})
		}).then(function success(response){
			// console.log(response.data);
			$scope.catalog=response.data;
			$scope.breadcrumbs=[];
			$scope.control_row_is_show(1);
		})
	}
	// 控制row的显示隐藏
	$scope.control_row_is_show=function(index){
		$("div.row").css({display:"none"});
		$("div.row").eq(0).css({display:"block"});
		$("div.row").eq(index).css({display:"block"});
	}

	$scope.get_poject_catalog();

	// 显示README内容
	$scope.show_project_readme=function(url){
		$http({
			method:"get",
			url:"/"+url+"/README.md",
		}).then(function success(response){
			$scope.readme  = $sce.trustAsHtml(new showdown.Converter().makeHtml(response.data));
		})

		$http({
			method:"get",
			url:"/"+url+"/CHANGELOG.md",
		}).then(function success(response){
			$scope.changelog  = $sce.trustAsHtml(new showdown.Converter().makeHtml(response.data));
		})
	}

	// 打开项目文件列表
	// 判断树的深度与导航数量？若相等：tree++,不相等：截取导航
	$scope.open_project_floder=function(index,url){
		// console.log(parseInt(index));
		// console.log($scope.breadcrumbs.length);
		// console.log("/"+$scope.breadcrumbs.join("/")+"/"+url+"/");

		if(parseInt(index)==$scope.breadcrumbs.length){
			index++;
			$http({
				method:"post",
				url:"/back-stage/action/floder/select.php",
				data:$.param({"url":"/"+$scope.breadcrumbs.join("/")+"/"+url+"/","tree":index})
			}).then(function success(response){
				$scope.floder_dir =response.data;
			})
			$http({
				method:"post",
				url:"/back-stage/action/file/select.php",
				data:$.param({"url":"/"+$scope.breadcrumbs.join("/")+"/"+url+"/","tree":index})
			}).then(function success(response){
				$scope.floder_file =response.data;

			})
			$scope.breadcrumbs[index-1]=url;

		}else{
			$scope.breadcrumbs=$scope.breadcrumbs.slice(0,index);
			$scope.open_project_floder(index,url);
		}


		$scope.control_row_is_show(2);


	}

	// 显示文件内容
	$scope.open_project_file=function(url){
		console.log(url);
		// 判断文件类型
		var type = url.slice(url.lastIndexOf(".")+1).toLowerCase();
		console.log(type);
		ace.require("ace/ext/language_tools");

		var editor = ace.edit("editor");
		editor.setTheme("ace/theme/chrome");

		switch(type){
			case "html":case "htm":{
				editor.session.setMode("ace/mode/html");
				break;
			};
			case "js":{
				editor.session.setMode("ace/mode/javascript");
				break;
			};
			case "css":{
				editor.session.setMode("ace/mode/css");
				break;
			};
			case "json":{
				editor.session.setMode("ace/mode/json");
				break;
			};
			case "md":{
				editor.session.setMode("ace/mode/markdown");
				break;
			};
			default:{
				console.log("switch");
				break;
			};

		}

		$.ajax({
			type:"post",
			url:"/back-stage/action/file/read.php",
			data:{"url":"/"+$scope.breadcrumbs.join("/")+"/"+url},
			dataType:"text",
			success:function(data){
				document.getElementById("editor").env.editor.setValue(data, 1);
			}
		})

	}




})