const path = require('path')
const files = require.context('./', true, /\.vue$/)
const components = files.keys().reduce((total, key) => {
  if (path.basename(key, '.vue') !== 'index') return total
  // 组件名
  const name = path.dirname(key).substring(2)
  if (!name) return total
  // 导入组件
  const VueComponent = require(`./${name}/index.vue`)['default']
  VueComponent.install = function (Vue) {
    Vue.component(name, VueComponent);
  };
  total.push(VueComponent)
  return total
}, [])
// 定义 install 方法
const install = function (Vue) {
  if (install.installed) return;
  install.installed = true;
  // 遍历并注册全局组件
  components.map((component) => {
    Vue.component(component.name, component);
  });
};

if (typeof window !== "undefined" && window.Vue) {
  install(window.Vue);
}

export default {
  // 导出的对象必须具备一个 install 方法
  install,
  // 组件列表
  ...components,
}
