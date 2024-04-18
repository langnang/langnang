// 导入组件，组件必须声明 name
import RouteMenuItem from "./main";

// 为组件提供 install 安装方法，供按需引入
RouteMenuItem.install = function (Vue) {
  Vue.component(RouteMenuItem.name, RouteMenuItem);
};

// 默认导出组件
export default RouteMenuItem;

