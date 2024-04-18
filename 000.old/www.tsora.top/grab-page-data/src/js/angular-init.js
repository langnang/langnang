/*













*/

var tsora=angular.module("tsora",[]);

// $http的post传递的header
tsora.config(function($httpProvider){
	$httpProvider.defaults.headers.post = { 'Content-Type': 'application/x-www-form-urlencoded' }
})

// htmlCtrl
tsora.controller("htmlCtrl",function($http,$scope,$interval,$timeout){

	// 获取config.json内容
	$http({
		method:"get",
		async:false,
		url:"/grab-page-data/config.json"
	}).then(function success(response){
		$scope.cfg=response.data;

		// 获取数据后自动测试数据库链接
		// $scope.testMysqlCon();
	})

	// 更新config.json内容
	$scope.UpdateCfg=function(){
		// console.log(new Date().toLocaleDateString());
		$scope.cfg.update=new Date().toLocaleDateString();
		// console.log($scope.cfg);
		$http({
			method:"post",
			url:$scope.cfg.basePath+"/action/filesystem/put-contents.php",
			data:$.param({"url":$scope.cfg.basePath+"/config.json","data":$scope.cfg})
		}).then(function success(response){
			// console.log(response.data);
			// if(response.data!=="-1"){
				// $scope.testMysqlCon();
			// }

		})
	}

	// 测试数据库链接
	$scope.testMysqlCon=function(){
		$scope.cfg.mySQL.state="Loading";
		$http({
			method:"get",
			url:$scope.cfg.basePath+"/action/mysqli/connect.php"
		}).then(function success(response){
			if(response.data!==""){
				$scope.cfg.mySQL.state="Failed";
			}else{
				$scope.cfg.mySQL.state="Success";
			}
		})
	}


	// 获取表中所有列名
	$scope.select_all_column_name=function(tbname){
		$http({
			method:"post",
			url:"/grab-page-data/action/mysqli/select-all-column-name.php",
			data:$.param({"tbname":tbname})
		}).then(function success(response){
			// console.log(response.data);
			$scope.table.thead=response.data;

		})
	}

	// 获取表中数据量
	$scope.select_all_data_count=function(tbname){
		$http({
			method:"post",
			url:"/grab-page-data/action/mysqli/select-all-data-count.php",
			data:$.param({"tbname":tbname})
		}).then(function success(response){
			// console.log(response.data);
			$scope.table.num=response.data;
			$scope.table.page=Math.ceil(response.data/50);
			$scope.table.from=1;
			$scope.table.to=50;
		})
	}

	// 获取指定限制的数据
	$scope.select_limit_data=function(num,tbname){
		// alert(num);
		// console.log(num);
		$scope.table.from=1 + 50 * (num - 1);
		if(num==$scope.table.page){
			$scope.table.to=$scope.table.num;
		}else{
			$scope.table.to=50 + 50 * (num - 1);

		}
		$http({
			method:"post",
			url:"/grab-page-data/action/mysqli/select-limit-data.php",
			data:$.param({"tbname":tbname,"row":$scope.table.from - 1})
		}).then(function success(response){
			// console.log(response.data);
			$scope.table.tbody=response.data;
		})
	}

	// 获取表中所有数据
	$scope.select_all_data=function(tbname){
		$http({
			method:"post",
			url:"/grab-page-data/action/mysqli/select-all-column-name.php",
			data:$.param({"tbname":tbname})
		}).then(function success(response){
			// console.log(response.data);
			$scope.table.thead=response.data;

		})
	}

	// 执行抓取数据步骤
	$scope.update=function(index){
		// console.log(index);
		// console.log($scope.grab.step.length);

		if(index!==undefined&&index<=$scope.grab.step.length-1&&index<3){

			if(index>0){
				console.log($scope.grab.step[index-1].result);
				if($scope.grab.step[index-1].result!=="Success"){
					return 0;
				}
			}
			$scope.grab.step[index].result="Loading";

			$scope.$watch("grab.step["+index+"].result",function(newvalue,oldvalue){
				console.log(newvalue);
				if(newvalue=="Success"){
					$interval.cancel(scroll_interval);
					index++;
					$scope.update(index);

				}
			})
			// $scope.$watch("grab.step[0].result",function(newvalue,oldvalue){
				// console.log(newvalue);
				// if(newvalue=="Success"){
				// 	$timeout(function(){
				// 		index++;
				// 		$scope.update(index);
				// 	},3000);
				// }
			// })

			switch ($scope.grab.step[index].type){
				case "scroll":{
					$scope.grab.step[index].min = -10;
					$scope.grab.step[index].max = 10;

					var scroll_interval=$interval(function(){
						$scope.grab.step[index].min=$scope.grab.step[index].min + 0.1;
						if($scope.grab.step[index].min>=100){
							$scope.grab.step[index].min=-10;
						}
					},25)

					$scope.grab_page_data($scope.grab.step[index].id,$scope.grab.tbname,"/grab-page-data/action/filesystem/grab-bootcdn.php");

					// $interval.cancel(scroll_interval);

					break;
				};
				case "progress":{
					// console.log($scope.grab.step[index].type);
					$scope.grab_page_data($scope.grab.step[index].id,$scope.grab.tbname,"/grab-page-data/action/filesystem/grab-bootcdn.php");
					break;
				};
				default:{
					$scope.grab.step[index].result="Failed";
					break;
				}

			}




		}
		return 0;
	}

	$scope.grab_page_data=function(step,tbname,url){

		// 由于AngularJS的$http请求默认为异步，不方便调整为同步进行。因此选用jquery的ajax
		// 可以使用angular的$watch属性来监听变量，来消除$http的异步问题

		$http({
			method:"post",
			url:url,
			data:$.param({"step":step,"tbname":tbname})
		}).then(function success(response){
			$timeout(function(){
				if(response.data==true){
					$scope.grab.step[step].result="Success";
				}else{
					$scope.grab.step[step].result="Failed";
				}
			},3000);
		})
		// $.ajax({
		// 	method:"post",
		// 	async:true,
		// 	url:url,
		// 	data:{"step":step,"tbname":tbname},
		// 	success:function(data){
		// 		console.log(data);
		// 		$timeout(function(){

		// 			if(data==true){
		// 			// console.log("Success");

		// 			$scope.grab.step[step].result="Success";

		// 		}else{
		// 			// console.log("Failed");
		// 			$scope.grab.step[step].result="Failed";
		// 		}
		// 	},3000);

		// 	}
		// })

	}



	// console.log($('html[ng-controller="htmlCtrl"]').scope().grab);
		// $('html[ng-controller="htmlCtrl"]').scope().grab.step[0].min = -10;
		// $('html[ng-controller="htmlCtrl"]').scope().grab.step[0].max = 10;


	// console.log($scope);
	// $interval(function(){
		// $('html[ng-controller="htmlCtrl"]').scope().grab.step[0].min = $('html[ng-controller="htmlCtrl"]').scope().grab.step[0].min + 0.1;
	// 	$('html[ng-controller="htmlCtrl"]').scope().grab.step[1].max =  $('html[ng-controller="htmlCtrl"]').scope().grab.step[1].max + 0.1;

		// if($('html[ng-controller="htmlCtrl"]').scope().grab.step[0].min>=100){
			// $('html[ng-controller="htmlCtrl"]').scope().grab.step[0].min=-10;
		// }
	// 	if($('html[ng-controller="htmlCtrl"]').scope().grab.step[1].max>=100){
	// 		$('html[ng-controller="htmlCtrl"]').scope().grab.step[1].max=-10;
	// 	}
	// },50)


})