# HTML DOM 元素对象

## HTML DOM 节点

在 HTML DOM (Document Object Model) 中, 每个东西都是 **节点** :

- 文档本身就是一个文档对象
- 所有 HTML 元素都是元素节点
- 所有 HTML 属性都是属性节点
- 插入到 HTML 元素文本是文本节点
- 注释是注释节点

## 元素对象

在 HTML DOM 中, **元素对象**代表着一个 HTML 元素。

元素对象 的 **子节点**可以是, 可以是元素节点，文本节点，注释节点。

**NodeList 对象** 代表了节点列表，类似于 HTML 元素的子节点集合。

元素可以有属性。属性属于属性节点（查看下一章节）。

## 属性

| 属性                        | 描述                                                   |
| :-------------------------- | :----------------------------------------------------- |
| `element.accessKey`         | 设置或返回 accesskey 一个元素                          |
| `element.attributes`        | 返回一个元素的属性数组                                 |
| `element.childNodes`        | 返回元素的一个子节点的数组                             |
| `element.classlist`         | 返回元素的类名，作为 DOMTokenList 对象。               |
| `element.className`         | 设置或返回元素的 class 属性                            |
| `element.clientHeight`      | 在页面上返回内容的可视高度（不包括边框，边距或滚动条） |
| `element.clientWidth`       | 在页面上返回内容的可视宽度（不包括边框，边距或滚动条） |
| `element.contentEditable`   | 设置或返回元素的内容是否可编辑                         |
| `element.dir`               | 设置或返回一个元素中的文本方向                         |
| `element.firstChild`        | 返回元素的第一个子节点                                 |
| `element.id`                | 设置或者返回元素的 id。                                |
| `element.innerHTML`         | 设置或者返回元素的内容。                               |
| `element.isContentEditable` | 如果元素内容可编辑返回 true，否则返回 false            |
| `element.lang`              | 设置或者返回一个元素的语言。                           |
| `element.lastChild`         | 返回的最后一个子元素                                   |
| `element.namespaceURI`      | 返回命名空间的 URI。                                   |
| `element.nextSibling`       | 返回该元素紧跟的一个元素                               |
| `element.nodeName`          | 返回元素的标记名（大写）                               |
| `element.nodeType`          | Returns the node type of an element                    |
| `element.nodeValue`         | 返回元素的类型                                         |
| `element.offsetHeight`      | 返回，任何一个元素的高度包括边框和填充，但不是边距     |
| `element.offsetWidth`       | 返回元素的宽度，包括边框和填充，但不是边距             |
| `element.offsetLeft`        | 返回当前元素的相对水平偏移位置的偏移容器               |
| `element.offsetParent`      | 返回元素的偏移容器                                     |
| `element.offsetTop`         | 返回当前元素的相对垂直偏移位置的偏移容器               |
| `element.ownerDocument`     | 返回元素的根元素（文档对象）                           |
| `element.parentNode`        | 返回元素的父节点                                       |
| `element.previousSibling`   | 返回某个元素紧接之前元素                               |
| `element.scrollHeight`      | 返回整个元素的高度（包括带滚动条的隐蔽的地方）         |
| `element.scrollLeft`        | 返回当前视图中的实际元素的左边缘和左边缘之间的距离     |
| `element.scrollTop`         | 返回当前视图中的实际元素的顶部边缘和顶部边缘之间的距离 |
| `element.scrollWidth`       | 返回元素的整个宽度（包括带滚动条的隐蔽的地方）         |
| `element.style`             | 设置或返回元素的样式属性                               |
| `element.tabIndex`          | 设置或返回元素的标签顺序。                             |
| `element.tagName`           | 作为一个字符串返回某个元素的标记名（大写）             |
| `element.textContent`       | 设置或返回一个节点和它的文本内容                       |
| `element.title`             | 设置或返回元素的 title 属性                            |
| `nodelist.length`           | 返回节点列表的节点数目。                               |

### `element.accessKey`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-html-accesskey.html)

accessKey 属性可设置或返回访问单选按钮的快捷键。

::: warning

请使用 Alt + accessKey 为拥有指定快捷键的元素赋予焦点。

:::

**语法**

```js
HTMLElementObject.accessKey = accessKey;
```

### `element.attributes`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-node-attributes.html)

返回一个元素的属性数组

### `element.childNodes`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-node-childnodes.html)

返回元素的一个子节点的数组

### `element.classlist`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-element-classlist.html)

返回元素的类名，作为 DOMTokenList 对象。

### `element.className`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-html-classname.html)

设置或返回元素的 class 属性

### `element.clientHeight`

在页面上返回内容的可视高度（不包括边框，边距或滚动条）

### `element.clientWidth`

在页面上返回内容的可视宽度（不包括边框，边距或滚动条）

### `element.contentEditable`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-html-contenteditable.html)

设置或返回元素的内容是否可编辑

### `element.dir`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-html-dir.html)

