---
created: 2022-07-29T13:12:53 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/repl.html
author: 
---

# repl 交互式解释器 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/repl/repl.html)

**源代码:** [lib/repl.js](https://github.com/nodejs/node/blob/v12.22.12/lib/repl.js)

`repl` 模块提供了一个读取-评估-打印-循环 (REPL) 实现，它既可以作为独立程序使用，也可以包含在其他应用程序中。 可以使用以下方式访问它：

```
const repl = require('repl');
```

### 设计与特性[#](http://nodejs.cn/api-v12/repl.html#design-and-features)

[中英对照](http://nodejs.cn/api-v12/repl/design_and_features.html)

`repl` 模块导出 [`repl.REPLServer`](http://nodejs.cn/api-v12/repl.html#repl_class_replserver) 类。 当运行时，[`repl.REPLServer`](http://nodejs.cn/api-v12/repl.html#repl_class_replserver) 的实例将接受用户输入的单行，根据用户定义的评估函数评估它们，然后输出结果。 输入和输出可能分别来自 `stdin` 和 `stdout`，也可能连接到任何 Node.js [流](http://nodejs.cn/api-v12/stream.html)。

[`repl.REPLServer`](http://nodejs.cn/api-v12/repl.html#repl_class_replserver) 实例支持自动补全输入、补全预览、简单的 Emacs 风格的行编辑、多行输入、类 [ZSH](http://url.nodejs.cn/7UdTEN) 的反向搜索、类 [ZSH](http://url.nodejs.cn/7UdTEN) 的基于子串的历史搜索、ANSI 风格的输出、保存和恢复当前 REPL 会话状态、错误恢复和可定制的评估函数。 不支持 ANSI 风格和 Emacs 风格的行编辑的终端会自动回退到有限的功能集。

#### 命令与特殊键[#](http://nodejs.cn/api-v12/repl.html#commands-and-special-keys)

[中英对照](http://nodejs.cn/api-v12/repl/commands_and_special_keys.html)

所有 REPL 实例都支持以下特殊命令：

-   `.break`:
-   `.clear`: 将 REPL `context` 重置为空对象并清除任何输入的多行表达式。
-   `.exit`: 关闭 I/O 流，导致 REPL 退出。
-   `.help`: 显示此特殊命令列表。
-   `.save`: 将当前 REPL 会话保存到文件：`> .save ./file/to/save.js`
-   `.load`: 将文件加载到当前 REPL 会话中。 `> .load ./file/to/load.js`
-   `.editor`:

```
> .editor
// 进入编辑器模式（^D 完成，^C 取消）
function welcome(name) {
  return `Hello ${name}!`;
}

welcome('Node.js User');

// ^D
'Hello Node.js User!'
>
```

REPL 中的以下组合键具有这些特殊效果：

-   `<ctrl>-C`: 当在空白行上按两次时，效果与 `.exit` 命令相同。
-   `<ctrl>-D`:
-   `<tab>`: 当在输入其他输入时按下时，显示相关的自动完成选项。

有关反向搜索的键绑定，请参阅 [`reverse-i-search`](http://nodejs.cn/api-v12/repl.html#repl_reverse_i_search)。 对于所有其他键绑定，请参阅 [TTY 键绑定](http://nodejs.cn/api-v12/readline.html#readline_tty_keybindings)。

#### 默认的解释器[#](http://nodejs.cn/api-v12/repl.html#default-evaluation)

[中英对照](http://nodejs.cn/api-v12/repl/default_evaluation.html)

默认情况下，[`repl.REPLServer`](http://nodejs.cn/api-v12/repl.html#repl_class_replserver) 的所有实例都使用评估函数来评估 JavaScript 表达式并提供对 Node.js 内置模块的访问。 可以通过在创建 [`repl.REPLServer`](http://nodejs.cn/api-v12/repl.html#repl_class_replserver) 实例时传入替代评估函数来覆盖此默认行为。

##### JavaScript 表达式[#](http://nodejs.cn/api-v12/repl.html#javascript-expressions)

[中英对照](http://nodejs.cn/api-v12/repl/javascript_expressions.html)

默认的求值器支持 JavaScript 表达式的直接求值：

```
> 1 + 1
2
> const m = 2
undefined
> m + 1
3
```

除非在块或函数内另有作用域，否则隐式声明或使用 `const`、`let` 或 `var` 关键字声明的变量在全局作用域内声明。

##### 全局作用域与局部作用域[#](http://nodejs.cn/api-v12/repl.html#global-and-local-scope)

[中英对照](http://nodejs.cn/api-v12/repl/global_and_local_scope.html)

默认求值器提供对全局作用域中存在的任何变量的访问。 可以通过将变量分配给与每个 `REPLServer` 关联的 `context` 对象来显式地向 REPL 公开变量：

```
const repl = require('repl');
const msg = 'message';

repl.start('> ').context.m = msg;
```

`context` 对象中的属性在 REPL 中显示为本地：

```
$ node repl_test.js
> m
'message'
```

默认情况下上下文属性不是只读的。 要指定只读的全局变量，则必须使用 `Object.defineProperty()` 定义上下文属性：

```
const repl = require('repl');
const msg = 'message';

const r = repl.start('> ');
Object.defineProperty(r.context, 'm', {
  configurable: false,
  enumerable: true,
  value: msg
});
```

##### 访问 Node.js 核心模块[#](http://nodejs.cn/api-v12/repl.html#accessing-core-nodejs-modules)

[中英对照](http://nodejs.cn/api-v12/repl/accessing_core_node_js_modules.html)

默认的求值器会在使用时自动将 Node.js 核心模块加载到 REPL 环境中。 例如，除非另外声明为全局变量或作用域变量，否则输入 `fs` 将按需评估为 `global.fs = require('fs')`。

```
> fs.createReadStream('./some/file');
```

##### 全局的未捕获异常[#](http://nodejs.cn/api-v12/repl.html#global-uncaught-exceptions)

[中英对照](http://nodejs.cn/api-v12/repl/global_uncaught_exceptions.html)

REPL 使用 [`domain`](http://nodejs.cn/api-v12/domain.html) 模块来捕获该 REPL 会话的所有未捕获的异常。

在 REPL 中使用 [`domain`](http://nodejs.cn/api-v12/domain.html) 模块有这些副作用：

-   未捕获的异常仅在独立 REPL 中触发 [`'uncaughtException'`](http://nodejs.cn/api-v12/process.html#process_event_uncaughtexception) 事件。
    
-   尝试使用 \[`process.setExceptionCaptureCallback()`\]\[\] 会抛出 [`ERR_DOMAIN_CANNOT_SET_UNCAUGHT_EXCEPTION_CAPTURE`](http://nodejs.cn/api-v12/errors.html#errors_err_domain_cannot_set_uncaught_exception_capture) 错误。
    

```
process.on('uncaughtException', () => console.log('Uncaught'));

throw new Error('foobar');
// Uncaught
```

```
process.on('uncaughtException', () => console.log('Uncaught'));
// TypeError [ERR_INVALID_REPL_INPUT]: Listeners for `uncaughtException`
// 

throw new Error('foobar');
// 
// 
```

##### \_（下划线）变量的赋值[#](http://nodejs.cn/api-v12/repl.html#assignment-of-the-_-underscore-variable)

[中英对照](http://nodejs.cn/api-v12/repl/assignment_of_the_underscore_variable.html)

默认情况下，默认求值器会将最近求值的表达式的结果分配给特殊变量 `_`（下划线）。 将 `_` 显式设置为一个值将禁用此行为。

```
> [ 'a', 'b', 'c' ]
[ 'a', 'b', 'c' ]
> _.length
3
> _ += 1
Expression assignment to _ now disabled.
4
> 1 + 1
2
> _
4
```

同样，`_error` 将引用上次看到的错误，如果有的话。 将 `_error` 显式设置为一个值将禁用此行为。

```
> throw new Error('foo');
Error: foo
> _error.message
'foo'
```

##### await 关键词[#](http://nodejs.cn/api-v12/repl.html#await-keyword)

With the [`--experimental-repl-await`](http://nodejs.cn/api-v12/cli.html#cli_experimental_repl_await) command line option specified, experimental support for the `await` keyword is enabled.

```
> await Promise.resolve(123)
123
> await Promise.reject(new Error('REPL await'))
Error: REPL await
    at repl:1:45
> const timeout = util.promisify(setTimeout);
undefined
> const old = Date.now(); await timeout(1000); console.log(Date.now() - old);
1002
undefined
```

#### 反向i搜索[#](http://nodejs.cn/api-v12/repl.html#reverse-i-search)

[中英对照](http://nodejs.cn/api-v12/repl/reverse_i_search.html)

新增于: v12.17.0

REPL 支持类似于 [ZSH](http://url.nodejs.cn/7UdTEN) 的双向反向搜索。

改变方向立即从当前位置开始搜索预期方向的下一个条目。

#### 自定义的解释函数[#](http://nodejs.cn/api-v12/repl.html#custom-evaluation-functions)

[中英对照](http://nodejs.cn/api-v12/repl/custom_evaluation_functions.html)

当新建 [`repl.REPLServer`](http://nodejs.cn/api-v12/repl.html#repl_class_replserver) 时，可能会提供自定义评价函数。 例如，这可用于实现完全定制的 REPL 应用程序。

以下说明了一个 REPL 的假设示例，该示例执行将文本从一种语言翻译成另一种语言：

```
const repl = require('repl');
const { Translator } = require('translator');

const myTranslator = new Translator('en', 'fr');

function myEval(cmd, context, filename, callback) {
  callback(null, myTranslator.translate(cmd));
}

repl.start({ prompt: '> ', eval: myEval });
```

##### 可恢复的错误[#](http://nodejs.cn/api-v12/repl.html#recoverable-errors)

As a user is typing input into the REPL prompt, pressing the `<enter>` key will send the current line of input to the `eval` function. In order to support multi-line input, the eval function can return an instance of `repl.Recoverable` to the provided callback function:

```
function myEval(cmd, context, filename, callback) {
  let result;
  try {
    result = vm.runInThisContext(cmd);
  } catch (e) {
    if (isRecoverableError(e)) {
      return callback(new repl.Recoverable(e));
    }
  }
  callback(null, result);
}

function isRecoverableError(error) {
  if (error.name === 'SyntaxError') {
    return /^(Unexpected end of input|Unexpected token)/.test(error.message);
  }
  return false;
}
```

#### 自定义 REPL 输出[#](http://nodejs.cn/api-v12/repl.html#customizing-repl-output)

[中英对照](http://nodejs.cn/api-v12/repl/customizing_repl_output.html)

默认情况下，[`repl.REPLServer`](http://nodejs.cn/api-v12/repl.html#repl_class_replserver) 实例在将输出写入提供的 `Writable` 流（默认为 `process.stdout`）之前使用 [`util.inspect()`](http://nodejs.cn/api-v12/util.html#util_util_inspect_object_options) 方法格式化输出。 `showProxy` 检查选项默认设置为 true，`colors` 选项设置为 true，具体取决于 REPL 的 `useColors` 选项。

可以在构造时指定 `useColors` 布尔选项，以指示默认编写器使用 ANSI 风格的代码为 `util.inspect()` 方法的输出着色。

如果 REPL 作为独立程序运行，也可以通过使用 `inspect.replDefaults` 属性（反映了 [`util.inspect()`](http://nodejs.cn/api-v12/util.html#util_util_inspect_object_options) 中的 `defaultOptions`）从 REPL 内部更改 REPL 的[检查默认值](http://nodejs.cn/api-v12/util.html#util_util_inspect_object_options)。

```
> util.inspect.replDefaults.compact = false;
false
> [1]
[
  1
]
>
```

要完全自定义 [`repl.REPLServer`](http://nodejs.cn/api-v12/repl.html#repl_class_replserver) 实例的输出，则在构建时为 `writer` 选项传入新函数。 例如，下面的示例只是将任何输入文本转换为大写：

```
const repl = require('repl');

const r = repl.start({ prompt: '> ', eval: myEval, writer: myWriter });

function myEval(cmd, context, filename, callback) {
  callback(null, cmd);
}

function myWriter(output) {
  return output.toUpperCase();
}
```

### `REPLServer` 类[#](http://nodejs.cn/api-v12/repl.html#class-replserver)

[中英对照](http://nodejs.cn/api-v12/repl/class_replserver.html)

新增于: v0.1.91

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK) 参见 [`repl.start()`](http://nodejs.cn/api-v12/repl.html#repl_repl_start_options)
-   继承自: [<readline.Interface>](http://nodejs.cn/api/readline.html#class-readlineinterface)

`repl.REPLServer` 的实例是使用 [`repl.start()`](http://nodejs.cn/api-v12/repl.html#repl_repl_start_options) 方法或直接使用 JavaScript `new` 关键字创建的。

```
const repl = require('repl');

const options = { useColors: true };

const firstInstance = repl.start(options);
const secondInstance = new repl.REPLServer(options);
```

#### `'exit'` 事件[#](http://nodejs.cn/api-v12/repl.html#event-exit)

[中英对照](http://nodejs.cn/api-v12/repl/event_exit.html)

新增于: v0.7.7

不带任何参数调用监听器回调。

```
replServer.on('exit', () => {
  console.log('Received "exit" event from repl!');
  process.exit();
});
```

#### `'reset'` 事件[#](http://nodejs.cn/api-v12/repl.html#event-reset)

[中英对照](http://nodejs.cn/api-v12/repl/event_reset.html)

新增于: v0.11.0

当重置 REPL 的上下文时会触发 `'reset'` 事件。 每当接收到 `.clear` 命令作为输入时，就会发生这种情况，除非 REPL 使用默认评估器并且 `repl.REPLServer` 实例是在 `useGlobal` 选项设置为 `true` 的情况下创建的。 将使用对 `context` 对象的引用作为唯一参数调用监听器回调。

这可以主要用于将 REPL 上下文重新初始化为一些预定义的状态：

```
const repl = require('repl');

function initializeContext(context) {
  context.m = 'test';
}

const r = repl.start({ prompt: '> ' });
initializeContext(r.context);

r.on('reset', initializeContext);
```

当执行此代码时，可以修改全局 `'m'` 变量，然后使用 `.clear` 命令将其重置为其初始值：

```
$ ./node example.js
> m
'test'
> m = 1
1
> m
1
> .clear
Clearing context...
> m
'test'
>
```

#### `replServer.defineCommand(keyword, cmd)`[#](http://nodejs.cn/api-v12/repl.html#replserverdefinecommandkeyword-cmd)

[中英对照](http://nodejs.cn/api-v12/repl/replserver_definecommand_keyword_cmd.html)

新增于: v0.3.0

-   `keyword` [<string>](http://url.nodejs.cn/9Tw2bK) 命令关键字（不带前导 `.` 字符）。
-   `cmd` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<Function>](http://url.nodejs.cn/ceTQa6) 当处理命令时调用的函数。

`replServer.defineCommand()` 方法用于向 REPL 实例添加新的以 `.` 为前缀的命令。 此类命令是通过键入 `.` 后跟 `keyword` 来调用的。 `cmd` 是具有以下属性的 `Function` 或 `Object`：

-   `help` [<string>](http://url.nodejs.cn/9Tw2bK) 当输入 `.help` 时显示的帮助文本（可选）。
-   `action` [<Function>](http://url.nodejs.cn/ceTQa6) 要执行的函数，可选择接受单个字符串参数。

以下示例显示了添加到 REPL 实例的两个新命令：

```
const repl = require('repl');

const replServer = repl.start({ prompt: '> ' });
replServer.defineCommand('sayhello', {
  help: 'Say hello',
  action(name) {
    this.clearBufferedCommand();
    console.log(`Hello, ${name}!`);
    this.displayPrompt();
  }
});
replServer.defineCommand('saybye', function saybye() {
  console.log('Goodbye!');
  this.close();
});
```

然后可以在 REPL 实例中使用新命令：

```
> .sayhello Node.js User
Hello, Node.js User!
> .saybye
Goodbye!
```

#### `replServer.displayPrompt([preserveCursor])`[#](http://nodejs.cn/api-v12/repl.html#replserverdisplaypromptpreservecursor)

[中英对照](http://nodejs.cn/api-v12/repl/replserver_displayprompt_preservecursor.html)

新增于: v0.1.91

-   `preserveCursor` [<boolean>](http://url.nodejs.cn/jFbvuT)

`replServer.displayPrompt()` 方法准备 REPL 实例以供用户输入，将配置的 `prompt` 打印到 `output` 中的新行并恢复 `input` 以接受新输入。

当输入多行输入时，打印省略号而不是'提示'。

当 `preserveCursor` 为 `true` 时，光标位置不会重置为 `0`。

`replServer.displayPrompt` 方法主要用于从操作函数内部调用使用 `replServer.defineCommand()` 方法注册的命令。

#### `replServer.clearBufferedCommand()`[#](http://nodejs.cn/api-v12/repl.html#replserverclearbufferedcommand)

[中英对照](http://nodejs.cn/api-v12/repl/replserver_clearbufferedcommand.html)

新增于: v9.0.0

`replServer.clearBufferedCommand()` 方法清除任何已缓冲但尚未执行的命令。 此方法主要用于从使用 `replServer.defineCommand()` 方法注册的命令的操作函数中调用。

#### `replServer.parseREPLKeyword(keyword[, rest])`[#](http://nodejs.cn/api-v12/repl.html#replserverparsereplkeywordkeyword-rest)

[中英对照](http://nodejs.cn/api-v12/repl/replserver_parsereplkeyword_keyword_rest.html)

新增于: v0.8.9弃用于: v9.0.0

-   `keyword` [<string>](http://url.nodejs.cn/9Tw2bK) 要解析和执行的潜在关键字
-   `rest` [<any>](http://url.nodejs.cn/6sTGdS) 关键字命令的任何参数
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

用于解析和执行 `REPLServer` 个关键字的内部方法。 如果 `keyword` 是有效关键字，则返回 `true`，否则返回 `false`。

#### `replServer.setupHistory(historyPath, callback)`[#](http://nodejs.cn/api-v12/repl.html#replserversetuphistoryhistorypath-callback)

[中英对照](http://nodejs.cn/api-v12/repl/replserver_setuphistory_historypath_callback.html)

新增于: v11.10.0

-   `historyPath` [<string>](http://url.nodejs.cn/9Tw2bK) 历史文件的路径
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 当历史写入准备好或出错时调用
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `repl` [<repl.REPLServer>](http://nodejs.cn/api/repl.html#class-replserver)

初始化 REPL 实例的历史日志文件。

但是，以编程方式创建 REPL 时并非如此。 在以编程方式使用 REPL 实例时，使用此方法初始化历史日志文件。

### `repl.start([options])`[#](http://nodejs.cn/api-v12/repl.html#replstartoptions)

[中英对照](http://nodejs.cn/api-v12/repl/repl_start_options.html)

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `prompt` [<string>](http://url.nodejs.cn/9Tw2bK) 要显示的输入提示。 **默认值:** `'> '` （带有尾随空格）。
    -   `input` [<stream.Readable>](http://nodejs.cn/api/stream.html#class-streamreadable) 将从中读取 REPL 输入的 `Readable` 流。 **默认值:** `process.stdin`。
    -   `output` [<stream.Writable>](http://nodejs.cn/api/stream.html#class-streamwritable) REPL 输出将写入的 `Writable` 流。 **默认值:** `process.stdout`。
    -   `terminal` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果 `true`，则指定 `output` 应被视为 TTY 终端。 **默认:** 在实例化时检查 `output` 流上 `isTTY` 属性的值。
    -   `eval` [<Function>](http://url.nodejs.cn/ceTQa6) 当评估每一给定输入行时要使用的函数。 **默认:** JavaScript `eval()` 函数的异步封装器。 `eval` 函数可能会出现 `repl.Recoverable` 错误，表明输入不完整并提示输入额外的行。
    -   `useColors` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 `true`，则指定默认的 `writer` 函数应在 REPL 输出中包含 ANSI 颜色样式。 如果提供了自定义 `writer` 函数，则此功能无效。 **默认:** 如果 REPL 实例的 `terminal` 值为 `true`，则检查 `output` 流上的颜色支持。
    -   `useGlobal` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 `true`，则指定默认评估函数将使用 JavaScript `global` 作为上下文，而不是为 REPL 实例创建新的单独上下文。 node CLI REPL 将此值设置为 `true`。 **默认值:** `false`。
    -   `ignoreUndefined` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 `true`，则指定默认编写器在计算结果为 `undefined` 时不会输出命令的返回值。 **默认值:** `false`。
    -   `writer` [<Function>](http://url.nodejs.cn/ceTQa6) 在写入 `output` 之前调用以格式化每个命令的输出的函数。 **默认值:** [`util.inspect()`](http://nodejs.cn/api-v12/util.html#util_util_inspect_object_options).
    -   `completer` [<Function>](http://url.nodejs.cn/ceTQa6) 用于自定义 Tab 自动完成的可选函数。 有关示例，请参见 [`readline.InterfaceCompleter`](http://nodejs.cn/api-v12/readline.html#readline_use_of_the_completer_function)。
    -   `replMode` [<symbol>](http://url.nodejs.cn/i5E1UH) 指定默认求值器是在严格模式还是默认（宽松）模式下执行所有 JavaScript 命令的标志。 可接受的值是：
        -   `repl.REPL_MODE_SLOPPY` 在宽松模式下计算表达式。
        -   `repl.REPL_MODE_STRICT` 在严格模式下计算表达式。 这相当于在每个 repl 语句前面加上 `'use strict'`。
    -   `breakEvalOnSigint` [<boolean>](http://url.nodejs.cn/jFbvuT) 这不能与自定义 `eval` 函数一起使用。 **默认值:** `false`。
    -   `preview` [<boolean>](http://url.nodejs.cn/jFbvuT) 定义 repl 是否打印自动完成和输出预览。 **默认值:** `true` 使用默认 eval 函数和 `false`，以防使用自定义 eval 函数。 如果 `terminal` 为假，则没有预览，`preview` 的值没有影响。
-   返回: [<repl.REPLServer>](http://nodejs.cn/api/repl.html#class-replserver)

`repl.start()` 方法创建并启动了一个 [`repl.REPLServer`](http://nodejs.cn/api-v12/repl.html#repl_class_replserver) 实例。

如果 `options` 是字符串，则指定输入提示：

```
const repl = require('repl');

// Unix 风格的提示
repl.start('$ ');
```

### Node.js 的 REPL[#](http://nodejs.cn/api-v12/repl.html#the-nodejs-repl)

[中英对照](http://nodejs.cn/api-v12/repl/the_node_js_repl.html)

Node.js 本身使用 `repl` 模块来提供自己的交互界面来执行 JavaScript。 这可以通过执行 Node.js 二进制文件而不传入任何参数（或通过传入 `-i` 参数）来使用：

```
$ node
> const a = [1, 2, 3];
undefined
> a
[ 1, 2, 3 ]
> a.forEach((v) => {
...   console.log(v);
...   });
1
2
3
```

#### 环境变量选项[#](http://nodejs.cn/api-v12/repl.html#environment-variable-options)

[中英对照](http://nodejs.cn/api-v12/repl/environment_variable_options.html)

可以使用以下环境变量自定义 Node.js REPL 的各种行为：

-   `NODE_REPL_HISTORY`: 当给出有效路径时，持久的 REPL 历史记录将保存到用户主目录中的指定文件而不是 `.node_repl_history`。 将此值设置为 `''`（空字符串）将禁用持久的 REPL 历史记录。 将从值中删除空格。 在 Windows 平台上，具有空值的环境变量无效，因此将此变量设置为一个或多个空格以禁用持久的 REPL 历史记录。
-   `NODE_REPL_HISTORY_SIZE`: 如果历史记录可用，则控制将保留多少行历史记录。 必须是正数。 **默认值:** `1000`。
-   `NODE_REPL_MODE`: 可能是 `'sloppy'` 或 `'strict'`。 **默认值:** `'sloppy'`，这将允许运行非严格模式的代码。

#### 历史记录[#](http://nodejs.cn/api-v12/repl.html#persistent-history)

[中英对照](http://nodejs.cn/api-v12/repl/persistent_history.html)

默认情况下，Node.js REPL 将通过将输入保存到位于用户主目录中的 `.node_repl_history` 文件来保留 `node` REPL 会话之间的历史记录。 这可以通过设置环境变量 `NODE_REPL_HISTORY=''` 来禁用。

#### 在高级的行编辑器中使用 Node.js REPL[#](http://nodejs.cn/api-v12/repl.html#using-the-nodejs-repl-with-advanced-line-editors)

[中英对照](http://nodejs.cn/api-v12/repl/using_the_node_js_repl_with_advanced_line_editors.html)

对于高级行编辑器，使用环境变量 `NODE_NO_READLINE=1` 启动 Node.js。 这将在规范的终端设置中启动主程序和调试器 REPL，这将允许与 `rlwrap` 一起使用。

例如，可以将以下内容添加到 `.bashrc` 文件中：

```
alias node="env NODE_NO_READLINE=1 rlwrap node"
```

#### 在一个 Node.js 实例中启动多个 REPL 实例[#](http://nodejs.cn/api-v12/repl.html#starting-multiple-repl-instances-against-a-single-running-instance)

[中英对照](http://nodejs.cn/api-v12/repl/starting_multiple_repl_instances_against_a_single_running_instance.html)

可以针对共享单个 `global` 对象但具有单独 I/O 接口的单个运行 Node.js 实例创建和运行多个 REPL 实例。

例如，以下示例在 `stdin`、Unix 套接字和 TCP 套接字上提供单独的 REPL：

```
const net = require('net');
const repl = require('repl');
let connections = 0;

repl.start({
  prompt: 'Node.js via stdin> ',
  input: process.stdin,
  output: process.stdout
});

net.createServer((socket) => {
  connections += 1;
  repl.start({
    prompt: 'Node.js via Unix socket> ',
    input: socket,
    output: socket
  }).on('exit', () => {
    socket.end();
  });
}).listen('/tmp/node-repl-sock');

net.createServer((socket) => {
  connections += 1;
  repl.start({
    prompt: 'Node.js via TCP socket> ',
    input: socket,
    output: socket
  }).on('exit', () => {
    socket.end();
  });
}).listen(5001);
```

从命令行运行此应用程序将在标准输入上启动 REPL。 其他 REPL 客户端可以通过 Unix 套接字或 TCP 套接字连接。 例如，`telnet` 可用于连接 TCP 套接字，而 `socat` 可用于连接 Unix 和 TCP 套接字。

通过从基于 Unix 套接字的服务器而不是标准输入启动 REPL，可以连接到长时间运行的 Node.js 进程而无需重新启动它。

有关在 `net.Server` 和 `net.Socket` 实例上运行 "全功能" (`terminal`) REPL 的示例，请参阅：[https://gist.github.com/TooTallNate/2209310](https://gist.github.com/TooTallNate/2209310)。

关于在 [`curl(1)`](http://url.nodejs.cn/oJ3NGb) 上运行 REPL 实例的示例，请参阅：[https://gist.github.com/TooTallNate/2053342](https://gist.github.com/TooTallNate/2053342)。
