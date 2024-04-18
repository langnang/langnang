"use strict";

require(["ini-default","angular","showdown","ace","lodash","css!/docs/src/css/style.css"],function(ini,angular,showdown,ace,_){
	var htmlApp=angular.module("htmlApp",[]);
	var navbar={
		"brand":{
			"href":"/docs/index.html",
			"content":"TSORA"
		},
		"leftNav":[]
	}

	htmlApp.config(function($httpProvider){
		$httpProvider.defaults.headers.post = { 'Content-Type': 'application/x-www-form-urlencoded' }
	})

	htmlApp.filter("markdownConvertHtml",function(){
		return function(markdown){
			return new showdown.Converter().makeHtml(markdown);
		}
	})

	var htmlCtrl=htmlApp.controller("htmlCtrl",function($scope,$http,$sce){
		$http({
			method:"get",
			url:"/docs/config.json"
		}).then(function success(response){
			$scope.cfg=response.data;
			$scope.cfg.navbar=navbar;
		});
		$http({
			method:"post",
			url:"/resources/action/api/eval.php",
			data:$.param({
				"code":`
				$directory=$_POST["directory"];
				$d = scandir($_SERVER['DOCUMENT_ROOT'].$directory);
				array_shift($d);
				array_shift($d);
				echo json_encode($d);
				`,
				"directory":"/docs/views/"
			})
		}).then(function success(response){
			$scope.cfg.navbar.leftNav=response.data;
		})

		$scope.markdownConvertHtml=function(markdown){
			// console.log(markdown);
			return $sce.trustAsHtml(new showdown.Converter().makeHtml(markdown));
		}
	})

	var bodyCtrl=htmlApp.controller("bodyCtrl",function($scope,$http,$sce){
		$scope.title=location.href.substring(location.href.indexOf("/docs/views/")+12).substring(0,location.href.substring(location.href.indexOf("/docs/views/")+12).indexOf("/"));
		$scope.docs=$.parseJSON(callAPI("fie","openfolder","/docs/views/"+$scope.title+"/docs/"));
		$scope.notes=$.parseJSON(callAPI("fie","openfolder","/docs/views/"+$scope.title+"/views/"));
		// console.log($scope.notes);
		_.forEach($scope.notes, function(value,key) {
			// console.log(value);
			$scope.notes[key].content=$.ajax({type:"get",async:false,url:"/docs/views/"+$scope.title+"/views/"+value.filename}).responseText;
			// $http({
			// 	method:"get",
			// 	async:false,
			// 	url:"/docs/views/"+$scope.title+"/views/"+value.filename,
			// }).then(function success(response){
			// 	console.log(response.data);
			// })
			// console.log(key);
		});

		$http({
			method:"get",
			url:"/docs/views/"+$scope.title+"/data/expand.json"
		}).then(function success(response){
			$scope.expands=response.data;
		})





		$scope.readfile=function(filename){
			$scope.note={};
			$scope.note.name=filename;
			$http({
				method:"get",
				url:"/docs/views/"+$scope.title+"/views/"+filename
			}).then(function success(response){
				$scope.note.markdown = response.data;

				$scope.note.content = $sce.trustAsHtml(new showdown.Converter().makeHtml(response.data));


				ace.require("ace/ext/language_tools");

				var editor = ace.edit("editor");
				editor.setTheme("ace/theme/chrome");
				editor.session.setMode("ace/mode/markdown");
				document.getElementById("editor").env.editor.setValue($scope.note.markdown, 1);
			})


		}

		$scope.writefile=function(){

			$http({
				method:"post",
				url:"/resource/action/api/files/writefile.php",
				data:$.param({
					"file":"/docs/views/"+$scope.title+"/views/"+$scope.note.name,
					"content":document.getElementById("editor").env.editor.getValue()
				})
			}).then(function success(response){
				if(response.data="更新成功"){
					alert("Success");
					$('#editModal').modal('hide');
				}else{
					alert("Failed");
				}
			})
		}

		$scope.createfile=function(){
			$http({
				method:"post",
				url:"/resource/action/api/files/createfile.php",
				data:$.param({"file":"/docs/views/"+$scope.title+"/views/"+$("#createModal input").val()})
			}).then(function success(response){
			// console.log(response.data);
			alert(response.data);
			location.reload();
		})
		}

		$scope.addExpand=function(){
			$scope.expands.push({'name':'','href':''});
		}
		$scope.writeExpand=function(){
		// console.log("/docs/views/"+$scope.title+"/data/expand.json");
		$http({
			method:"post",
			url:"/resources/action/api/files/writefile.php",
			data:$.param({
				"file":"/docs/views/"+$scope.title+"/data/expand.json",
				"content":JSON.stringify($scope.expands)
			})
		}).then(function success(response){
			if(response.data="更新成功"){
				alert("Success");
				$('#expandModal').modal('hide');
			}else{
				alert("Failed");
			}
		})
	}
})
	angular.bootstrap(document, ["htmlApp"]);


})
