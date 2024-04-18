# 更新日志

## `0.0.2` 实现步骤
- 基于angular：
  - 以html标签为根module，获取config.json为配置信息$scope.cfg
  - 引入模板导航栏navbar页面，设置基本$scope.cfg
  - 调用api中函数读取wiews文件中文件夹名，并做出相应转换填入$scope.cfg中
  - 根据地址栏连接获取文件位置，读取note文件列表
  - 引入showdown插件，将markdown代码转换为html代码
