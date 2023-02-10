# SimpleSnabbdom

[snabbdom](https://github.com/snabbdom/snabbdom)| [simple-snabbdom](https://github.com/langnang/simple-snabbdom)

## vnode

```puml
left to right direction
class Node{
  tagName
  innerText
  others
}
class Vnode{
  sel: String
  data: <Object Attributes>
  children: <Array Vnode>
  text: String
  elm: <DOM>
  key: String
}

Node::tagName --> Vnode::sel
Node::innerText --> Vnode::text
Node::others --> Vnode::data
```

## h

根据传参的个数以及类型，动态生成虚拟 DOM

**示例**

```javascript
h("div", {}, "文字");
```

```json
{
  "sel": "div",
  "data": {},
  "text": "文字"
}
```

```javascript
h("ul", {}, []);
```

```json
{
  "sel": "ul",
  "data": {},
  "children": []
}
```

```javascript
h("ul", {}, h());
```

```json
{
  "sel": "ul",
  "data": {},
  "children": [
    {
      "sel": "li",
      "data": {},
      "text": "文字"
    }
  ]
}
```

## createElement

```mermaid
flowchart LR
  start("Start") --> ?hasText{"vnode 是不是文本"}
  ?hasText --> |是文本| hasTextEqualTrue["element.innerHTML = vnode.text"]-->ed
  ?hasText --> |不是文本| ?hasChildren{"vnode 有没有子节点"}
  ?hasChildren --> |有子节点| hasChildrenEqualTrue["遍历children\n递归创建子节点\n并将创建的子节点添加到当前节点"]-->ed
  ?hasChildren --> |没有子节点|ed
  ed("End 并返回创建节点")
```

**示例**

```javascript
createElement(h("div", {}, "文字")).nodeType === 1;
// true
createElement(h("ul", {}, [])).nodeType === 1;
// true
createElement(h("ul", {}, h("li", {}, "文字"))).nodeType === 1;
// true
```

## patch

修补节点

```mermaid
flowchart LR
  patchStart([Patch 函数被调用]) --> ?isVnode{"oldVnode \n是虚拟节点\n还是DOM节点？"}
  ?isVnode --> |是 DOM 节点|isVnodeEqualTrue[将 oldVnode 包装为虚拟节点]-->?isSameVnode{"oldVnode 和 newVnode \n是不是同一节点\n(sel 和 key 都相同)？"}
  ?isVnode --> |是虚拟节点|?isSameVnode
  ?isSameVnode --> |不是|isSameVnodeEqualFalse["暴力删除旧的，插入新的"]
  ?isSameVnode --> |是|isSameVnodeEqualTrue["精细化比较"]
```

**示例**

```javascript
const example01 = h("div", {}, "文字");
const example02 = h("ul", {}, []);
const example03 = h("ul", {}, h("li", {}, "文字"));
patch(container, example01);
patch(container, example03);
```

## patchVnode

```mermaid
flowchart LR
  patchVnodeStart(["patchVnode"]) --> ?isSameObject{"oldVnode 和 newVnode \n就是内存中的同一对象？"}
    ?isSameObject --> |是| isSameObjectEqualTrue["什么都不用做"]
    ?isSameObject --> |不是| ?hasPropertyText{"newVnode \n有没有 text 属性？"}
    ?hasPropertyText --> |"没有(意味着newVnode有children)"| ?hasPropertyChildren{"oldVnode 有没有 children"}
    ?hasPropertyChildren --> |有| hasPropertyChildrenEqualTrue{{"最复杂的情况，\n就是新旧vnode都有children，\n此时就要精选最优雅的diff"}}
    ?hasPropertyChildren --> |"没有（意味着oldVnode有text）"| hasPropertyChildrenEqualFalse["1：清空oldVnode中的text。\n2：并且把newVnode的children添加到DOM中。"]
    ?hasPropertyText --> |有| ?isEqualPropertyText{"newVnode 的 text 和oldVnode 是否相同？"}
    ?isEqualPropertyText --> |相同| E["什么都不用做"]
    ?isEqualPropertyText --> |不同| F["把elm中的innerText改变为newVnode的text"]
```

**示例**

```javascript
const example01 = h("div", {}, "文字");
const example02 = h("ul", {}, []);
const example03 = h("ul", {}, h("li", {}, "文字"));
patch(container, example01);
patch(container, example03);
```

## updateChildren

新旧节点都有子节点的情况下，diff 更新新旧子节点

**语法**

```js
updateChildren(newChildren, oldChildren, parent);
```

```mermaid
flowchart TD

start("Start")
ed("End")

  subgraph traverseCompare ["traverseCompare: 遍历比对新旧子节点"]
    step1{"1. 命中新前与旧前"}
      step1 --> |True| step1IsTrue["移动对应指针"]
      step1 --> |False| step2
    step2{"2. 命中新后与旧后"}
      step2 --> step2IsTrue["移动对应指针"]
      step2 --> |False| step3
    step3{"3. 命中新后与旧前"}
      step3 --> step3IsTrue["移动命中的oldStartVnode至oldEndVnode的后，\n移动对应指针"]
      step3 --> |False| step4
    step4{"4. 命中新前与旧后"}
      step4 --> step4IsTrue["移动命中的oldEndVnode至oldStartVnode前，\n移动对应指针"]
      step4 --> |False| violenceCompare
    violenceCompare["命中失败，\n直接暴力查找单个新节点在旧节点中的位置"]-->
    newStartVnodeIsInOld{"检测newStartVnode是否存在于旧节点中"}
    newStartVnodeIsInOld-->|Fasle| newStartVnodeIsInOld?IsFalse["转换为DOM，\n并插入到旧节点oldStartVnode之前"]
    newStartVnodeIsInOld-->|True| newStartVnodeIsInOld?IsTrue["移动节点至oldStartVnode之前"]
  end

start --> traverseCompare

traverseCompare --> handleRemainingNodes("处理剩余节点")
handleRemainingNodes-->newHasRemainingNodes{"新节点是否有剩余节点"} --> |True|newHasRemainingNodesIsTrue["添加剩余节点"]
handleRemainingNodes-->oldHasRemainingNodes{"旧节点是否有剩余节点"} --> |True|oldHasRemainingNodesIsTrue["删除剩余节点"]

newHasRemainingNodesIsTrue --> ed
oldHasRemainingNodesIsTrue --> ed
```

```mermaid
flowchart TB
  subgraph patchVnode ["patchVnode: 修补节点"]
  end
  subgraph updateChildren ["updateChildren: 新旧节点都有子节点"]
    subgraph traverseCompare ["traverseCompare: 遍历比对新旧子节点"]
        step1{"1. 命中新前与旧前"}
            step1 --> |True| step1IsTrue["移动对应指针"]
            step1 --> |False| step2
        step2{"2. 命中新后与旧后"}
            step2 --> step2IsTrue["移动对应指针"]
            step2 --> |False| step3
        step3{"3. 命中新后与旧前"}
            step3 --> step3IsTrue["移动命中的oldStartVnode至oldEndVnode的后，\n移动对应指针"]
            step3 --> |False| step4
        step4{"4. 命中新前与旧后"}
            step4 --> step4IsTrue["移动命中的oldEndVnode至oldStartVnode前，\n移动对应指针"]
            step4 --> |False| violenceCompare
        violenceCompare["命中失败，\n直接暴力查找单个新节点在旧节点中的位置"]-->
            newStartVnodeIsInOld{"检测newStartVnode是否存在于旧节点中"}
                newStartVnodeIsInOld-->|Fasle| newStartVnodeIsInOld?IsFalse["转换为DOM，\n并插入到旧节点oldStartVnode之前"]
                newStartVnodeIsInOld-->|True| newStartVnodeIsInOld?IsTrue["移动节点至oldStartVnode之前"]
    end
    traverseCompare --> handleRemainingNodes("处理剩余节点")
    handleRemainingNodes-->newHasRemainingNodes{"新节点是否有剩余节点"} --> |True|newHasRemainingNodesIsTrue["添加剩余节点"]
    handleRemainingNodes-->oldHasRemainingNodes{"旧节点是否有剩余节点"} --> |True|oldHasRemainingNodesIsTrue["删除剩余节点"]
  end

  start("Start")-->patchVnode
  patchVnode-->updateChildren
  updateChildren-->ed("End")
```
