
# API 参考 | Vue.js

> Vue.js - 渐进式的 JavaScript 框架

---

## 全局 API

### 应用实例

```
createApp()
createSSRApp()
app.mount()
app.unmount()
app.provide()
app.component()
app.directive()
app.use()
app.mixin()
app.version
app.config
app.config.errorHandler
app.config.warnHandler
app.config.performance
app.config.compilerOptions
app.config.globalProperties
app.config.optionMergeStrategies
```

### 通用

```
version
nextTick()
defineComponent()
defineAsyncComponent()
defineCustomElement()
```

## 组合式 API

### setup()

```
基本使用
访问 Props
Setup 上下文
与渲染函数一起使用
```

### 响应式: 核心

```
ref()
computed()
reactive()
readonly()
watchEffect()
watchPostEffect()
watchSyncEffect()
watch()
```

### 响应式: 工具

```
isRef()
unref()
toRef()
toRefs()
isProxy()
isReactive()
isReadonly()
```

### 响应式: 进阶

```
shallowRef()
triggerRef()
customRef()
shallowReactive()
shallowReadonly()
toRaw()
markRaw()
effectScope()
getCurrentScope()
onScopeDispose()
```

### 生命周期钩子

```
onMounted()
onUpdated()
onUnmounted()
onBeforeMount()
onBeforeUpdate()
onBeforeUnmount()
onErrorCaptured()
onRenderTracked()
onRenderTriggered()
onActivated()
onDeactivated()
onServerPrefetch()
```

### 依赖注入

```
provide()
inject()
```

## 选项式 API

### 状态选项

```
data
props
computed
methods
watch
emits
expose
```

### 渲染选项

```
template
render
compilerOptions
```

### 生命周期选项

```
beforeCreate
created
beforeMount
mounted
beforeUpdate
updated
beforeUnmount
unmounted
errorCaptured
renderTracked
renderTriggered
activated
deactivated
serverPrefetch
```

### 组合选项

```
provide
inject
mixins
extends
```

### 其他杂项

```
name
inheritAttrs
components
directives
```

### 组件实例

```
$data
$props
$el
$options
$parent
$root
$slots
$refs
$attrs
$watch()
$emit()
$forceUpdate()
$nextTick()
```

## 内置内容

### 指令

```
v-text
v-html
v-show
v-if
v-else
v-else-if
v-for
v-on
v-bind
v-model
v-slot
v-pre
v-once
v-memo
v-cloak
```

### 组件

```
<Transition>
<TransitionGroup>
<KeepAlive>
<Teleport>
<Suspense>
```

### 特殊元素

```
<component>
<slot>
<template>
```

### 特殊 Attributes

```
key
ref
is
```

## 单文件组件

### 语法定义

```
总览
相应语言块
自动名称推导
预处理器
src 导入
注释
```

### `<script setup>`

```
基本语法
响应式
使用组件
使用自定义指令
defineProps() 和 defineEmits()
defineExpose()
useSlots() 和 useAttrs()
与普通的 <script> 一起使用
顶层 await
针对 TypeScript 的功能
限制
```

### CSS 功能

```
组件作用域 CSS
CSS Modules
CSS 中的 v-bind()
```

## 进阶 API

### 渲染函数

```
h()
mergeProps()
cloneVNode()
isVNode()
resolveComponent()
resolveDirective()
withDirectives()
withModifiers()
```

### 服务端渲染

```
renderToString()
renderToNodeStream()
pipeToNodeWritable()
renderToWebStream()
pipeToWebWritable()
renderToSimpleStream()
useSSRContext()
```

### TypeScript 工具类型

```
PropType<T>
ComponentCustomProperties
ComponentCustomOptions
ComponentCustomProps
CSSProperties
```

### 自定义渲染

```
createRenderer()
```
