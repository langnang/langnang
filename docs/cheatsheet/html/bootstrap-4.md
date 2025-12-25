---
title: Bootstrap v4
layout: cheatsheet
---

## 快速入门（Started）

> 快速入门

## 布局（Layout）

> 布局

## 页面内容（Content）

> 页面内容

### 警告框（Alerts）

通过精炼且灵活的警告消息为典型的用户操作提供契合上下文的反馈。

```sh
.alert
├─.alert-{type}    # primary,secondary,success,danger,warning,info,light,dark
│ ├─.alert-primary
│ ├─.alert-secondary
│ ├─.alert-success
│ ├─.alert-danger
│ ├─.alert-warning
│ ├─.alert-info
│ ├─.alert-light
│ └─.alert-dark
├─.alert-heading      
├─.alert-link      
└─.alert-dismissible      
  └─.close      
```

#### 示例

警告框（alert）组件能够展示任意长度的文本以及一个可选的关闭按钮。为了展示合适的样式，**必须** 从下列 8 个情境类（例如 `.alert-success`）中选择一个合适的并使用。中选择一个合适的并使用。如需内联一个关闭按钮，请使用 [警告框（alert）的 JavaScript 插件](https://v4.bootcss.com/docs/components/alerts/#dismissing)。

```html
<div class="alert alert-primary" role="alert"> 
  A simple primary alert—check it out! 
</div> 
<div class="alert alert-secondary" role="alert"> 
  A simple secondary alert—check it out! 
</div> 
<div class="alert alert-success" role="alert"> 
  A simple success alert—check it out! 
</div> 
<div class="alert alert-danger" role="alert"> 
  A simple danger alert—check it out! 
</div> 
<div class="alert alert-warning" role="alert"> 
  A simple warning alert—check it out! 
</div> 
<div class="alert alert-info" role="alert"> 
  A simple info alert—check it out! 
</div> 
<div class="alert alert-light" role="alert"> 
  A simple light alert—check it out! 
</div> 
<div class="alert alert-dark" role="alert"> 
  A simple dark alert—check it out! 
</div>
```

#### 链接的颜色

通过使用 `.alert-link` 工具类可以为任何警告框（alert）组件添加颜色相匹配的链接。

```html
<div class="alert alert-primary" role="alert"> 
  A simple primary alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like. 
</div> 
<div class="alert alert-secondary" role="alert"> 
  A simple secondary alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like. 
</div> 
<div class="alert alert-success" role="alert"> 
  A simple success alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like. 
</div> 
<div class="alert alert-danger" role="alert"> 
  A simple danger alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like. 
</div> 
<div class="alert alert-warning" role="alert"> 
  A simple warning alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like. 
</div> 
<div class="alert alert-info" role="alert"> 
  A simple info alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like. 
</div> 
<div class="alert alert-light" role="alert"> 
  A simple light alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like. 
</div> 
<div class="alert alert-dark" role="alert"> 
  A simple dark alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like. 
</div>
```

#### 添加其它内容

警告框（alert）组件还可以包含其它 HTML 元素，例如标题、段落、分割线等。

```html
<div class="alert alert-success" role="alert"> 
  <h4 class="alert-heading">Well done!</h4> 
  <p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p> 
  <hr> 
  <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p> 
</div>
```

#### 关闭警告框

通过使用警告框（alert）组件的 JavaScript 插件，可以为任何警告框（alert）组件添加内联的关闭按钮。步骤如下：

- 确保已加载了警告框（alert）组件的 JavaScript 插件，或者是 Bootstrap 的预编译 JavaScript 文件。
- 如果你是自行编译的 JavaScript 源码，那么需要依赖 `util.js` 文件。预编译版本已经包含了该文件。
- 添加关闭按钮和 `.alert-dismissible` 类，这将在警告框（alert）组件的右侧增加额外的空间并放置关闭按钮（ `.close`）。
- 在关闭按钮上添加 `data-dismiss="alert"` 属性，该属性会触发 JavaScript 代码。请务必使用 `<button>` 元素，以确保在所有设备上都具有正确的行为。
- 如需在关闭警告框（alert）时展示动画效果，请确保添加 `.fade` 和 `.show`。

以下是演示效果：

```html
<div class="alert alert-warning alert-dismissible fade show" role="alert"> 
  <strong>Holy guacamole!</strong> 
  You should check in on some of those fields below. 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
    <span aria-hidden="true">&times;</span> 
  </button> 
</div>
```

#### 通过 JavaScript 触发行为

##### 触发器

通过 JavaScript 代码关闭警告框（alert）：

或者在 **警告框（alert）组件内** 添加一个按钮，并为按钮设置相应的 `data` 属性，如下所示：

```html
<button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
  <span aria-hidden="true">&times;</span> 
</button>
```

请注意，关闭的警告框（alert）将被从 DOM 中删除。

##### 本组件所暴露的方法

| 方法 | 描述 |
| --- | --- |
| `$().alert()` | 让警告框（alert）能够监听具有 `data-dismiss="alert"` 属性的子元素上的点击事件。（如果使用的是 data 属性 API 来自动初始化组件的话，则不需要调用此函数。） |
| `$().alert('close')` | 关闭警告框（alert）并将其从 DOM 中删除。如果该元素被设置了 `.fade` 和 `.show` 类的话，则警告框（alert）将在被删除之前展示逐渐消散（fade out）的效果。 |
| `$().alert('dispose')` | 销毁某个元素的警告框（alert） |

```js
$('.alert').alert('close')
```

##### 本组件所暴露的事件

Bootstrap 的警告框（alert）插件暴露了一些可以监听的事件。

| 事件 | 描述 |
| --- | --- |
| `close.bs.alert` | 当 `close` 实例方法被调用时，该事件被立即触发。 |
| `closed.bs.alert` | 当警告框（alert）已关闭时（并将等待 CSS transitions 执行完），该事件将被触发。 |

```js
$('#myAlert').on('closed.bs.alert', function () { 
  // do something... 
})
```

### 徽章（Badge）

徽章（badge）组件相关的文档和示例。徽章（badge）是一种小型的用于计数和打标签的组件。

#### 示例

徽章（badge）组件通过使用相对字体大小和 `em` 单位来实现缩放以匹配其直接父元素的大小。

```html
<h1>Example heading <span class="badge badge-secondary">New</span></h1> 
<h2>Example heading <span class="badge badge-secondary">New</span></h2> 
<h3>Example heading <span class="badge badge-secondary">New</span></h3> 
<h4>Example heading <span class="badge badge-secondary">New</span></h4> 
<h5>Example heading <span class="badge badge-secondary">New</span></h5> 
<h6>Example heading <span class="badge badge-secondary">New</span></h6>
```

徽章（badge）组件可以作为链接或按钮的一个组成部分，以提供计数功能。

```html
<button type="button" class="btn btn-primary"> Notifications <span class="badge badge-light">4</span> </button>
```

请注意，根据使用方式的不同，徽章（badge）组件可能会给使用屏幕阅读器及类似辅助技术的用户带来困惑。虽然徽章（badge）组件通过样式传达了有关其用途的视觉提示，但视觉受限的用户则只能获取到徽章（badge）组件内所包含的文本内容。根据具体使用情况（例如放在句子、链接或按钮的结尾处），这些徽章（badge）组件可能给人的印象是一串随机的单词或数字。

除非上下文是清晰的（例如，在 “Notifications” 示例中，数字 “4” 被理解为通知的条数），否则请考虑附上一段额外的文本并在视觉上设置为隐藏以提供一个额外的上下文。

```html
<button type="button" class="btn btn-primary"> Profile <span class="badge badge-light">9</span> <span class="sr-only">unread messages</span> </button>
```

#### 根据情境改变外观

添加下面列出的任何一个修饰符类来更改徽章（badge）组件的外观。

Primary Secondary Success Danger Warning Info Light Dark

```html
<span class="badge badge-primary">Primary</span> <span class="badge badge-secondary">Secondary</span> <span class="badge badge-success">Success</span> <span class="badge badge-danger">Danger</span> <span class="badge badge-warning">Warning</span> <span class="badge badge-info">Info</span> <span class="badge badge-light">Light</span> <span class="badge badge-dark">Dark</span>
```

> Conveying meaning to assistive technologies
>
> Using color to add meaning only provides a visual indication, which will not be conveyed to users of assistive technologies – such as screen readers. Ensure that information denoted by the color is either obvious from the content itself (e.g. the visible text), or is included through alternative means, such as additional text hidden with the `.sr-only` class.

#### 胶囊式徽章（Pill badges）

使用 `.badge-pill` 修饰符类能够让徽章（badge）组件的边角变得更圆滑（这是通过设置更大的 `border-radius`， 并在水平方向添加额外的 `padding` 来实现的）。如果你很怀念 Bootstrap v3 中的徽章（badge）组件的话，这就是你的老朋友。

Primary Secondary Success Danger Warning Info Light Dark

```html
<span class="badge badge-pill badge-primary">Primary</span> 
<span class="badge badge-pill badge-secondary">Secondary</span> 
<span class="badge badge-pill badge-success">Success</span> 
<span class="badge badge-pill badge-danger">Danger</span> 
<span class="badge badge-pill badge-warning">Warning</span> 
<span class="badge badge-pill badge-info">Info</span> 
<span class="badge badge-pill badge-light">Light</span> 
<span class="badge badge-pill badge-dark">Dark</span>
```

#### 链接

在 `<a>` 元素上使用具有情境模式的 `.badge-*` 类可以快速为 _可相应动作的_ 徽章（badge）组件赋予鼠标悬停和焦点状态。

```html
<a href="#" class="badge badge-primary">Primary</a> 
<a href="#" class="badge badge-secondary">Secondary</a> 
<a href="#" class="badge badge-success">Success</a> 
<a href="#" class="badge badge-danger">Danger</a> 
<a href="#" class="badge badge-warning">Warning</a> 
<a href="#" class="badge badge-info">Info</a> 
<a href="#" class="badge badge-light">Light</a> 
<a href="#" class="badge badge-dark">Dark</a>
```

### 面包屑导航（Breadcrumb）

### 按钮（Buttons）

### 按钮组（Button group）

### 卡片（Card）

### 轮播（Carousel）

### 折叠（Collapse）

### 下拉菜单（Dropdowns）

### 表单（Forms）

### 输入组（Input group）

### 巨幕（Jumbotron）

### 列表组（List group）

### 媒体对象（Media object）

### 模态框（Modal）

### 导航（Navs）

### 导航条（Navbar）

### 分页（Pagination）

### 弹出框（Popovers）

### 进度条（Progress）

### 滚动监听（Scrollspy）

### 旋转图标（Spinners）

### 轻量弹框（Toasts）

### 工具提示框（Tooltips）

## Components

> 组件

## Utilities

> 工具类
