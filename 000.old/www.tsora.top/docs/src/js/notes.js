var bodyCtrl=htmlApp.controller("bodyCtrl",function($scope,$http,$sce){
	$scope.title=location.href.substring(location.href.indexOf("/docs-management/views/")+23).substring(0,location.href.substring(location.href.indexOf("/docs-management/views/")+23).indexOf("/"));



	$http({
		method:"post",
		url:"/resource/action/api/files/opendir.php",
		data:$.param({
			"dir":"/docs-management/views/"+$scope.title+"/docs/"
		})
	}).then(function success(response){
		// console.log(response.data);
		$scope.docs=response.data;
		// $scope.notes=response.data;

		// console.log(response.data);
	})




	$http({
		method:"post",
		url:"/resource/action/api/files/opendir.php",
		data:$.param({
			"dir":"/docs-management/views/"+$scope.title+"/views/"
		})
	}).then(function success(response){
		$scope.notes=response.data;

		// console.log(response.data);
	})

	$http({
		method:"get",
		url:"/docs-management/views/"+$scope.title+"/data/expand.json"
	}).then(function success(response){
		// console.log(response.data);
		$scope.expands=response.data;
	})





	$scope.readfile=function(filename){
		$scope.note={};
		$scope.note.name=filename;
		// console.log(filename);
		$http({
			method:"get",
			url:"/docs-management/views/"+$scope.title+"/views/"+filename
		}).then(function success(response){
			// console.log(response.data);
			$scope.note.markdown = response.data;

			$scope.note.content = $sce.trustAsHtml(new showdown.Converter().makeHtml(response.data));


			ace.require("ace/ext/language_tools");

			var editor = ace.edit("editor");
			editor.setTheme("ace/theme/chrome");
			editor.session.setMode("ace/mode/markdown");
			document.getElementById("editor").env.editor.setValue($scope.note.markdown, 1);
			// console.log($scope.readme);
		})


	}

	$scope.writefile=function(){
		// console.log(document.getElementById("editor").env.editor.getValue());

		$http({
			method:"post",
			url:"/resource/action/api/files/writefile.php",
			data:$.param({
				"file":"/docs-management/views/"+$scope.title+"/views/"+$scope.note.name,
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
			data:$.param({"file":"/docs-management/views/"+$scope.title+"/views/"+$("#createModal input").val()})
		}).then(function success(response){
			// console.log(response.data);
			alert(response.data);
			location.reload();
		})
	}

	$scope.addExpand=function(){
		// console.log($scope.expands);
		$scope.expands.push({'name':'','href':''});
	}
	$scope.writeExpand=function(){
		// console.log("/docs-management/views/"+$scope.title+"/data/expand.json");
		$http({
			method:"post",
			url:"/resource/action/api/files/writefile.php",
			data:$.param({
				"file":"/docs-management/views/"+$scope.title+"/data/expand.json",
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


