# Number

 JavaScript 的 **`Number`** 对象是经过封装的能让你处理数字值的对象。`Number` 对象由 `Number()` 构造器创建。

JavaScript 的`Number`类型为[双精度 IEEE 754 64 位浮点](https://en.wikipedia.org/wiki/Floating-point_arithmetic)类型。

最近出了 stage3[`BigInt`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/BigInt) 任意精度数字类型，已经进入 stage3 规范

## [语法](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number#syntax)

```
new Number(value);
var a = new Number('123'); // a === 123 is false
var b = Number('123'); // b === 123 is true
a instanceof Number; // is true
b instanceof Number; // is false
```

### [参数](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number#parameters)

- `value`

  被创建对象的数字值。

## [描述](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number#description)

`Number` 对象主要用于：

- 如果参数无法被转换为数字，则返回 [`NaN`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/NaN)。
- 在非构造器上下文中 (如：没有 [`new`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Operators/new) 操作符)，`Number` 能被用来执行类型转换。

## [属性](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number#properties)

- [`Number.EPSILON`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number/EPSILON)

  两个可表示 (representable) 数之间的最小间隔。

- [`Number.MAX_SAFE_INTEGER`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number/MAX_SAFE_INTEGER)

  JavaScript 中最大的安全整数 (`2^53 - 1`)。

- [`Number.MAX_VALUE`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number/MAX_VALUE)

  能表示的最大正数。最小的负数是 `-MAX_VALUE`。

- [`Number.MIN_SAFE_INTEGER`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number/MIN_SAFE_INTEGER)

  JavaScript 中最小的安全整数 (`-(2^53 - 1)`).

- [`Number.MIN_VALUE`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number/MIN_VALUE)

  能表示的最小正数即最接近 0 的正数 (实际上不会变成 0)。最大的负数是 `-MIN_VALUE`。

- [`Number.NaN`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number/NaN)

  特殊的“非数字”值。

- [`Number.NEGATIVE_INFINITY`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number/NEGATIVE_INFINITY)

  特殊的负无穷大值，在溢出时返回该值。

- [`Number.POSITIVE_INFINITY`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number/POSITIVE_INFINITY)

  特殊的正无穷大值，在溢出时返回该值。

- [`Number.prototype` (en-US)](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number)

  Number 对象上允许的额外属性。

## [方法](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number#methods)

- [`Number.isNaN()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number/isNaN)

  确定传递的值是否是 NaN。

- [`Number.isFinite()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number/isFinite)

  确定传递的值类型及本身是否是有限数。

- [`Number.isInteger()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number/isInteger)

  确定传递的值类型是“number”，且是整数。

- [`Number.isSafeInteger()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number/isSafeInteger)

  确定传递的值是否为安全整数 ( -`(2^53 - 1)` 至 `2^53 - 1`) 之间。

- `Number.toInteger()`     Deprecated

  计算传递的值并将其转换为整数 (或无穷大)。

- [`Number.parseFloat()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number/parseFloat)

  和全局对象 [`parseFloat()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/parseFloat) 一样。

- [`Number.parseInt()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number/parseInt)

  和全局对象 [`parseInt()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/parseInt) 一样。

## [`Number` 实例](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number#number_instances)

所有 `Number` 实例都继承自 [`Number.prototype` (en-US)](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number)。`被修改的 Number` 构造器的原型对象对全部 `Number` 实例都生效。

### [方法](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number#methods_of_number_instance)

- [`Number.prototype.toExponential(fractionDigits)`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number/toExponential)

  返回使用指数表示法表示数字的字符串。

- [`Number.prototype.toFixed(digits)`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number/toFixed)

  返回使用定点表示法表示数字的字符串。

- [`Number.prototype.toLocaleString([locales [, options\]])`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number/toLocaleString)

  返回数字在特定语言环境下表示的字符串。覆盖 [`Object.prototype.toLocaleString()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/toLocaleString) 方法。

- [`Number.prototype.toPrecision(precision)`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number/toPrecision)

  返回数字使用定点表示法或指数表示法至指定精度的字符串。

- [`Number.prototype.toString([radix\])`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number/toString)

  返回一个代表给定对象的字符串，基于指定的基数。覆盖 [`Object.prototype.toString()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/toString) 方法。

- [`Number.prototype.valueOf()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number/valueOf)

  返回指定对象的原始值。覆盖 [`Object.prototype.valueOf()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/valueOf) 方法。

## [示例](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number#examples)

### [使用 Number 对象给数字变量赋值](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number#example_using_the_number_object_to_assign_values_to_numeric_variables)

下例使用 `Number` 对象的属性给几个数字变量赋值：

```
var biggestNum = Number.MAX_VALUE;
var smallestNum = Number.MIN_VALUE;
var infiniteNum = Number.POSITIVE_INFINITY;
var negInfiniteNum = Number.NEGATIVE_INFINITY;
var notANum = Number.NaN;
```

### [整数类型的范围](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number#整数类型的范围)

JavaScript 能够准确表示的整数范围在`-2^53`到`2^53`之间（不含两个端点），超过这个范围，无法精确表示这个整数。 (详情请参阅 ECMAScript standard, chapter *[6.1.6 The Number Type](https://www.ecma-international.org/ecma-262/#sec-ecmascript-language-types-number-type)*):

```
var biggestInt = Number.MAX_SAFE_INTEGER;
//9007199254740991
var smallestInt = Number.MIN_SAFE_INTEGER;
//-9007199254740991
```

在解析序列化的 JSON 时，如果 JSON 解析器将它们强制转换为 Number 类型，那么超出此范围的整数值可能会被破坏。在工作中使用[`String`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/String) 类型代替，是一个可行的解决方案。

### [使用 `Number` 转换 `Date` 对象](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number#example_using_number_to_convert_a_date_object)

下例使用 Number 作为函数来转换 `Date` 对象为数字值：

```
var d = new Date("December 17, 1995 03:24:00");
print(Number(d));
```

这将输出 "819199440000"。

### [转换数字字符串为数字](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number#转换数字字符串为数字)

```
Number('123')     // 123
Number('12.3')    // 12.3
Number('12.00')   // 12
Number('123e-1')  // 12.3
Number('')        // 0
Number(null)      // 0
Number('0x11')    // 17
Number('0b11')    // 3
Number('0o11')    // 9
Number('foo')     // NaN
Number('100a')    // NaN
Number('-Infinity') //-Infinity
```

## [Specifications](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number#specifications)

| Specification                                                |
| ------------------------------------------------------------ |
| [ECMAScript Language Specification  # sec-number-objects](https://tc39.es/ecma262/multipage/numbers-and-dates.html#sec-number-objects) |

## [浏览器兼容性](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number#browser_compatibility)

[Report problems with this compatibility data on GitHub](https://github.com/mdn/browser-compat-data/issues/new?mdn-url=https%3A%2F%2Fdeveloper.mozilla.org%2Fzh-CN%2Fdocs%2FWeb%2FJavaScript%2FReference%2FGlobal_Objects%2FNumber&metadata= MDN+page+report+details<%2Fsummary> *+Query%3A+`javascript.builtins.Number` *+Report+started%3A+2022-07-27T11%3A32%3A04.065Z <%2Fdetails>&title=javascript.builtins.Number+-+&template=data-problem.yml)

|          | desktop | mobile | server  |                   |       |        |                |                     |               |               |                  |                 |      |         |
| -------- | ------- | ------ | ------- | ----------------- | ----- | ------ | -------------- | ------------------- | ------------- | ------------- | ---------------- | --------------- | ---- | ------- |
|          | Chrome  | Edge   | Firefox | Internet Explorer | Opera | Safari | Chrome Android | Firefox for Android | Opera Android | Safari on iOS | Samsung Internet | WebView Android | Deno | Node.js |
| `Number` |         |        |         |                   |       |        |                |                     |               |               |                  |                 |      |         |

| [`EPSILON`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/EPSILON) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`MAX_SAFE_INTEGER`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/MAX_SAFE_INTEGER) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`MAX_VALUE`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/MAX_VALUE) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`MIN_SAFE_INTEGER`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/MIN_SAFE_INTEGER) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`MIN_VALUE`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/MIN_VALUE) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`NEGATIVE_INFINITY`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/NEGATIVE_INFINITY) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`NaN`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/NaN) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`Number()` constructor](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/Number) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`POSITIVE_INFINITY`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/POSITIVE_INFINITY) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`isFinite`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/isFinite) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`isInteger`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/isInteger) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`isNaN`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/isNaN) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`isSafeInteger`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/isSafeInteger) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`parseFloat`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/parseFloat) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`parseInt`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/parseInt) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`toExponential`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/toExponential) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`toFixed`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/toFixed) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`toLocaleString`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/toLocaleString) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| `toLocaleString.locales` |      |
| ------------------------ | ---- |
|                          |      |

| `toLocaleString.options` |      |
| ------------------------ | ---- |
|                          |      |

| [`toPrecision`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/toPrecision) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`toString`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/toString) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`valueOf`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/valueOf) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

### Legend







## [参阅](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Number#see_also)

- [`NaN`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/NaN)
- 全局对象 [`Math`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Math) 
- Integers with arbitrary precision: [`BigInt`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/BigInt)
- [Number type in details](https://medium.com/@maximus.koretskyi/javascripts-number-type-8d59199db1b6#.9whwe88tz)