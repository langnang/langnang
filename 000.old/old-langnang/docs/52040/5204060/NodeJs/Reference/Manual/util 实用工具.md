---
created: 2022-07-29T13:12:54 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/util.html
author: 
---

# util 实用工具 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/util/util.html)

**源代码:** [lib/util.js](https://github.com/nodejs/node/blob/v12.22.12/lib/util.js)

`util` 模块支持 Node.js 内部 API 的需求。 许多实用工具对应用程序和模块开发者也很有用。 要访问它：

```
const util = require('util');
```

### `util.callbackify(original)`[#](http://nodejs.cn/api-v12/util.html#utilcallbackifyoriginal)

[中英对照](http://nodejs.cn/api-v12/util/util_callbackify_original.html)

新增于: v8.2.0

-   `original` [<Function>](http://url.nodejs.cn/ceTQa6) `async` 函数
-   返回: [<Function>](http://url.nodejs.cn/ceTQa6) 回调风格的函数

采用 `async` 函数（或返回 `Promise` 的函数）并返回遵循错误优先回调风格的函数，即将 `(err, value) => ...` 回调作为最后一个参数。 在回调中，第一个参数将是拒绝原因（如果 `Promise` 已解决，则为 `null`），第二个参数将是已解决的值。

```
const util = require('util');

async function fn() {
  return 'hello world';
}
const callbackFunction = util.callbackify(fn);

callbackFunction((err, ret) => {
  if (err) throw err;
  console.log(ret);
});
```

将打印：

```
hello world
```

回调是异步执行的，并且将具有有限的堆栈跟踪。 如果回调抛出，进程将触发 [`'uncaughtException'`](http://nodejs.cn/api-v12/process.html#process_event_uncaughtexception) 事件，如果不处理将退出。

由于 `null` 作为回调的第一个参数有特殊含义，如果封装的函数使用假值为理由来拒绝 `Promise`，则该值被封装在 `Error` 中，原始值存储在名为 `reason` 的字段中。

```
function fn() {
  return Promise.reject(null);
}
const callbackFunction = util.callbackify(fn);

callbackFunction((err, ret) => {
  // 当 Promise 使用 `null` 拒绝时，它会使用 Error 封装，
  // 原始值存储在 `reason` 中。
  err && err.hasOwnProperty('reason') && err.reason === null;  // true
});
```

### `util.debuglog(section[, callback])`[#](http://nodejs.cn/api-v12/util.html#utildebuglogsection-callback)

[中英对照](http://nodejs.cn/api-v12/util/util_debuglog_section_callback.html)

新增于: v0.11.3

-   `section` [<string>](http://url.nodejs.cn/9Tw2bK) 标识正在为其创建 `debuglog` 函数的应用程序部分的字符串。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 第一次调用日志函数时调用的回调函数参数是更优化的日志函数。
-   返回: [<Function>](http://url.nodejs.cn/ceTQa6) 日志函数

`util.debuglog()` 方法用于创建函数，该函数根据 `NODE_DEBUG` 环境变量的存在有条件地将调试消息写入 `stderr`。 如果 `section` 名称出现在该环境变量的值中，则返回的函数的操作类似于 [`console.error()`](http://nodejs.cn/api-v12/console.html#console_console_error_data_args)。 如果不是，则返回的函数是空操作。

```
const util = require('util');
const debuglog = util.debuglog('foo');

debuglog('hello from foo [%d]', 123);
```

如果这个程序在环境中与 `NODE_DEBUG=foo` 一起运行，则它会输出如下内容：

```
FOO 3245: hello from foo [123]
```

其中 `3245` 是进程 ID。 如果它没有使用该环境变量集运行，则它不会打印任何内容。

`section` 还支持通配符：

```
const util = require('util');
const debuglog = util.debuglog('foo-bar');

debuglog('hi there, it\'s foo-bar [%d]', 2333);
```

如果它在环境中与 `NODE_DEBUG=foo*` 一起运行，则它将输出如下内容：

```
FOO-BAR 3257: hi there, it's foo-bar [2333]
```

可以在 `NODE_DEBUG` 环境变量中指定多个逗号分隔的 `section` 名称：`NODE_DEBUG=fs,net,tls`。

可选的 `callback` 参数可用于用一个不同的函数替换日志函数，该函数没有任何初始化或不必要的封装。

```
const util = require('util');
let debuglog = util.debuglog('internals', (debug) => {
  // 如果启用该部分，
  // 则替换为优化测试的日志记录函数
  debuglog = debug;
});
```

### `util.deprecate(fn, msg[, code])`[#](http://nodejs.cn/api-v12/util.html#utildeprecatefn-msg-code)

[中英对照](http://nodejs.cn/api-v12/util/util_deprecate_fn_msg_code.html)

-   `fn` [<Function>](http://url.nodejs.cn/ceTQa6) 被弃用的函数。
-   `msg` [<string>](http://url.nodejs.cn/9Tw2bK) 调用弃用的函数时显示的警告消息。
-   `code` [<string>](http://url.nodejs.cn/9Tw2bK) 弃用代码。 有关代码的列表，请参阅[弃用的 API 列表](http://nodejs.cn/api-v12/deprecations.html#deprecations_list_of_deprecated_apis)。
-   返回: [<Function>](http://url.nodejs.cn/ceTQa6) 弃用的函数被封装以触发警告。

`util.deprecate()` 方法以标记为已弃用的方式封装 `fn`（可能是函数或类）。

```
const util = require('util');

exports.obsoleteFunction = util.deprecate(() => {
  // 在这里做点事情。
}, 'obsoleteFunction() is deprecated. Use newShinyFunction() instead.');
```

当调用时，`util.deprecate()` 将返回将使用 [`'warning'`](http://nodejs.cn/api-v12/process.html#process_event_warning) 事件触发 `DeprecationWarning` 的函数。 第一次调用返回的函数时，警告将触发并打印到 `stderr`。 触发警告后，将调用封装的函数而不触发警告。

如果在多次调用 `util.deprecate()` 时提供了相同的可选 `code`，则该 `code` 只会触发一次警告。

```
const util = require('util');

const fn1 = util.deprecate(someFunction, someMessage, 'DEP0001');
const fn2 = util.deprecate(someOtherFunction, someOtherMessage, 'DEP0001');
fn1(); // 使用代码 DEP0001 触发弃用警告
fn2(); // 不触发弃用警告，因为它具有相同的代码
```

### `util.format(format[, ...args])`[#](http://nodejs.cn/api-v12/util.html#utilformatformat-args)

[中英对照](http://nodejs.cn/api-v12/util/util_format_format_args.html)

-   `format` [<string>](http://url.nodejs.cn/9Tw2bK) 类似 `printf` 的格式字符串。

`util.format()` 方法使用第一个参数作为类似 `printf` 的格式字符串（其可以包含零个或多个格式说明符）来返回格式化的字符串。 每个说明符都替换为来自相应参数的转换后的值。 支持的说明符有：

-   `%s`: `String` 将用于转换除 `BigInt`、`Object` 和 `-0` 之外的所有值。 `BigInt` 值将用 `n` 表示，没有用户定义的 `toString` 函数的对象使用具有选项 `{ depth: 0, colors: false, compact: 3 }` 的 `util.inspect()` 进行检查。
-   `%d`: `Number` 将用于转换除 `BigInt` 和 `Symbol` 之外的所有值。
-   `%i`: `parseInt(value, 10)` 用于除 `BigInt` 和 `Symbol` 之外的所有值。
-   `%f`: `parseFloat(value)` 用于除 `Symbol` 之外的所有值。
-   `%j`: JSON。 如果参数包含循环引用，则替换为字符串 `'[Circular]'`。
-   `%o`: `Object`. 具有通用 JavaScript 对象格式的对象的字符串表示形式。 类似于具有选项 `{ showHidden: true, showProxy: true }` 的 `util.inspect()`。 这将显示完整的对象，包括不可枚举的属性和代理。
-   `%O`: `Object`. 具有通用 JavaScript 对象格式的对象的字符串表示形式。 类似于没有选项的 `util.inspect()`。 这将显示完整的对象，但不包括不可枚举的属性和代理。
-   `%c`: `CSS`. 此说明符被忽略，将跳过任何传入的 CSS。
-   `%%`: 单个百分号 (`'%'`)。 这不消费参数。
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK) 格式化的字符串

如果说明符没有相应的参数，则不会替换它：

```
util.format('%s:%s', 'foo');
// 返回: 'foo:%s'
```

如果其类型不是 `string`，则不属于格式字符串的值将使用 `util.inspect()` 进行格式化。

如果传给 `util.format()` 方法的参数多于说明符的数量，则额外的参数将以空格分隔串联到返回的字符串：

```
util.format('%s:%s', 'foo', 'bar', 'baz');
// 返回: 'foo:bar baz'
```

如果第一个参数不包含有效的格式说明符，则 `util.format()` 返回以空格分隔的所有参数的串联的字符串：

```
util.format(1, 2, 3);
// 返回: '1 2 3'
```

如果只有一个参数传给 `util.format()`，则它会按原样返回，不进行任何格式化：

```
util.format('%% %s');
// 返回: '%% %s'
```

`util.format()` 是同步的方法，旨在用作调试工具。 某些输入值可能会产生显着的性能开销，从而阻塞事件循环。 小心使用此函数，切勿在热代码路径中使用。

### `util.formatWithOptions(inspectOptions, format[, ...args])`[#](http://nodejs.cn/api-v12/util.html#utilformatwithoptionsinspectoptions-format-args)

[中英对照](http://nodejs.cn/api-v12/util/util_formatwithoptions_inspectoptions_format_args.html)

新增于: v10.0.0

-   `inspectOptions` [<Object>](http://url.nodejs.cn/jzn6Ao)
-   `format` [<string>](http://url.nodejs.cn/9Tw2bK)

此函数与 [`util.format()`](http://nodejs.cn/api-v12/util.html#util_util_format_format_args) 相同，不同之处在于它接受 `inspectOptions` 参数，该参数指定传给 [`util.inspect()`](http://nodejs.cn/api-v12/util.html#util_util_inspect_object_options) 的选项。

```
util.formatWithOptions({ colors: true }, 'See object %O', { foo: 42 });
// 返回 'See object { foo: 42 }'，
// 其中 `42` 在打印到终端时被着色为数字。
```

### `util.getSystemErrorName(err)`[#](http://nodejs.cn/api-v12/util.html#utilgetsystemerrornameerr)

[中英对照](http://nodejs.cn/api-v12/util/util_getsystemerrorname_err.html)

新增于: v9.7.0

-   `err` [<number>](http://url.nodejs.cn/SXbo1v)
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

返回来自 Node.js API 的数字错误码的字符串名称。 错误码和错误名称之间的映射是平台相关的。 有关常见错误的名称，请参阅[常见的系统错误](http://nodejs.cn/api-v12/errors.html#errors_common_system_errors)。

```
fs.access('file/that/does/not/exist', (err) => {
  const name = util.getSystemErrorName(err.errno);
  console.error(name);  // ENOENT
});
```

### `util.inherits(constructor, superConstructor)`[#](http://nodejs.cn/api-v12/util.html#utilinheritsconstructor-superconstructor)

[中英对照](http://nodejs.cn/api-v12/util/util_inherits_constructor_superconstructor.html)

-   `constructor` [<Function>](http://url.nodejs.cn/ceTQa6)
-   `superConstructor` [<Function>](http://url.nodejs.cn/ceTQa6)

不鼓励使用 `util.inherits()`。 请使用 ES6 `class` 和 `extends` 关键字来获得语言级别的继承支持。 另请注意，这两种风格在[语义上不兼容](http://url.nodejs.cn/mYyGrU)。

将原型方法从一个[构造函数](http://url.nodejs.cn/PFdNT3)继承到另一个构造函数。 `constructor` 的原型将被设置为从 `superConstructor` 创建的新对象。

这主要是在 `Object.setPrototypeOf(constructor.prototype, superConstructor.prototype)` 之上添加了一些输入验证。 作为额外的便利，`superConstructor` 将可通过 `constructor.super_` 属性访问。

```
const util = require('util');
const EventEmitter = require('events');

function MyStream() {
  EventEmitter.call(this);
}

util.inherits(MyStream, EventEmitter);

MyStream.prototype.write = function(data) {
  this.emit('data', data);
};

const stream = new MyStream();

console.log(stream instanceof EventEmitter); // true
console.log(MyStream.super_ === EventEmitter); // true

stream.on('data', (data) => {
  console.log(`Received data: "${data}"`);
});
stream.write('It works!'); // 接收到的数据："It works!"
```

使用 `class` 和 `extends` 的 ES6 示例：

```
const EventEmitter = require('events');

class MyStream extends EventEmitter {
  write(data) {
    this.emit('data', data);
  }
}

const stream = new MyStream();

stream.on('data', (data) => {
  console.log(`Received data: "${data}"`);
});
stream.write('With ES6');
```

### `util.inspect(object[, options])`[#](http://nodejs.cn/api-v12/util.html#utilinspectobject-options)

### `util.inspect(object[, showHidden[, depth[, colors]]])`[#](http://nodejs.cn/api-v12/util.html#utilinspectobject-showhidden-depth-colors)

[中英对照](http://nodejs.cn/api-v12/util/util_inspect_object_showhidden_depth_colors.html)

-   `object` [<any>](http://url.nodejs.cn/6sTGdS) 任何 JavaScript 原始类型或 `Object`。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `showHidden` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 `true`，则 `object` 的不可枚举符号和属性包含在格式化的结果中。 [`WeakMap`](http://url.nodejs.cn/JkfoVY) 和 [`WeakSet`](http://url.nodejs.cn/gsMyy2) 条目以及用户定义的原型属性（不包括方法属性）也包括在内。 **默认值:** `false`。
    -   `depth` [<number>](http://url.nodejs.cn/SXbo1v) 指定格式化 `object` 时递归的次数。 这对于检查大型对象很有用。 要递归到最大调用堆栈大小，则传入 `Infinity` 或 `null`。 **默认值:** `2`。
    -   `colors` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 `true`，则输出的样式为 ANSI 颜色代码。 颜色是可自定义的。 参阅[自定义 `util.inspect` 颜色](http://nodejs.cn/api-v12/util.html#util_customizing_util_inspect_colors)。 **默认值:** `false`。
    -   `customInspect` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 `false`，则 `[util.inspect.custom](depth, opts)` 函数不被调用。 **默认值:** `true`。
    -   `showProxy` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 `true`，则 `Proxy` 检查包括 [`target` 和 `handler`](http://url.nodejs.cn/avcf1v) 对象。 **默认值:** `false`。
    -   `maxArrayLength` [<integer>](http://url.nodejs.cn/SXbo1v) 指定格式化时要包含的 `Array`、[`TypedArray`](http://url.nodejs.cn/oh3CkV)、[`WeakMap`](http://url.nodejs.cn/JkfoVY) 和 [`WeakSet`](http://url.nodejs.cn/gsMyy2) 元素的最大数量。 设置为 `null` 或 `Infinity` 则显示所有元素。 设置为 `0` 或负数则不显示任何元素。 **默认值:** `100`。
    -   `maxStringLength` [<integer>](http://url.nodejs.cn/SXbo1v) 指定格式化时要包含的最大字符数。 设置为 `null` 或 `Infinity` 则显示所有元素。 设置为 `0` 或负数则不显示字符。 **默认值:** `Infinity`。
    -   `breakLength` [<integer>](http://url.nodejs.cn/SXbo1v) 输入值在多行中拆分的长度。 设置为 `Infinity` 则将输入格式化为单行（与设置为 `true` 或任何数字 >= `1` 的 `compact` 组合）。 **默认值:** `80`。
    -   `compact` [<boolean>](http://url.nodejs.cn/jFbvuT) | [<integer>](http://url.nodejs.cn/SXbo1v) 将此设置为 `false` 会导致每个对象的键显示在新行上。 它还会向比 `breakLength` 长的文本添加新行。 如果设置为数字，则只要所有属性都适合 `breakLength`，则最多 `n` 个内部元素将合并在一行中。 短数组元素也组合在一起。 无论 `breakLength` 大小如何，文本都不会减少到 16 个字符以下。 有关更多信息，请参阅下面的示例。 **默认值:** `3`。
    -   `sorted` [<boolean>](http://url.nodejs.cn/jFbvuT) | [<Function>](http://url.nodejs.cn/ceTQa6) 如果设置为 `true` 或函数，则对象的所有属性以及 `Set` 和 `Map` 条目都将在结果字符串中排序。 如果设置为 `true`，则使用[默认的排序](http://url.nodejs.cn/cV2zqg)。 如果设置为函数，则用作[比较函数](http://url.nodejs.cn/4cBSzy)。
    -   `getters` [<boolean>](http://url.nodejs.cn/jFbvuT) | [<string>](http://url.nodejs.cn/9Tw2bK) 如果设置为 `true`，则检查获取器。 如果设置为 `'get'`，则只检查没有相应设置器的获取器。 如果设置为 `'set'`，则只检查具有相应设置器的获取器。 这可能会导致副作用，具体取决于获取器函数。 **默认值:** `false`。
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK) `object` 的表示。

`util.inspect()` 方法返回用于调试的 `object` 的字符串表示。 `util.inspect` 的输出可能随时更改，不应以编程方式依赖。 可以传入额外的 `options` 来改变结果。 `util.inspect()` 将使用构造函数的名称和/或 `@@toStringTag` 为检查的值制作可识别的标签。

```
class Foo {
  get [Symbol.toStringTag]() {
    return 'bar';
  }
}

class Bar {}

const baz = Object.create(null, { [Symbol.toStringTag]: { value: 'foo' } });

util.inspect(new Foo()); // 'Foo [bar] {}'
util.inspect(new Bar()); // 'Bar {}'
util.inspect(baz);       // '[foo] {}'
```

```
const { inspect } = require('util');

const obj = {};
obj.a = [obj];
obj.b = {};
obj.b.inner = obj.b;
obj.b.obj = obj;

console.log(inspect(obj));
// 
```

以下示例检查 `util` 对象的所有属性：

```
const util = require('util');

console.log(util.inspect(util, { showHidden: true, depth: null }));
```

以下示例高亮了 `compact` 选项的效果：

```
const util = require('util');

const o = {
  a: [1, 2, [[
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do ' +
      'eiusmod tempor incididunt ut labore et dolore magna aliqua.',
    'test',
    'foo']], 4],
  b: new Map([['za', 1], ['zb', 'test']])
};
console.log(util.inspect(o, { compact: true, depth: 5, breakLength: 80 }));

// { a:
//   [ 1,
//     2,
//     [ [ 'Lorem ipsum dolor sit amet, consectetur [...]', // A long line
//           'test',
//           'foo' ] ],
//     4 ],
//   b: Map { 'za' => 1, 'zb' => 'test' } }

// 将 `compact` 设置为 false 会将输出更改为对读者更友好。
console.log(util.inspect(o, { compact: false, depth: 5, breakLength: 80 }));

// {
//   a: [
//     1,
//     2,
//     [
//       [
//         'Lorem ipsum dolor sit amet, consectetur ' +
//           'adipiscing elit, sed do eiusmod tempor ' +
//           'incididunt ut labore et dolore magna ' +
//           'aliqua.,
//         'test',
//         'foo'
//       ]
//     ],
//     4
//   ],
//   b: Map {
//     'za' => 1,
//     'zb' => 'test'
//   }
// }

// 将 `breakLength` 设置为例如 150，
// 则将在一行中打印 "Lorem ipsum" 文本。
// 减少 `breakLength` 会将 "Lorem ipsum" 文本分成
// 更小的块。
```

`showHidden` 选项允许检查 [`WeakMap`](http://url.nodejs.cn/JkfoVY) 和 [`WeakSet`](http://url.nodejs.cn/gsMyy2) 条目。 如果条目多于 `maxArrayLength`，则无法保证显示哪些条目。 这意味着两次检索相同的 [`WeakSet`](http://url.nodejs.cn/gsMyy2) 条目可能会导致不同的输出。 此外，没有剩余强引用的条目可能随时被垃圾回收。

```
const { inspect } = require('util');

const obj = { a: 1 };
const obj2 = { b: 2 };
const weakSet = new WeakSet([obj, obj2]);

console.log(inspect(weakSet, { showHidden: true }));
// WeakSet { { a: 1 }, { b: 2 } }
```

`sorted` 选项确保对象的属性插入顺序不会影响 `util.inspect()` 的结果。

```
const { inspect } = require('util');
const assert = require('assert');

const o1 = {
  b: [2, 3, 1],
  a: '`a` comes before `b`',
  c: new Set([2, 3, 1])
};
console.log(inspect(o1, { sorted: true }));
// { a: '`a` comes before `b`', b: [ 2, 3, 1 ], c: Set { 1, 2, 3 } }
console.log(inspect(o1, { sorted: (a, b) => b.localeCompare(a) }));
// { c: Set { 3, 2, 1 }, b: [ 2, 3, 1 ], a: '`a` comes before `b`' }

const o2 = {
  c: new Set([2, 1, 3]),
  a: '`a` comes before `b`',
  b: [2, 3, 1]
};
assert.strict.equal(
  inspect(o1, { sorted: true }),
  inspect(o2, { sorted: true })
);
```

`util.inspect()` 是用于调试的同步方法。 其最大输出长度约为 128 MB。 造成更长输出的输入将被截断。

#### 自定义 util.inspect 的颜色[#](http://nodejs.cn/api-v12/util.html#customizing-utilinspect-colors)

[中英对照](http://nodejs.cn/api-v12/util/customizing_util_inspect_colors.html)

`util.inspect` 的颜色输出（如果启用）可通过 `util.inspect.styles` 和 `util.inspect.colors` 属性全局地自定义。

`util.inspect.styles` 是将样式名称与来自 `util.inspect.colors` 的颜色相关联的映射。

默认的样式和相关的颜色为：

-   `bigint`: `yellow`
-   `boolean`: `yellow`
-   `date`: `magenta`
-   `module`: `underline`
-   `name`: （没有样式）
-   `null`: `bold`
-   `number`: `yellow`
-   `regexp`: `red`
-   `special`: `cyan`（例如，`Proxies`）
-   `string`: `green`
-   `symbol`: `green`
-   `undefined`: `grey`

颜色样式使用 ANSI 控制代码，可能并非所有终端都支持。 要验证颜色支持，则使用 [`tty.hasColors()`](http://nodejs.cn/api-v12/tty.html#tty_writestream_hascolors_count_env)。

下面列出了预定义的控制代码（分组为“修饰符”、“前景色”和“背景色”）。

##### 修饰符[#](http://nodejs.cn/api-v12/util.html#modifiers)

[中英对照](http://nodejs.cn/api-v12/util/modifiers.html)

修饰符的支持因不同的终端而异。 如果不支持，则它们通常会被忽略。

-   `reset` - 将所有（颜色）修饰符重置为其默认值
-   **bold** - 使文本加粗
-   _italic_ - 使文本斜体
-   underline - 使文本下划线
-   ~strikethrough~ - 在文本中间放置一条水平线（别名：`strikeThrough`, `crossedout`, `crossedOut`）
-   `hidden` - 打印文本，但使其不可见（别名：conceal）
-   dim - 颜色强度降低（别名：`faint`）
-   overlined - 使文本上划线
-   blink - 间隔地隐藏和显示文本
-   inverse - 交换前景色和背景色（别名：`swapcolors`、`swapColors`）
-   doubleunderline - 使文本双下划线（别名：`doubleUnderline`）
-   framed - 在文本周围画一个框架

##### 前景颜色[#](http://nodejs.cn/api-v12/util.html#foreground-colors)

[中英对照](http://nodejs.cn/api-v12/util/foreground_colors.html)

-   `black`
-   `red`
-   `green`
-   `yellow`
-   `blue`
-   `magenta`
-   `cyan`
-   `white`
-   `gray`（别名：`grey`、`blackBright`）
-   `redBright`
-   `greenBright`
-   `yellowBright`
-   `blueBright`
-   `magentaBright`
-   `cyanBright`
-   `whiteBright`

##### 背景颜色[#](http://nodejs.cn/api-v12/util.html#background-colors)

[中英对照](http://nodejs.cn/api-v12/util/background_colors.html)

-   `bgBlack`
-   `bgRed`
-   `bgGreen`
-   `bgYellow`
-   `bgBlue`
-   `bgMagenta`
-   `bgCyan`
-   `bgWhite`
-   `bgGray`（别名：`bgGrey`、`bgBlackBright`）
-   `bgRedBright`
-   `bgGreenBright`
-   `bgYellowBright`
-   `bgBlueBright`
-   `bgMagentaBright`
-   `bgCyanBright`
-   `bgWhiteBright`

#### 对象上的自定义检查函数[#](http://nodejs.cn/api-v12/util.html#custom-inspection-functions-on-objects)

[中英对照](http://nodejs.cn/api-v12/util/custom_inspection_functions_on_objects.html)

对象也可以定义自己的 [`[util.inspect.custom](depth, opts)`](http://nodejs.cn/api-v12/util.html#util_util_inspect_custom) 函数，`util.inspect()` 将在检查对象时调用并使用其结果：

```
const util = require('util');

class Box {
  constructor(value) {
    this.value = value;
  }

  [util.inspect.custom](depth, options) {
    if (depth < 0) {
      return options.stylize('[Box]', 'special');
    }

    const newOptions = Object.assign({}, options, {
      depth: options.depth === null ? null : options.depth - 1
    });

    // 五个空格填充，因为这是“Box<”的大小。
    const padding = ' '.repeat(5);
    const inner = util.inspect(this.value, newOptions)
                      .replace(/\n/g, `\n${padding}`);
    return `${options.stylize('Box', 'special')}< ${inner} >`;
  }
}

const box = new Box(true);

util.inspect(box);
// 返回: "Box< true >"
```

自定义的 `[util.inspect.custom](depth, opts)` 函数通常返回一个字符串，但也可能返回一个由 `util.inspect()` 相应格式化的任何类型的值。

```
const util = require('util');

const obj = { foo: 'this will not show up in the inspect() output' };
obj[util.inspect.custom] = (depth) => {
  return { bar: 'baz' };
};

util.inspect(obj);
// 返回: "{ bar: 'baz' }"
```

#### `util.inspect.custom`[#](http://nodejs.cn/api-v12/util.html#utilinspectcustom)

[中英对照](http://nodejs.cn/api-v12/util/util_inspect_custom.html)

-   [<symbol>](http://url.nodejs.cn/i5E1UH) 可用于声明自定义的检查函数。

除了可以通过 `util.inspect.custom` 访问之外，此符号是[全局地注册](http://url.nodejs.cn/ru12Zo)，可以在任何环境中作为 `Symbol.for('nodejs.util.inspect.custom')` 访问。

```
const inspect = Symbol.for('nodejs.util.inspect.custom');

class Password {
  constructor(value) {
    this.value = value;
  }

  toString() {
    return 'xxxxxxxx';
  }

  [inspect]() {
    return `Password <${this.toString()}>`;
  }
}

const password = new Password('r0sebud');
console.log(password);
// 打印 Password <xxxxxxxx>
```

有关更多详细信息，请参阅[对象上的自定义检查函数](http://nodejs.cn/api-v12/util.html#util_custom_inspection_functions_on_objects)。

#### `util.inspect.defaultOptions`[#](http://nodejs.cn/api-v12/util.html#utilinspectdefaultoptions)

[中英对照](http://nodejs.cn/api-v12/util/util_inspect_defaultoptions.html)

新增于: v6.4.0

`defaultOptions` 值允许自定义 `util.inspect` 使用的默认选项。 这对于像 `console.log` 或 `util.format` 这样隐式调用 `util.inspect` 的函数很有用。 它应设置为包含一个或多个有效 [`util.inspect()`](http://nodejs.cn/api-v12/util.html#util_util_inspect_object_options) 选项的对象。 也支持直接设置选项属性。

```
const util = require('util');
const arr = Array(101).fill(0);

console.log(arr); // 记录截断的数组
util.inspect.defaultOptions.maxArrayLength = null;
console.log(arr); // 记录完整的数组
```

### `util.isDeepStrictEqual(val1, val2)`[#](http://nodejs.cn/api-v12/util.html#utilisdeepstrictequalval1-val2)

[中英对照](http://nodejs.cn/api-v12/util/util_isdeepstrictequal_val1_val2.html)

新增于: v9.0.0

-   `val1` [<any>](http://url.nodejs.cn/6sTGdS)
-   `val2` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果 `val1` 和 `val2` 之间存在深度严格相等，则返回 `true`。 否则，返回 `false`。

有关深度严格相等的更多信息，请参见 [`assert.deepStrictEqual()`](http://nodejs.cn/api-v12/assert.html#assert_assert_deepstrictequal_actual_expected_message)。

### `util.promisify(original)`[#](http://nodejs.cn/api-v12/util.html#utilpromisifyoriginal)

[中英对照](http://nodejs.cn/api-v12/util/util_promisify_original.html)

新增于: v8.0.0

-   `original` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<Function>](http://url.nodejs.cn/ceTQa6)

采用遵循常见的错误优先的回调风格的函数（也就是将 `(err, value) => ...` 回调作为最后一个参数），并返回一个返回 promise 的版本。

```
const util = require('util');
const fs = require('fs');

const stat = util.promisify(fs.stat);
stat('.').then((stats) => {
  // 使用 `stats` 做些事情
}).catch((error) => {
  // 处理错误。
});
```

或者，等效地使用 `async function`：

```
const util = require('util');
const fs = require('fs');

const stat = util.promisify(fs.stat);

async function callStat() {
  const stats = await stat('.');
  console.log(`This directory is owned by ${stats.uid}`);
}
```

如果存在 `original[util.promisify.custom]` 属性，则 `promisify` 将返回其值，请参阅[自定义的 promise 化函数](http://nodejs.cn/api-v12/util.html#util_custom_promisified_functions)。

`promisify()` 假设 `original` 是在所有情况下都将回调作为其最后一个参数的函数。 如果 `original` 不是函数，则 `promisify()` 将抛出错误。 如果 `original` 是函数，但其最后一个参数不是错误优先的回调，则它仍然会被传入错误优先的回调作为其最后一个参数。

除非经过特殊处理，否则在类方法或其他使用 `this` 的方法上使用 `promisify()` 可能无法按预期工作：

```
const util = require('util');

class Foo {
  constructor() {
    this.a = 42;
  }

  bar(callback) {
    callback(null, this.a);
  }
}

const foo = new Foo();

const naiveBar = util.promisify(foo.bar);
// TypeError: Cannot read property 'a' of undefined
// naiveBar().then(a => console.log(a));

naiveBar.call(foo).then((a) => console.log(a)); // '42'

const bindBar = naiveBar.bind(foo);
bindBar().then((a) => console.log(a)); // '42'
```

#### 自定义的 promise 化函数[#](http://nodejs.cn/api-v12/util.html#custom-promisified-functions)

[中英对照](http://nodejs.cn/api-v12/util/custom_promisified_functions.html)

使用 `util.promisify.custom` 符号可以覆盖 [`util.promisify()`](http://nodejs.cn/api-v12/util.html#util_util_promisify_original) 的返回值：

```
const util = require('util');

function doSomething(foo, callback) {
  // ...
}

doSomething[util.promisify.custom] = (foo) => {
  return getPromiseSomehow();
};

const promisified = util.promisify(doSomething);
console.log(promisified === doSomething[util.promisify.custom]);
// 打印 'true'
```

这对于原始函数不遵循将错误优先的回调作为最后一个参数的标准格式的情况很有用。

例如，对于接受 `(foo, onSuccessCallback, onErrorCallback)` 的函数：

```
doSomething[util.promisify.custom] = (foo) => {
  return new Promise((resolve, reject) => {
    doSomething(foo, resolve, reject);
  });
};
```

如果 `promisify.custom` 已定义但不是函数，则 `promisify()` 将抛出错误。

#### `util.promisify.custom`[#](http://nodejs.cn/api-v12/util.html#utilpromisifycustom)

[中英对照](http://nodejs.cn/api-v12/util/util_promisify_custom.html)

-   [<symbol>](http://url.nodejs.cn/i5E1UH) 可用于声明自定义的 promise 化的函数变体，参阅[自定义的 promise 化函数](http://nodejs.cn/api-v12/util.html#util_custom_promisified_functions)。

除了可以通过 `util.promisify.custom` 访问之外，此符号是[全局地注册](http://url.nodejs.cn/ru12Zo)，可以在任何环境中作为 `Symbol.for('nodejs.util.promisify.custom')` 访问。

例如，对于接受 `(foo, onSuccessCallback, onErrorCallback)` 的函数：

```
const kCustomPromisifiedSymbol = Symbol.for('nodejs.util.promisify.custom');

doSomething[kCustomPromisifiedSymbol] = (foo) => {
  return new Promise((resolve, reject) => {
    doSomething(foo, resolve, reject);
  });
};
```

### `util.TextDecoder` 类[#](http://nodejs.cn/api-v12/util.html#class-utiltextdecoder)

[中英对照](http://nodejs.cn/api-v12/util/class_util_textdecoder.html)

新增于: v8.3.0

[WHATWG 编码标准](http://url.nodejs.cn/sasgQF) `TextDecoder` API 的实现。

```
const decoder = new TextDecoder('shift_jis');
let string = '';
let buffer;
while (buffer = getNextChunkSomehow()) {
  string += decoder.decode(buffer, { stream: true });
}
string += decoder.decode(); // 流结束
```

#### WHATWG 支持的编码[#](http://nodejs.cn/api-v12/util.html#whatwg-supported-encodings)

[中英对照](http://nodejs.cn/api-v12/util/whatwg_supported_encodings.html)

根据 [WHATWG 编码标准](http://url.nodejs.cn/sasgQF)，`TextDecoder` API 支持的编码在下表中列出。 对于每种编码，可以使用一个或多个别名。

不同的 Node.js 构建配置支持不同的编码集。

##### Encodings Supported Without ICU[#](http://nodejs.cn/api-v12/util.html#encodings-supported-without-icu)

| Encoding | Aliases |
| --- | --- |
| `'utf-8'` | `'unicode-1-1-utf-8'`, `'utf8'` |
| `'utf-16le'` | `'utf-16'` |

##### Encodings Supported by Default (With ICU)[#](http://nodejs.cn/api-v12/util.html#encodings-supported-by-default-with-icu)

| Encoding | Aliases |
| --- | --- |
| `'utf-8'` | `'unicode-1-1-utf-8'`, `'utf8'` |
| `'utf-16le'` | `'utf-16'` |
| `'utf-16be'` |  |

##### Encodings requiring full ICU data[#](http://nodejs.cn/api-v12/util.html#encodings-requiring-full-icu-data)

[中英对照](http://nodejs.cn/api-v12/util/encodings_requiring_full_icu_data.html)

| Encoding | Aliases |
| --- | --- |
| `'ibm866'` | `'866'`, `'cp866'`, `'csibm866'` |
| `'iso-8859-2'` | `'csisolatin2'`, `'iso-ir-101'`, `'iso8859-2'`, `'iso88592'`, `'iso_8859-2'`, `'iso_8859-2:1987'`, `'l2'`, `'latin2'` |
| `'iso-8859-3'` | `'csisolatin3'`, `'iso-ir-109'`, `'iso8859-3'`, `'iso88593'`, `'iso_8859-3'`, `'iso_8859-3:1988'`, `'l3'`, `'latin3'` |
| `'iso-8859-4'` | `'csisolatin4'`, `'iso-ir-110'`, `'iso8859-4'`, `'iso88594'`, `'iso_8859-4'`, `'iso_8859-4:1988'`, `'l4'`, `'latin4'` |
| `'iso-8859-5'` | `'csisolatincyrillic'`, `'cyrillic'`, `'iso-ir-144'`, `'iso8859-5'`, `'iso88595'`, `'iso_8859-5'`, `'iso_8859-5:1988'` |
| `'iso-8859-6'` | `'arabic'`, `'asmo-708'`, `'csiso88596e'`, `'csiso88596i'`, `'csisolatinarabic'`, `'ecma-114'`, `'iso-8859-6-e'`, `'iso-8859-6-i'`, `'iso-ir-127'`, `'iso8859-6'`, `'iso88596'`, `'iso_8859-6'`, `'iso_8859-6:1987'` |
| `'iso-8859-7'` | `'csisolatingreek'`, `'ecma-118'`, `'elot_928'`, `'greek'`, `'greek8'`, `'iso-ir-126'`, `'iso8859-7'`, `'iso88597'`, `'iso_8859-7'`, `'iso_8859-7:1987'`, `'sun_eu_greek'` |
| `'iso-8859-8'` | `'csiso88598e'`, `'csisolatinhebrew'`, `'hebrew'`, `'iso-8859-8-e'`, `'iso-ir-138'`, `'iso8859-8'`, `'iso88598'`, `'iso_8859-8'`, `'iso_8859-8:1988'`, `'visual'` |
| `'iso-8859-8-i'` | `'csiso88598i'`, `'logical'` |
| `'iso-8859-10'` | `'csisolatin6'`, `'iso-ir-157'`, `'iso8859-10'`, `'iso885910'`, `'l6'`, `'latin6'` |
| `'iso-8859-13'` | `'iso8859-13'`, `'iso885913'` |
| `'iso-8859-14'` | `'iso8859-14'`, `'iso885914'` |
| `'iso-8859-15'` | `'csisolatin9'`, `'iso8859-15'`, `'iso885915'`, `'iso_8859-15'`, `'l9'` |
| `'koi8-r'` | `'cskoi8r'`, `'koi'`, `'koi8'`, `'koi8_r'` |
| `'koi8-u'` | `'koi8-ru'` |
| `'macintosh'` | `'csmacintosh'`, `'mac'`, `'x-mac-roman'` |
| `'windows-874'` | `'dos-874'`, `'iso-8859-11'`, `'iso8859-11'`, `'iso885911'`, `'tis-620'` |
| `'windows-1250'` | `'cp1250'`, `'x-cp1250'` |
| `'windows-1251'` | `'cp1251'`, `'x-cp1251'` |
| `'windows-1252'` | `'ansi_x3.4-1968'`, `'ascii'`, `'cp1252'`, `'cp819'`, `'csisolatin1'`, `'ibm819'`, `'iso-8859-1'`, `'iso-ir-100'`, `'iso8859-1'`, `'iso88591'`, `'iso_8859-1'`, `'iso_8859-1:1987'`, `'l1'`, `'latin1'`, `'us-ascii'`, `'x-cp1252'` |
| `'windows-1253'` | `'cp1253'`, `'x-cp1253'` |
| `'windows-1254'` | `'cp1254'`, `'csisolatin5'`, `'iso-8859-9'`, `'iso-ir-148'`, `'iso8859-9'`, `'iso88599'`, `'iso_8859-9'`, `'iso_8859-9:1989'`, `'l5'`, `'latin5'`, `'x-cp1254'` |
| `'windows-1255'` | `'cp1255'`, `'x-cp1255'` |
| `'windows-1256'` | `'cp1256'`, `'x-cp1256'` |
| `'windows-1257'` | `'cp1257'`, `'x-cp1257'` |
| `'windows-1258'` | `'cp1258'`, `'x-cp1258'` |
| `'x-mac-cyrillic'` | `'x-mac-ukrainian'` |
| `'gbk'` | `'chinese'`, `'csgb2312'`, `'csiso58gb231280'`, `'gb2312'`, `'gb_2312'`, `'gb_2312-80'`, `'iso-ir-58'`, `'x-gbk'` |
| `'gb18030'` |  |
| `'big5'` | `'big5-hkscs'`, `'cn-big5'`, `'csbig5'`, `'x-x-big5'` |
| `'euc-jp'` | `'cseucpkdfmtjapanese'`, `'x-euc-jp'` |
| `'iso-2022-jp'` | `'csiso2022jp'` |
| `'shift_jis'` | `'csshiftjis'`, `'ms932'`, `'ms_kanji'`, `'shift-jis'`, `'sjis'`, `'windows-31j'`, `'x-sjis'` |
| `'euc-kr'` | `'cseuckr'`, `'csksc56011987'`, `'iso-ir-149'`, `'korean'`, `'ks_c_5601-1987'`, `'ks_c_5601-1989'`, `'ksc5601'`, `'ksc_5601'`, `'windows-949'` |

不支持 [WHATWG 编码标准](http://url.nodejs.cn/sasgQF)中列出的 `'iso-8859-16'` 编码。

#### `new TextDecoder([encoding[, options]])`[#](http://nodejs.cn/api-v12/util.html#new-textdecoderencoding-options)

[中英对照](http://nodejs.cn/api-v12/util/new_textdecoder_encoding_options.html)

-   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 标识此 `TextDecoder` 实例支持的 `encoding`。 **默认值:** `'utf-8'`。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `fatal` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果解码失败是致命的，则为 `true`。 **默认值:** `false`。
    -   `ignoreBOM` [<boolean>](http://url.nodejs.cn/jFbvuT) 当 `true` 时，`TextDecoder` 将在解码结果中包含字节顺序标记。 当 `false` 时，字节顺序标记将从输出中删除。 此选项仅在 `encoding` 为 `'utf-8'`、`'utf-16be'` 或 `'utf-16le'` 时使用。 **默认值:** `false`。

创建新的 `TextDecoder` 实例。 `encoding` 可以指定支持的编码之一或别名。

`TextDecoder` 类也在全局对象上可用。

#### `textDecoder.decode([input[, options]])`[#](http://nodejs.cn/api-v12/util.html#textdecoderdecodeinput-options)

[中英对照](http://nodejs.cn/api-v12/util/textdecoder_decode_input_options.html)

-   `input` [<ArrayBuffer>](http://url.nodejs.cn/mUbfvF) | [<DataView>](http://url.nodejs.cn/yCdVkD) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) 包含编码数据的 `ArrayBuffer`、`DataView` 或 `TypedArray` 实例。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `stream` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果需要额外的数据块，则为 `true`。 **默认值:** `false`。
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

解码 `input` 并返回字符串。 如果 `options.stream` 是 `true`，则在 `input` 末尾出现的任何不完整的字节序列都会在内部缓冲并在下一次调用 `textDecoder.decode()` 后触发。

如果 `textDecoder.fatal` 是 `true`，则发生的解码错误将导致抛出 `TypeError`。

#### `textDecoder.encoding`[#](http://nodejs.cn/api-v12/util.html#textdecoderencoding)

[中英对照](http://nodejs.cn/api-v12/util/textdecoder_encoding.html)

-   [<string>](http://url.nodejs.cn/9Tw2bK)

`TextDecoder` 实例支持的编码。

#### `textDecoder.fatal`[#](http://nodejs.cn/api-v12/util.html#textdecoderfatal)

[中英对照](http://nodejs.cn/api-v12/util/textdecoder_fatal.html)

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果解码错误导致抛出 `TypeError`，则该值将为 `true`。

#### `textDecoder.ignoreBOM`[#](http://nodejs.cn/api-v12/util.html#textdecoderignorebom)

[中英对照](http://nodejs.cn/api-v12/util/textdecoder_ignorebom.html)

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果解码结果将包含字节顺序标记，则该值将为 `true`。

### `util.TextEncoder` 类[#](http://nodejs.cn/api-v12/util.html#class-utiltextencoder)

[中英对照](http://nodejs.cn/api-v12/util/class_util_textencoder.html)

[WHATWG 编码标准](http://url.nodejs.cn/sasgQF) `TextEncoder` API 的实现。 `TextEncoder` 的所有实例仅支持 UTF-8 编码。

```
const encoder = new TextEncoder();
const uint8array = encoder.encode('this is some data');
```

`TextEncoder` 类也在全局对象上可用。

#### `textEncoder.encode([input])`[#](http://nodejs.cn/api-v12/util.html#textencoderencodeinput)

[中英对照](http://nodejs.cn/api-v12/util/textencoder_encode_input.html)

-   `input` [<string>](http://url.nodejs.cn/9Tw2bK) 要编码的文本。 **默认值:** 空字符串。
-   返回: [<Uint8Array>](http://url.nodejs.cn/ZbDkpm)

对 `input` 字符串进行 UTF-8 编码并返回包含编码字节的 `Uint8Array`。

#### `textEncoder.encodeInto(src, dest)`[#](http://nodejs.cn/api-v12/util.html#textencoderencodeintosrc-dest)

[中英对照](http://nodejs.cn/api-v12/util/textencoder_encodeinto_src_dest.html)

-   `src` [<string>](http://url.nodejs.cn/9Tw2bK) 要编码的文本。
-   `dest` [<Uint8Array>](http://url.nodejs.cn/ZbDkpm) 保存编码结果的数组。
-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `read` [<number>](http://url.nodejs.cn/SXbo1v) 读取的来源的 Unicode 代码单元。
    -   `written` [<number>](http://url.nodejs.cn/SXbo1v) 写入的目标的 UTF-8 字节。

将 `src` 字符串 UTF-8 编码为 `dest` Uint8Array 并返回包含读取的 Unicode 代码单元和写入的 UTF-8 字节的对象。

```
const encoder = new TextEncoder();
const src = 'this is some data';
const dest = new Uint8Array(10);
const { read, written } = encoder.encodeInto(src, dest);
```

#### `textEncoder.encoding`[#](http://nodejs.cn/api-v12/util.html#textencoderencoding)

[中英对照](http://nodejs.cn/api-v12/util/textencoder_encoding.html)

-   [<string>](http://url.nodejs.cn/9Tw2bK)

`TextEncoder` 实例支持的编码。 始终设置为 `'utf-8'`。

### `util.types`[#](http://nodejs.cn/api-v12/util.html#utiltypes)

[中英对照](http://nodejs.cn/api-v12/util/util_types.html)

新增于: v10.0.0

`util.types` 为不同种类的内置对象提供类型检查。 与 `instanceof` 或 `Object.prototype.toString.call(value)` 不同，这些检查不检查可从 JavaScript 访问的对象的属性（如它们的原型），并且通常具有调用 C++ 的开销。

结果通常不会对值在 JavaScript 中公开的属性或行为类型做出任何保证。 它们主要对喜欢在 JavaScript 中进行类型检查的插件开发者有用。

#### `util.types.isAnyArrayBuffer(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisanyarraybuffervalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isanyarraybuffer_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为内置的 [`ArrayBuffer`](http://url.nodejs.cn/mUbfvF) 或 [`SharedArrayBuffer`](http://url.nodejs.cn/6J6LBy) 实例，则返回 `true`。

另见 [`util.types.isArrayBuffer()`](http://nodejs.cn/api-v12/util.html#util_util_types_isarraybuffer_value) 和 [`util.types.isSharedArrayBuffer()`](http://nodejs.cn/api-v12/util.html#util_util_types_issharedarraybuffer_value)。

```
util.types.isAnyArrayBuffer(new ArrayBuffer());  // 返回 true
util.types.isAnyArrayBuffer(new SharedArrayBuffer());  // 返回 true
```

#### `util.types.isArrayBufferView(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisarraybufferviewvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isarraybufferview_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值是 [`ArrayBuffer`](http://url.nodejs.cn/mUbfvF) 视图之一的实例，例如类型化数组对象或 [`DataView`](http://url.nodejs.cn/yCdVkD)，则返回 `true`。 相当于 [`ArrayBuffer.isView()`](http://url.nodejs.cn/JCN3SX)。

```
util.types.isArrayBufferView(new Int8Array());  // true
util.types.isArrayBufferView(Buffer.from('hello world')); // true
util.types.isArrayBufferView(new DataView(new ArrayBuffer(16)));  // true
util.types.isArrayBufferView(new ArrayBuffer());  // false
```

#### `util.types.isArgumentsObject(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisargumentsobjectvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isargumentsobject_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为 `arguments` 对象，则返回 `true`。

```
function foo() {
  util.types.isArgumentsObject(arguments);  // 返回 true
}
```

#### `util.types.isArrayBuffer(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisarraybuffervalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isarraybuffer_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为内置的 [`ArrayBuffer`](http://url.nodejs.cn/mUbfvF) 实例，则返回 `true`。 这不包括 [`SharedArrayBuffer`](http://url.nodejs.cn/6J6LBy) 实例。 通常，最好对两者进行测试；参见 [`util.types.isAnyArrayBuffer()`](http://nodejs.cn/api-v12/util.html#util_util_types_isanyarraybuffer_value)。

```
util.types.isArrayBuffer(new ArrayBuffer());  // 返回 true
util.types.isArrayBuffer(new SharedArrayBuffer());  // 返回 false
```

#### `util.types.isAsyncFunction(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisasyncfunctionvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isasyncfunction_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值是[异步函数](http://url.nodejs.cn/Suojt5)，则返回 `true`。 这只会报告 JavaScript 引擎看到的内容；特别是，如果使用了转译工具，则返回值可能与原始源代码不匹配。

```
util.types.isAsyncFunction(function foo() {});  // 返回 false
util.types.isAsyncFunction(async function foo() {});  // 返回 true
```

#### `util.types.isBigInt64Array(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisbigint64arrayvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isbigint64array_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为 `BigInt64Array` 实例，则返回 `true`。

```
util.types.isBigInt64Array(new BigInt64Array());   // 返回 true
util.types.isBigInt64Array(new BigUint64Array());  // 返回 false
```

#### `util.types.isBigUint64Array(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisbiguint64arrayvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isbiguint64array_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为 `BigUint64Array` 实例，则返回 `true`。

```
util.types.isBigUint64Array(new BigInt64Array());   // 返回 false
util.types.isBigUint64Array(new BigUint64Array());  // 返回 true
```

#### `util.types.isBooleanObject(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisbooleanobjectvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isbooleanobject_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值是布尔对象（例如由 `new Boolean()` 创建），则返回 `true`。

```
util.types.isBooleanObject(false);  // 返回 false
util.types.isBooleanObject(true);   // 返回 false
util.types.isBooleanObject(new Boolean(false)); // 返回 true
util.types.isBooleanObject(new Boolean(true));  // 返回 true
util.types.isBooleanObject(Boolean(false)); // 返回 false
util.types.isBooleanObject(Boolean(true));  // 返回 false
```

#### `util.types.isBoxedPrimitive(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisboxedprimitivevalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isboxedprimitive_value.html)

新增于: v10.11.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值是任何封装的原始对象（例如由 `new Boolean()`、`new String()` 或 `Object(Symbol())` 创建），则返回 `true`。

例如：

```
util.types.isBoxedPrimitive(false); // 返回 false
util.types.isBoxedPrimitive(new Boolean(false)); // 返回 true
util.types.isBoxedPrimitive(Symbol('foo')); // 返回 false
util.types.isBoxedPrimitive(Object(Symbol('foo'))); // 返回 true
util.types.isBoxedPrimitive(Object(BigInt(5))); // 返回 true
```

#### `util.types.isDataView(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisdataviewvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isdataview_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为内置的 [`DataView`](http://url.nodejs.cn/yCdVkD) 实例，则返回 `true`。

```
const ab = new ArrayBuffer(20);
util.types.isDataView(new DataView(ab));  // 返回 true
util.types.isDataView(new Float64Array());  // 返回 false
```

另见 [`ArrayBuffer.isView()`](http://url.nodejs.cn/JCN3SX)。

#### `util.types.isDate(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisdatevalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isdate_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为内置的 [`Date`](http://url.nodejs.cn/A9TMoa) 实例，则返回 `true`。

```
util.types.isDate(new Date());  // 返回 true
```

#### `util.types.isExternal(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisexternalvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isexternal_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值是原生的 `External` 值，则返回 `true`。

原生的 `External` 值是特殊类型的对象，它包含用于从原生代码访问的原始 C++ 指针 (`void*`)，并且没有其他属性。 此类对象由 Node.js 内部或原生插件创建。 在 JavaScript 中，它们是带有 `null` 原型的[冻结](http://url.nodejs.cn/zc6Cc2)对象。

```
#include <js_native_api.h>
#include <stdlib.h>
napi_value result;
static napi_value MyNapi(napi_env env, napi_callback_info info) {
  int* raw = (int*) malloc(1024);
  napi_status status = napi_create_external(env, (void*) raw, NULL, NULL, &result);
  if (status != napi_ok) {
    napi_throw_error(env, NULL, "napi_create_external failed");
    return NULL;
  }
  return result;
}
...
DECLARE_NAPI_PROPERTY("myNapi", MyNapi)
...
```

```
const native = require('napi_addon.node');
const data = native.myNapi();
util.types.isExternal(data); // 返回 true
util.types.isExternal(0); // 返回 false
util.types.isExternal(new String('foo')); // 返回 false
```

有关 `napi_create_external` 的更多信息，请参阅 [`napi_create_external()`](http://nodejs.cn/api-v12/n-api.html#n_api_napi_create_external)。

#### `util.types.isFloat32Array(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisfloat32arrayvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isfloat32array_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为内置的 [`Float32Array`](http://url.nodejs.cn/wRJ94K) 实例，则返回 `true`。

```
util.types.isFloat32Array(new ArrayBuffer());  // 返回 false
util.types.isFloat32Array(new Float32Array());  // 返回 true
util.types.isFloat32Array(new Float64Array());  // 返回 false
```

#### `util.types.isFloat64Array(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisfloat64arrayvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isfloat64array_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为内置的 [`Float64Array`](http://url.nodejs.cn/tmfL9c) 实例，则返回 `true`。

```
util.types.isFloat64Array(new ArrayBuffer());  // 返回 false
util.types.isFloat64Array(new Uint8Array());  // 返回 false
util.types.isFloat64Array(new Float64Array());  // 返回 true
```

#### `util.types.isGeneratorFunction(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisgeneratorfunctionvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isgeneratorfunction_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值是生成器函数，则返回 `true`。 这只会报告 JavaScript 引擎看到的内容；特别是，如果使用了转译工具，则返回值可能与原始源代码不匹配。

```
util.types.isGeneratorFunction(function foo() {});  // 返回 false
util.types.isGeneratorFunction(function* foo() {});  // 返回 true
```

#### `util.types.isGeneratorObject(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisgeneratorobjectvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isgeneratorobject_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值是从内置的生成器函数返回的生成器对象，则返回 `true`。 这只会报告 JavaScript 引擎看到的内容；特别是，如果使用了转译工具，则返回值可能与原始源代码不匹配。

```
function* foo() {}
const generator = foo();
util.types.isGeneratorObject(generator);  // 返回 true
```

#### `util.types.isInt8Array(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisint8arrayvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isint8array_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为内置的 [`Int8Array`](http://url.nodejs.cn/NHXNir) 实例，则返回 `true`。

```
util.types.isInt8Array(new ArrayBuffer());  // 返回 false
util.types.isInt8Array(new Int8Array());  // 返回 true
util.types.isInt8Array(new Float64Array());  // 返回 false
```

#### `util.types.isInt16Array(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisint16arrayvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isint16array_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为内置的 [`Int16Array`](http://url.nodejs.cn/2DjwvZ) 实例，则返回 `true`。

```
util.types.isInt16Array(new ArrayBuffer());  // 返回 false
util.types.isInt16Array(new Int16Array());  // 返回 true
util.types.isInt16Array(new Float64Array());  // 返回 false
```

#### `util.types.isInt32Array(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisint32arrayvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isint32array_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为内置的 [`Int32Array`](http://url.nodejs.cn/MGFZik) 实例，则返回 `true`。

```
util.types.isInt32Array(new ArrayBuffer());  // 返回 false
util.types.isInt32Array(new Int32Array());  // 返回 true
util.types.isInt32Array(new Float64Array());  // 返回 false
```

#### `util.types.isMap(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesismapvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_ismap_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为内置的 [`Map`](http://url.nodejs.cn/EnuJtG) 实例，则返回 `true`。

```
util.types.isMap(new Map());  // 返回 true
```

#### `util.types.isMapIterator(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesismapiteratorvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_ismapiterator_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值是为内置的 [`Map`](http://url.nodejs.cn/EnuJtG) 实例返回的迭代器，则返回 `true`。

```
const map = new Map();
util.types.isMapIterator(map.keys());  // 返回 true
util.types.isMapIterator(map.values());  // 返回 true
util.types.isMapIterator(map.entries());  // 返回 true
util.types.isMapIterator(map[Symbol.iterator]());  // 返回 true
```

#### `util.types.isModuleNamespaceObject(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesismodulenamespaceobjectvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_ismodulenamespaceobject_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值是[模块命名空间对象](http://url.nodejs.cn/uwQPrn)的实例，则返回 `true`。

```
import * as ns from './a.js';

util.types.isModuleNamespaceObject(ns);  // 返回 true
```

#### `util.types.isNativeError(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisnativeerrorvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isnativeerror_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值是内置的 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 类型的实例，则返回 `true`。

```
util.types.isNativeError(new Error());  // 返回 true
util.types.isNativeError(new TypeError());  // 返回 true
util.types.isNativeError(new RangeError());  // 返回 true
```

#### `util.types.isNumberObject(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisnumberobjectvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isnumberobject_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值是数字对象（例如由 `new Number()` 创建），则返回 `true`。

```
util.types.isNumberObject(0);  // 返回 false
util.types.isNumberObject(new Number(0));   // 返回 true
```

#### `util.types.isPromise(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesispromisevalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_ispromise_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为内置的 [`Promise`](http://url.nodejs.cn/ri1kj8)，则返回 `true`。

```
util.types.isPromise(Promise.resolve(42));  // 返回 true
```

#### `util.types.isProxy(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisproxyvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isproxy_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为 [`Proxy`](http://url.nodejs.cn/4mR5dW) 实例，则返回 `true`。

```
const target = {};
const proxy = new Proxy(target, {});
util.types.isProxy(target);  // 返回 false
util.types.isProxy(proxy);  // 返回 true
```

#### `util.types.isRegExp(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisregexpvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isregexp_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值是正则表达式对象，则返回 `true`。

```
util.types.isRegExp(/abc/);  // 返回 true
util.types.isRegExp(new RegExp('abc'));  // 返回 true
```

#### `util.types.isSet(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesissetvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isset_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为内置的 [`Set`](http://url.nodejs.cn/yej4PC) 实例，则返回 `true`。

```
util.types.isSet(new Set());  // 返回 true
```

#### `util.types.isSetIterator(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesissetiteratorvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_issetiterator_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值是为内置的 [`Set`](http://url.nodejs.cn/yej4PC) 实例返回的迭代器，则返回 `true`。

```
const set = new Set();
util.types.isSetIterator(set.keys());  // 返回 true
util.types.isSetIterator(set.values());  // 返回 true
util.types.isSetIterator(set.entries());  // 返回 true
util.types.isSetIterator(set[Symbol.iterator]());  // 返回 true
```

#### `util.types.isSharedArrayBuffer(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesissharedarraybuffervalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_issharedarraybuffer_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为内置的 [`SharedArrayBuffer`](http://url.nodejs.cn/6J6LBy) 实例，则返回 `true`。 这不包括 [`ArrayBuffer`](http://url.nodejs.cn/mUbfvF) 实例。 通常，最好对两者进行测试；参见 [`util.types.isAnyArrayBuffer()`](http://nodejs.cn/api-v12/util.html#util_util_types_isanyarraybuffer_value)。

```
util.types.isSharedArrayBuffer(new ArrayBuffer());  // 返回 false
util.types.isSharedArrayBuffer(new SharedArrayBuffer());  // 返回 true
```

#### `util.types.isStringObject(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisstringobjectvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isstringobject_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值是字符串对象（例如由 `new String()` 创建），则返回 `true`。

```
util.types.isStringObject('foo');  // 返回 false
util.types.isStringObject(new String('foo'));   // 返回 true
```

#### `util.types.isSymbolObject(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesissymbolobjectvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_issymbolobject_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值是符号对象（通过在 `Symbol` 原始类型上调用 `Object()` 创建），则返回 `true`。

```
const symbol = Symbol('foo');
util.types.isSymbolObject(symbol);  // 返回 false
util.types.isSymbolObject(Object(symbol));   // 返回 true
```

#### `util.types.isTypedArray(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesistypedarrayvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_istypedarray_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为内置的 [`TypedArray`](http://url.nodejs.cn/oh3CkV) 实例，则返回 `true`。

```
util.types.isTypedArray(new ArrayBuffer());  // 返回 false
util.types.isTypedArray(new Uint8Array());  // 返回 true
util.types.isTypedArray(new Float64Array());  // 返回 true
```

另见 [`ArrayBuffer.isView()`](http://url.nodejs.cn/JCN3SX)。

#### `util.types.isUint8Array(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisuint8arrayvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isuint8array_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为内置的 [`Uint8Array`](http://url.nodejs.cn/ZbDkpm) 实例，则返回 `true`。

```
util.types.isUint8Array(new ArrayBuffer());  // 返回 false
util.types.isUint8Array(new Uint8Array());  // 返回 true
util.types.isUint8Array(new Float64Array());  // 返回 false
```

#### `util.types.isUint8ClampedArray(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisuint8clampedarrayvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isuint8clampedarray_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为内置的 [`Uint8ClampedArray`](http://url.nodejs.cn/kP17gQ) 实例，则返回 `true`。

```
util.types.isUint8ClampedArray(new ArrayBuffer());  // 返回 false
util.types.isUint8ClampedArray(new Uint8ClampedArray());  // 返回 true
util.types.isUint8ClampedArray(new Float64Array());  // 返回 false
```

#### `util.types.isUint16Array(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisuint16arrayvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isuint16array_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为内置的 [`Uint16Array`](http://url.nodejs.cn/4eJuTr) 实例，则返回 `true`。

```
util.types.isUint16Array(new ArrayBuffer());  // 返回 false
util.types.isUint16Array(new Uint16Array());  // 返回 true
util.types.isUint16Array(new Float64Array());  // 返回 false
```

#### `util.types.isUint32Array(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisuint32arrayvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isuint32array_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为内置的 [`Uint32Array`](http://url.nodejs.cn/xF6oKR) 实例，则返回 `true`。

```
util.types.isUint32Array(new ArrayBuffer());  // 返回 false
util.types.isUint32Array(new Uint32Array());  // 返回 true
util.types.isUint32Array(new Float64Array());  // 返回 false
```

#### `util.types.isWeakMap(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisweakmapvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isweakmap_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为内置的 [`WeakMap`](http://url.nodejs.cn/JkfoVY) 实例，则返回 `true`。

```
util.types.isWeakMap(new WeakMap());  // 返回 true
```

#### `util.types.isWeakSet(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesisweaksetvalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_isweakset_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为内置的 [`WeakSet`](http://url.nodejs.cn/gsMyy2) 实例，则返回 `true`。

```
util.types.isWeakSet(new WeakSet());  // 返回 true
```

#### `util.types.isWebAssemblyCompiledModule(value)`[#](http://nodejs.cn/api-v12/util.html#utiltypesiswebassemblycompiledmodulevalue)

[中英对照](http://nodejs.cn/api-v12/util/util_types_iswebassemblycompiledmodule_value.html)

新增于: v10.0.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果值为内置的 [`WebAssembly.Module`](http://url.nodejs.cn/jrrZmy) 实例，则返回 `true`。

```
const module = new WebAssembly.Module(wasmBuffer);
util.types.isWebAssemblyCompiledModule(module);  // 返回 true
```

### 弃用的 API[#](http://nodejs.cn/api-v12/util.html#deprecated-apis)

[中英对照](http://nodejs.cn/api-v12/util/deprecated_apis.html)

以下 API 已弃用，不应再使用。 应更新现有应用程序和模块以寻找替代方法。

#### `util._extend(target, source)`[#](http://nodejs.cn/api-v12/util.html#util_extendtarget-source)

[中英对照](http://nodejs.cn/api-v12/util/util_extend_target_source.html)

新增于: v0.7.5弃用于: v6.0.0

-   `target` [<Object>](http://url.nodejs.cn/jzn6Ao)
-   `source` [<Object>](http://url.nodejs.cn/jzn6Ao)

`util._extend()` 方法从未打算在内部的 Node.js 模块之外使用。 社区无论如何都找到并使用了它。

它已被弃用，不应在新代码中使用。 JavaScript 通过 [`Object.assign()`](http://url.nodejs.cn/TYhxhX) 提供了非常相似的内置功能。

#### `util.isArray(object)`[#](http://nodejs.cn/api-v12/util.html#utilisarrayobject)

[中英对照](http://nodejs.cn/api-v12/util/util_isarray_object.html)

新增于: v0.6.0弃用于: v4.0.0

-   `object` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

[`Array.isArray()`](http://url.nodejs.cn/PVQvCh) 的别名。

如果给定的 `object` 是 `Array`，则返回 `true`。 否则，返回 `false`。

```
const util = require('util');

util.isArray([]);
// 返回: true
util.isArray(new Array());
// 返回: true
util.isArray({});
// 返回: false
```

#### `util.isBoolean(object)`[#](http://nodejs.cn/api-v12/util.html#utilisbooleanobject)

[中英对照](http://nodejs.cn/api-v12/util/util_isboolean_object.html)

新增于: v0.11.5弃用于: v4.0.0

[稳定性: 0](http://nodejs.cn/api/documentation.html#stability-index) - 弃用: 改为使用 `typeof value === 'boolean'` 。

-   `object` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果给定的 `object` 是 `Boolean`，则返回 `true`。 否则，返回 `false`。

```
const util = require('util');

util.isBoolean(1);
// 返回: false
util.isBoolean(0);
// 返回: false
util.isBoolean(false);
// 返回: true
```

#### `util.isBuffer(object)`[#](http://nodejs.cn/api-v12/util.html#utilisbufferobject)

[中英对照](http://nodejs.cn/api-v12/util/util_isbuffer_object.html)

新增于: v0.11.5弃用于: v4.0.0

-   `object` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果给定的 `object` 是 `Buffer`，则返回 `true`。 否则，返回 `false`。

```
const util = require('util');

util.isBuffer({ length: 0 });
// 返回: false
util.isBuffer([]);
// 返回: false
util.isBuffer(Buffer.from('hello world'));
// 返回: true
```

#### `util.isDate(object)`[#](http://nodejs.cn/api-v12/util.html#utilisdateobject)

[中英对照](http://nodejs.cn/api-v12/util/util_isdate_object.html)

新增于: v0.6.0弃用于: v4.0.0

-   `object` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果给定的 `object` 是 `Date`，则返回 `true`。 否则，返回 `false`。

```
const util = require('util');

util.isDate(new Date());
// 返回: true
util.isDate(Date());
// false（没有 'new' 返回字符串）
util.isDate({});
// 返回: false
```

#### `util.isError(object)`[#](http://nodejs.cn/api-v12/util.html#utiliserrorobject)

[中英对照](http://nodejs.cn/api-v12/util/util_iserror_object.html)

新增于: v0.6.0弃用于: v4.0.0

-   `object` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果给定的 `object` 是 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)，则返回 `true`。 否则，返回 `false`。

```
const util = require('util');

util.isError(new Error());
// 返回: true
util.isError(new TypeError());
// 返回: true
util.isError({ name: 'Error', message: 'an error occurred' });
// 返回: false
```

此方法依赖于 `Object.prototype.toString()` 行为。 当 `object` 参数操作 `@@toStringTag` 时，可能会得到错误的结果。

```
const util = require('util');
const obj = { name: 'Error', message: 'an error occurred' };

util.isError(obj);
// 返回: false
obj[Symbol.toStringTag] = 'Error';
util.isError(obj);
// 返回: true
```

#### `util.isFunction(object)`[#](http://nodejs.cn/api-v12/util.html#utilisfunctionobject)

[中英对照](http://nodejs.cn/api-v12/util/util_isfunction_object.html)

新增于: v0.11.5弃用于: v4.0.0

[稳定性: 0](http://nodejs.cn/api/documentation.html#stability-index) - 弃用: 改为使用 `typeof value === 'function'` 。

-   `object` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果给定的 `object` 是 `Function`，则返回 `true`。 否则，返回 `false`。

```
const util = require('util');

function Foo() {}
const Bar = () => {};

util.isFunction({});
// 返回: false
util.isFunction(Foo);
// 返回: true
util.isFunction(Bar);
// 返回: true
```

#### `util.isNull(object)`[#](http://nodejs.cn/api-v12/util.html#utilisnullobject)

[中英对照](http://nodejs.cn/api-v12/util/util_isnull_object.html)

新增于: v0.11.5弃用于: v4.0.0

[稳定性: 0](http://nodejs.cn/api/documentation.html#stability-index) - 弃用: 改为使用 `value === null` 。

-   `object` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果给定的 `object` 严格为 `null`，则返回 `true`。 否则，返回 `false`。

```
const util = require('util');

util.isNull(0);
// 返回: false
util.isNull(undefined);
// 返回: false
util.isNull(null);
// 返回: true
```

#### `util.isNullOrUndefined(object)`[#](http://nodejs.cn/api-v12/util.html#utilisnullorundefinedobject)

[中英对照](http://nodejs.cn/api-v12/util/util_isnullorundefined_object.html)

新增于: v0.11.5弃用于: v4.0.0

[稳定性: 0](http://nodejs.cn/api/documentation.html#stability-index) - 弃用: 改为使用 `value === undefined || value === null` 。

-   `object` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果给定的 `object` 是 `null` 或 `undefined`，则返回 `true`。 否则，返回 `false`。

```
const util = require('util');

util.isNullOrUndefined(0);
// 返回: false
util.isNullOrUndefined(undefined);
// 返回: true
util.isNullOrUndefined(null);
// 返回: true
```

#### `util.isNumber(object)`[#](http://nodejs.cn/api-v12/util.html#utilisnumberobject)

[中英对照](http://nodejs.cn/api-v12/util/util_isnumber_object.html)

新增于: v0.11.5弃用于: v4.0.0

[稳定性: 0](http://nodejs.cn/api/documentation.html#stability-index) - 弃用: 改为使用 `typeof value === 'number'` 。

-   `object` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果给定的 `object` 是 `Number`，则返回 `true`。 否则，返回 `false`。

```
const util = require('util');

util.isNumber(false);
// 返回: false
util.isNumber(Infinity);
// 返回: true
util.isNumber(0);
// 返回: true
util.isNumber(NaN);
// 返回: true
```

#### `util.isObject(object)`[#](http://nodejs.cn/api-v12/util.html#utilisobjectobject)

[中英对照](http://nodejs.cn/api-v12/util/util_isobject_object.html)

新增于: v0.11.5弃用于: v4.0.0

[稳定性: 0](http://nodejs.cn/api/documentation.html#stability-index) - 弃用: 改为使用 `value !== null && typeof value === 'object'` 。

-   `object` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果给定的 `object` 严格来说是 `Object` 而不是 `Function`（即使函数是 JavaScript 中的对象），则返回 `true`。 否则，返回 `false`。

```
const util = require('util');

util.isObject(5);
// 返回: false
util.isObject(null);
// 返回: false
util.isObject({});
// 返回: true
util.isObject(() => {});
// 返回: false
```

#### `util.isPrimitive(object)`[#](http://nodejs.cn/api-v12/util.html#utilisprimitiveobject)

[中英对照](http://nodejs.cn/api-v12/util/util_isprimitive_object.html)

新增于: v0.11.5弃用于: v4.0.0

[稳定性: 0](http://nodejs.cn/api/documentation.html#stability-index) - 弃用: 改为使用 `(typeof value !== 'object' && typeof value !== 'function') || value === null` 。

-   `object` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果给定的 `object` 是原始类型，则返回 `true`。 否则，返回 `false`。

```
const util = require('util');

util.isPrimitive(5);
// 返回: true
util.isPrimitive('foo');
// 返回: true
util.isPrimitive(false);
// 返回: true
util.isPrimitive(null);
// 返回: true
util.isPrimitive(undefined);
// 返回: true
util.isPrimitive({});
// 返回: false
util.isPrimitive(() => {});
// 返回: false
util.isPrimitive(/^$/);
// 返回: false
util.isPrimitive(new Date());
// 返回: false
```

#### `util.isRegExp(object)`[#](http://nodejs.cn/api-v12/util.html#utilisregexpobject)

[中英对照](http://nodejs.cn/api-v12/util/util_isregexp_object.html)

新增于: v0.6.0弃用于: v4.0.0

-   `object` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果给定的 `object` 是 `RegExp`，则返回 `true`。 否则，返回 `false`。

```
const util = require('util');

util.isRegExp(/some regexp/);
// 返回: true
util.isRegExp(new RegExp('another regexp'));
// 返回: true
util.isRegExp({});
// 返回: false
```

#### `util.isString(object)`[#](http://nodejs.cn/api-v12/util.html#utilisstringobject)

[中英对照](http://nodejs.cn/api-v12/util/util_isstring_object.html)

新增于: v0.11.5弃用于: v4.0.0

[稳定性: 0](http://nodejs.cn/api/documentation.html#stability-index) - 弃用: 改为使用 `typeof value === 'string'` 。

-   `object` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果给定的 `object` 是 `string`，则返回 `true`。 否则，返回 `false`。

```
const util = require('util');

util.isString('');
// 返回: true
util.isString('foo');
// 返回: true
util.isString(String('foo'));
// 返回: true
util.isString(5);
// 返回: false
```

#### `util.isSymbol(object)`[#](http://nodejs.cn/api-v12/util.html#utilissymbolobject)

[中英对照](http://nodejs.cn/api-v12/util/util_issymbol_object.html)

新增于: v0.11.5弃用于: v4.0.0

[稳定性: 0](http://nodejs.cn/api/documentation.html#stability-index) - 弃用: 改为使用 `typeof value === 'symbol'` 。

-   `object` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果给定的 `object` 是 `Symbol`，则返回 `true`。 否则，返回 `false`。

```
const util = require('util');

util.isSymbol(5);
// 返回: false
util.isSymbol('foo');
// 返回: false
util.isSymbol(Symbol('foo'));
// 返回: true
```

#### `util.isUndefined(object)`[#](http://nodejs.cn/api-v12/util.html#utilisundefinedobject)

[中英对照](http://nodejs.cn/api-v12/util/util_isundefined_object.html)

新增于: v0.11.5弃用于: v4.0.0

[稳定性: 0](http://nodejs.cn/api/documentation.html#stability-index) - 弃用: 改为使用 `value === undefined` 。

-   `object` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果给定的 `object` 是 `undefined`，则返回 `true`。 否则，返回 `false`。

```
const util = require('util');

const foo = undefined;
util.isUndefined(5);
// 返回: false
util.isUndefined(foo);
// 返回: true
util.isUndefined(null);
// 返回: false
```

#### `util.log(string)`[#](http://nodejs.cn/api-v12/util.html#utillogstring)

[中英对照](http://nodejs.cn/api-v12/util/util_log_string.html)

新增于: v0.3.0弃用于: v6.0.0

-   `string` [<string>](http://url.nodejs.cn/9Tw2bK)

`util.log()` 方法使用包含的时间戳打印给定的 `string` 到 `stdout`。

```
const util = require('util');

util.log('Timestamped message.');
```
