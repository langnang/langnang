---
title: 希尔排序·ShellSort
description: 设置增量序列/因子,分割数组进行插入排序,直至增量因子为 1
---

# 希尔排序·ShellSort

希尔排序(Shell's Sort)是插入排序的一种又称“缩小增量排序”（Diminishing Increment Sort），是直接插入排序算法的一种更高效的改进版本。希尔排序是非稳定排序算法。该方法因 D.L.Shell 于
1959 年提出而得名。

希尔排序是把记录按下标的一定增量分组，对每组使用直接插入排序算法排序；随着增量逐渐减少，每组包含的关键词越来越多，当增量减至 1 时，整个文件恰被分成一组，算法便终止。

## 算法原理

> 设置增量序列/因子,分割数组进行插入排序,直至增量因子为 1

1. 选择一个增量序列 t1，t2，…，tk，其中 ti>tj，tk=1；
2. 按增量序列个数 k，对序列进行 k 趟排序；
3. 每趟排序，根据对应的增量 ti，将待排序列分割成若干长度为 m 的子序列，分别对各子表进行直接插入排序。仅增量因子为 1 时，整个序列作为一个表来处理，表长度即为整个序列的长度。

## 实例演示

![](./ShellSort.gif)

## 算法分析

### 时间复杂度

- 最好时间复杂度 ![](<https://latex.codecogs.com/png.latex?O(nlog^{2}n)>)
- 最坏时间复杂度 ![](<https://latex.codecogs.com/png.latex?O(nlog^{2}n)>)
- 平均时间复杂度 O(nlog2n)

### 空间复杂度

- 平均空间复杂度

### 稳定性

不稳定排序算法

由于多次插入排序，我们知道一次插入排序是稳定的，不会改变相同元素的相对顺序，但在不同的插入排序过程中，相同的元素可能在各自的插入排序中移动，最后其稳定性就会被打乱，所以 shell 排序
是不稳定的。

## 代码实现

<!-- <code-group>
<code-block title="JavaScript">
<<< @/scripts/js/algorithm/shellSort.js
</code-block>
</code-group> -->

## 参考

- [希尔排序\_百度百科](https://baike.baidu.com/item/%E5%B8%8C%E5%B0%94%E6%8E%92%E5%BA%8F)