设置或返回一个元素中的文本方向

### `element.firstChild`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-node-firstchild.html)

返回元素的第一个子节点

### `element.id`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-html-id.html)

设置或者返回元素的 id。

### `element.innerHTML`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-html-innerhtml.html)

设置或者返回元素的内容。

### `element.isContentEditable`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-html-iscontenteditable.html)

如果元素内容可编辑返回 true，否则返回 false

### `element.lang`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-html-lang.html)

设置或者返回一个元素的语言。

### `element.lastChild`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-node-lastchild.html)

返回的最后一个子元素

### `element.namespaceURI`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-node-namespaceuri.html)

返回命名空间的 URI。

### `element.nextSibling`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-node-nextsibling.html)

返回该元素紧跟的一个元素

### `element.nodeName`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-node-nodename.html)

返回元素的标记名（大写）

### `element.nodeType`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-node-nodetype.html)

Returns the node type of an element

### `element.nodeValue`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-node-nodevalue.html)

返回元素的类型

### `element.offsetHeight`

返回，任何一个元素的高度包括边框和填充，但不是边距

### `element.offsetWidth`

返回元素的宽度，包括边框和填充，但不是边距

### `element.offsetLeft`

返回当前元素的相对水平偏移位置的偏移容器

### `element.offsetParent`

返回元素的偏移容器

### `element.offsetTop`

返回当前元素的相对垂直偏移位置的偏移容器

### `element.ownerDocument`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-node-ownerdocument.html)

返回元素的根元素（文档对象）

### `element.parentNode`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-node-parentnode.html)

返回元素的父节点

### `element.previousSibling`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-node-previoussibling.html)

返回某个元素紧接之前元素

### `element.scrollHeight`

返回整个元素的高度（包括带滚动条的隐蔽的地方）

### `element.scrollLeft`

返回当前视图中的实际元素的左边缘和左边缘之间的距离

### `element.scrollTop`

返回当前视图中的实际元素的顶部边缘和顶部边缘之间的距离

### `element.scrollWidth`

返回元素的整个宽度（包括带滚动条的隐蔽的地方）

### `element.style`

设置或返回元素的样式属性

### `element.tabIndex`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-html-tabindex.html)

设置或返回元素的标签顺序。

### `element.tagName`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-element-tagname.html)

作为一个字符串返回某个元素的标记名（大写）

### `element.textContent`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-node-textcontent.html)

设置或返回一个节点和它的文本内容

### `element.title`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-html-title.html)

设置或返回元素的 title 属性

### `nodelist.length`

