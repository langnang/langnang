"use strict";

require.config({
    baseUrl: "/back-stage/vendor/",// 所有模块的查找根路径
    paths: {// path映射那些不直接放置于baseUrl下的模块名
        "ace":"ace/ace",
        "angular":"angular/angular.min",
        "bootstrap":"bootstrap/js/bootstrap.min",
        "jquery":"jquery/jquery.min",
        "jquery-easyui":"jquery-easyui/jquery.easyui.min",
        "jquery-treeview":"jquery-treeview/jquery.treeview"

    },
    shim: {// 为那些没有使用define()来声明依赖关系、设置模块的"浏览器全局变量注入"型脚本做依赖和导出配置。
    "angular":{
        exports:"angular"
    },
    "bootstrap":{
            // 指定要加载的一个依赖数组。
            deps:[
            "css!/back-stage/vendor/bootstrap/css/bootstrap.min.css",
            "css!/back-stage/vendor/bootstrap/css/bootstrap-theme.min.css",
            "css!/back-stage/vendor/font-awesome/css/font-awesome.min.css",
            "css!/back-stage/src/css/bootstrap-cus.css",
            "jquery"
            ],
            exports:"bootstrap"
        },
        "jquery":{
            exports:"$"
        },
        "jquery-easyui":{
            deps:[
            "css!/back-stage/vendor/jquery-easyui/themes/default/easyui.css",
            "css!/back-stage/vendor/jquery-easyui/themes/icon.css",
            "css!/back-stage/vendor/jquery-easyui/demo/demo.css",
            "jquery"
            ],
            exports:"treeview"
        },
        "jquery-treeview":{
            deps:[
            "css!/back-stage/vendor/jquery-treeview/jquery.treeview.css",
            "jquery"
            ],
            exports:"treeview"
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
            "css":"require-css/require-css.min"
        }
    },
})

define("initialize",function(require){
    require("layout");
    // console.log(this);
})


define("layout",function(require){
    require("bootstrap");

})



function callAPI(config){
    // console.log(config);
    var result;
    $.ajax({
        url:config.url,
        async:false,
        type:"post",
        data:config.data,
        success:function(data){
            // console.log(data);
            result=data;
        },
        error:function(data){
            console.log(data);
        }
    })
    // console.log(result);
    return result;

}

function openAllFolders(baseUrl){
    var files;
    files=$.parseJSON(callAPI({
        url:"/back-stage/action/api/openFolder.php",
        data:{url:baseUrl}
    }));
    files.forEach(function(value,index){
        if(value.filetype=="dir"){
            // console.log(value.filename);
            files[index].files=openAllFolders(baseUrl+value.filename+"/");
        }
    // console.log(value);
    })
    // console.log(files);
    return files;
}
function openFolder(baseUrl){
    var files;
    files=$.parseJSON(callAPI({
        url:"/back-stage/action/api/openFolder.php",
        data:{url:baseUrl}
    }));
    return files;
}

// function callAPI(project,act,data){
//     var ajaxType,ajaxUrl,ajaxData,ajaxResult;
//     switch(project){
//         case "res":{
//             ajaxUrl="/resources/action/api/res/default.php";
//             switch(act){

//                 case "getfileinfo":{
//                     ajaxData={code:`echo selectFileInfo($link,"`+data+`");`};
//                     break;
//                 };
//                 case "getallfileurl":{
//                     ajaxData={code:`echo selectAllFileUrl($link);`};
//                     break;
//                 };
//                 case "insertfileinfo":{
//                     ajaxData={code:`echo insertFileData($link,'`+data+`');`};
//                     break;
//                 };
//                 case "updatefileinfo":{
//                     ajaxData={code:`echo updateFileData($link,'`+data+`');`};
//                     break;
//                 };
//                 default:break;
//             }
//             break;

//         };
//         case "fie":{
//             ajaxUrl="/resources/action/api/eval.php";
//             switch(act){
//                 case "openfolder":{
//                     ajaxData={code:`echo openFolder($_SERVER['DOCUMENT_ROOT']."`+data+`");`};
//                     break;
//                 };
//                 case "openfile":{
//                     ajaxData={code:`echo openFile($_SERVER['DOCUMENT_ROOT']."`+data+`");`};
//                     break;
//                 };
//                 case "readfilecontent":{
//                     ajaxData={code:`echo readFileContent($_SERVER['DOCUMENT_ROOT']."`+data+`");`};
//                     break;
//                 };
//                 default:break;
//             }
//             break;
//         };
//         case "gpd":{
//             break;
//         };
//         case "bkg":{
//             break;
//         };
//         case "tol":{
//             break;
//         };
//         default:break;
//     }
//     // console.log(ajaxData);
//     $.ajax({
//         type:"post",
//         async:false,
//         url:ajaxUrl,
//         data:ajaxData,
//         success:function(data){
//             // console.log(data);
//             ajaxResult=data;
//         }
//     })
//     return ajaxResult;
// }


/*"use strict";

define('htmlApp',function(require) {
    require("bootstrap");
    require("angular");
    var config=require("data/report");
    console.log(config);
    if(config.showReport==true){
        $("body").prepend("<ng-include src=&#39;/resource/template/html/report.angular&#39; class='ng-scope'></ng-include>");
    }
    // $("body").prepend("<ng-include src=&#39;/back-stage-management/template/navbar.html&#39; class='ng-scope'></ng-include>");
    // 定义 angular 模块
    var htmlApp = angular.module('htmlApp', []);

    // $http的post传递的header
    htmlApp.config(function($httpProvider){
        $httpProvider.defaults.headers.post = { 'Content-Type': 'application/x-www-form-urlencoded' }
    })

    var htmlCtrl=htmlApp.controller("htmlCtrl",function($scope){
       $scope.title="Bake Stage Management";
   });


    var bodyCtrl=htmlApp.controller("bodyCtrl",function($scope,$http){
        $scope.title="Grab Page Data";
        if(config.showReport==true){
            $scope.report=config.report;
            console.log($scope.report);
        }

    });

    angular.bootstrap(document, ["htmlApp"]);

    return htmlApp;
});
*/