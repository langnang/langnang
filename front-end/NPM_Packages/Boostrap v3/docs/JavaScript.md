jQuery 插件为 Bootstrap 的组件赋予了“生命”。可以简单地一次性引入所有插件，或者逐个引入到你的页面中。

## [](https://v3.bootcss.com/javascript/#js-individual-compiled)单个还是全部引入

JavaScript 插件可以单个引入（使用 Bootstrap 提供的单个 `*.js` 文件），或者一次性全部引入（使用 `bootstrap.js` 或压缩版的 `bootstrap.min.js`）。

#### 建议使用压缩版的 JavaScript 文件

`bootstrap.js` 和 `bootstrap.min.js` 都包含了所有插件，你在使用时，只需选择一个引入页面就可以了。

#### 插件之间的依赖关系

某些插件和 CSS 组件依赖于其它插件。如果你是单个引入每个插件的，请确保在文档中检查插件之间的依赖关系。注意，所有插件都依赖 jQuery （也就是说，jQuery必须在所有插件**之前**引入页面）。 [`bower.json`](https://github.com/twbs/bootstrap/blob/v3-dev/bower.json) 文件中列出了 Bootstrap 所支持的 jQuery 版本。

## [](https://v3.bootcss.com/javascript/#js-data-attrs)data 属性

你可以仅仅通过 data 属性 API 就能使用所有的 Bootstrap 插件，无需写一行 JavaScript 代码。这是 Bootstrap 中的一等 API，也应该是你的首选方式。

话又说回来，在某些情况下可能需要将此功能关闭。因此，我们还提供了关闭 data 属性 API 的方法，即解除以 `data-api` 为命名空间并绑定在文档上的事件。就像下面这样：

```
$(document).off('.data-api')
```

另外，如果是针对某个特定的插件，只需在 `data-api` 前面添加那个插件的名称作为命名空间，如下：

```
$(document).off('.alert.data-api')
```

#### Only one plugin per element via data attributes

Don't use data attributes from multiple plugins on the same element. For example, a button cannot both have a tooltip and toggle a modal. To accomplish this, use a wrapping element.

## [](https://v3.bootcss.com/javascript/#js-programmatic-api)编程方式的 API

我们为所有 Bootstrap 插件提供了纯 JavaScript 方式的 API。所有公开的 API 都是支持单独或链式调用方式，并且返回其所操作的元素集合（注：和jQuery的调用形式一致）。

```
$('.btn.danger').button('toggle').addClass('fat')
```

所有方法都可以接受一个可选的 option 对象作为参数，或者一个代表特定方法的字符串，或者什么也不提供（在这种情况下，插件将会以默认值初始化）：

```
$('#myModal').modal()                      // 以默认值初始化
$('#myModal').modal({ keyboard: false })   // initialized with no keyboard
$('#myModal').modal('show')                // 初始化后立即调用 show 方法
```

每个插件还通过 `Constructor` 属性暴露了其原始的构造函数：`$.fn.popover.Constructor`。如果你想获取某个插件的实例，可以直接通过页面元素获取：`$('[rel="popover"]').data('popover')`。

#### [](https://v3.bootcss.com/javascript/#%E9%BB%98%E8%AE%A4%E8%AE%BE%E7%BD%AE)默认设置

每个插件都可以通过修改其自身的 `Constructor.DEFAULTS` 对象从而改变插件的默认设置：

```
$.fn.modal.Constructor.DEFAULTS.keyboard = false // 将模态框插件的 `keyboard` 默认选参数置为 false
```

## [](https://v3.bootcss.com/javascript/#js-noconflict)避免命名空间冲突

某些时候可能需要将 Bootstrap 插件与其他 UI 框架共同使用。在这种情况下，命名空间冲突随时可能发生。如果不幸发生了这种情况，你可以通过调用插件的 `.noConflict` 方法恢复其原始值。

```
var bootstrapButton = $.fn.button.noConflict() // return $.fn.button to previously assigned value
$.fn.bootstrapBtn = bootstrapButton            // give $().bootstrapBtn the Bootstrap functionality
```

## [](https://v3.bootcss.com/javascript/#js-events)事件

Bootstrap 为大部分插件所具有的动作提供了自定义事件。一般来说，这些事件都有不定式和过去式两种动词的命名形式，例如，不定式形式的动词（例如 `show`）表示其在事件开始时被触发；而过去式动词（例如 `shown` ）表示在动作执行完毕之后被触发。

从 3.0.0 版本开始，所有 Bootstrap 事件的名称都采用命名空间方式。

所有以不定式形式的动词命名的事件都提供了 `preventDefault` 功能。这就赋予你在动作开始执行前将其停止的能力。

```
$('#myModal').on('show.bs.modal', function (e) {
  if (!data) return e.preventDefault() // 阻止模态框的展示
})
```

## [](https://v3.bootcss.com/javascript/#js-sanitizer)Sanitizer

Tooltips and Popovers use our built-in sanitizer to sanitize options which accept HTML.

The default `whiteList` value is the following:

```
var ARIA_ATTRIBUTE_PATTERN = /^aria-[\w-]*$/i
var DefaultWhitelist = {
  // Global attributes allowed on any supplied element below.
  '*': ['class', 'dir', 'id', 'lang', 'role', ARIA_ATTRIBUTE_PATTERN],
  a: ['target', 'href', 'title', 'rel'],
  area: [],
  b: [],
  br: [],
  col: [],
  code: [],
  div: [],
  em: [],
  hr: [],
  h1: [],
  h2: [],
  h3: [],
  h4: [],
  h5: [],
  h6: [],
  i: [],
  img: ['src', 'alt', 'title', 'width', 'height'],
  li: [],
  ol: [],
  p: [],
  pre: [],
  s: [],
  small: [],
  span: [],
  sub: [],
  sup: [],
  strong: [],
  u: [],
  ul: []
}
```

If you want to add new values to this default `whiteList` you can do the following:

```
var myDefaultWhiteList = $.fn.tooltip.Constructor.DEFAULTS.whiteList

// To allow table elements
myDefaultWhiteList.table = []

// To allow td elements and data-option attributes on td elements
myDefaultWhiteList.td = ['data-option']

// You can push your custom regex to validate your attributes.
// Be careful about your regular expressions being too lax
var myCustomRegex = /^data-my-app-[\w-]+/
myDefaultWhiteList['*'].push(myCustomRegex)
```

If you want to bypass our sanitizer because you prefer to use a dedicated library, for example [DOMPurify](https://www.npmjs.com/package/dompurify), you should do the following:

```
$('#yourTooltip').tooltip({
  sanitizeFn: function (content) {
    return DOMPurify.sanitize(content)
  }
})
```

#### Browsers without `document.implementation.createHTMLDocument`

In case of browsers that don't support `document.implementation.createHTMLDocument`, like Internet Explorer 8, the built-in sanitize function returns the HTML as is.

If you want to perform sanitization in this case, please specify `sanitizeFn` and use an external library like [DOMPurify](https://www.npmjs.com/package/dompurify).

## [](https://v3.bootcss.com/javascript/#js-version-nums)插件的版本号

每个 Bootstrap 的 jQuery 插件的版本号都可以通过插件的构造函数上的 `VERSION` 属性获取到。例如工具提示框（tooltip）插件：

```
$.fn.tooltip.Constructor.VERSION // => "3.4.1"
```

## [](https://v3.bootcss.com/javascript/#js-disabled)未对禁用 JavaScript 的浏览器提供补救措施

Bootstrap 插件未对禁用 JavaScript 的浏览器提供补救措施。如果你对这种情况下的用户体验很关心的话，请添加 [`<noscript>`](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/noscript) 标签向你的用户进行解释（并告诉他们如何启用 JavaScript），或者按照你自己的方式提供补救措施。

#### 第三方工具库

**Bootstrap 官方不提供对第三方 JavaScript 工具库的支持，**例如 Prototype 或 jQuery UI。除了 `.noConflict` 和为事件名称添加命名空间，还可能会有兼容性方面的问题，这就需要你自己来处理了。

## [](https://v3.bootcss.com/javascript/#%E5%85%B3%E4%BA%8E%E8%BF%87%E6%B8%A1%E6%95%88%E6%9E%9C)关于过渡效果

对于简单的过渡效果，只需将 `transition.js` 和其它 JS 文件一起引入即可。如果你使用的是编译（或压缩）版的 `bootstrap.js` 文件，就无需再单独将其引入了。

## [](https://v3.bootcss.com/javascript/#%E5%8C%85%E5%90%AB%E7%9A%84%E5%86%85%E5%AE%B9)包含的内容

Transition.js 是针对 `transitionEnd` 事件的一个基本辅助工具，也是对 CSS 过渡效果的模拟。它被其它插件用来检测当前浏览器对是否支持 CSS 的过渡效果。

## [](https://v3.bootcss.com/javascript/#%E7%A6%81%E7%94%A8%E8%BF%87%E5%BA%A6%E6%95%88%E6%9E%9C)禁用过度效果

通过下面的 JavaScript 代码可以在全局范围禁用过渡效果，并且必须将此代码放在 `transition.js` （或 `bootstrap.js` 或 `bootstrap.min.js`）后面，确保在 js 文件加载完毕后再执行下面的代码：

```
$.support.transition = false
```

模态框经过了优化，更加灵活，以弹出对话框的形式出现，具有最小和最实用的功能集。

#### 不支持同时打开多个模态框

千万不要在一个模态框上重叠另一个模态框。要想同时支持多个模态框，需要自己写额外的代码来实现。

#### 模态框的 HTML 代码放置的位置

务必将模态框的 HTML 代码放在文档的最高层级内（也就是说，尽量作为 body 标签的直接子元素），以避免其他组件影响模态框的展现和/或功能。

#### 对于移动设备的附加说明

在移动设备上使用模态框有一些额外要注意的事项。请参考 [对浏览器的支持](https://v3.bootcss.com/getting-started/#support-fixed-position-keyboards) 章节获取更多信息。

**Due to how HTML5 defines its semantics, the `autofocus` HTML attribute has no effect in Bootstrap modals.** To achieve the same effect, use some custom JavaScript:

```
$('#myModal').on('shown.bs.modal', function () {
  $('#myInput').focus()
})
```

## [](https://v3.bootcss.com/javascript/#modals-examples)实例

### [](https://v3.bootcss.com/javascript/#%E9%9D%99%E6%80%81%E5%AE%9E%E4%BE%8B)静态实例

以下模态框包含了模态框的头、体和一组放置于底部的按钮。

```
<div class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <p>One fine body&hellip;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
```

### [](https://v3.bootcss.com/javascript/#%E5%8A%A8%E6%80%81%E5%AE%9E%E4%BE%8B)动态实例

点击下面的按钮即可通过 JavaScript 启动一个模态框。此模态框将从上到下、逐渐浮现到页面前。

```
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
```

#### 增强模态框的可访问性

务必为 `.modal` 添加 `role="dialog"` 和 `aria-labelledby="..."` 属性，用于指向模态框的标题栏；为 `.modal-dialog` 添加 `aria-hidden="true"` 属性。

另外，你还应该通过 `aria-describedby` 属性为模态框 `.modal` 添加描述性信息。

#### 嵌入 YouTube 视频（天朝无用）

在模态框中嵌入 YouTube 视频需要增加一些额外的 JavaScript 代码，用于自动停止重放等功能，这些代码并没有在 Bootstrap 中提供。请参考这份[发布在 Stack Overflow 上的文章](https://stackoverflow.com/questions/18622508/bootstrap-3-and-youtube-in-modal)。

## [](https://v3.bootcss.com/javascript/#modals-sizes)可选尺寸

模态框提供了两个可选尺寸，通过为 `.modal-dialog` 增加一个样式调整类实现。

```
<!-- Large modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Large modal</button>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      ...
    </div>
  </div>
</div>

<!-- Small modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      ...
    </div>
  </div>
</div>
```

## [](https://v3.bootcss.com/javascript/#modals-remove-animation)禁止动画效果

如果你不需要模态框弹出时的动画效果（淡入淡出效果），删掉 `.fade` 类即可。

```
<div class="modal" tabindex="-1" role="dialog" aria-labelledby="...">
  ...
</div>
```

## [](https://v3.bootcss.com/javascript/#modals-grid-system)Using the grid system

To take advantage of the Bootstrap grid system within a modal, just nest `.row`s within the `.modal-body` and then use the normal grid system classes.

```
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">.col-md-4</div>
          <div class="col-md-4 col-md-offset-4">.col-md-4 .col-md-offset-4</div>
        </div>
        <div class="row">
          <div class="col-md-3 col-md-offset-3">.col-md-3 .col-md-offset-3</div>
          <div class="col-md-2 col-md-offset-4">.col-md-2 .col-md-offset-4</div>
        </div>
        <div class="row">
          <div class="col-md-6 col-md-offset-3">.col-md-6 .col-md-offset-3</div>
        </div>
        <div class="row">
          <div class="col-sm-9">
            Level 1: .col-sm-9
            <div class="row">
              <div class="col-xs-8 col-sm-6">
                Level 2: .col-xs-8 .col-sm-6
              </div>
              <div class="col-xs-4 col-sm-6">
                Level 2: .col-xs-4 .col-sm-6
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
```

Have a bunch of buttons that all trigger the same modal, just with slightly different contents? Use `event.relatedTarget` and [HTML `data-*` attributes](https://developer.mozilla.org/en-US/docs/Learn/HTML/Howto/Use_data_attributes) (possibly [via jQuery](https://api.jquery.com/data/)) to vary the contents of the modal depending on which button was clicked. See the Modal Events docs for details on `relatedTarget`,

```
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Open modal for @mdo</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat">Open modal for @fat</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Open modal for @getbootstrap</button>
...more buttons...

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">New message</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="control-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
      </div>
    </div>
  </div>
</div>
```

```
$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('.modal-body input').val(recipient)
})
```

## [](https://v3.bootcss.com/javascript/#modals-usage)用法

通过 data 属性或 JavaScript 调用模态框插件，可以根据需要动态展示隐藏的内容。模态框弹出时还会为 `<body>` 元素添加 `.modal-open` 类，从而覆盖页面默认的滚动行为，并且还会自动生成一个 `.modal-backdrop` 元素用于提供一个可点击的区域，点击此区域就即可关闭模态框。

### [](https://v3.bootcss.com/javascript/#%E9%80%9A%E8%BF%87-data-%E5%B1%9E%E6%80%A7)通过 data 属性

不需写 JavaScript 代码也可激活模态框。通过在一个起控制器作用的元素（例如：按钮）上添加 `data-toggle="modal"` 属性，或者 `data-target="#foo"` 属性，再或者 `href="#foo"` 属性，用于指向被控制的模态框。

```
<button type="button" data-toggle="modal" data-target="#myModal">Launch modal</button>
```

### [](https://v3.bootcss.com/javascript/#%E9%80%9A%E8%BF%87-javascript-%E8%B0%83%E7%94%A8)通过 JavaScript 调用

只需一行 JavaScript 代码，即可通过元素的 id `myModal` 调用模态框：

```
$('#myModal').modal(options)
```

### [](https://v3.bootcss.com/javascript/#modals-options)参数

可以将选项通过 data 属性或 JavaScript 代码传递。对于 data 属性，需要将参数名称放到 `data-` 之后，例如 `data-backdrop=""`。

| 名称 | 类型 | 默认值 | 描述 |
| --- | --- | --- | --- |
| backdrop | boolean 或 字符串 `'static'` | true | Includes a modal-backdrop element. Alternatively, specify `static` for a backdrop which doesn't close the modal on click. |
| keyboard | boolean | true | 键盘上的 esc 键被按下时关闭模态框。 |
| show | boolean | true | 模态框初始化之后就立即显示出来。 |
| remote | path | false | 
**This option is deprecated since v3.3.0 and has been removed in v4.** We recommend instead using client-side templating or a data binding framework, or calling [jQuery.load](https://api.jquery.com/load/) yourself.

如果提供的是 URL，将利用 jQuery 的 `load` 方法**从此 URL 地址加载要展示的内容（只加载一次）**并插入 `.modal-content` 内。如果使用的是 data 属性 API，还可以利用 `href` 属性指定内容来源地址。下面是一个实例：

```
<a data-toggle="modal" href="remote.html" data-target="#modal">Click me</a>
```



 |

### [](https://v3.bootcss.com/javascript/#modals-methods)方法

#### [](https://v3.bootcss.com/javascript/#modal-options)`.modal(options)`

将页面中的某块内容作为模态框激活。接受可选参数 `object`。

```
$('#myModal').modal({
  keyboard: false
})
```

#### [](https://v3.bootcss.com/javascript/#modal-toggle)`.modal('toggle')`

手动打开或关闭模态框。**在模态框显示或隐藏之前返回到主调函数中**（也就是，在触发 `shown.bs.modal` 或 `hidden.bs.modal` 事件之前）。

```
$('#myModal').modal('toggle')
```

#### [](https://v3.bootcss.com/javascript/#modal-show)`.modal('show')`

手动打开模态框。**在模态框显示之前返回到主调函数中** （也就是，在触发 `shown.bs.modal` 事件之前）。

```
$('#myModal').modal('show')
```

#### [](https://v3.bootcss.com/javascript/#modal-hide)`.modal('hide')`

手动隐藏模态框。**在模态框隐藏之前返回到主调函数中** （也就是，在触发 `hidden.bs.modal` 事件之前）。

```
$('#myModal').modal('hide')
```

#### [](https://v3.bootcss.com/javascript/#modal-handleupdate)`.modal('handleUpdate')`

Readjusts the modal's positioning to counter a scrollbar in case one should appear, which would make the modal jump to the left.

Only needed when the height of the modal changes while it is open.

```
$('#myModal').modal('handleUpdate')
```

### [](https://v3.bootcss.com/javascript/#modals-events)事件

Bootstrap 的模态框类提供了一些事件用于监听并执行你自己的代码。

All modal events are fired at the modal itself (i.e. at the `<div class="modal">`).

| 事件类型 | 描述 |
| --- | --- |
| show.bs.modal | `show` 方法调用之后立即触发该事件。如果是通过点击某个作为触发器的元素，则此元素可以通过事件的 `relatedTarget` 属性进行访问。 |
| shown.bs.modal | 此事件在模态框已经显示出来（并且同时在 CSS 过渡效果完成）之后被触发。如果是通过点击某个作为触发器的元素，则此元素可以通过事件的 `relatedTarget` 属性进行访问。 |
| hide.bs.modal | `hide` 方法调用之后立即触发该事件。 |
| hidden.bs.modal | 此事件在模态框被隐藏（并且同时在 CSS 过渡效果完成）之后被触发。 |
| loaded.bs.modal | 从`远端的数据源`加载完数据之后触发该事件。 |

```
$('#myModal').on('hidden.bs.modal', function (e) {
  // do something...
})
```

## [](https://v3.bootcss.com/javascript/#dropdowns-examples)Examples

Add dropdown menus to nearly anything with this simple plugin, including the navbar, tabs, and pills.

### [](https://v3.bootcss.com/javascript/#within-a-navbar)Within a navbar

-   [Dropdown](https://v3.bootcss.com/javascript/#)
-   [Dropdown](https://v3.bootcss.com/javascript/#)

### [](https://v3.bootcss.com/javascript/#within-pills)Within pills

-   [Regular link](https://v3.bootcss.com/javascript/#)
-   [Dropdown](https://v3.bootcss.com/javascript/#)
-   [Dropdown](https://v3.bootcss.com/javascript/#)
-   [Dropdown](https://v3.bootcss.com/javascript/#)

## [](https://v3.bootcss.com/javascript/#dropdowns-usage)Usage

Via data attributes or JavaScript, the dropdown plugin toggles hidden content (dropdown menus) by toggling the `.open` class on the parent list item.

On mobile devices, opening a dropdown adds a `.dropdown-backdrop` as a tap area for closing dropdown menus when tapping outside the menu, a requirement for proper iOS support. **This means that switching from an open dropdown menu to a different dropdown menu requires an extra tap on mobile.**

Note: The `data-toggle="dropdown"` attribute is relied on for closing dropdown menus at an application level, so it's a good idea to always use it.

### [](https://v3.bootcss.com/javascript/#via-data-attributes)Via data attributes

Add `data-toggle="dropdown"` to a link or button to toggle a dropdown.

```
<div class="dropdown">
  <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Dropdown trigger
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dLabel">
    ...
  </ul>
</div>
```

To keep URLs intact with link buttons, use the `data-target` attribute instead of `href="#"`.

```
<div class="dropdown">
  <a id="dLabel" data-target="#" href="http://example.com/" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
    Dropdown trigger
    <span class="caret"></span>
  </a>

  <ul class="dropdown-menu" aria-labelledby="dLabel">
    ...
  </ul>
</div>
```

### [](https://v3.bootcss.com/javascript/#via-javascript)Via JavaScript

Call the dropdowns via JavaScript:

```
$('.dropdown-toggle').dropdown()
```

#### `data-toggle="dropdown"` still required

Regardless of whether you call your dropdown via JavaScript or instead use the data-api, `data-toggle="dropdown"` is always required to be present on the dropdown's trigger element.

### [](https://v3.bootcss.com/javascript/#dropdowns-options)Options

_None_

### [](https://v3.bootcss.com/javascript/#dropdowns-methods)Methods

#### [](https://v3.bootcss.com/javascript/#dropdown-toggle)`$().dropdown('toggle')`

Toggles the dropdown menu of a given navbar or tabbed navigation.

### [](https://v3.bootcss.com/javascript/#dropdowns-events)Events

All dropdown events are fired at the `.dropdown-menu`'s parent element.

All dropdown events have a `relatedTarget` property, whose value is the toggling anchor element.

| Event Type | Description |
| --- | --- |
| show.bs.dropdown | This event fires immediately when the show instance method is called. |
| shown.bs.dropdown | This event is fired when the dropdown has been made visible to the user (will wait for CSS transitions, to complete). |
| hide.bs.dropdown | This event is fired immediately when the hide instance method has been called. |
| hidden.bs.dropdown | This event is fired when the dropdown has finished being hidden from the user (will wait for CSS transitions, to complete). |

```
$('#myDropdown').on('show.bs.dropdown', function () {
  // do something…
})
```

滚动监听插件是用来根据滚动条所处的位置来自动更新导航项的。如下所示，滚动导航条下面的区域并关注导航项的变化。下拉菜单中的条目也会自动高亮显示。

### [](https://v3.bootcss.com/javascript/#%E9%9C%80%E8%A6%81%E7%9B%B8%E5%AF%B9%E5%AE%9A%E4%BD%8D%EF%BC%88relative-positioning%EF%BC%89)需要相对定位（relative positioning）

无论何种实现方式，滚动监听都需要被监听的组件是 `position: relative;` 即相对定位方式。大多数时候是监听 `<body>` 元素。When scrollspying on elements other than the `<body>`, be sure to have a `height` set and `overflow-y: scroll;` applied.

### [](https://v3.bootcss.com/javascript/#%E9%80%9A%E8%BF%87-data-%E5%B1%9E%E6%80%A7%E8%B0%83%E7%94%A8)通过 data 属性调用

To easily add scrollspy behavior to your topbar navigation, add `data-spy="scroll"` to the element you want to spy on (most typically this would be the `<body>`). Then add the `data-target` attribute with the ID or class of the parent element of any Bootstrap `.nav` component.

```
body {
  position: relative;
}
```

```
<body data-spy="scroll" data-target="#navbar-example">
  ...
  <div id="navbar-example">
    <ul class="nav nav-tabs" role="tablist">
      ...
    </ul>
  </div>
  ...
</body>
```

### [](https://v3.bootcss.com/javascript/#%E9%80%9A%E8%BF%87-javascript-%E8%B0%83%E7%94%A8-1)通过 JavaScript 调用

在 CSS 中添加 `position: relative;` 之后，通过 JavaScript 代码启动滚动监听插件：

```
$('body').scrollspy({ target: '#navbar-example' })
```

### [](https://v3.bootcss.com/javascript/#scrollspy-methods)方法

#### [](https://v3.bootcss.com/javascript/#scrollspy-refresh)`.scrollspy('refresh')`

当使用滚动监听插件的同时在 DOM 中添加或删除元素后，你需要像下面这样调用此刷新（ refresh） 方法：

```
$('[data-spy="scroll"]').each(function () {
  var $spy = $(this).scrollspy('refresh')
})
```

### [](https://v3.bootcss.com/javascript/#scrollspy-options)参数

可以通过 data 属性或 JavaScript 传递参数。对于 data 属性，其名称是将参数名附着到 `data-` 后面组成，例如 `data-offset=""`。

| 名称 | 类型 | 默认值 | 描述 |
| --- | --- | --- | --- |
| offset | number | 10 | 计算滚动位置时相对于顶部的偏移量（像素数）。 |

### [](https://v3.bootcss.com/javascript/#scrollspy-events)事件

| 事件类型 | 描述 |
| --- | --- |
| activate.bs.scrollspy | 每当一个新条目被激活后都将由滚动监听插件触发此事件。 |

```
$('#myScrollspy').on('activate.bs.scrollspy', function () {
  // do something…
})
```

## [](https://v3.bootcss.com/javascript/#tabs-examples)Example tabs

Add quick, dynamic tab functionality to transition through panes of local content, even via dropdown menus. **Nested tabs are not supported.**

-   [Home](https://v3.bootcss.com/javascript/#home)
-   [Profile](https://v3.bootcss.com/javascript/#profile)
-   [Dropdown](https://v3.bootcss.com/javascript/#)
    -   [@fat](https://v3.bootcss.com/javascript/#dropdown1)
    -   [@mdo](https://v3.bootcss.com/javascript/#dropdown2)

Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.

Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.

Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.

Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan, sartorial keffiyeh echo park vegan.

## [](https://v3.bootcss.com/javascript/#tabs-usage)Usage

Enable tabbable tabs via JavaScript (each tab needs to be activated individually):

```
$('#myTabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})
```

You can activate individual tabs in several ways:

```
$('#myTabs a[href="#profile"]').tab('show') // Select tab by name
$('#myTabs a:first').tab('show') // Select first tab
$('#myTabs a:last').tab('show') // Select last tab
$('#myTabs li:eq(2) a').tab('show') // Select third tab (0-indexed)
```

### [](https://v3.bootcss.com/javascript/#markup)Markup

You can activate a tab or pill navigation without writing any JavaScript by simply specifying `data-toggle="tab"` or `data-toggle="pill"` on an element. Adding the `nav` and `nav-tabs` classes to the tab `ul` will apply the Bootstrap [tab styling](https://v3.bootcss.com/components/#nav-tabs), while adding the `nav` and `nav-pills` classes will apply [pill styling](https://v3.bootcss.com/components/#nav-pills).

```
<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">...</div>
    <div role="tabpanel" class="tab-pane" id="profile">...</div>
    <div role="tabpanel" class="tab-pane" id="messages">...</div>
    <div role="tabpanel" class="tab-pane" id="settings">...</div>
  </div>

</div>
```

### [](https://v3.bootcss.com/javascript/#fade-effect)Fade effect

To make tabs fade in, add `.fade` to each `.tab-pane`. The first tab pane must also have `.in` to make the initial content visible.

```
<div class="tab-content">
  <div role="tabpanel" class="tab-pane fade in active" id="home">...</div>
  <div role="tabpanel" class="tab-pane fade" id="profile">...</div>
  <div role="tabpanel" class="tab-pane fade" id="messages">...</div>
  <div role="tabpanel" class="tab-pane fade" id="settings">...</div>
</div>
```

### [](https://v3.bootcss.com/javascript/#tabs-methods)Methods

#### [](https://v3.bootcss.com/javascript/#tab)`$().tab`

Activates a tab element and content container. Tab should have either a `data-target` or an `href` targeting a container node in the DOM. In the above examples, the tabs are the `<a>`s with `data-toggle="tab"` attributes.

#### [](https://v3.bootcss.com/javascript/#tab-show)`.tab('show')`

Selects the given tab and shows its associated content. Any other tab that was previously selected becomes unselected and its associated content is hidden. **Returns to the caller before the tab pane has actually been shown** (i.e. before the `shown.bs.tab` event occurs).

```
$('#someTab').tab('show')
```

### [](https://v3.bootcss.com/javascript/#tabs-events)Events

When showing a new tab, the events fire in the following order:

1.  `hide.bs.tab` (on the current active tab)
2.  `show.bs.tab` (on the to-be-shown tab)
3.  `hidden.bs.tab` (on the previous active tab, the same one as for the `hide.bs.tab` event)
4.  `shown.bs.tab` (on the newly-active just-shown tab, the same one as for the `show.bs.tab` event)

If no tab was already active, then the `hide.bs.tab` and `hidden.bs.tab` events will not be fired.

| Event Type | Description |
| --- | --- |
| show.bs.tab | This event fires on tab show, but before the new tab has been shown. Use `event.target` and `event.relatedTarget` to target the active tab and the previous active tab (if available) respectively. |
| shown.bs.tab | This event fires on tab show after a tab has been shown. Use `event.target` and `event.relatedTarget` to target the active tab and the previous active tab (if available) respectively. |
| hide.bs.tab | This event fires when a new tab is to be shown (and thus the previous active tab is to be hidden). Use `event.target` and `event.relatedTarget` to target the current active tab and the new soon-to-be-active tab, respectively. |
| hidden.bs.tab | This event fires after a new tab is shown (and thus the previous active tab is hidden). Use `event.target` and `event.relatedTarget` to target the previous active tab and the new active tab, respectively. |

```
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  e.target // newly activated tab
  e.relatedTarget // previous active tab
})
```

Inspired by the excellent jQuery.tipsy plugin written by Jason Frame; Tooltips are an updated version, which don't rely on images, use CSS3 for animations, and data-attributes for local title storage.

Tooltips with zero-length titles are never displayed.

Hover over the links below to see tooltips:

Tight pants next level keffiyeh [you probably](https://v3.bootcss.com/javascript/# "Default tooltip") haven't heard of them. Photo booth beard raw denim letterpress vegan messenger bag stumptown. Farm-to-table seitan, mcsweeney's fixie sustainable quinoa 8-bit american apparel [have a](https://v3.bootcss.com/javascript/# "Another tooltip") terry richardson vinyl chambray. Beard stumptown, cardigans banh mi lomo thundercats. Tofu biodiesel williamsburg marfa, four loko mcsweeney's cleanse vegan chambray. A really ironic artisan [whatever keytar](https://v3.bootcss.com/javascript/# "Another one here too"), scenester farm-to-table banksy Austin [twitter handle](https://v3.bootcss.com/javascript/# "The last tip!") freegan cred raw denim single-origin coffee viral.

### [](https://v3.bootcss.com/javascript/#static-tooltip)Static tooltip

Four options are available: top, right, bottom, and left aligned.

### [](https://v3.bootcss.com/javascript/#four-directions)Four directions

```
<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Tooltip on left">Tooltip on left</button>

<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Tooltip on top">Tooltip on top</button>

<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Tooltip on bottom">Tooltip on bottom</button>

<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Tooltip on right">Tooltip on right</button>
```

The tooltip plugin generates content and markup on demand, and by default places tooltips after their trigger element.

Trigger the tooltip via JavaScript:

```
$('#example').tooltip(options)
```

### [](https://v3.bootcss.com/javascript/#markup-1)Markup

The required markup for a tooltip is only a `data` attribute and `title` on the HTML element you wish to have a tooltip. The generated markup of a tooltip is rather simple, though it does require a position (by default, set to `top` by the plugin).

```
<!-- HTML to write -->
<a href="#" data-toggle="tooltip" title="Some tooltip text!">Hover over me</a>

<!-- Generated markup by the plugin -->
<div class="tooltip top" role="tooltip">
  <div class="tooltip-arrow"></div>
  <div class="tooltip-inner">
    Some tooltip text!
  </div>
</div>
```

### [](https://v3.bootcss.com/javascript/#tooltips-options)Options

Options can be passed via data attributes or JavaScript. For data attributes, append the option name to `data-`, as in `data-animation=""`.

Note that for security reasons the `sanitize`, `sanitizeFn` and `whiteList` options cannot be supplied using data attributes.

| Name | Type | Default | Description |
| --- | --- | --- | --- |
| animation | boolean | true | Apply a CSS fade transition to the tooltip |
| container | string | false | false | 
Appends the tooltip to a specific element. Example: `container: 'body'`. This option is particularly useful in that it allows you to position the tooltip in the flow of the document near the triggering element - which will prevent the tooltip from floating away from the triggering element during a window resize.

 |
| delay | number | object | 0 | 

Delay showing and hiding the tooltip (ms) - does not apply to manual trigger type

If a number is supplied, delay is applied to both hide/show

Object structure is: `delay: { "show": 500, "hide": 100 }`

 |
| html | boolean | false | Insert HTML into the tooltip. If false, jQuery's `text` method will be used to insert content into the DOM. Use text if you're worried about XSS attacks. |
| placement | string | function | 'top' | 

How to position the tooltip - top | bottom | left | right | auto.  
When "auto" is specified, it will dynamically reorient the tooltip. For example, if placement is "auto left", the tooltip will display to the left when possible, otherwise it will display right.

When a function is used to determine the placement, it is called with the tooltip DOM node as its first argument and the triggering element DOM node as its second. The `this` context is set to the tooltip instance.

 |
| selector | string | false | If a selector is provided, tooltip objects will be delegated to the specified targets. In practice, this is used to also apply tooltips to dynamically added DOM elements (`jQuery.on` support). See [this](https://github.com/twbs/bootstrap/issues/4215) and [an informative example](http://jsbin.com/zopod/1/edit). |
| template | string | `'<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'` | 

Base HTML to use when creating the tooltip.

The tooltip's `title` will be injected into the `.tooltip-inner`.

`.tooltip-arrow` will become the tooltip's arrow.

The outermost wrapper element should have the `.tooltip` class.

 |
| title | string | function | '' | 

Default title value if `title` attribute isn't present.

If a function is given, it will be called with its `this` reference set to the element that the tooltip is attached to.

 |
| trigger | string | 'hover focus' | How tooltip is triggered - click | hover | focus | manual. You may pass multiple triggers; separate them with a space. `manual` cannot be combined with any other trigger. |
| viewport | string | object | function | { selector: 'body', padding: 0 } | 

Keeps the tooltip within the bounds of this element. Example: `viewport: '#viewport'` or `{ "selector": "#viewport", "padding": 0 }`

If a function is given, it is called with the triggering element DOM node as its only argument. The `this` context is set to the tooltip instance.

 |
| sanitize | boolean | true | Enable or disable the sanitization. If activated `'template'`, `'content'` and `'title'` options will be sanitized. |
| whiteList | object | [Default value](https://v3.bootcss.com/javascript/#js-sanitizer) | Object which contains allowed attributes and tags |
| sanitizeFn | null | function | null | Here you can supply your own sanitize function. This can be useful if you prefer to use a dedicated library to perform sanitization. |

### [](https://v3.bootcss.com/javascript/#tooltips-methods)Methods

#### [](https://v3.bootcss.com/javascript/#tooltip-options)`$().tooltip(options)`

Attaches a tooltip handler to an element collection.

#### [](https://v3.bootcss.com/javascript/#tooltip-show)`.tooltip('show')`

Reveals an element's tooltip. **Returns to the caller before the tooltip has actually been shown** (i.e. before the `shown.bs.tooltip` event occurs). This is considered a "manual" triggering of the tooltip. Tooltips with zero-length titles are never displayed.

```
$('#element').tooltip('show')
```

#### [](https://v3.bootcss.com/javascript/#tooltip-hide)`.tooltip('hide')`

Hides an element's tooltip. **Returns to the caller before the tooltip has actually been hidden** (i.e. before the `hidden.bs.tooltip` event occurs). This is considered a "manual" triggering of the tooltip.

```
$('#element').tooltip('hide')
```

#### [](https://v3.bootcss.com/javascript/#tooltip-toggle)`.tooltip('toggle')`

Toggles an element's tooltip. **Returns to the caller before the tooltip has actually been shown or hidden** (i.e. before the `shown.bs.tooltip` or `hidden.bs.tooltip` event occurs). This is considered a "manual" triggering of the tooltip.

```
$('#element').tooltip('toggle')
```

#### [](https://v3.bootcss.com/javascript/#tooltip-destroy)`.tooltip('destroy')`

Hides and destroys an element's tooltip. Tooltips that use delegation (which are created using [the `selector` option](https://v3.bootcss.com/javascript/#tooltips-options)) cannot be individually destroyed on descendant trigger elements.

```
$('#element').tooltip('destroy')
```

### [](https://v3.bootcss.com/javascript/#tooltips-events)Events

| Event Type | Description |
| --- | --- |
| show.bs.tooltip | This event fires immediately when the `show` instance method is called. |
| shown.bs.tooltip | This event is fired when the tooltip has been made visible to the user (will wait for CSS transitions to complete). |
| hide.bs.tooltip | This event is fired immediately when the `hide` instance method has been called. |
| hidden.bs.tooltip | This event is fired when the tooltip has finished being hidden from the user (will wait for CSS transitions to complete). |
| inserted.bs.tooltip | This event is fired after the `show.bs.tooltip` event when the tooltip template has been added to the DOM. |

```
$('#myTooltip').on('hidden.bs.tooltip', function () {
  // do something…
})
```

为任意元素添加一小块浮层，就像 iPad 上一样，用于存放非主要信息。

弹出框的标题和内容的长度都是零的话将永远不会被显示出来。

#### 初始化

由于性能的原因，工具提示和弹出框的 data 编程接口（data api）是必须要**手动初始化的**。

在一个页面上一次性初始化所有弹出框的方式是通过 `data-toggle` 属性选中他们：

```
$(function () {
  $('[data-toggle="popover"]').popover()
})
```

#### Popovers in button groups, input groups, and tables require special setting

When using popovers on elements within a `.btn-group` or an `.input-group`, or on table-related elements (`<td>`, `<th>`, `<tr>`, `<thead>`, `<tbody>`, `<tfoot>`), you'll have to specify the option `container: 'body'` (documented below) to avoid unwanted side effects (such as the element growing wider and/or losing its rounded corners when the popover is triggered).

#### Popovers on disabled elements require wrapper elements

To add a popover to a `disabled` or `.disabled` element, put the element inside of a `<div>` and apply the popover to that `<div>` instead.

#### Multiple-line links

Sometimes you want to add a popover to a hyperlink that wraps multiple lines. The default behavior of the popover plugin is to center it horizontally and vertically. Add `white-space: nowrap;` to your anchors to avoid this.

## [](https://v3.bootcss.com/javascript/#popovers-examples)实例

### [](https://v3.bootcss.com/javascript/#%E9%9D%99%E6%80%81%E5%BC%B9%E5%87%BA%E6%A1%86)静态弹出框

4个可能的弹出方向：顶部、右侧、底部和左侧。

### Popover 顶部

Sed posuere consectetur est at lobortis. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum.

### Popover 右侧

Sed posuere consectetur est at lobortis. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum.

### Popover 顶部

Sed posuere consectetur est at lobortis. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum.

### Popover 左侧

Sed posuere consectetur est at lobortis. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum.

### [](https://v3.bootcss.com/javascript/#%E5%AE%9E%E4%BE%8B%E6%BC%94%E7%A4%BA)实例演示

```
<button type="button" class="btn btn-lg btn-danger" data-toggle="popover" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?">点我弹出/隐藏弹出框</button>
```

#### [](https://v3.bootcss.com/javascript/#4%E4%B8%AA%E5%BC%B9%E5%87%BA%E6%96%B9%E5%90%91)4个弹出方向

```
<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
  Popover on 左侧
</button>

<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
  Popover on 顶部
</button>

<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Vivamus
sagittis lacus vel augue laoreet rutrum faucibus.">
  Popover on 底部
</button>

<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="right" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
  Popover on 右侧
</button>
```

#### [](https://v3.bootcss.com/javascript/#%E7%82%B9%E5%87%BB%E5%B9%B6%E8%AE%A9%E5%BC%B9%E5%87%BA%E6%A1%86%E6%B6%88%E5%A4%B1)点击并让弹出框消失

通过使用 `focus` 触发器可以在用户点击弹出框是让其消失。

#### 实现“点击并让弹出框消失”的效果需要一些额外的代码

为了更好的跨浏览器和跨平台效果，你必须使用 `<a>` 签，_不能_ 使用 `<button>` 标签，并且，还必须包含 `role="button"` 和 [`tabindex`](https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/tabindex) 属性。

```
<a tabindex="0" class="btn btn-lg btn-danger" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?">可消失的弹出框</a>
```

## [](https://v3.bootcss.com/javascript/#popovers-usage)用法

通过 JavaScript 代码启动弹出框：

```
$('#example').popover(options)
```

### [](https://v3.bootcss.com/javascript/#popovers-options)参数

可以通过 data 属性或 JavaScript 传递参数。对于 data 属性，将参数名附着到 `data-` 后面，例如 `data-animation=""`。

Note that for security reasons the `sanitize`, `sanitizeFn` and `whiteList` options cannot be supplied using data attributes.

| 名称 | 类型 | 默认值 | 描述 |
| --- | --- | --- | --- |
| animation | boolean | true | 为弹出框赋予淡出的 CSS 动画效果。 |
| container | string | false | false | 
Appends the popover to a specific element. Example: `container: 'body'`. This option is particularly useful in that it allows you to position the popover in the flow of the document near the triggering element - which will prevent the popover from floating away from the triggering element during a window resize.

 |
| content | string | function | '' | 

Default content value if `data-content` attribute isn't present.

If a function is given, it will be called with its `this` reference set to the element that the popover is attached to.

 |
| delay | number | object | 0 | 

Delay showing and hiding the popover (ms) - does not apply to manual trigger type

If a number is supplied, delay is applied to both hide/show

Object structure is: `delay: { "show": 500, "hide": 100 }`

 |
| html | boolean | false | Insert HTML into the popover. If false, jQuery's `text` method will be used to insert content into the DOM. Use text if you're worried about XSS attacks. |
| placement | string | function | 'right' | 

How to position the popover - top | bottom | left | right | auto.  
When "auto" is specified, it will dynamically reorient the popover. For example, if placement is "auto left", the popover will display to the left when possible, otherwise it will display right.

When a function is used to determine the placement, it is called with the popover DOM node as its first argument and the triggering element DOM node as its second. The `this` context is set to the popover instance.

 |
| selector | string | false | If a selector is provided, popover objects will be delegated to the specified targets. In practice, this is used to enable dynamic HTML content to have popovers added. See [this](https://github.com/twbs/bootstrap/issues/4215) and [an informative example](http://jsbin.com/zopod/1/edit). |
| template | string | `'<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'` | 

Base HTML to use when creating the popover.

The popover's `title` will be injected into the `.popover-title`.

The popover's `content` will be injected into the `.popover-content`.

`.arrow` will become the popover's arrow.

The outermost wrapper element should have the `.popover` class.

 |
| title | string | function | '' | 

Default title value if `title` attribute isn't present.

If a function is given, it will be called with its `this` reference set to the element that the popover is attached to.

 |
| trigger | string | 'click' | How popover is triggered - click | hover | focus | manual. You may pass multiple triggers; separate them with a space. `manual` cannot be combined with any other trigger. |
| viewport | string | object | function | { selector: 'body', padding: 0 } | 

Keeps the popover within the bounds of this element. Example: `viewport: '#viewport'` or `{ "selector": "#viewport", "padding": 0 }`

If a function is given, it is called with the triggering element DOM node as its only argument. The `this` context is set to the popover instance.

 |
| sanitize | boolean | true | Enable or disable the sanitization. If activated `'template'`, `'content'` and `'title'` options will be sanitized. |
| whiteList | object | [Default value](https://v3.bootcss.com/javascript/#js-sanitizer) | Object which contains allowed attributes and tags |
| sanitizeFn | null | function | null | Here you can supply your own sanitize function. This can be useful if you prefer to use a dedicated library to perform sanitization. |

#### Data attributes for individual popovers

Options for individual popovers can alternatively be specified through the use of data attributes, as explained above.

### [](https://v3.bootcss.com/javascript/#popovers-methods)Methods

#### [](https://v3.bootcss.com/javascript/#popover-options)`$().popover(options)`

Initializes popovers for an element collection.

#### [](https://v3.bootcss.com/javascript/#popover-show)`.popover('show')`

Reveals an element's popover. **Returns to the caller before the popover has actually been shown** (i.e. before the `shown.bs.popover` event occurs). This is considered a "manual" triggering of the popover. Popovers whose both title and content are zero-length are never displayed.

```
$('#element').popover('show')
```

#### [](https://v3.bootcss.com/javascript/#popover-hide)`.popover('hide')`

Hides an element's popover. **Returns to the caller before the popover has actually been hidden** (i.e. before the `hidden.bs.popover` event occurs). This is considered a "manual" triggering of the popover.

```
$('#element').popover('hide')
```

#### [](https://v3.bootcss.com/javascript/#popover-toggle)`.popover('toggle')`

Toggles an element's popover. **Returns to the caller before the popover has actually been shown or hidden** (i.e. before the `shown.bs.popover` or `hidden.bs.popover` event occurs). This is considered a "manual" triggering of the popover.

```
$('#element').popover('toggle')
```

#### [](https://v3.bootcss.com/javascript/#popover-destroy)`.popover('destroy')`

Hides and destroys an element's popover. Popovers that use delegation (which are created using [the `selector` option](https://v3.bootcss.com/javascript/#popovers-options)) cannot be individually destroyed on descendant trigger elements.

```
$('#element').popover('destroy')
```

### [](https://v3.bootcss.com/javascript/#popovers-events)Events

| Event Type | Description |
| --- | --- |
| show.bs.popover | This event fires immediately when the `show` instance method is called. |
| shown.bs.popover | This event is fired when the popover has been made visible to the user (will wait for CSS transitions to complete). |
| hide.bs.popover | This event is fired immediately when the `hide` instance method has been called. |
| hidden.bs.popover | This event is fired when the popover has finished being hidden from the user (will wait for CSS transitions to complete). |
| inserted.bs.popover | This event is fired after the `show.bs.popover` event when the popover template has been added to the DOM. |

```
$('#myPopover').on('hidden.bs.popover', function () {
  // do something…
})
```

## [](https://v3.bootcss.com/javascript/#alerts-examples)实例

通过此插件可以为警告信息添加点击并消失的功能。

当使用 `.close` 按钮时，它必须是 `.alert-dismissible` 的第一个子元素，并且在它之前不能有任何文本内容。

## [](https://v3.bootcss.com/javascript/#alerts-usage)用法

为关闭按钮添加 `data-dismiss="alert"` 属性就可以使其自动为警告框赋予关闭功能。关闭警告框也就是将其从 DOM 中删除。

```
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
```

为了让警告框在关闭时表现出动画效果，请确保为其添加了 `.fade` 和 `.in` 类。

### [](https://v3.bootcss.com/javascript/#alerts-methods)方法

#### [](https://v3.bootcss.com/javascript/#alert)`$().alert()`

让警告框监听具有 `data-dismiss="alert"` 属性的后裔元素的点击（click）事件。（如果是通过 data 属性进行的初始化则无需使用）

#### [](https://v3.bootcss.com/javascript/#alert-close)`$().alert('close')`

关闭警告框并从 DOM 中将其删除。如果警告框被赋予了 `.fade` 和 `.in` 类，那么，警告框在淡出之后才会被删除。

### [](https://v3.bootcss.com/javascript/#alerts-events)事件

Bootstrap 的警告框插件对外暴露了一些可以被监听的事件。

| 事件类型 | 描述 |
| --- | --- |
| close.bs.alert | 当 `close` 方法被调用后立即触发此事件。 |
| closed.bs.alert | 当警告框被关闭后（也即 CSS 过渡效果完毕之后）立即触发此事件。 |

```
$('#myAlert').on('closed.bs.alert', function () {
  // do something…
})
```

按钮的功能很丰富。通过控制按钮的状态或创建一组按钮并形成一些新的组件，例如工具条。

## [](https://v3.bootcss.com/javascript/#buttons-stateful)状态

通过添加 `data-loading-text="Loading..."` 可以为按钮设置正在加载的状态。

**从 v3.3.5 版本开始，此特性不再建议使用，并且已经在 v4 版本中删除了。**

#### Use whichever state you like!

For the sake of this demonstration, we are using `data-loading-text` and `$().button('loading')`, but that's not the only state you can use. [See more on this below in the `$().button(string)` documentation](https://v3.bootcss.com/javascript/#buttons-methods).

```
<button type="button" id="myButton" data-loading-text="Loading..." class="btn btn-primary">
  Loading state
</button>

<script>
  $('#myButton').on('click', function () {
    var $btn = $(this).button('loading')
    // business logic...
    $btn.button('reset')
  })
</script>
```

## [](https://v3.bootcss.com/javascript/#buttons-single-toggle)Single toggle

Add `data-toggle="button"` to activate toggling on a single button.

#### Pre-toggled buttons need `.active` and `aria-pressed="true"`

For pre-toggled buttons, you must add the `.active` class and the `aria-pressed="true"` attribute to the `button` yourself.

```
<button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false">
  Single toggle
</button>
```

## [](https://v3.bootcss.com/javascript/#buttons-checkbox-radio)Checkbox / Radio

Add `data-toggle="buttons"` to a `.btn-group` containing checkbox or radio inputs to enable toggling in their respective styles.

#### Preselected options need `.active`

For preselected options, you must add the `.active` class to the input's `label` yourself.

#### Visual checked state only updated on click

If the checked state of a checkbox button is updated without firing a `click` event on the button (e.g. via `<input type="reset">` or via setting the `checked` property of the input), you will need to toggle the `.active` class on the input's `label` yourself.

Checkbox 1 (pre-checked) Checkbox 2 Checkbox 3

```
<div class="btn-group" data-toggle="buttons">
  <label class="btn btn-primary active">
    <input type="checkbox" checked> Checkbox 1 (pre-checked)
  </label>
  <label class="btn btn-primary">
    <input type="checkbox"> Checkbox 2
  </label>
  <label class="btn btn-primary">
    <input type="checkbox"> Checkbox 3
  </label>
</div>
```

Radio 1 (preselected) Radio 2 Radio 3

```
<div class="btn-group" data-toggle="buttons">
  <label class="btn btn-primary active">
    <input type="radio" name="options" id="option1" checked> Radio 1 (preselected)
  </label>
  <label class="btn btn-primary">
    <input type="radio" name="options" id="option2"> Radio 2
  </label>
  <label class="btn btn-primary">
    <input type="radio" name="options" id="option3"> Radio 3
  </label>
</div>
```

## [](https://v3.bootcss.com/javascript/#buttons-methods)方法

#### [](https://v3.bootcss.com/javascript/#button-toggle)`$().button('toggle')`

Toggles push state. Gives the button the appearance that it has been activated.

#### [](https://v3.bootcss.com/javascript/#button-reset)`$().button('reset')`

重置按钮状态 - 将按钮上的文本还原回原始的内容。**此为异步方法，此方法在内容被重置完成之前即返回。**

#### [](https://v3.bootcss.com/javascript/#button-string)`$().button(string)`

Swaps text to any data defined text state.

```
<button type="button" id="myStateButton" data-complete-text="finished!" class="btn btn-primary">
  ...
</button>

<script>
  $('#myStateButton').on('click', function () {
    $(this).button('complete') // button text will be "finished!"
  })
</script>
```

Flexible plugin that utilizes a handful of classes for easy toggle behavior.

#### Plugin dependency

Collapse requires the [transitions plugin](https://v3.bootcss.com/javascript/#transitions) to be included in your version of Bootstrap.

## [](https://v3.bootcss.com/javascript/#collapse-example)Example

Click the buttons below to show and hide another element via class changes:

-   `.collapse` hides content
-   `.collapsing` is applied during transitions
-   `.collapse.in` shows content

You can use a link with the `href` attribute, or a button with the `data-target` attribute. In both cases, the `data-toggle="collapse"` is required.

[Link with href](https://v3.bootcss.com/javascript/#collapseExample)

Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.

```
<a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
  Link with href
</a>
<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
  Button with data-target
</button>
<div class="collapse" id="collapseExample">
  <div class="well">
    ...
  </div>
</div>
```

## [](https://v3.bootcss.com/javascript/#collapse-example-accordion)Accordion example

Extend the default collapse behavior to create an accordion with the panel component.

#### [Collapsible Group Item #1](https://v3.bootcss.com/javascript/#collapseOne)

Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.

#### [Collapsible Group Item #2](https://v3.bootcss.com/javascript/#collapseTwo)

Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.

#### [Collapsible Group Item #3](https://v3.bootcss.com/javascript/#collapseThree)

Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.

```
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Collapsible Group Item #1
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Collapsible Group Item #2
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingThree">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Collapsible Group Item #3
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
      <div class="panel-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
</div>
```

It's also possible to swap out `.panel-body`s with `.list-group`s.

#### [Collapsible list group](https://v3.bootcss.com/javascript/#collapseListGroup1)

-   Bootply
-   One itmus ac facilin
-   Second eros

#### Make expand/collapse controls accessible

Be sure to add `aria-expanded` to the control element. This attribute explicitly defines the current state of the collapsible element to screen readers and similar assistive technologies. If the collapsible element is closed by default, it should have a value of `aria-expanded="false"`. If you've set the collapsible element to be open by default using the `in` class, set `aria-expanded="true"` on the control instead. The plugin will automatically toggle this attribute based on whether or not the collapsible element has been opened or closed.

Additionally, if your control element is targeting a single collapsible element – i.e. the `data-target` attribute is pointing to an `id` selector – you may add an additional `aria-controls` attribute to the control element, containing the `id` of the collapsible element. Modern screen readers and similar assistive technologies make use of this attribute to provide users with additional shortcuts to navigate directly to the collapsible element itself.

## [](https://v3.bootcss.com/javascript/#collapse-usage)Usage

The collapse plugin utilizes a few classes to handle the heavy lifting:

-   `.collapse` hides the content
-   `.collapse.in` shows the content
-   `.collapsing` is added when the transition starts, and removed when it finishes

These classes can be found in `component-animations.less`.

### [](https://v3.bootcss.com/javascript/#via-data-attributes-1)Via data attributes

Just add `data-toggle="collapse"` and a `data-target` to the element to automatically assign control of a collapsible element. The `data-target` attribute accepts a CSS selector to apply the collapse to. Be sure to add the class `collapse` to the collapsible element. If you'd like it to default open, add the additional class `in`.

To add accordion-like group management to a collapsible control, add the data attribute `data-parent="#selector"`. Refer to the demo to see this in action.

### [](https://v3.bootcss.com/javascript/#via-javascript-1)Via JavaScript

Enable manually with:

```
$('.collapse').collapse()
```

### [](https://v3.bootcss.com/javascript/#collapse-options)Options

Options can be passed via data attributes or JavaScript. For data attributes, append the option name to `data-`, as in `data-parent=""`.

| Name | type | default | description |
| --- | --- | --- | --- |
| parent | selector | false | If a selector is provided, then all collapsible elements under the specified parent will be closed when this collapsible item is shown. (similar to traditional accordion behavior - this is dependent on the `panel` class) |
| toggle | boolean | true | Toggles the collapsible element on invocation |

### [](https://v3.bootcss.com/javascript/#collapse-methods)Methods

#### [](https://v3.bootcss.com/javascript/#collapse-options-1)`.collapse(options)`

Activates your content as a collapsible element. Accepts an optional options `object`.

```
$('#myCollapsible').collapse({
  toggle: false
})
```

#### [](https://v3.bootcss.com/javascript/#collapse-toggle)`.collapse('toggle')`

Toggles a collapsible element to shown or hidden. **Returns to the caller before the collapsible element has actually been shown or hidden** (i.e. before the `shown.bs.collapse` or `hidden.bs.collapse` event occurs).

#### [](https://v3.bootcss.com/javascript/#collapse-show)`.collapse('show')`

Shows a collapsible element. **Returns to the caller before the collapsible element has actually been shown** (i.e. before the `shown.bs.collapse` event occurs).

#### [](https://v3.bootcss.com/javascript/#collapse-hide)`.collapse('hide')`

Hides a collapsible element. **Returns to the caller before the collapsible element has actually been hidden** (i.e. before the `hidden.bs.collapse` event occurs).

### [](https://v3.bootcss.com/javascript/#collapse-events)Events

Bootstrap's collapse class exposes a few events for hooking into collapse functionality.

| Event Type | Description |
| --- | --- |
| show.bs.collapse | This event fires immediately when the `show` instance method is called. |
| shown.bs.collapse | This event is fired when a collapse element has been made visible to the user (will wait for CSS transitions to complete). |
| hide.bs.collapse | This event is fired immediately when the `hide` method has been called. |
| hidden.bs.collapse | This event is fired when a collapse element has been hidden from the user (will wait for CSS transitions to complete). |

```
$('#myCollapsible').on('hidden.bs.collapse', function () {
  // do something…
})
```

A slideshow component for cycling through elements, like a carousel. **Nested carousels are not supported.**

## [](https://v3.bootcss.com/javascript/#carousel-examples)Examples

```
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="..." alt="...">
      <div class="carousel-caption">
        ...
      </div>
    </div>
    <div class="item">
      <img src="..." alt="...">
      <div class="carousel-caption">
        ...
      </div>
    </div>
    ...
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
```

#### Accessibility issue

The carousel component is generally not compliant with accessibility standards. If you need to be compliant, please consider other options for presenting your content.

#### Transition animations not supported in Internet Explorer 8 & 9

Bootstrap exclusively uses CSS3 for its animations, but Internet Explorer 8 & 9 don't support the necessary CSS properties. Thus, there are no slide transition animations when using these browsers. We have intentionally decided not to include jQuery-based fallbacks for the transitions.

#### Initial active element required

The `.active` class needs to be added to one of the slides. Otherwise, the carousel will not be visible.

#### Glyphicon icons not necessary

The `.glyphicon .glyphicon-chevron-left` and `.glyphicon .glyphicon-chevron-right` classes are not necessarily needed for the controls. Bootstrap provides `.icon-prev` and `.icon-next` as plain unicode alternatives.

### [](https://v3.bootcss.com/javascript/#optional-captions)Optional captions

Add captions to your slides easily with the `.carousel-caption` element within any `.item`. Place just about any optional HTML within there and it will be automatically aligned and formatted.

![900x500](data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iOTAwIiBoZWlnaHQ9IjUwMCIgdmlld0JveD0iMCAwIDkwMCA1MDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzkwMHg1MDAvYXV0by8jNzc3OiM3NzcKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xODIzZTQ2ZGVlZSB0ZXh0IHsgZmlsbDojNzc3O2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjQ1cHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE4MjNlNDZkZWVlIj48cmVjdCB3aWR0aD0iOTAwIiBoZWlnaHQ9IjUwMCIgZmlsbD0iIzc3NyIvPjxnPjx0ZXh0IHg9IjMzMy4yMTY2NjcxNzUyOTI5NyIgeT0iMjcwLjEiPjkwMHg1MDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=)

### First slide label

Nulla vitae elit libero, a pharetra augue mollis interdum.

![900x500](data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iOTAwIiBoZWlnaHQ9IjUwMCIgdmlld0JveD0iMCAwIDkwMCA1MDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzkwMHg1MDAvYXV0by8jNjY2OiM2NjYKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xODIzZTQ2Zjc4OCB0ZXh0IHsgZmlsbDojNjY2O2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjQ1cHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE4MjNlNDZmNzg4Ij48cmVjdCB3aWR0aD0iOTAwIiBoZWlnaHQ9IjUwMCIgZmlsbD0iIzY2NiIvPjxnPjx0ZXh0IHg9IjMzMy4yMTY2NjcxNzUyOTI5NyIgeT0iMjcwLjEiPjkwMHg1MDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=)

### Second slide label

Lorem ipsum dolor sit amet, consectetur adipiscing elit.

![900x500](data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iOTAwIiBoZWlnaHQ9IjUwMCIgdmlld0JveD0iMCAwIDkwMCA1MDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzkwMHg1MDAvYXV0by8jNTU1OiM1NTUKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xODIzZTQ3M2I3NiB0ZXh0IHsgZmlsbDojNTU1O2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjQ1cHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE4MjNlNDczYjc2Ij48cmVjdCB3aWR0aD0iOTAwIiBoZWlnaHQ9IjUwMCIgZmlsbD0iIzU1NSIvPjxnPjx0ZXh0IHg9IjMzMy4yMTY2NjcxNzUyOTI5NyIgeT0iMjcwLjEiPjkwMHg1MDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=)

### Third slide label

Praesent commodo cursus magna, vel scelerisque nisl consectetur.

[Previous](https://v3.bootcss.com/javascript/#carousel-example-captions) [Next](https://v3.bootcss.com/javascript/#carousel-example-captions)

```
<div class="item">
  <img src="..." alt="...">
  <div class="carousel-caption">
    <h3>...</h3>
    <p>...</p>
  </div>
</div>
```

## [](https://v3.bootcss.com/javascript/#carousel-usage)Usage

### [](https://v3.bootcss.com/javascript/#multiple-carousels)Multiple carousels

Carousels require the use of an `id` on the outermost container (the `.carousel`) for carousel controls to function properly. When adding multiple carousels, or when changing a carousel's `id`, be sure to update the relevant controls.

### [](https://v3.bootcss.com/javascript/#via-data-attributes-2)Via data attributes

Use data attributes to easily control the position of the carousel. `data-slide` accepts the keywords `prev` or `next`, which alters the slide position relative to its current position. Alternatively, use `data-slide-to` to pass a raw slide index to the carousel `data-slide-to="2"`, which shifts the slide position to a particular index beginning with `0`.

The `data-ride="carousel"` attribute is used to mark a carousel as animating starting at page load. **It cannot be used in combination with (redundant and unnecessary) explicit JavaScript initialization of the same carousel.**

### [](https://v3.bootcss.com/javascript/#via-javascript-2)Via JavaScript

Call carousel manually with:

```
$('.carousel').carousel()
```

### [](https://v3.bootcss.com/javascript/#carousel-options)Options

Options can be passed via data attributes or JavaScript. For data attributes, append the option name to `data-`, as in `data-interval=""`.

| Name | type | default | description |
| --- | --- | --- | --- |
| interval | number | 5000 | The amount of time to delay between automatically cycling an item. If false, carousel will not automatically cycle. |
| pause | string | null | "hover" | If set to `"hover"`, pauses the cycling of the carousel on `mouseenter` and resumes the cycling of the carousel on `mouseleave`. If set to `null`, hovering over the carousel won't pause it. |
| wrap | boolean | true | Whether the carousel should cycle continuously or have hard stops. |
| keyboard | boolean | true | Whether the carousel should react to keyboard events. |

### [](https://v3.bootcss.com/javascript/#carousel-methods)Methods

#### [](https://v3.bootcss.com/javascript/#carousel-options-1)`.carousel(options)`

Initializes the carousel with an optional options `object` and starts cycling through items.

```
$('.carousel').carousel({
  interval: 2000
})
```

#### [](https://v3.bootcss.com/javascript/#carousel-cycle)`.carousel('cycle')`

Cycles through the carousel items from left to right.

#### [](https://v3.bootcss.com/javascript/#carousel-pause)`.carousel('pause')`

Stops the carousel from cycling through items.

#### [](https://v3.bootcss.com/javascript/#carousel-number)`.carousel(number)`

Cycles the carousel to a particular frame (0 based, similar to an array).

#### [](https://v3.bootcss.com/javascript/#carousel-prev)`.carousel('prev')`

Cycles to the previous item.

#### [](https://v3.bootcss.com/javascript/#carousel-next)`.carousel('next')`

Cycles to the next item.

### [](https://v3.bootcss.com/javascript/#carousel-events)Events

Bootstrap's carousel class exposes two events for hooking into carousel functionality.

Both events have the following additional properties:

-   `direction`: The direction in which the carousel is sliding (either `"left"` or `"right"`).
-   `relatedTarget`: The DOM element that is being slid into place as the active item.

All carousel events are fired at the carousel itself (i.e. at the `<div class="carousel">`).

| Event Type | Description |
| --- | --- |
| slide.bs.carousel | This event fires immediately when the `slide` instance method is invoked. |
| slid.bs.carousel | This event is fired when the carousel has completed its slide transition. |

```
$('#myCarousel').on('slide.bs.carousel', function () {
  // do something…
})
```

## [](https://v3.bootcss.com/javascript/#affix-examples)Example

The affix plugin toggles `position: fixed;` on and off, emulating the effect found with [`position: sticky;`](https://developer.mozilla.org/en-US/docs/Web/CSS/position#Sticky_positioning). The subnavigation on the right is a live demo of the affix plugin.

___

## [](https://v3.bootcss.com/javascript/#affix-usage)Usage

Use the affix plugin via data attributes or manually with your own JavaScript. **In both situations, you must provide CSS for the positioning and width of your affixed content.**

Note: Do not use the affix plugin on an element contained in a relatively positioned element, such as a pulled or pushed column, due to a [Safari rendering bug](https://github.com/twbs/bootstrap/issues/12126).

### [](https://v3.bootcss.com/javascript/#positioning-via-css)Positioning via CSS

The affix plugin toggles between three classes, each representing a particular state: `.affix`, `.affix-top`, and `.affix-bottom`. You must provide the styles, with the exception of `position: fixed;` on `.affix`, for these classes yourself (independent of this plugin) to handle the actual positions.

Here's how the affix plugin works:

1.  To start, the plugin adds `.affix-top` to indicate the element is in its top-most position. At this point no CSS positioning is required.
2.  Scrolling past the element you want affixed should trigger the actual affixing. This is where `.affix` replaces `.affix-top` and sets `position: fixed;` (provided by Bootstrap's CSS).
3.  If a bottom offset is defined, scrolling past it should replace `.affix` with `.affix-bottom`. Since offsets are optional, setting one requires you to set the appropriate CSS. In this case, add `position: absolute;` when necessary. The plugin uses the data attribute or JavaScript option to determine where to position the element from there.

Follow the above steps to set your CSS for either of the usage options below.

### [](https://v3.bootcss.com/javascript/#via-data-attributes-3)Via data attributes

To easily add affix behavior to any element, just add `data-spy="affix"` to the element you want to spy on. Use offsets to define when to toggle the pinning of an element.

```
<div data-spy="affix" data-offset-top="60" data-offset-bottom="200">
  ...
</div>
```

### [](https://v3.bootcss.com/javascript/#via-javascript-3)Via JavaScript

Call the affix plugin via JavaScript:

```
$('#myAffix').affix({
  offset: {
    top: 100,
    bottom: function () {
      return (this.bottom = $('.footer').outerHeight(true))
    }
  }
})
```

### [](https://v3.bootcss.com/javascript/#affix-options)Options

Options can be passed via data attributes or JavaScript. For data attributes, append the option name to `data-`, as in `data-offset-top="200"`.

| Name | type | default | description |
| --- | --- | --- | --- |
| offset | number | function | object | 10 | Pixels to offset from screen when calculating position of scroll. If a single number is provided, the offset will be applied in both top and bottom directions. To provide a unique, bottom and top offset just provide an object `offset: { top: 10 }` or `offset: { top: 10, bottom: 5 }`. Use a function when you need to dynamically calculate an offset. |
| target | selector | node | jQuery element | the `window` object | Specifies the target element of the affix. |

### [](https://v3.bootcss.com/javascript/#affix-methods)Methods

#### [](https://v3.bootcss.com/javascript/#affix-options-1)`.affix(options)`

Activates your content as affixed content. Accepts an optional options `object`.

```
$('#myAffix').affix({
  offset: 15
})
```

#### [](https://v3.bootcss.com/javascript/#affix-checkposition)`.affix('checkPosition')`

Recalculates the state of the affix based on the dimensions, position, and scroll position of the relevant elements. The `.affix`, `.affix-top`, and `.affix-bottom` classes are added to or removed from the affixed content according to the new state. This method needs to be called whenever the dimensions of the affixed content or the target element are changed, to ensure correct positioning of the affixed content.

```
$('#myAffix').affix('checkPosition')
```

### [](https://v3.bootcss.com/javascript/#affix-events)Events

Bootstrap's affix plugin exposes a few events for hooking into affix functionality.

| Event Type | Description |
| --- | --- |
| affix.bs.affix | This event fires immediately before the element has been affixed. |
| affixed.bs.affix | This event is fired after the element has been affixed. |
| affix-top.bs.affix | This event fires immediately before the element has been affixed-top. |
| affixed-top.bs.affix | This event is fired after the element has been affixed-top. |
| affix-bottom.bs.affix | This event fires immediately before the element has been affixed-bottom. |
| affixed-bottom.bs.affix | This event is fired after the element has been affixed-bottom. |