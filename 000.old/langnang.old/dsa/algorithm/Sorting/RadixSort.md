# 基数排序

> 基数排序（radix sort）属于“分配式排序”（distribution sort），又称“桶子法”（bucket sort）或 bin sort，顾名思义，它是透过键值的部份资讯，将要排序的元素分配至某些“桶”中，藉以达到排
> 序的作用，基数排序法是属于稳定性的排序，其时间复杂度为 O (nlog(r)m)，其中 r 为所采取的基数，而 m 为堆数，在某些时候，基数排序法的效率高于其它的稳定性排序法。

## 算法原理

1. 取得数组中的最大数，并取得位数；
2. arr 为原始数组，从最低位开始取每个位组成 radix 数组；
3. 对 radix 进行计数排序（利用计数排序适用于小范围数的特点）；

> 取最大值及其位数,取元素的每个位组成技术序列,进行计数排序

## 算法演示

![](https://forum.mianbaoban.cn/data/attachment/forum/201803/20/140204ezq2fmi0pm2o9bb9.gif)

## 算法分析

### 时间复杂度

- 最好时间复杂度 O(n\*k)
- 最坏时间复杂度 O(n\*k)
- 平均时间复杂度 O(n\*k)

### 空间复杂度

### 稳定性

>

## 代码实现

<!-- <code-group>
<code-block title="JavaScript">
<<< @/scripts/js/algorithm/radixSort.js
</code-block>
</code-group> -->

## 参考

- [](https://baike.baidu.com/item/%E5%9F%BA%E6%95%B0%E6%8E%92%E5%BA%8F)
