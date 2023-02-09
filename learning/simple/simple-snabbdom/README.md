# SimpleSnabbdom

[snabbdom](https://github.com/snabbdom/snabbdom)| [simple-snabbdom](https://github.com/langnang/simple-snabbdom)

## vnode

## h

## patch

## patchVnode

## updateChildren

> 新旧节点都有子节点的情况下，diff 更新新旧子节点

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
