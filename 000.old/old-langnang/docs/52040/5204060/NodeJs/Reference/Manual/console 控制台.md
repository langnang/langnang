---
created: 2022-07-29T13:12:54 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/console.html
author: 
---

# console 控制台 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/console/console.html)

**源代码:** [lib/console.js](https://github.com/nodejs/node/blob/v12.22.12/lib/console.js)

`console` 模块提供了一个简单的调试控制台，类似于网络浏览器提供的 JavaScript 控制台机制。

该模块导出两个特定组件：

-   `Console` 类，具有 `console.log()`、`console.error()` 和 `console.warn()` 等方法，可用于写入任何 Node.js 流。
-   全局的 `console` 实例，配置为写入 [`process.stdout`](http://nodejs.cn/api-v12/process.html#process_process_stdout) 和 [`process.stderr`](http://nodejs.cn/api-v12/process.html#process_process_stderr)。 全局的 `console` 无需调用 `require('console')` 就可以使用。

_**警告**_：全局的控制台对象的方法既不像与其相似的浏览器 API 那样始终同步，也不像所有其他 Node.js 流那样始终异步。 有关更多信息，请参阅[进程 I/O 的注意事项](http://nodejs.cn/api-v12/process.html#process_a_note_on_process_i_o)。

使用全局的 `console` 的示例：

```
console.log('hello world');
// 打印: hello world 到标准输出
console.log('hello %s', 'world');
// 打印: hello world 到标准输出
console.error(new Error('Whoops, something bad happened'));
// 打印: [Error: Whoops, something bad happened] 到标准错误

const name = 'Will Robinson';
console.warn(`Danger ${name}! Danger!`);
// 打印: Danger Will Robinson! Danger! 到标准错误
```

使用 `Console` 类的示例：

```
const out = getStreamSomehow();
const err = getStreamSomehow();
const myConsole = new console.Console(out, err);

myConsole.log('hello world');
// 打印: hello world 到输出
myConsole.log('hello %s', 'world');
// 打印: hello world 到输出
myConsole.error(new Error('Whoops, something bad happened'));
// 打印: [Error: Whoops, something bad happened] 到错误

const name = 'Will Robinson';
myConsole.warn(`Danger ${name}! Danger!`);
// 打印: Danger Will Robinson! Danger! 到错误
```

### `Console` 类[#](http://nodejs.cn/api-v12/console.html#class-console)

[中英对照](http://nodejs.cn/api-v12/console/class_console.html)

`Console` 类可用于创建具有可配置输出流的简单记录器，并可使用 `require('console').Console` 或 `console.Console`（或它们的解构对应物）访问：

```
const { Console } = require('console');
```

```
const { Console } = console;
```

#### `new Console(stdout[, stderr][, ignoreErrors])`[#](http://nodejs.cn/api-v12/console.html#new-consolestdout-stderr-ignoreerrors)

#### `new Console(options)`[#](http://nodejs.cn/api-v12/console.html#new-consoleoptions)

[中英对照](http://nodejs.cn/api-v12/console/new_console_options.html)

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `stdout` [<stream.Writable>](http://nodejs.cn/api/stream.html#class-streamwritable)
    -   `stderr` [<stream.Writable>](http://nodejs.cn/api/stream.html#class-streamwritable)
    -   `ignoreErrors` [<boolean>](http://url.nodejs.cn/jFbvuT) 写入底层流时忽略错误。 **默认值:** `true`。
    -   `colorMode` [<boolean>](http://url.nodejs.cn/jFbvuT) | [<string>](http://url.nodejs.cn/9Tw2bK) 为此 `Console` 实例设置颜色支持。 设置为 `true` 可在检查值时进行着色。 设置为 `false` 会在检查值时禁用着色。 设置为 `'auto'` 使颜色支持取决于 `isTTY` 属性的值和 `getColorDepth()` 在相应流上返回的值。 如果同时设置了 `inspectOptions.colors`，则无法使用此选项。 **默认值:** `'auto'`。
    -   `inspectOptions` [<Object>](http://url.nodejs.cn/jzn6Ao) 指定传给 [`util.inspect()`](http://nodejs.cn/api-v12/util.html#util_util_inspect_object_options) 的选项。
    -   `groupIndentation` [<number>](http://url.nodejs.cn/SXbo1v) 设置组缩进。 **默认值:** `2`。

使用一个或两个可写流实例创建新的 `Console`。 `stdout` 是用于打印日志或信息输出的可写流。 `stderr` 用于警告或错误输出。 如果未提供 `stderr`，则 `stdout` 用于 `stderr`。

```
const output = fs.createWriteStream('./stdout.log');
const errorOutput = fs.createWriteStream('./stderr.log');
// 自定义的简单记录器
const logger = new Console({ stdout: output, stderr: errorOutput });
// 像控制台一样使用它
const count = 5;
logger.log('count: %d', count);
// 在 stdout.log 中：count 5
```

全局的 `console` 是特殊的 `Console`，它的输出被发送到 [`process.stdout`](http://nodejs.cn/api-v12/process.html#process_process_stdout) 和 [`process.stderr`](http://nodejs.cn/api-v12/process.html#process_process_stderr)。 它相当于调用：

```
new Console({ stdout: process.stdout, stderr: process.stderr });
```

#### `console.assert(value[, ...message])`[#](http://nodejs.cn/api-v12/console.html#consoleassertvalue-message)

[中英对照](http://nodejs.cn/api-v12/console/console_assert_value_message.html)

-   `value` [<any>](http://url.nodejs.cn/6sTGdS) 测试为真的值。
-   `...message` [<any>](http://url.nodejs.cn/6sTGdS) 除了 `value` 之外的所有参数都用作错误消息。

如果 `value` 为[假值](http://url.nodejs.cn/Dyv3rW)或省略，则 `console.assert()` 写入一条消息。 它只写入一条消息，不会影响执行。 输出始终以 `"Assertion failed"` 开头。 如果提供，则使用 [`util.format()`](http://nodejs.cn/api-v12/util.html#util_util_format_format_args) 格式化 `message`。

如果 `value` 为[真值](http://url.nodejs.cn/Fn23EW)，则什么也不会发生。

```
console.assert(true, 'does nothing');

console.assert(false, 'Whoops %s work', 'didn\'t');
// Assertion failed: Whoops didn't work

console.assert();
// Assertion failed
```

#### `console.clear()`[#](http://nodejs.cn/api-v12/console.html#consoleclear)

[中英对照](http://nodejs.cn/api-v12/console/console_clear.html)

新增于: v8.3.0

当 `stdout` 是终端时，调用 `console.clear()` 将尝试清除终端。 当 `stdout` 不是终端时，此方法不执行任何操作。

`console.clear()` 的具体操作可能因操作系统和终端类型而异。 对于大多数 Linux 操作系统，`console.clear()` 的操作类似于 `clear` shell 命令。 在 Windows 上，`console.clear()` 将仅清除 Node.js 二进制文件的当前终端视口中的输出。

#### `console.count([label])`[#](http://nodejs.cn/api-v12/console.html#consolecountlabel)

[中英对照](http://nodejs.cn/api-v12/console/console_count_label.html)

新增于: v8.3.0

-   `label` [<string>](http://url.nodejs.cn/9Tw2bK) 计数器的显示标签。 **默认值:** `'default'`。

维护一个特定于 `label` 的内部计数器，并向 `stdout` 输出使用给定 `label` 调用 `console.count()` 的次数。

```
> console.count()
default: 1
undefined
> console.count('default')
default: 2
undefined
> console.count('abc')
abc: 1
undefined
> console.count('xyz')
xyz: 1
undefined
> console.count('abc')
abc: 2
undefined
> console.count()
default: 3
undefined
>
```

#### `console.countReset([label])`[#](http://nodejs.cn/api-v12/console.html#consolecountresetlabel)

[中英对照](http://nodejs.cn/api-v12/console/console_countreset_label.html)

新增于: v8.3.0

-   `label` [<string>](http://url.nodejs.cn/9Tw2bK) 计数器的显示标签。 **默认值:** `'default'`。

重置特定于 `label` 的内部计数器。

```
> console.count('abc');
abc: 1
undefined
> console.countReset('abc');
undefined
> console.count('abc');
abc: 1
undefined
>
```

#### `console.debug(data[, ...args])`[#](http://nodejs.cn/api-v12/console.html#consoledebugdata-args)

[中英对照](http://nodejs.cn/api-v12/console/console_debug_data_args.html)

-   `data` [<any>](http://url.nodejs.cn/6sTGdS)
-   `...args` [<any>](http://url.nodejs.cn/6sTGdS)

`console.debug()` 函数是 [`console.log()`](http://nodejs.cn/api-v12/console.html#console_console_log_data_args) 的别名。

#### `console.dir(obj[, options])`[#](http://nodejs.cn/api-v12/console.html#consoledirobj-options)

[中英对照](http://nodejs.cn/api-v12/console/console_dir_obj_options.html)

新增于: v0.1.101

-   `obj` [<any>](http://url.nodejs.cn/6sTGdS)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `showHidden` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 `true`，则对象的不可枚举和符号属性也将显示。 **默认值:** `false`。
    -   `depth` [<number>](http://url.nodejs.cn/SXbo1v) 告诉 [`util.inspect()`](http://nodejs.cn/api-v12/util.html#util_util_inspect_object_options) 在格式化对象时递归多少次。 这对于检查大型复杂对象很有用。 要使其无限递归，则传入 `null`。 **默认值:** `2`。
    -   `colors` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 `true`，则输出将使用 ANSI 颜色代码进行样式设置。 颜色可自定义；请参阅[自定义 `util.inspect()` 颜色](http://nodejs.cn/api-v12/util.html#util_customizing_util_inspect_colors)。 **默认值:** `false`。

在 `obj` 上使用 [`util.inspect()`](http://nodejs.cn/api-v12/util.html#util_util_inspect_object_options) 并将结果字符串打印到 `stdout`。 此函数绕过在 `obj` 上定义的任何自定义 `inspect()` 函数。

#### `console.dirxml(...data)`[#](http://nodejs.cn/api-v12/console.html#consoledirxmldata)

[中英对照](http://nodejs.cn/api-v12/console/console_dirxml_data.html)

-   `...data` [<any>](http://url.nodejs.cn/6sTGdS)

此方法调用 `console.log()` 将接收到的参数传给它。 此方法不会产生任何 XML 格式。

#### `console.error([data][, ...args])`[#](http://nodejs.cn/api-v12/console.html#consoleerrordata-args)

[中英对照](http://nodejs.cn/api-v12/console/console_error_data_args.html)

新增于: v0.1.100

-   `data` [<any>](http://url.nodejs.cn/6sTGdS)
-   `...args` [<any>](http://url.nodejs.cn/6sTGdS)

使用换行符打印到 `stderr`。 可以传入多个参数，其中第一个用作主要消息，所有其他参数用作类似于 [`printf(3)`](http://url.nodejs.cn/E2r4iW) 的替换值（所有参数都传给 [`util.format()`](http://nodejs.cn/api-v12/util.html#util_util_format_format_args)）。

```
const code = 5;
console.error('error #%d', code);
// 打印: error #5 到标准错误
console.error('error', code);
// 打印: error 5 到标准错误
```

如果在第一个字符串中找不到格式化元素（例如 `%d`），则在每个参数上调用 [`util.inspect()`](http://nodejs.cn/api-v12/util.html#util_util_inspect_object_options) 并将结果字符串值连接起来。 有关详细信息，请参阅 [`util.format()`](http://nodejs.cn/api-v12/util.html#util_util_format_format_args)。

#### `console.group([...label])`[#](http://nodejs.cn/api-v12/console.html#consolegrouplabel)

[中英对照](http://nodejs.cn/api-v12/console/console_group_label.html)

新增于: v8.5.0

-   `...label` [<any>](http://url.nodejs.cn/6sTGdS)

将后续行的缩进增加 `groupIndentation` 长度的空格。

如果提供了一个或多个 `label`，则首先打印这些 `label`，没有额外的缩进。

#### `console.groupCollapsed()`[#](http://nodejs.cn/api-v12/console.html#consolegroupcollapsed)

[中英对照](http://nodejs.cn/api-v12/console/console_groupcollapsed.html)

新增于: v8.5.0

[`console.group()`](http://nodejs.cn/api-v12/console.html#console_console_group_label) 的别名。

#### `console.groupEnd()`[#](http://nodejs.cn/api-v12/console.html#consolegroupend)

[中英对照](http://nodejs.cn/api-v12/console/console_groupend.html)

新增于: v8.5.0

将后续行的缩进减少 `groupIndentation` 长度的空格。

#### `console.info([data][, ...args])`[#](http://nodejs.cn/api-v12/console.html#consoleinfodata-args)

[中英对照](http://nodejs.cn/api-v12/console/console_info_data_args.html)

新增于: v0.1.100

-   `data` [<any>](http://url.nodejs.cn/6sTGdS)
-   `...args` [<any>](http://url.nodejs.cn/6sTGdS)

`console.info()` 函数是 [`console.log()`](http://nodejs.cn/api-v12/console.html#console_console_log_data_args) 的别名。

#### `console.log([data][, ...args])`[#](http://nodejs.cn/api-v12/console.html#consolelogdata-args)

[中英对照](http://nodejs.cn/api-v12/console/console_log_data_args.html)

新增于: v0.1.100

-   `data` [<any>](http://url.nodejs.cn/6sTGdS)
-   `...args` [<any>](http://url.nodejs.cn/6sTGdS)

使用换行符打印到 `stdout`。 可以传入多个参数，其中第一个用作主要消息，所有其他参数用作类似于 [`printf(3)`](http://url.nodejs.cn/E2r4iW) 的替换值（所有参数都传给 [`util.format()`](http://nodejs.cn/api-v12/util.html#util_util_format_format_args)）。

```
const count = 5;
console.log('count: %d', count);
// 打印: count: 5 到标准输出
console.log('count:', count);
// 打印: count: 5 到标准输出
```

有关详细信息，请参阅 [`util.format()`](http://nodejs.cn/api-v12/util.html#util_util_format_format_args)。

#### `console.table(tabularData[, properties])`[#](http://nodejs.cn/api-v12/console.html#consoletabletabulardata-properties)

[中英对照](http://nodejs.cn/api-v12/console/console_table_tabulardata_properties.html)

新增于: v10.0.0

-   `tabularData` [<any>](http://url.nodejs.cn/6sTGdS)
-   `properties` [<string\[\]>](http://url.nodejs.cn/9Tw2bK) 用于构造表格的替代属性。

尝试用 `tabularData` 的属性的列（或使用 `properties`）和 `tabularData` 的行构建表格并记录它。 如果无法将其解析为表格，则回退到仅记录参数。

```
// 这些无法解析为表格数据
console.table(Symbol());
// Symbol()

console.table(undefined);
// undefined

console.table([{ a: 1, b: 'Y' }, { a: 'Z', b: 2 }]);
// ┌─────────┬─────┬─────┐
// │ (index) │  a  │  b  │
// ├─────────┼─────┼─────┤
// │    0    │  1  │ 'Y' │
// │    1    │ 'Z' │  2  │
// └─────────┴─────┴─────┘

console.table([{ a: 1, b: 'Y' }, { a: 'Z', b: 2 }], ['a']);
// ┌─────────┬─────┐
// │ (index) │  a  │
// ├─────────┼─────┤
// │    0    │  1  │
// │    1    │ 'Z' │
// └─────────┴─────┘
```

#### `console.time([label])`[#](http://nodejs.cn/api-v12/console.html#consoletimelabel)

[中英对照](http://nodejs.cn/api-v12/console/console_time_label.html)

新增于: v0.1.104

-   `label` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'default'`

启动可用于计算操作持续时间的计时器。 计时器由唯一的 `label` 标识。

#### `console.timeEnd([label])`[#](http://nodejs.cn/api-v12/console.html#consoletimeendlabel)

[中英对照](http://nodejs.cn/api-v12/console/console_timeend_label.html)

-   `label` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'default'`

停止之前通过调用 [`console.time()`](http://nodejs.cn/api-v12/console.html#console_console_time_label) 启动的计时器并将结果打印到 `stdout`：

```
console.time('100-elements');
for (let i = 0; i < 100; i++) {}
console.timeEnd('100-elements');
// 打印 100-elements: 225.438ms
```

#### `console.timeLog([label][, ...data])`[#](http://nodejs.cn/api-v12/console.html#consoletimeloglabel-data)

[中英对照](http://nodejs.cn/api-v12/console/console_timelog_label_data.html)

新增于: v10.7.0

-   `label` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'default'`
-   `...data` [<any>](http://url.nodejs.cn/6sTGdS)

对于先前通过调用 [`console.time()`](http://nodejs.cn/api-v12/console.html#console_console_time_label) 启动的计时器，将经过时间和其他 `data` 参数打印到 `stdout`：

```
console.time('process');
const value = expensiveProcess1(); // 返回 42
console.timeLog('process', value);
// 打印 "process: 365.227ms 42"
doExpensiveProcess2(value);
console.timeEnd('process');
```

#### `console.trace([message][, ...args])`[#](http://nodejs.cn/api-v12/console.html#consoletracemessage-args)

[中英对照](http://nodejs.cn/api-v12/console/console_trace_message_args.html)

新增于: v0.1.104

-   `message` [<any>](http://url.nodejs.cn/6sTGdS)
-   `...args` [<any>](http://url.nodejs.cn/6sTGdS)

将字符串 `'Trace: '` 打印到 `stderr`，然后是 [`util.format()`](http://nodejs.cn/api-v12/util.html#util_util_format_format_args) 格式的消息和到代码中当前位置的堆栈跟踪。

```
console.trace('Show me');
// 打印: (（堆栈跟踪将根据调用跟踪的位置而有所不同）)
//  Trace: Show me
//    at repl:2:9
//    at REPLServer.defaultEval (repl.js:248:27)
//    at bound (domain.js:287:14)
//    at REPLServer.runBound [as eval] (domain.js:300:12)
//    at REPLServer.<anonymous> (repl.js:412:12)
//    at emitOne (events.js:82:20)
//    at REPLServer.emit (events.js:169:7)
//    at REPLServer.Interface._onLine (readline.js:210:10)
//    at REPLServer.Interface._line (readline.js:549:8)
//    at REPLServer.Interface._ttyWrite (readline.js:826:14)
```

#### `console.warn([data][, ...args])`[#](http://nodejs.cn/api-v12/console.html#consolewarndata-args)

[中英对照](http://nodejs.cn/api-v12/console/console_warn_data_args.html)

新增于: v0.1.100

-   `data` [<any>](http://url.nodejs.cn/6sTGdS)
-   `...args` [<any>](http://url.nodejs.cn/6sTGdS)

`console.warn()` 函数是 [`console.error()`](http://nodejs.cn/api-v12/console.html#console_console_error_data_args) 的别名。

### 仅用于检查器的方法[#](http://nodejs.cn/api-v12/console.html#inspector-only-methods)

[中英对照](http://nodejs.cn/api-v12/console/inspector_only_methods.html)

以下方法由 V8 引擎在通用 API 中公开，但不显示任何内容，除非与[检查器](http://nodejs.cn/api-v12/debugger.html)结合使用（`--inspect` 标志）。

#### `console.profile([label])`[#](http://nodejs.cn/api-v12/console.html#consoleprofilelabel)

[中英对照](http://nodejs.cn/api-v12/console/console_profile_label.html)

新增于: v8.0.0

-   `label` [<string>](http://url.nodejs.cn/9Tw2bK)

除非在检查器中使用，否则此方法不会显示任何内容。 `console.profile()` 方法启动带有可选标签的 JavaScript CPU 配置文件，直到调用 [`console.profileEnd()`](http://nodejs.cn/api-v12/console.html#console_console_profileend_label)。 然后将配置文件添加到检查器的**配置文件**面板中。

```
console.profile('MyLabel');
// 一些代码
console.profileEnd('MyLabel');
// 将配置文件“MyLabel”添加到检查器的配置文件面板。
```

#### `console.profileEnd([label])`[#](http://nodejs.cn/api-v12/console.html#consoleprofileendlabel)

[中英对照](http://nodejs.cn/api-v12/console/console_profileend_label.html)

新增于: v8.0.0

-   `label` [<string>](http://url.nodejs.cn/9Tw2bK)

除非在检查器中使用，否则此方法不会显示任何内容。 如果已启动，则停止当前的 JavaScript CPU 分析会话并将报告打印到检查器的**配置文件**面板。 有关示例，请参见 [`console.profile()`](http://nodejs.cn/api-v12/console.html#console_console_profile_label)。

如果在没有标签的情况下调用此方法，则会停止最近启动的配置文件。

#### `console.timeStamp([label])`[#](http://nodejs.cn/api-v12/console.html#consoletimestamplabel)

[中英对照](http://nodejs.cn/api-v12/console/console_timestamp_label.html)

新增于: v8.0.0

-   `label` [<string>](http://url.nodejs.cn/9Tw2bK)

除非在检查器中使用，否则此方法不会显示任何内容。 `console.timeStamp()` 方法将带有标签 `'label'` 的事件添加到检查器的**时间轴**面板。
