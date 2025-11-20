---
title: 冒泡排序·BubbleSort
description: 重复遍历比较相邻元素，将最大/小元素移至末尾，并逐渐减少遍历长度
---

# 冒泡排序

冒泡排序（Bubble Sort），是一种计算机科学领域的较简单的排序算法。

它重复地走访过要排序的元素列，依次比较两个相邻的元素，如果他们的顺序（如从大到小、首字母从 A 到 Z）错误就把他们交换过来。走访元素的工作是重复地进行直到没有相邻元素需要交换，也就是
说该元素列已经排序完成。

这个算法的名字由来是因为越大的元素会经由交换慢慢“浮”到数列的顶端（升序或降序排列），就如同碳酸饮料中二氧化碳的气泡最终会上浮到顶端一样，故名“冒泡排序”。

## 算法原理

> 重复遍历比较相邻元素，将最大/小元素移至末尾，并逐渐减少遍历长度

1. 比较相邻的元素。如果第一个比第二个大，就交换他们两个。
2. 对每一对相邻元素做同样的工作，从开始第一对到结尾的最后一对。在这一点，最后的元素应该会是最大的数。
3. 针对所有的元素重复以上的步骤，除了最后一个。
4. 持续每次对越来越少的元素重复上面的步骤，直到没有任何一对数字需要比较。

```mermaid
flowchart TB
start("BubbleSort(array)")-->op("for (const i = 0; i < array.length - 1; i++)")-->cond("array[i] > array[i + 1]?")
cond--Yes-->io("[array[i], array[i + 1]] = [array[i + 1], array[i]]")
cond--No-->op
End
```

@flowstart
st=>start: Start
e=>end: End
op1=>operation: for (const i = 0; i < array.length - 1; i++)
sub1=>subroutine: My Subroutine
cond=>condition: array[i] > array[i + 1]
io=>inputoutput: [array[i], array[i + 1]] = [array[i + 1], array[i]]
para=>parallel: parallel tasks

st->op1->cond
cond(yes)->io->e
cond(no)->para
para(path1, bottom)->sub1(right)->op1
para(path2, top)->op1

@flowend

## 实例演示

![](./BubbleSort.gif)

```sh
// 第一次冒泡
array:  [6] [3] [9] [4] [7] [1] [5] [2] [8] [0]
         └───┘ 6>3;tmp=array[0];array[0]=array[1];array[1]=tmp;
        [3] [6] [9] [4] [7] [1] [5] [2] [8] [0]
             └───┘ 6<9;不交换
        [3] [6] [9] [4] [7] [1] [5] [2] [8] [0]
                 └───┘ 9>4;交换
        [3] [6] [4] [9] [7] [1] [5] [2] [8] [0]
                     └───┘ 9>7;交换
        [3] [6] [4] [7] [9] [1] [5] [2] [8] [0]
                         └───┘ 9>1;交换
        [3] [6] [4] [7] [1] [9] [5] [2] [8] [0]
                             └───┘ 9>5;交换
        [3] [6] [4] [7] [1] [5] [9] [2] [8] [0]
                                 └───┘ 9>2;交换
        [3] [6] [4] [7] [1] [5] [2] [9] [8] [0]
                                     └───┘ 9>8;交换
        [3] [6] [4] [7] [1] [5] [2] [8] [9] [0]
                                         └───┘ 9>0;交换
        [3] [6] [4] [7] [1] [5] [2] [8] [0] [9]
// 第一次冒泡结束
```

```sh
// 第二次冒泡
array:  [3] [6] [4] [7] [1] [5] [2] [8] [0] [9]
         └───┘ 6>3;不交换
        [3] [6] [4] [7] [1] [5] [2] [8] [0] [9]
             └───┘ 4<6;交换
        [3] [4] [6] [7] [1] [5] [2] [8] [0] [9]
                 └───┘ 7>6;不交换
        [3] [4] [6] [7] [1] [5] [2] [8] [0] [9]
                     └───┘ 1<7;交换
        [3] [4] [6] [1] [7] [5] [2] [8] [0] [9]
                         └───┘ 5<7;交换
        [3] [4] [6] [1] [5] [7] [2] [8] [0] [9]
                             └───┘ 2<7;交换
        [3] [4] [6] [1] [5] [2] [7] [8] [0] [9]
                                 └───┘ 8>7;不交换
        [3] [4] [6] [1] [5] [2] [7] [8] [0] [9]
                                     └───┘ 0<8;交换
        [3] [4] [6] [1] [5] [2] [7] [0] [8] [9]
// 第二次冒泡结束
```

...

```sh
// 第N-1次冒泡
array:  [1] [0] [2] [3] [4] [5] [6] [7] [8] [9]
         └───┘ 0<1;交换
        [0] [1] [2] [3] [4] [5] [6] [7] [8] [9]
// 第N-1次冒泡结束
```

## 算法分析

### 时间复杂度

- 最好时间复杂度 $C_{min}=n-1;M_{min}=0;O(n);$
- 最坏时间复杂度 $C_{max}=\frac{n(n-1)}{2}=O(n^2);M_{max}=\frac{3n(n-1)}{2}=O(n^2);O(n^2);$
- 平均时间复杂度 $O(n^2);$

### 空间复杂度

- 最好空间复杂度 $0;$
- 最坏空间复杂度 $O(n);$
- 平均空间复杂度 $O(1);$

### 稳定性

**稳定排序算法**

冒泡排序就是把小的元素往前调或者把大的元素往后调。比较是相邻的两个元素比较，交换也发生在这两个元素之间。

所以，如果两个元素相等，是不会再交换的；如果两个相等的元素没有相邻，那么即使通过前面的两两交换把两个相邻起来，这时候也不会交换。

所以相同元素的前后顺序并没有改变，所以冒泡排序是一种**稳定**排序算法。

## 代码实现

```js
function BubbleSort(array) {
  for (let i = 0; i <= array.length - 1; i++) {}
}
```

<!-- <code-group>
<code-block title="JavaScript">
<<< @/scripts/js/algorithm/bubbleSort.js
</code-block>
<code-block title="PHP">
<<< @/scripts/php/algorithm/bubbleSort.php
</code-block>
</code-group> -->

<CodeSwitcher :languages="{js:'JavaScript',ts:'TypeScript'}">

  <template v-slot:js>

```js
module.exports = function (str) {
  return typeof str === "string" && str.trim() === str;
};
```

  </template>
  <template v-slot:ts>

```ts
export default function isString(str: string): str is string {
  return typeof str === "string" && str.trim() === str;
}
```

  </template>
</CodeSwitcher>

## 参考

- [冒泡排序\_百度百科](https://baike.baidu.com/item/%E5%86%92%E6%B3%A1%E6%8E%92%E5%BA%8F)
