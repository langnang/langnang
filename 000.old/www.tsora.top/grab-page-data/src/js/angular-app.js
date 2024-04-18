"use strict";

define('htmlApp', ['angular'], function(angular) {
	"use strict";

    // 定义 angular 模块
    var htmlApp = angular.module('htmlApp', []);

    htmlApp.controller("htmlCtrl",["$scope",function($scope){
    	// $("body").prepend("<ng-include src=&#39;/grab-page-data/template/navbar.html&#39; class='ng-scope'></ng-include>");
    	$scope.greeting = 'Hello, world!';
    	// console.log(123);

    }]);
    
    angular.bootstrap(document, ["htmlApp"]);

    return htmlApp;
});