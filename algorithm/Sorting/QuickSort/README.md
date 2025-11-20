---
title: 快速排序·QuickSort
description: 根据基准值分割序列,左侧小于,右侧大于,递归执行后合并
---

# 快速排序·QuickSort

快速排序（Quicksort）是对冒泡排序的一种改进。

快速排序由 C. A. R. Hoare 在 1960 年提出。

它的基本思想是：通过一趟排序将要排序的数据分割成独立的两部分，其中一部分的所有数据都比另外一部分的所有数据都要小，然后再按此方法对这两部分数据分别进行快速排序，整个排序过程可以递归
进行，以此达到整个数据变成有序序列。

## 算法原理

> 根据基准值分割序列,左侧小于,右侧大于,递归执行后合并

1. 从数列中挑出一个元素，称为 “基准”（pivot）；
2. 重新排序数列，所有元素比基准值小的摆放在基准前面，所有元素比基准值大的摆在基准的后面（相同的数可以到任一边）。在这个分区退出之后，该基准就处于数列的中间位置。这个称为分区
   （partition）操作；
3. 递归地（recursive）把小于基准值元素的子数列和大于基准值元素的子数列排序。

## 实例演示

![](./QuickSort.gif)

```c
// 快速排序
array:  [6] [3] [9] [4] [7] [1] [5] [2] [8] [0];pivot:
// 快速排序结束
```

## 算法分析

### 时间复杂度

- 最好时间复杂度 ![](<https://latex.codecogs.com/png.latex?O(nlogn);>)
- 最坏时间复杂度 ![](<https://latex.codecogs.com/png.latex?O(n^{2})>)
- 平均时间复杂度 ![](<https://latex.codecogs.com/png.latex?O(nlogn);>)

### 空间复杂度

- 平均空间复杂度 ![](<https://latex.codecogs.com/png.latex?O(nlogn);>)

### 稳定性

不稳定排序算法

## 代码实现

<!-- <code-group>
<code-block title="JavaScript">
<<< @/scripts/js/algorithm/quickSort.js
</code-block>
</code-group> -->

## 参考

- [快速排序算法\_百度百科](https://baike.baidu.com/item/%E5%BF%AB%E9%80%9F%E6%8E%92%E5%BA%8F%E7%AE%97%E6%B3%95/369842)
