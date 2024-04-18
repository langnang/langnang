---
sidebarDepth: 6
---

# Array

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array)

> JavaScript 的  Array 对象是用于构造数组的全局对象，数组是类似于列表的高阶对象。

JavaScript 的  **`Array`** 对象是用于构造数组的全局对象，数组是类似于列表的高阶对象。

## 描述

数组是一种类列表对象，它的原型中提供了遍历和修改元素的相关操作。JavaScript 数组的长度和元素类型都是非固定的。因为数组的长度可随时改变，并且其数据在内存中也可以不连续，所以 JavaScript 数组不一定是密集型的，这取决于它的使用方式。一般来说，数组的这些特性会给使用带来方便，但如果这些特性不适用于你的特定使用场景的话，可以考虑使用类型数组 [`TypedArray`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/TypedArray)。

只能用整数作为数组元素的索引，而不能用字符串。后者称为 [关联数组](https://en.wikipedia.org/wiki/Associative_array)。使用非整数并通过 [方括号](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Guide/Working_with_Objects#%E5%AF%B9%E8%B1%A1%E5%92%8C%E5%B1%9E%E6%80%A7) 或 [点号](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Operators/Property_Accessors) 来访问或设置数组元素时，所操作的并不是数组列表中的元素，而是数组对象的 [属性集合](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Data_structures#%E5%B1%9E%E6%80%A7) 上的变量。数组对象的属性和数组元素列表是分开存储的，并且数组的遍历和修改操作也不能作用于这些命名属性。

## 构造器

## 属性

| 属性        | 描述                             |
| :---------- | :------------------------------- |
| constructor | 返回创建数组对象的原型函数。     |
| length      | 设置或返回数组元素的个数。       |
| prototype   | 允许你向数组对象添加属性或方法。 |

### 静态属性

### 实例属性

#### `Array.prototype.length`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/length)

数组中的元素个数

#### `Array.prototype[@@unscopables]`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/@@unscopables)

包含了所有 ES2015 (ES6) 中新定义的、且并未被更早的 ECMAScript 标准收纳的属性名。这些属性被排除在由 [`with`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Statements/with) 语句绑定的环境中

## 方法

| 方法                                  | 描述                                                                         |
| :------------------------------------ | :--------------------------------------------------------------------------- |
| [`concat()`](#array-prototype-concat) | 连接两个或更多的数组，并返回结果。                                           |
| copyWithin()                          | 从数组的指定位置拷贝元素到数组的另一个指定位置中。                           |
| entries()                             | 返回数组的可迭代对象。                                                       |
| every()                               | 检测数组元素的每个元素是否都符合条件。                                       |
| fill()                                | 使用一个固定值来填充数组。                                                   |
| filter()                              | 检测数组元素，并返回符合条件所有元素的数组。                                 |
| find()                                | 返回符合传入测试（函数）条件的数组元素。                                     |
| findIndex()                           | 返回符合传入测试（函数）条件的数组元素索引。                                 |
| forEach()                             | 数组每个元素都执行一次回调函数。                                             |
| from()                                | 通过给定的对象中创建一个数组。                                               |
| indexOf()                             | 搜索数组中的元素，并返回它所在的位置。                                       |
| join()                                | 把数组的所有元素放入一个字符串。                                             |
| lastIndexOf()                         | 返回一个指定的字符串值最后出现的位置，在一个字符串中的指定位置从后向前搜索。 |
| map()                                 | 通过指定函数处理数组的每个元素，并返回处理后的数组。                         |
| pop()                                 | 删除数组的最后一个元素并返回删除的元素。                                     |
| push()                                | 向数组的末尾添加一个或更多元素，并返回新的长度。                             |
| reverse()                             | 反转数组的元素顺序。                                                         |
| shift()                               | 删除数组的第一个元素。                                                       |
| slice()                               | 选取数组的的一部分，并返回一个新数组。                                       |
| some()                                | 检测数组元素中是否有元素符合指定条件。                                       |
| sort()                                | 对数组的元素进行排序。                                                       |
| splice()                              | 从数组中添加或删除元素。                                                     |
| toString()                            | 把数组转换为字符串，并返回结果。                                             |
| unshift()                             | 向数组的开头添加一个或更多元素，并返回新的长度。                             |
| valueOf()                             | 返回数组对象的原始值。                                                       |

### 静态方法

#### `Array.from()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/from)

从类数组对象或者可迭代对象中创建一个新的数组实例

#### `Array.isArray()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/isArray)

用来判断某个变量是否是一个数组对象

#### `Array.of()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/of)

根据一组参数来创建新的数组实例，支持任意的参数数量和类型

### 实例方法

#### `Array.prototype.at()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/at)

Returns the array item at the given index. Accepts negative integers, which count back from the last item.

#### `Array.prototype.concat()`

用于合并两个或多个数组。此方法不会更改现有数组，而是返回一个新数组

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/concat)

**语法**

```js
array.concat(value0, value1, /* … ,*/ valueN);
```

**参数**

- `valueN`: 可选。 数组和/或值，将被合并到一个新的数组中。如果省略了所有 valueN 参数，则 concat 会返回调用此方法的现存数组的一个浅拷贝。详情请参阅下文描述。

**返回值**

新的 Array 实例。

#### `Array.prototype.copyWithin()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/copyWithin)

浅复制数组的一部分到同一数组中的另一个位置，并返回它，不会改变原数组的长度

#### `Array.prototype.entries()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/entries)

返回一个新的 `Array Iterator` 对象，该对象包含数组中每个索引的键/值对

#### `Array.prototype.every()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/every)

测试一个数组内的所有元素是否都能通过某个指定函数的测试。它返回一个布尔值

#### `Array.prototype.fill()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/fill)

用一个固定值填充一个数组中从起始索引到终止索引内的全部元素

#### `Array.prototype.filter()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/filter)

创建一个新数组，其包含通过所提供函数实现的测试的所有元素

#### `Array.prototype.find()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/find)

返回数组中满足提供的测试函数的第一个元素的值。否则返回 `undefined`

#### `Array.prototype.findIndex()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/findIndex)

返回数组中满足提供的测试函数的第一个元素的**索引**。若没有找到对应元素则返回 `-1`

#### `Array.prototype.flat()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/flat)

按照一个可指定的深度递归遍历数组，并将所有元素与遍历到的子数组中的元素合并为一个新数组返回

#### `Array.prototype.flatMap()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/flatMap)

使用映射函数映射每个元素，然后将结果压缩成一个新数组

#### `Array.prototype.forEach()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/forEach)

对数组的每个元素执行一次给定的函数

#### `Array.prototype.includes()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/includes)

判断一个数组是否包含一个指定的值，如果包含则返回 `true`，否则返回 `false`

#### `Array.prototype.indexOf()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/indexOf)

返回在数组中可以找到一个给定元素的第一个索引，如果不存在，则返回 `-1`

#### `Array.prototype.join()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/join)

将一个数组的所有元素连接成一个字符串并返回这个字符串

#### `Array.prototype.keys()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/keys)

返回一个包含数组中每个索引键的 `Array Iterator` 对象

#### `Array.prototype.lastIndexOf()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/lastIndexOf)

返回指定元素在数组中的最后一个的索引，如果不存在则返回 `-1`

#### `Array.prototype.map()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/map)

返回一个新数组，其结果是该数组中的每个元素是调用一次提供的函数后的返回值

#### `Array.prototype.pop()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/pop)

从数组中删除最后一个元素，并返回该元素的值

#### `Array.prototype.push()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/push)

将一个或多个元素添加到数组的末尾，并返回该数组的新长度

#### `Array.prototype.reduce()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/Reduce)

对数组中的每个元素执行一个由您提供的 reducer 函数（升序执行），将其结果汇总为单个返回值

#### `Array.prototype.reduceRight()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/ReduceRight)

接受一个函数作为累加器（accumulator）和数组的每个值（从右到左）将其减少为单个值

#### `Array.prototype.reverse()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/reverse)

将数组中元素的位置颠倒，并返回该数组。该方法会改变原数组

#### `Array.prototype.shift()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/shift)

从数组中删除第一个元素，并返回该元素的值

#### `Array.prototype.slice()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/slice)

提取源数组的一部分并返回一个新数组

#### `Array.prototype.some()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/some)

测试数组中是不是至少有一个元素通过了被提供的函数测试

#### `Array.prototype.sort()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/sort)

对数组元素进行原地排序并返回此数组

#### `Array.prototype.splice()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/splice)

通过删除或替换现有元素或者原地添加新的元素来修改数组，并以数组形式返回被修改的内容

#### `Array.prototype.toLocaleString()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/toLocaleString)

返回一个字符串表示数组中的元素。数组中的元素将使用各自的

#### `Object.prototype.toLocaleString()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/toLocaleString) 方法转成字符串

#### `Array.prototype.toString()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/toString)

返回一个字符串表示指定的数组及其元素。数组中的元素将使用各自的

#### `Object.prototype.toString()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/toString) 方法转成字符串

#### `Array.prototype.unshift()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/unshift)

将一个或多个元素添加到数组的头部，并返回该数组的新长度

#### `Array.prototype.values()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/values)

返回一个新的 `Array Iterator 对象`，该对象包含数组每个索引的值

#### `Array.prototype[@@iterator]()`

[MDN](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/@@iterator)

返回一个新的 `Array Iterator 对象`，该对象包含数组每个索引的值

## 示例

### 创建数组

下面这个例子创建了一个长度为 `0` 的数组 `msgArray`，然后给  `msgArray[0]`  和  `msgArray[99]`  赋值，从而导致数组长度变为了 `100`。

```js
let msgArray = [];
msgArray[0] = "Hello";
msgArray[99] = "world";

if (msgArray.length === 100) {
  console.log("The length is 100.");
}
```

### 创建二维数组

下面的例子创建了一个代表国际象棋棋盘的二维数组，然后将  `[6][4]`  上的 `p` (Pawn 兵) 拷贝到 `[4][4]`，而原本的 `[6][4]` 位置则被设置为空格。

```js
let board = [
  ["R", "N", "B", "Q", "K", "B", "N", "R"],
  ["P", "P", "P", "P", "P", "P", "P", "P"],
  [" ", " ", " ", " ", " ", " ", " ", " "],
  [" ", " ", " ", " ", " ", " ", " ", " "],
  [" ", " ", " ", " ", " ", " ", " ", " "],
  [" ", " ", " ", " ", " ", " ", " ", " "],
  ["p", "p", "p", "p", "p", "p", "p", "p"],
  ["r", "n", "b", "q", "k", "b", "n", "r"],
];

console.log(board.join("\n") + "\n\n");

board[4][4] = board[6][4];
board[6][4] = " ";
console.log(board.join("\n"));
```

下面是输出：

```md
R,N,B,Q,K,B,N,R
P,P,P,P,P,P,P,P
, , , , , , ,
, , , , , , ,
, , , , , , ,
, , , , , , ,
p,p,p,p,p,p,p,p
r,n,b,q,k,b,n,r

R,N,B,Q,K,B,N,R
P,P,P,P,P,P,P,P
, , , , , , ,
, , , , , , ,
, , , ,p, , ,
, , , , , , ,
p,p,p,p, ,p,p,p
r,n,b,q,k,b,n,r
```

### 用数组将一组值以表格形式显示

```js
values = [];
for (let x = 0; x < 10; x++) {
  values.push([2 ** x, 2 * x ** 2]);
}
console.table(values);
```

结果为：

```md
// The first column is the index
0 1 0
1 2 2
2 4 8
3 8 18
4 16 32
5 32 50
6 64 72
7 128 98
8 256 128
9 512 162
```

## 规范

| Specification |
| ------------- |

| [ECMAScript Language Specification
\# sec-array-objects](https://tc39.es/ecma262/multipage/indexed-collections.html#sec-array-objects) |

## 浏览器兼容性

[Report problems with this compatibility data on GitHub](https://github.com/mdn/browser-compat-data/issues/new?mdn-url=https%3A%2F%2Fdeveloper.mozilla.org%2Fzh-CN%2Fdocs%2FWeb%2FJavaScript%2FReference%2FGlobal_Objects%2FArray&metadata=%3C%21--+Do+not+make+changes+below+this+line+--%3E%0A%3Cdetails%3E%0A%3Csummary%3EMDN+page+report+details%3C%2Fsummary%3E%0A%0A*+Query%3A+%60javascript.builtins.Array%60%0A*+Report+started%3A+2022-07-27T11%3A31%3A28.631Z%0A%0A%3C%2Fdetails%3E&title=javascript.builtins.Array+-+%3CSUMMARIZE+THE+PROBLEM%3E&template=data-problem.yml "Report an issue with this compatibility data")
