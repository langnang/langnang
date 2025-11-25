<!--
 * @Descripttion:
 * @version:
 * @Author: Langnang
 * @Date: 2021-05-22 13:48:32
 * @LastEditors: Langnang
 * @LastEditTime: 2021-05-23 10:37:26
-->

# Vue 源码解析

- [`function Vue (options)`：声明 Vue](2.6.12/src/core/instance/index.js)
- `initMixin(Vue)`
  - `initLifecycle(vm)`
  - `initEvents(vm)`
  - `initRender(vm)`
  - `callHook(vm, 'beforeCreate')`
  - `initInjections(vm)`
  - `initState(vm)`
    - `initProps(vm, opts.props)`
    - `initMethods(vm, opts.methods)`
    - `initData(vm)`
      - `proxy(vm, '_data', key)`：代理
      - `observe(data, true);`：监听
  - `initProvide(vm)`
  - `callHook(vm, 'created')`
- `stateMixin(Vue)`
- `eventsMixin(Vue)`：混入事件
  - `Vue.prototype.$on`
  - `Vue.prototype.$once`
  - `Vue.prototype.$off`
  - `Vue.prototype.$emit`
- `lifecycleMixin(Vue)`：混入生命周期
  - `Vue.prototype._update`
  - `Vue.prototype.$forceUpdate`
  - `Vue.prototype.$destroy`
- `renderMixin(Vue)`
  - `Vue.prototype.$nextTick`
  - `Vue.prototype._render`

## 1.原理篇

- [响应式原理](/响应式原理.md)
- 虚拟 DOM 原理
- computed 实现原理
- watch 实现原理
- diff 算法原理

## 其它

- 第一次实例化发生了什么
