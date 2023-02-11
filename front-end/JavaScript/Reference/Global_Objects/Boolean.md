# Boolean - JavaScript | MDN

> Boolean 对象是一个布尔值的对象包装器。

**`Boolean`** 对象是一个布尔值的对象包装器。

[描述](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Boolean#%E6%8F%8F%E8%BF%B0 "Permalink to 描述")
-----------------------------------------------------------------------------------------------------------------------------------

如果需要，作为第一个参数传递的值将转换为布尔值。如果省略该参数或参数值为 `0`、`-0`、[`null`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Operators/null)、`false`、[`NaN`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/NaN)、[`undefined`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/undefined)，或空字符串（`""`），则该对象具有的初始值为 `false`。所有其它值，包括任何对象，空数组（`[]`）或字符串 `"false"`，都会创建一个初始值为 `true` 的对象。

注意不要将基本类型中的布尔值 `true` 和 `false` 与值为 `true` 和 `false` 的 `Boolean` 对象弄混了。

其值不是 [`undefined`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/undefined) 或 [`null`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Operators/null) 的任何对象（包括其值为 `false` 的布尔对象）在传递给条件语句时都将计算为 `true`。例如，以下 [`if`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Statements/if...else) 语句中的条件评估为 `true`：

    const x = new Boolean(false);
    if (x) {
      
    }
    

基本类型的布尔值不受此规则影响。例如下面的 [`if`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Statements/if...else) 语句的条件为假：

    const x = false;
    if (x) {
      
    }
    

不要用创建 `Boolean` 对象的方式将一个非布尔值转化成布尔值，直接将 `Boolean` 当做转换函数来使用即可，或者使用[双重非（!!）运算符](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Operators/Logical_NOT#double_not_!!)：

    const x = Boolean(expression);     
    const x = !!(expression);          
    const x = new Boolean(expression); 
    

对于任何对象，即使是值为 `false` 的 `Boolean` 对象，当将其传给 `Boolean` 函数时，生成的 `Boolean` 对象的值都是 `true`。

    const myFalse = new Boolean(false);   
    const g = Boolean(myFalse);       
    const myString = new String('Hello'); 
    const s = Boolean(myString);      
    

最后，不要在应该使用基本类型布尔值的地方使用 `Boolean` 对象。

**备注：** 当将非标准属性 [`document.all`](https://developer.mozilla.org/zh-CN/docs/Web/API/Document#%E5%B1%9E%E6%80%A7) 用作此构造函数的参数时，结果是值为 `false` 的布尔对象。此属性是旧的、非标准的属性，不应使用。

当使用非严格相等（`==`）来比较一个对象和布尔原始值时，最重要的是需要弄明白最终比较的是什么。请看一下的示例：

    if ([]) { console.log("[] is truthy")}         
    if ([] == false) { console.log("[] == false")} 
    

`[]` 是真值而 `[] == false` 也同时成立的原因是：非严格比较 `[] == false` 会将 `[]` 的原始值和 `false` 进行比较。而获取 `[]` 的原始值时，JavaScript 引擎会首先调用 `[].toString()`。其结果为 `""`，也是最终和 `false` 一起比较的值。换句话说，`[] == false` 等价于 `"" == false`，而 `""` 是假值——这也解释了为什么会得到这一结果。

[构造函数](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Boolean#%E6%9E%84%E9%80%A0%E5%87%BD%E6%95%B0 "Permalink to 构造函数")
---------------------------------------------------------------------------------------------------------------------------------------------------------

[`Boolean()` (en-US)](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Boolean/Boolean "Currently only available in English (US)")

创建一个新的 `Boolean` 对象。

[实例方法](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Boolean#%E5%AE%9E%E4%BE%8B%E6%96%B9%E6%B3%95 "Permalink to 实例方法")
---------------------------------------------------------------------------------------------------------------------------------------------------------

[示例](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Boolean#%E7%A4%BA%E4%BE%8B "Permalink to 示例")
-----------------------------------------------------------------------------------------------------------------------------------

### [以初始值 `false` 创建 `Boolean` 对象](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Boolean#%E4%BB%A5%E5%88%9D%E5%A7%8B%E5%80%BC_false_%E5%88%9B%E5%BB%BA_boolean_%E5%AF%B9%E8%B1%A1 "Permalink to 以初始值 false 创建 Boolean 对象")

    const bNoParam = new Boolean();
    const bZero = new Boolean(0);
    const bNull = new Boolean(null);
    const bEmptyString = new Boolean('');
    const bfalse = new Boolean(false);
    

### [以初始值 `true` 创建 `Boolean` 对象](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Boolean#%E4%BB%A5%E5%88%9D%E5%A7%8B%E5%80%BC_true_%E5%88%9B%E5%BB%BA_boolean_%E5%AF%B9%E8%B1%A1 "Permalink to 以初始值 true 创建 Boolean 对象")

    const btrue = new Boolean(true);
    const btrueString = new Boolean('true');
    const bfalseString = new Boolean('false');
    const bSuLin = new Boolean('Su Lin');
    const bArrayProto = new Boolean([]);
    const bObjProto = new Boolean({});
    

[规范](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Boolean#%E8%A7%84%E8%8C%83 "Permalink to 规范")
-----------------------------------------------------------------------------------------------------------------------------------

| Specification |
| --- |
| [ECMAScript Language Specification  
\# sec-boolean-objects](https://tc39.es/ecma262/multipage/fundamental-objects.html#sec-boolean-objects) |

[浏览器兼容性](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Boolean#%E6%B5%8F%E8%A7%88%E5%99%A8%E5%85%BC%E5%AE%B9%E6%80%A7 "Permalink to 浏览器兼容性")
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

[Report problems with this compatibility data on GitHub](https://github.com/mdn/browser-compat-data/issues/new?mdn-url=https%3A%2F%2Fdeveloper.mozilla.org%2Fzh-CN%2Fdocs%2FWeb%2FJavaScript%2FReference%2FGlobal_Objects%2FBoolean&metadata=%3C%21--+Do+not+make+changes+below+this+line+--%3E%0A%3Cdetails%3E%0A%3Csummary%3EMDN+page+report+details%3C%2Fsummary%3E%0A%0A*+Query%3A+%60javascript.builtins.Boolean%60%0A*+Report+started%3A+2022-07-27T11%3A31%3A40.225Z%0A%0A%3C%2Fdetails%3E&title=javascript.builtins.Boolean+-+%3CSUMMARIZE+THE+PROBLEM%3E&template=data-problem.yml "Report an issue with this compatibility data")

### Legend

Full support

Full support

The compatibility table on this page is generated from structured data. If you'd like to contribute to the data, please check out [https://github.com/mdn/browser-compat-data](https://github.com/mdn/browser-compat-data) and send us a pull request.

[参见](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Boolean#%E5%8F%82%E8%A7%81 "Permalink to 参见")
-----------------------------------------------------------------------------------------------------------------------------------


[Source](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Boolean)