[W3Cschool](https://www.w3cschool.cn/jsref/prop-nodelist-length.html)

返回节点列表的节点数目。

## 方法

| 方法                                | 描述                                                   |
| :---------------------------------- | :----------------------------------------------------- |
| `element.addEventListener()`        | 向指定元素添加事件句柄                                 |
| `element.appendChild()`             | 为元素添加一个新的子元素                               |
| `element.cloneNode()`               | 克隆某个元素                                           |
| `element.compareDocumentPosition()` | 比较两个元素的文档位置。                               |
| `element.focus()`                   | 设置文档或元素获取焦点                                 |
| `element.getAttribute()`            | 返回指定元素的属性值                                   |
| `element.getAttributeNode()`        | 返回指定属性节点                                       |
| `element.getElementsByTagName()`    | 返回指定标签名的所有子元素集合。                       |
| `element. getElementsByClassName()` | 返回文档中所有指定类名的元素集合，作为 NodeList 对象。 |
| `element.getFeature()`              | 返回指定特征的执行 APIs 对象。                         |
| `element.getUserData()`             | 返回一个元素中关联键值的对象。                         |
| `element.hasAttribute()`            | 如果元素中存在指定的属性返回 true，否则返回 false。    |
| `element.hasAttributes()`           | 如果元素有任何属性返回 true，否则返回 false。          |
| `element.hasChildNodes()`           | 返回一个元素是否具有任何子元素                         |
| `element.hasfocus()`                | 返回布尔值，检测文档或元素是否获取焦点                 |
| `element.insertBefore()`            | 现有的子元素之前插入一个新的子元素                     |
| `element.isDefaultNamespace()`      | 如果指定了 namespaceURI 返回 true，否则返回 false。    |
| `element.isEqualNode()`             | 检查两个元素是否相等                                   |
| `element.isSameNode()`              | 检查两个元素所有有相同节点。                           |
| `element.isSupported()`             | 如果在元素中支持指定特征返回 true。                    |
| `element.normalize()`               | 合并相邻的文本节点并删除空的文本节点                   |
| `element.querySelector()`           | 返回匹配指定 CSS 选择器元素的第一个子元素              |
| `document.querySelectorAll()`       | 返回匹配指定 CSS 选择器元素的所有子元素节点列表        |
| `element.removeAttribute()`         | 从元素中删除指定的属性                                 |
| `element.removeAttributeNode()`     | 删除指定属性节点并返回移除后的节点。                   |
| `element.removeChild()`             | 删除一个子元素                                         |
| `element.removeEventListener()`     | 移除由 addEventListener() 方法添加的事件句柄           |
| `element.replaceChild()`            | 替换一个子元素                                         |
| `element.setAttribute()`            | 设置或者改变指定属性并指定值。                         |
| `element.setAttributeNode()`        | 设置或者改变指定属性节点。                             |
| `element.setIdAttribute()`          |                                                        |
| `element.setIdAttributeNode()`      |                                                        |
| `element.setUserData()`             | 在元素中为指定键值关联对象。                           |
| `element.toString()`                | 一个元素转换成字符串                                   |
| `nodelist.item()`                   | 返回某个元素基于文档树的索引                           |

### `element.addEventListener()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-element-addeventlistener.html)

向指定元素添加事件句柄

### `element.appendChild()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-node-appendchild.html)

`appendChild()` 方法可向节点的子节点列表的末尾添加新的子节点。

::: tip

如果文档树中已经存在了 newchild，它将从文档树中删除，然后重新插入它的新位置。如果 newchild 是 DocumentFragment 节点，则不会直接插入它，而是把它的子节点按序插入当前节点的 childNodes[] 数组的末尾。

:::

你可以使用 appendChild() 方法移除元素到另外一个元素。

**语法**

```js
/**
 * @param {HTMLDOMElement} node 节点对象。必须。
 * @returns {HTMLDOMElement}
 */
node.appendChild(node);
```

### `element.cloneNode()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-node-clonenode.html)

克隆某个元素

### `element.compareDocumentPosition()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-node-comparedocumentposition.html)

比较两个元素的文档位置。

### `element.focus()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-html-focus.html)

设置文档或元素获取焦点

### `element.getAttribute()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-element-getattribute.html)

返回指定元素的属性值

### `element.getAttributeNode()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-element-getattributenode.html)

返回指定属性节点

### `element.getElementsByTagName()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-element-getelementsbytagname.html)

返回指定标签名的所有子元素集合。

### `element. getElementsByClassName()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-element-getelementsbyclassname.html)

返回文档中所有指定类名的元素集合，作为 NodeList 对象。

### `element.getFeature()`

返回指定特征的执行 APIs 对象。

### `element.getUserData()`

返回一个元素中关联键值的对象。

### `element.hasAttribute()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-element-hasattribute.html)

如果元素中存在指定的属性返回 true，否则返回 false。

### `element.hasAttributes()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-node-hasattributes.html)

如果元素有任何属性返回 true，否则返回 false。

### `element.hasChildNodes()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-node-haschildnodes.html)

返回一个元素是否具有任何子元素

### `element.hasfocus()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-document-hasfocus.html)

返回布尔值，检测文档或元素是否获取焦点

### `element.insertBefore()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-node-insertbefore.html)

现有的子元素之前插入一个新的子元素

### `element.isDefaultNamespace()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-node-isdefaultnamespace.html)

如果指定了 namespaceURI 返回 true，否则返回 false。

### `element.isEqualNode()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-node-isequalnode.html)

检查两个元素是否相等

### `element.isSameNode()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-node-issamenode.html)

检查两个元素所有有相同节点。

### `element.isSupported()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-node-issupported.html)

如果在元素中支持指定特征返回 true。

### `element.normalize()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-node-normalize.html)

使得此成为一个"normal"的形式，其中只有结构（如元素，注释，处理指令，CDATA 节和实体引用）隔开 Text 节点，即元素（包括属性）下面的所有文本节点，既没有相邻的文本节点也没有空的文本节点

**语法**

```js
/**
 * @param
 * @return
 */
node.normalize();
```

### `element.querySelector()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-element-queryselector.html)

返回匹配指定 CSS 选择器元素的第一个子元素

### document.querySelectorAll()`

返回匹配指定 CSS 选择器元素的所有子元素节点列表

### `element.removeAttribute()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-element-removeattribute.html)

从元素中删除指定的属性

### `element.removeAttributeNode()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-element-removeattributenode.html)

删除指定属性节点并返回移除后的节点。

### `element.removeChild()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-node-removechild.html)

删除一个子元素

### `element.removeEventListener()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-element-removeeventlistener.html)

移除由 addEventListener() 方法添加的事件句柄

### `element.replaceChild()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-node-replacechild.html)

替换一个子元素

### `element.setAttribute()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-element-setattribute.html)

设置或者改变指定属性并指定值。

### `element.setAttributeNode()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-element-setattributenode.html)

设置或者改变指定属性节点。

### `element.setIdAttribute()`

### `element.setIdAttributeNode()`

### `element.setUserData()`

在元素中为指定键值关联对象。

### `element.toString()`

一个元素转换成字符串

### `nodelist.item()`

[W3Cschool](https://www.w3cschool.cn/jsref/met-nodelist-item.html)

返回某个元素基于文档树的索引
