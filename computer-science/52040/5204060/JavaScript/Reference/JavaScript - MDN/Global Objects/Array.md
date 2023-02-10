# Array - JavaScript | MDN

> JavaScript 的 Array 对象是用于构造数组的全局对象，数组是类似于列表的高阶对象。

JavaScript 的 **`Array`** 对象是用于构造数组的全局对象，数组是类似于列表的高阶对象。

[描述](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array#%E6%8F%8F%E8%BF%B0 "Permalink to 描述")
---------------------------------------------------------------------------------------------------------------------------------

数组是一种类列表对象，它的原型中提供了遍历和修改元素的相关操作。JavaScript 数组的长度和元素类型都是非固定的。因为数组的长度可随时改变，并且其数据在内存中也可以不连续，所以 JavaScript 数组不一定是密集型的，这取决于它的使用方式。一般来说，数组的这些特性会给使用带来方便，但如果这些特性不适用于你的特定使用场景的话，可以考虑使用类型数组 [`TypedArray`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/TypedArray)。

只能用整数作为数组元素的索引，而不能用字符串。后者称为 [关联数组](https://en.wikipedia.org/wiki/Associative_array)。使用非整数并通过 [方括号](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Guide/Working_with_Objects#%E5%AF%B9%E8%B1%A1%E5%92%8C%E5%B1%9E%E6%80%A7) 或 [点号](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Operators/Property_Accessors) 来访问或设置数组元素时，所操作的并不是数组列表中的元素，而是数组对象的 [属性集合](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Data_structures#%E5%B1%9E%E6%80%A7) 上的变量。数组对象的属性和数组元素列表是分开存储的，并且数组的遍历和修改操作也不能作用于这些命名属性。

### [常见操作](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array#%E5%B8%B8%E8%A7%81%E6%93%8D%E4%BD%9C "Permalink to 常见操作")

**创建数组**

    let fruits = ['Apple', 'Banana']
    
    console.log(fruits.length)
    
    

**通过索引访问数组元素**

    let first = fruits[0]
    
    
    let last = fruits[fruits.length - 1]
    
    

**遍历数组**

    fruits.forEach(function(item, index, array) {
      console.log(item, index)
    })
    
    
    

**添加元素到数组的末尾**

    let newLength = fruits.push('Orange')
    
    

**删除数组末尾的元素**

**删除数组头部元素**

    let first = fruits.shift() 
    
    

**添加元素到数组的头部**

    let newLength = fruits.unshift('Strawberry') 
    
    

**找出某个元素在数组中的索引**

    fruits.push('Mango')
    
    
    let pos = fruits.indexOf('Banana')
    
    

**通过索引删除某个元素**

    let removedItem = fruits.splice(pos, 1) 
    
    
    

**从一个索引位置删除多个元素**

    let vegetables = ['Cabbage', 'Turnip', 'Radish', 'Carrot']
    console.log(vegetables)
    
    
    let pos = 1
    let n = 2
    
    let removedItems = vegetables.splice(pos, n)
    
    
    
    console.log(vegetables)
    
    
    console.log(removedItems)
    
    

**复制一个数组**

    let shallowCopy = fruits.slice() 
    
    

### [访问数组元素](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array#%E8%AE%BF%E9%97%AE%E6%95%B0%E7%BB%84%E5%85%83%E7%B4%A0 "Permalink to 访问数组元素")

JavaScript 数组的索引是从 0 开始的，第一个元素的索引为 0，最后一个元素的索引等于该数组的 [`长度`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/length) 减 1。

如果指定的索引是一个无效值，JavaScript 数组并不会报错，而是会返回 `undefined`。

    let arr = ['this is the first element', 'this is the second element', 'this is the last element']
    console.log(arr[0])              
    console.log(arr[1])              
    console.log(arr[arr.length - 1]) 
    

虽然数组元素可以看做是数组对象的属性，就像 `toString` 一样，但是下面的写法是错误的，运行时会抛出 `SyntaxError` 异常，而原因则是使用了非法的属性名：

并不是 JavaScript 数组有什么特殊之处，而是因为在 JavaScript 中，以数字开头的属性不能用点号引用，必须用方括号。

比如，如果一个对象有一个名为 `3d` 的属性，那么只能用方括号来引用它。下面是具体的例子：

    let years = [1950, 1960, 1970, 1980, 1990, 2000, 2010]
    console.log(years.0)   
    console.log(years[0])  
    

    renderer.3d.setTexture(model, 'character.png')     
    renderer['3d'].setTexture(model, 'character.png')  
    

注意在 `3d` 那个例子中，引号是必须的。你也可以将数组的索引用引号引起来，比如 `years[2]` 可以写成 `years['2']`。

`years[2]` 中的 2 会被 JavaScript 解释器通过调用 `toString` 隐式转换成字符串。正因为这样，`'2'` 和 `'02'` 在 `years` 中所引用的可能是不同位置上的元素。而下面这个例子也可能会打印 `true`：

    console.log(years['2'] != years['02'])
    

### [数组长度与数字下标之间的关系](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array#%E6%95%B0%E7%BB%84%E9%95%BF%E5%BA%A6%E4%B8%8E%E6%95%B0%E5%AD%97%E4%B8%8B%E6%A0%87%E4%B9%8B%E9%97%B4%E7%9A%84%E5%85%B3%E7%B3%BB "Permalink to 数组长度与数字下标之间的关系")

JavaScript 数组的 [`length`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/length) 属性和其数字下标之间有着紧密的联系。

数组内置的几个方法（例如 [`join`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/join)、[`slice`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/slice)、[`indexOf`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/indexOf) 等）都会考虑 [`length`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/length) 的值。

另外还有一些方法（例如 [`push`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/push)、[`splice`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/splice) 等）还会改变 [`length`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/length) 的值。

    const fruits = []
    fruits.push('banana', 'apple', 'peach')
    
    console.log(fruits.length) 
    

使用一个合法的下标为数组元素赋值，并且该下标超出了当前数组的大小的时候，解释器会同时修改 [`length`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/length) 的值：

    fruits[5] = 'mango'
    console.log(fruits[5])            
    console.log(Object.keys(fruits))  
    console.log(fruits.length)        
    

也可以显式地给 [`length`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/length) 赋一个更大的值：

    fruits.length = 10
    console.log(fruits)              
    console.log(Object.keys(fruits)) 
    console.log(fruits.length)       
    console.log(fruits[8])           
    

而为 [`length`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/length) 赋一个更小的值则会删掉一部分元素：

    fruits.length = 2
    console.log(Object.keys(fruits)) 
    console.log(fruits.length)       
    

这一节的内容在 [`Array.length`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/length) 中有更详细的介绍。

### [正则匹配结果所返回的数组](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array#%E6%AD%A3%E5%88%99%E5%8C%B9%E9%85%8D%E7%BB%93%E6%9E%9C%E6%89%80%E8%BF%94%E5%9B%9E%E7%9A%84%E6%95%B0%E7%BB%84 "Permalink to 正则匹配结果所返回的数组")

使用正则表达式匹配字符串可以得到一个数组。这个数组中包含本次匹配的相关信息和匹配结果。[`RegExp.exec`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/RegExp/exec)、[`String.match`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/String/match)、[`String.replace`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/String/replace) 都会返回这样的数组。

看下面的例子和例子下面的表格：

    
    
    
    
    const myRe = /d(b+)(d)/i
    const myArray = myRe.exec('cdbBdbsbz')
    

该正则匹配返回的数组包含以下属性和元素：

[构造器](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array#%E6%9E%84%E9%80%A0%E5%99%A8 "Permalink to 构造器")
--------------------------------------------------------------------------------------------------------------------------------------------

[静态属性](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array#%E9%9D%99%E6%80%81%E5%B1%9E%E6%80%A7 "Permalink to 静态属性")
-------------------------------------------------------------------------------------------------------------------------------------------------------

[静态方法](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array#%E9%9D%99%E6%80%81%E6%96%B9%E6%B3%95 "Permalink to 静态方法")
-------------------------------------------------------------------------------------------------------------------------------------------------------

[`Array.from()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/from)

从类数组对象或者可迭代对象中创建一个新的数组实例

[`Array.isArray()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/isArray)

用来判断某个变量是否是一个数组对象

[`Array.of()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/of)

根据一组参数来创建新的数组实例，支持任意的参数数量和类型

[实例属性](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array#%E5%AE%9E%E4%BE%8B%E5%B1%9E%E6%80%A7 "Permalink to 实例属性")
-------------------------------------------------------------------------------------------------------------------------------------------------------

[`Array.prototype.length`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/length)

数组中的元素个数

[`Array.prototype[@@unscopables]`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/@@unscopables)

包含了所有 ES2015 (ES6) 中新定义的、且并未被更早的 ECMAScript 标准收纳的属性名。这些属性被排除在由 [`with`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Statements/with) 语句绑定的环境中

[实例方法](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array#%E5%AE%9E%E4%BE%8B%E6%96%B9%E6%B3%95 "Permalink to 实例方法")
-------------------------------------------------------------------------------------------------------------------------------------------------------

[`Array.prototype.at()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/at) Experimental

Returns the array item at the given index. Accepts negative integers, which count back from the last item.

[`Array.prototype.concat()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/concat)

用于合并两个或多个数组。此方法不会更改现有数组，而是返回一个新数组

[`Array.prototype.copyWithin()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/copyWithin)

浅复制数组的一部分到同一数组中的另一个位置，并返回它，不会改变原数组的长度

[`Array.prototype.entries()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/entries)

返回一个新的 `Array Iterator` 对象，该对象包含数组中每个索引的键/值对

[`Array.prototype.every()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/every)

测试一个数组内的所有元素是否都能通过某个指定函数的测试。它返回一个布尔值

[`Array.prototype.fill()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/fill)

用一个固定值填充一个数组中从起始索引到终止索引内的全部元素

[`Array.prototype.filter()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/filter)

创建一个新数组，其包含通过所提供函数实现的测试的所有元素

[`Array.prototype.find()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/find)

返回数组中满足提供的测试函数的第一个元素的值。否则返回 `undefined`

[`Array.prototype.findIndex()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/findIndex)

返回数组中满足提供的测试函数的第一个元素的**索引**。若没有找到对应元素则返回 `-1`

[`Array.prototype.flat()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/flat)

按照一个可指定的深度递归遍历数组，并将所有元素与遍历到的子数组中的元素合并为一个新数组返回

[`Array.prototype.flatMap()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/flatMap)

使用映射函数映射每个元素，然后将结果压缩成一个新数组

[`Array.prototype.forEach()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/forEach)

对数组的每个元素执行一次给定的函数

[`Array.prototype.includes()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/includes)

判断一个数组是否包含一个指定的值，如果包含则返回 `true`，否则返回 `false`

[`Array.prototype.indexOf()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/indexOf)

返回在数组中可以找到一个给定元素的第一个索引，如果不存在，则返回 `-1`

[`Array.prototype.join()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/join)

将一个数组的所有元素连接成一个字符串并返回这个字符串

[`Array.prototype.keys()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/keys)

返回一个包含数组中每个索引键的 `Array Iterator` 对象

[`Array.prototype.lastIndexOf()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/lastIndexOf)

返回指定元素在数组中的最后一个的索引，如果不存在则返回 `-1`

[`Array.prototype.map()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/map)

返回一个新数组，其结果是该数组中的每个元素是调用一次提供的函数后的返回值

[`Array.prototype.pop()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/pop)

从数组中删除最后一个元素，并返回该元素的值

[`Array.prototype.push()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/push)

将一个或多个元素添加到数组的末尾，并返回该数组的新长度

[`Array.prototype.reduce()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/Reduce)

对数组中的每个元素执行一个由您提供的 reducer 函数（升序执行），将其结果汇总为单个返回值

[`Array.prototype.reduceRight()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/ReduceRight)

接受一个函数作为累加器（accumulator）和数组的每个值（从右到左）将其减少为单个值

[`Array.prototype.reverse()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/reverse)

将数组中元素的位置颠倒，并返回该数组。该方法会改变原数组

[`Array.prototype.shift()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/shift)

从数组中删除第一个元素，并返回该元素的值

[`Array.prototype.slice()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/slice)

提取源数组的一部分并返回一个新数组

[`Array.prototype.some()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/some)

测试数组中是不是至少有一个元素通过了被提供的函数测试

[`Array.prototype.sort()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/sort)

对数组元素进行原地排序并返回此数组

[`Array.prototype.splice()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/splice)

通过删除或替换现有元素或者原地添加新的元素来修改数组，并以数组形式返回被修改的内容

[`Array.prototype.toLocaleString()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/toLocaleString)

返回一个字符串表示数组中的元素。数组中的元素将使用各自的 [`Object.prototype.toLocaleString()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/toLocaleString) 方法转成字符串

[`Array.prototype.toString()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/toString)

返回一个字符串表示指定的数组及其元素。数组中的元素将使用各自的 [`Object.prototype.toString()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/toString) 方法转成字符串

[`Array.prototype.unshift()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/unshift)

将一个或多个元素添加到数组的头部，并返回该数组的新长度

[`Array.prototype.values()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/values)

返回一个新的 `Array Iterator 对象`，该对象包含数组每个索引的值

[`Array.prototype[@@iterator]()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array/@@iterator)

返回一个新的 `Array Iterator 对象`，该对象包含数组每个索引的值

[示例](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array#%E7%A4%BA%E4%BE%8B "Permalink to 示例")
---------------------------------------------------------------------------------------------------------------------------------

### [创建数组](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array#%E5%88%9B%E5%BB%BA%E6%95%B0%E7%BB%84 "Permalink to 创建数组")

下面这个例子创建了一个长度为 `0` 的数组 `msgArray`，然后给 `msgArray[0]` 和 `msgArray[99]` 赋值，从而导致数组长度变为了 `100`。

    let msgArray = []
    msgArray[0] = 'Hello'
    msgArray[99] = 'world'
    
    if (msgArray.length === 100) {
      console.log('The length is 100.')
    }
    

### [创建二维数组](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array#%E5%88%9B%E5%BB%BA%E4%BA%8C%E7%BB%B4%E6%95%B0%E7%BB%84 "Permalink to 创建二维数组")

下面的例子创建了一个代表国际象棋棋盘的二维数组，然后将 `[6][4]` 上的 `p` (Pawn 兵) 拷贝到 `[4][4]`，而原本的 `[6][4]` 位置则被设置为空格。

    let board = [
      ['R','N','B','Q','K','B','N','R'],
      ['P','P','P','P','P','P','P','P'],
      [' ',' ',' ',' ',' ',' ',' ',' '],
      [' ',' ',' ',' ',' ',' ',' ',' '],
      [' ',' ',' ',' ',' ',' ',' ',' '],
      [' ',' ',' ',' ',' ',' ',' ',' '],
      ['p','p','p','p','p','p','p','p'],
      ['r','n','b','q','k','b','n','r'] ]
    
    console.log(board.join('\n') + '\n\n')
    
    
    board[4][4] = board[6][4]
    board[6][4] = ' '
    console.log(board.join('\n'))
    

下面是输出：

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

### [用数组将一组值以表格形式显示](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array#%E7%94%A8%E6%95%B0%E7%BB%84%E5%B0%86%E4%B8%80%E7%BB%84%E5%80%BC%E4%BB%A5%E8%A1%A8%E6%A0%BC%E5%BD%A2%E5%BC%8F%E6%98%BE%E7%A4%BA "Permalink to 用数组将一组值以表格形式显示")

    values = []
    for (let x = 0; x < 10; x++){
     values.push([
      2 ** x,
      2 * x ** 2
     ])
    }
    console.table(values)
    

结果为：

// The first column is the index
0  1    0
1  2    2
2  4    8
3  8    18
4  16   32
5  32   50
6  64   72
7  128  98
8  256  128
9  512  162

[规范](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array#%E8%A7%84%E8%8C%83 "Permalink to 规范")
---------------------------------------------------------------------------------------------------------------------------------

| Specification |
| --- |
| [ECMAScript Language Specification  
\# sec-array-objects](https://tc39.es/ecma262/multipage/indexed-collections.html#sec-array-objects) |

[浏览器兼容性](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array#%E6%B5%8F%E8%A7%88%E5%99%A8%E5%85%BC%E5%AE%B9%E6%80%A7 "Permalink to 浏览器兼容性")
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

[Report problems with this compatibility data on GitHub](https://github.com/mdn/browser-compat-data/issues/new?mdn-url=https%3A%2F%2Fdeveloper.mozilla.org%2Fzh-CN%2Fdocs%2FWeb%2FJavaScript%2FReference%2FGlobal_Objects%2FArray&metadata=%3C%21--+Do+not+make+changes+below+this+line+--%3E%0A%3Cdetails%3E%0A%3Csummary%3EMDN+page+report+details%3C%2Fsummary%3E%0A%0A*+Query%3A+%60javascript.builtins.Array%60%0A*+Report+started%3A+2022-07-27T11%3A31%3A28.631Z%0A%0A%3C%2Fdetails%3E&title=javascript.builtins.Array+-+%3CSUMMARIZE+THE+PROBLEM%3E&template=data-problem.yml "Report an issue with this compatibility data")

### Legend

Full support

Full support

Partial support

Partial support

In development. Supported in a pre-release version.

In development. Supported in a pre-release version.

No support

No support

Experimental. Expect behavior to change in the future.

See implementation notes.

User must explicitly enable this feature.

Uses a non-standard name.

The compatibility table on this page is generated from structured data. If you'd like to contribute to the data, please check out [https://github.com/mdn/browser-compat-data](https://github.com/mdn/browser-compat-data) and send us a pull request.

[相关链接](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array#%E7%9B%B8%E5%85%B3%E9%93%BE%E6%8E%A5 "Permalink to 相关链接")
-------------------------------------------------------------------------------------------------------------------------------------------------------


[Source](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Array)