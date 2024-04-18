"use strict";

// define('htmlApp', ["bootstrap","angular"], function() {
// 	$("button[for='grabPageData']").click(function(){
//         if(confirm("确定要重新抓取数据么，这将会耗费大量时间？")){
//             // alert(1);
//             $("[role='grabPageData']").show();

//         }else{
//             // alert(2);
//             $("[role='grabPageData']").hide();

//         }
//     })
//     // 定义 angular 模块
//     var htmlApp = angular.module('htmlApp', []);

//     // $http的post传递的header
//     htmlApp.config(function($httpProvider){
//         $httpProvider.defaults.headers.post = { 'Content-Type': 'application/x-www-form-urlencoded' }
//     })

//     // 过滤器：向上取整
//     htmlApp.filter("ceil", function () {
//         return function(number){
//             return Math.ceil(number);
//         }
//     });

//     var htmlCtrl=htmlApp.controller("htmlCtrl",function($scope){
//        $scope.title="Grab Page Data";
//    });


//     var bodyCtrl=htmlApp.controller("bodyCtrl",function($scope,$http){
//         $scope.title="Grab Page Data";
//         $scope.tbname="";
//         $scope.table={
//             thead:[]
//         };
//         // 获取表中所有列名
//         $scope.select_all_column_name=function(){
//             $http({
//                 method:"post",
//                 url:"/resources/action/api/eval.php",
//                 data:$.param({
//                     "code":`
//                     include_once $_SERVER['DOCUMENT_ROOT']."/resource/action/api/grab-data/default.php";
//                     $tbname=$_POST["tbname"];
//                     // echo $tbname;
//                     echo json_encode(select_all_colname($link,$tbname));
//                     `,
//                     "tbname":$scope.tbname
//                 })
//             }).then(function success(response){
//                 // console.log(response.data);
//                 $scope.table.thead=response.data;

//             })
//         }

//         // 获取表中数据量
//         $scope.select_all_data_count=function(){
//             $http({
//                 method:"post",
//                 url:"/resources/action/api/eval.php",
//                 data:$.param({
//                     "code":`
//                     include_once $_SERVER['DOCUMENT_ROOT']."/resource/action/api/grab-data/default.php";
//                     $tbname=$_POST["tbname"];
//                     // echo $tbname;
//                     echo count_all_data($link,$tbname);
//                     `,
//                     "tbname":$scope.tbname
//                 })
//             }).then(function success(response){
//                 // console.log(response.data);
//                 $scope.table.num=response.data;
//                 $scope.table.page=Math.ceil(response.data/50);
//                 $scope.table.from=1;
//                 $scope.table.to=50;
//             })
//         }

//         // 获取指定限制的数据
//         $scope.select_limit_data=function(num){
//             // alert(num);
//             // console.log(num);
//             $scope.table.from=1 + 50 * (num - 1);
//             if(num==$scope.table.page){
//                 $scope.table.to=$scope.table.num;
//             }else{
//                 $scope.table.to=50 + 50 * (num - 1);

//             }
//             $http({
//                 method:"post",
//                 url:"/resources/action/api/eval.php",
//                 data:$.param({
//                     "code":`
//                     include_once $_SERVER['DOCUMENT_ROOT']."/resource/action/api/grab-data/default.php";
//                     $tbname=$_POST["tbname"];
//                     $row=$_POST["row"];
//                     $limit=$_POST["limit"];
//                     // echo $tbname;
//                     echo json_encode(select_limit_data($link,$tbname,$row,$limit));
//                     `,
//                     "tbname":$scope.tbname,
//                     "row":$scope.table.from - 1,
//                     "limit":50
//                 })
//             }).then(function success(response){
//                 // console.log(response.data);
//                 $scope.table.tbody=response.data;
//             })
//         }
        
//     });

//     angular.bootstrap(document, ["htmlApp"]);

//     return htmlApp;
// });

function callAPI(url,data){
    var API_PATH="/resources/action/grab-page/index.php";
    var result;
    if(data==undefined){data='{}'};
    $.ajax({
        type:"post",
        async:false,
        url:API_PATH+url,
        data:{"data":data},
        // dataType:"json",
        success:function(data){
            result=data;
        }
    })
    return result;
}