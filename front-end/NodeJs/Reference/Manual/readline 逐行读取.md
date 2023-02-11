---
created: 2022-07-29T13:12:55 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/readline.html
author: 
---

# readline 逐行读取 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/readline/readline.html)

**源代码:** [lib/readline.js](https://github.com/nodejs/node/blob/v12.22.12/lib/readline.js)

`readline` 模块提供了用于从[可读](http://nodejs.cn/api-v12/stream.html#stream_readable_streams)流（例如 [`process.stdin`](http://nodejs.cn/api-v12/process.html#process_process_stdin)）每次一行地读取数据的接口。 可以使用以下方式访问它：

```
const readline = require('readline');
```

下面的简单示例阐明了 `readline` 模块的基本用法。

```
const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

rl.question('What do you think of Node.js? ', (answer) => {
  // TODO：记录答案到数据库中
  console.log(`Thank you for your valuable feedback: ${answer}`);

  rl.close();
});
```

一旦调用此代码，则 Node.js 应用程序将不会终止，直到 `readline.Interface` 关闭，因为接口在 `input` 流上等待接收数据。

### `Interface` 类[#](http://nodejs.cn/api-v12/readline.html#class-interface)

[中英对照](http://nodejs.cn/api-v12/readline/class_interface.html)

新增于: v0.1.104

-   继承自: [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter)

`readline.Interface` 类的实例是使用 `readline.createInterface()` 方法构造的。 每个实例都与单个 `input` [可读](http://nodejs.cn/api-v12/stream.html#stream_readable_streams)流和单个 `output` [可写](http://nodejs.cn/api-v12/stream.html#stream_writable_streams)流相关联。 `output` 流用于打印到达并从 `input` 流中读取的用户输入的提示。

#### `'close'` 事件[#](http://nodejs.cn/api-v12/readline.html#event-close)

[中英对照](http://nodejs.cn/api-v12/readline/event_close.html)

新增于: v0.1.98

发生以下情况之一时会触发 `'close'` 事件：

-   `rl.close()` 方法被调用，`readline.Interface` 实例放弃了对 `input` 和 `output` 流的控制；
-   `input` 流接收到它的 `'end'` 事件；

调用监听器函数时不传入任何参数。

一旦触发 `'close'` 事件，则 `readline.Interface` 实例就完成了。

#### `'line'` 事件[#](http://nodejs.cn/api-v12/readline.html#event-line)

[中英对照](http://nodejs.cn/api-v12/readline/event_line.html)

新增于: v0.1.98

每当 `input` 流接收到行尾输入（`\n`、`\r` 或 `\r\n`）时，则会触发 `'line'` 事件。

使用包含单行接收输入的字符串调用监听器函数。

```
rl.on('line', (input) => {
  console.log(`Received: ${input}`);
});
```

#### `'pause'` 事件[#](http://nodejs.cn/api-v12/readline.html#event-pause)

[中英对照](http://nodejs.cn/api-v12/readline/event_pause.html)

新增于: v0.7.5

发生以下情况之一时会触发 `'pause'` 事件：

-   `input` 流已暂停。
-   `input` 流没有暂停并接收 `'SIGCONT'` 事件。 （参见事件 [`'SIGTSTP'`](http://nodejs.cn/api-v12/readline.html#readline_event_sigtstp) 和 [`'SIGCONT'`](http://nodejs.cn/api-v12/readline.html#readline_event_sigcont)。）

调用监听器函数时不传入任何参数。

```
rl.on('pause', () => {
  console.log('Readline paused.');
});
```

#### `'resume'` 事件[#](http://nodejs.cn/api-v12/readline.html#event-resume)

[中英对照](http://nodejs.cn/api-v12/readline/event_resume.html)

新增于: v0.7.5

每当 `input` 流恢复时，则会触发 `'resume'` 事件。

调用监听器函数时不传入任何参数。

```
rl.on('resume', () => {
  console.log('Readline resumed.');
});
```

#### `'SIGCONT'` 事件[#](http://nodejs.cn/api-v12/readline.html#event-sigcont)

[中英对照](http://nodejs.cn/api-v12/readline/event_sigcont.html)

新增于: v0.7.5

如果 `input` 流在 `SIGTSTP` 请求之前暂停，则不会触发此事件。

调用监听器函数时不传入任何参数。

```
rl.on('SIGCONT', () => {
  // `prompt` 会自动恢复流
  rl.prompt();
});
```

Windows 不支持 `'SIGCONT'` 事件。

#### `'SIGINT'` 事件[#](http://nodejs.cn/api-v12/readline.html#event-sigint)

[中英对照](http://nodejs.cn/api-v12/readline/event_sigint.html)

新增于: v0.3.0

如果在 `input` 流接收到 `SIGINT` 时没有注册 `'SIGINT'` 事件监听器，则将触发 `'pause'` 事件。

调用监听器函数时不传入任何参数。

```
rl.on('SIGINT', () => {
  rl.question('Are you sure you want to exit? ', (answer) => {
    if (answer.match(/^y(es)?$/i)) rl.pause();
  });
});
```

#### `'SIGTSTP'` 事件[#](http://nodejs.cn/api-v12/readline.html#event-sigtstp)

[中英对照](http://nodejs.cn/api-v12/readline/event_sigtstp.html)

新增于: v0.7.5

如果 `input` 流接收到 `SIGTSTP` 时没有注册 `'SIGTSTP'` 事件监听器，则 Node.js 进程将被发送到后台。

当使用 [`fg(1p)`](http://url.nodejs.cn/hgYpiL) 恢复程序时，则将触发 `'pause'` 和 `'SIGCONT'` 事件。 这些可用于恢复 `input` 流。

如果 `input` 在进程发送到后台之前暂停，则不会触发 `'pause'` 和 `'SIGCONT'` 事件。

调用监听器函数时不传入任何参数。

```
rl.on('SIGTSTP', () => {
  // 这将覆盖 SIGTSTP 
  // 并且阻止程序进入后台。
  console.log('Caught SIGTSTP.');
});
```

Windows 不支持 `'SIGTSTP'` 事件。

#### `rl.close()`[#](http://nodejs.cn/api-v12/readline.html#rlclose)

[中英对照](http://nodejs.cn/api-v12/readline/rl_close.html)

新增于: v0.1.98

`rl.close()` 方法关闭 `readline.Interface` 实例并放弃对 `input` 和 `output` 流的控制。 当调用时，将触发 `'close'` 事件。

调用 `rl.close()` 不会立即阻止其他由 `readline.Interface` 实例触发的事件（包括 `'line'`）。

#### `rl.pause()`[#](http://nodejs.cn/api-v12/readline.html#rlpause)

[中英对照](http://nodejs.cn/api-v12/readline/rl_pause.html)

新增于: v0.3.4

`rl.pause()` 方法暂停 `input` 流，允许它稍后在必要时恢复。

调用 `rl.pause()` 不会立即暂停其他由 `readline.Interface` 实例触发的事件（包括 `'line'`）。

#### `rl.prompt([preserveCursor])`[#](http://nodejs.cn/api-v12/readline.html#rlpromptpreservecursor)

[中英对照](http://nodejs.cn/api-v12/readline/rl_prompt_preservecursor.html)

新增于: v0.1.98

-   `preserveCursor` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 `true`，则防止光标位置重置为 `0`。

`rl.prompt()` 方法将配置为 `prompt` 的 `readline.Interface` 实例写入 `output` 中的新行，以便为用户提供用于提供输入的新位置。

当调用时，如果 `rl.prompt()` 流已暂停，则 `rl.prompt()` 将恢复 `input` 流。

如果 `readline.Interface` 是在 `output` 设置为 `null` 或 `undefined` 的情况下创建的，则不会写入提示。

#### `rl.question(query, callback)`[#](http://nodejs.cn/api-v12/readline.html#rlquestionquery-callback)

[中英对照](http://nodejs.cn/api-v12/readline/rl_question_query_callback.html)

新增于: v0.3.3

-   `query` [<string>](http://url.nodejs.cn/9Tw2bK) 要写入 `output` 的语句或查询，位于提示之前。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 使用用户输入调用的回调函数以响应 `query`。

`rl.question()` 方法通过将 `query` 写入 `output` 来显示 `query`，等待在 `input` 上提供用户输入，然后调用 `callback` 函数，将提供的输入作为第一个参数传入。

当调用时，如果 `rl.question()` 流已暂停，则 `rl.question()` 将恢复 `input` 流。

如果 `readline.Interface` 是在 `output` 设置为 `null` 或 `undefined` 的情况下创建的，则不会写入 `query`。

用法示例：

```
rl.question('What is your favorite food? ', (answer) => {
  console.log(`Oh, so your favorite food is ${answer}`);
});
```

传给 `rl.question()` 的 `callback` 函数不遵循接受 `Error` 对象或 `null` 作为第一个参数的典型模式。 以提供的答案作为唯一参数调用 `callback`。

#### `rl.resume()`[#](http://nodejs.cn/api-v12/readline.html#rlresume)

[中英对照](http://nodejs.cn/api-v12/readline/rl_resume.html)

新增于: v0.3.4

如果 `input` 流已暂停，则 `rl.resume()` 方法会恢复该流。

#### `rl.setPrompt(prompt)`[#](http://nodejs.cn/api-v12/readline.html#rlsetpromptprompt)

[中英对照](http://nodejs.cn/api-v12/readline/rl_setprompt_prompt.html)

新增于: v0.1.98

-   `prompt` [<string>](http://url.nodejs.cn/9Tw2bK)

`rl.setPrompt()` 方法设置了在调用 `rl.prompt()` 时将写入 `output` 的提示。

#### `rl.write(data[, key])`[#](http://nodejs.cn/api-v12/readline.html#rlwritedata-key)

[中英对照](http://nodejs.cn/api-v12/readline/rl_write_data_key.html)

新增于: v0.1.98

-   `data` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `key` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `ctrl` [<boolean>](http://url.nodejs.cn/jFbvuT)
    -   `meta` [<boolean>](http://url.nodejs.cn/jFbvuT)
    -   `shift` [<boolean>](http://url.nodejs.cn/jFbvuT)
    -   `name` [<string>](http://url.nodejs.cn/9Tw2bK) 键的名称。

`rl.write()` 方法会将 `data` 或由 `key` 标识的键序列写入 `output`。 仅当 `output` 是 [TTY](http://nodejs.cn/api-v12/tty.html) 文本终端时才支持 `key` 参数。 有关组合键的列表，请参阅 [TTY 快捷键](http://nodejs.cn/api-v12/readline.html#readline_tty_keybindings)。

如果指定了 `key`，则忽略 `data`。

当调用时，如果 `rl.write()` 流已暂停，则 `rl.write()` 将恢复 `input` 流。

如果 `readline.Interface` 是在 `output` 设置为 `null` 或 `undefined` 的情况下创建的，则不会写入 `data` 和 `key`。

```
rl.write('Delete this!');
// 
rl.write(null, { ctrl: true, name: 'u' });
```

`rl.write()` 方法将数据写入 `readline` `Interface` 的 `input`，就好像它是由用户提供的一样。

#### `rl[Symbol.asyncIterator]()`[#](http://nodejs.cn/api-v12/readline.html#rlsymbolasynciterator)

[中英对照](http://nodejs.cn/api-v12/readline/rl_symbol_asynciterator.html)

-   返回: [<AsyncIterator>](http://url.nodejs.cn/HnG4ws)

创建 `AsyncIterator` 对象，该对象遍历输入流中的每一行作为字符串。 此方法允许通过 `for await...of` 循环异步迭代 `readline.Interface` 对象。

输入流中的错误不会被转发。

如果循环以 `break`、`throw` 或 `return` 终止，则将调用 [`rl.close()`](http://nodejs.cn/api-v12/readline.html#readline_rl_close)。 换句话说，迭代 `readline.Interface` 将始终完全消费输入流。

性能无法与传统的 `'line'` 事件 API 相提并论。 对于性能敏感的应用程序，请改用 `'line'`。

```
async function processLineByLine() {
  const rl = readline.createInterface({
    // ...
  });

  for await (const line of rl) {
    // 逐行读取输入中的每一行
    // 都将在此处作为 `line` 连续可用。
  }
}
```

`readline.createInterface()` 将在调用后开始使用输入流。 在接口创建和异步迭代之间进行异步操作可能会导致丢失行。

#### rl.line[#](http://nodejs.cn/api-v12/readline.html#rlline)

[中英对照](http://nodejs.cn/api-v12/readline/rl_line.html)

新增于: v0.1.98

-   [<string>](http://url.nodejs.cn/9Tw2bK) | [<undefined>](http://url.nodejs.cn/8ym6ow)

节点正在处理的当前输入数据。

这可用于从 TTY 流中收集输入以检索迄今为止（在 `line` 事件触发之前）已处理的当前值。 一旦触发 `line` 事件，则此属性将是空字符串。

请注意，如果 `rl.cursor` 也不受控制，则在实例运行时修改该值可能会产生意想不到的后果。

**如果不使用 TTY 流进行输入，则使用 [`'line'`](http://nodejs.cn/api-v12/readline.html#readline_event_line) 事件。**

一个可能的用例如下：

```
const values = ['lorem ipsum', 'dolor sit amet'];
const rl = readline.createInterface(process.stdin);
const showResults = debounce(() => {
  console.log(
    '\n',
    values.filter((val) => val.startsWith(rl.line)).join(' ')
  );
}, 300);
process.stdin.on('keypress', (c, k) => {
  showResults();
});
```

#### rl.cursor[#](http://nodejs.cn/api-v12/readline.html#rlcursor)

[中英对照](http://nodejs.cn/api-v12/readline/rl_cursor.html)

新增于: v0.1.98

-   [<number>](http://url.nodejs.cn/SXbo1v) | [<undefined>](http://url.nodejs.cn/8ym6ow)

相对于 `rl.line` 的光标位置。

当从 TTY 流读取输入时，这将跟踪当前光标在输入字符串中的位置。 光标的位置决定了在处理输入时将被修改的输入字符串部分，以及将呈现终端插入符号的列。

#### `rl.getCursorPos()`[#](http://nodejs.cn/api-v12/readline.html#rlgetcursorpos)

[中英对照](http://nodejs.cn/api-v12/readline/rl_getcursorpos.html)

新增于: v12.16.0

-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `rows` [<number>](http://url.nodejs.cn/SXbo1v) 光标当前所在的提示行
    -   `cols` [<number>](http://url.nodejs.cn/SXbo1v) 光标当前所在的屏幕列

返回光标相对于输入提示 + 字符串的实际位置。 长输入（换行）字符串以及多行提示都包含在计算中。

### `readline.clearLine(stream, dir[, callback])`[#](http://nodejs.cn/api-v12/readline.html#readlineclearlinestream-dir-callback)

[中英对照](http://nodejs.cn/api-v12/readline/readline_clearline_stream_dir_callback.html)

-   `stream` [<stream.Writable>](http://nodejs.cn/api/stream.html#class-streamwritable)
-   `dir` [<number>](http://url.nodejs.cn/SXbo1v)
    -   `-1`: 从光标向左
    -   `1`: 从光标向右
    -   `0`: 整行
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 操作完成后调用。
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT) 如果 `stream` 希望调用代码在继续写入额外的数据之前等待 `'drain'` 事件被触发，则为 `false`；否则为 `true`。

`readline.clearLine()` 方法在 `dir` 标识的指定方向上清除给定 TTY 流的当前行。

### `readline.clearScreenDown(stream[, callback])`[#](http://nodejs.cn/api-v12/readline.html#readlineclearscreendownstream-callback)

[中英对照](http://nodejs.cn/api-v12/readline/readline_clearscreendown_stream_callback.html)

-   `stream` [<stream.Writable>](http://nodejs.cn/api/stream.html#class-streamwritable)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 操作完成后调用。
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT) 如果 `stream` 希望调用代码在继续写入额外的数据之前等待 `'drain'` 事件被触发，则为 `false`；否则为 `true`。

`readline.clearScreenDown()` 方法从光标的当前位置向下清除给定的 [TTY](http://nodejs.cn/api-v12/tty.html) 流。

### `readline.createInterface(options)`[#](http://nodejs.cn/api-v12/readline.html#readlinecreateinterfaceoptions)

[中英对照](http://nodejs.cn/api-v12/readline/readline_createinterface_options.html)

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `input` [<stream.Readable>](http://nodejs.cn/api/stream.html#class-streamreadable) 要监听的[可读](http://nodejs.cn/api-v12/stream.html#stream_readable_streams)流。 此选项是必需的。
    -   `output` [<stream.Writable>](http://nodejs.cn/api/stream.html#class-streamwritable) 要将逐行读取的数据写入的[可写](http://nodejs.cn/api-v12/stream.html#stream_writable_streams)流。
    -   `completer` [<Function>](http://url.nodejs.cn/ceTQa6) 可选的用于制表符自动补全的函数。
    -   `terminal` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果 `input` 和 `output` 流应该被视为终端，并且写入了 ANSI/VT100 转义码，则为 `true`。 **默认值:** 在实例化时检查 `output` 流上的 `isTTY`。
    -   `historySize` [<number>](http://url.nodejs.cn/SXbo1v) 保留的最大历史行数。 要禁用历史记录，则将此值设置为 `0`。 仅当 `terminal` 由用户或内部的 `output` 检查设置为 `true` 时，此选项才有意义，否则历史缓存机制根本不会初始化。 **默认值:** `30`。
    -   `prompt` [<string>](http://url.nodejs.cn/9Tw2bK) 要使用的提示字符串。 **默认值:** `'> '`。
    -   `crlfDelay` [<number>](http://url.nodejs.cn/SXbo1v) 如果 `\r` 和 `\n` 之间的延迟超过 `crlfDelay` 毫秒，则 `\r` 和 `\n` 都将被视为单独的行尾输入。 `crlfDelay` 将被强制为不小于 `100` 的数字。 它可以设置为 `Infinity`，在这种情况下，`\r` 后跟 `\n` 将始终被视为单个换行符（这对于具有 `\r\n` 行分隔符的[文件读取](http://nodejs.cn/api-v12/readline.html#readline_example_read_file_stream_line_by_line)可能是合理的）。 **默认值:** `100`。
    -   `removeHistoryDuplicates` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 `true`，则当添加到历史列表的新输入行与旧输入行重复时，这将从列表中删除旧行。 **默认值:** `false`。
    -   `escapeCodeTimeout` [<number>](http://url.nodejs.cn/SXbo1v) `readline` 将等待字符的时长（当以毫秒为单位读取不明确的键序列时，既可以使用目前读取的输入形成完整的键序列，又可以采用额外的输入来完成更长的键序列）。 **默认值:** `500`。

`readline.createInterface()` 方法创建新的 `readline.Interface` 实例。

```
const readline = require('readline');
const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});
```

一旦创建了 `readline.Interface` 实例，则最常见的场景就是监听 `'line'` 事件：

```
rl.on('line', (line) => {
  console.log(`Received: ${line}`);
});
```

如果此实例的 `terminal` 是 `true`，则如果它定义了 `output.columns` 属性，并且如果或当列发生变化时（[`process.stdout`](http://nodejs.cn/api-v12/process.html#process_process_stdout) 会当其是终端时自动执行此操作）在 `output` 上触发 `'resize'` 事件，则 `output` 流将获得最佳的兼容性。

#### completer 函数的使用[#](http://nodejs.cn/api-v12/readline.html#use-of-the-completer-function)

[中英对照](http://nodejs.cn/api-v12/readline/use_of_the_completer_function.html)

`completer` 函数将用户输入的当前行作为参数，并返回包含 2 个条目的 `Array`：

-   使用匹配条目的 `Array` 补全。
-   用于匹配的子字符串。

例如：`[[substr1, substr2, ...], originalsubstring]`。

```
function completer(line) {
  const completions = '.help .error .exit .quit .q'.split(' ');
  const hits = completions.filter((c) => c.startsWith(line));
  // 如果没有找到，则显示所有补全
  return [hits.length ? hits : completions, line];
}
```

如果 `completer` 函数接受两个参数，则可以异步地调用它：

```
function completer(linePartial, callback) {
  callback(null, [['123'], linePartial]);
}
```

### `readline.cursorTo(stream, x[, y][, callback])`[#](http://nodejs.cn/api-v12/readline.html#readlinecursortostream-x-y-callback)

[中英对照](http://nodejs.cn/api-v12/readline/readline_cursorto_stream_x_y_callback.html)

-   `stream` [<stream.Writable>](http://nodejs.cn/api/stream.html#class-streamwritable)
-   `x` [<number>](http://url.nodejs.cn/SXbo1v)
-   `y` [<number>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 操作完成后调用。
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT) 如果 `stream` 希望调用代码在继续写入额外的数据之前等待 `'drain'` 事件被触发，则为 `false`；否则为 `true`。

`readline.cursorTo()` 方法将光标移动到给定的 [TTY](http://nodejs.cn/api-v12/tty.html) `stream` 中的指定位置。

### `readline.emitKeypressEvents(stream[, interface])`[#](http://nodejs.cn/api-v12/readline.html#readlineemitkeypresseventsstream-interface)

[中英对照](http://nodejs.cn/api-v12/readline/readline_emitkeypressevents_stream_interface.html)

新增于: v0.7.7

-   `stream` [<stream.Readable>](http://nodejs.cn/api/stream.html#class-streamreadable)
-   `interface` [<readline.Interface>](http://nodejs.cn/api/readline.html#class-readlineinterface)

`readline.emitKeypressEvents()` 方法使给定的[可读](http://nodejs.cn/api-v12/stream.html#stream_readable_streams)流开始触发与接收到的输入相对应的 `'keypress'` 事件。

可选地，`interface` 指定 `readline.Interface` 实例，当检测到复制粘贴输入时禁用自动完成。

如果 `stream` 是 [TTY](http://nodejs.cn/api-v12/tty.html)，则它必须处于原始模式。

如果 `input` 是终端，则它会被其 `input` 上的任何逐行读取实例自动调用。 关闭 `readline` 实例不会阻止 `input` 触发 `'keypress'` 事件。

```
readline.emitKeypressEvents(process.stdin);
if (process.stdin.isTTY)
  process.stdin.setRawMode(true);
```

### `readline.moveCursor(stream, dx, dy[, callback])`[#](http://nodejs.cn/api-v12/readline.html#readlinemovecursorstream-dx-dy-callback)

[中英对照](http://nodejs.cn/api-v12/readline/readline_movecursor_stream_dx_dy_callback.html)

-   `stream` [<stream.Writable>](http://nodejs.cn/api/stream.html#class-streamwritable)
-   `dx` [<number>](http://url.nodejs.cn/SXbo1v)
-   `dy` [<number>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 操作完成后调用。
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT) 如果 `stream` 希望调用代码在继续写入额外的数据之前等待 `'drain'` 事件被触发，则为 `false`；否则为 `true`。

`readline.moveCursor()` 方法相对于它在给定的 [TTY](http://nodejs.cn/api-v12/tty.html) `stream` 中的当前位置移动光标。

### 示例：微型 CLI[#](http://nodejs.cn/api-v12/readline.html#example-tiny-cli)

[中英对照](http://nodejs.cn/api-v12/readline/example_tiny_cli.html)

下面的例子说明了使用 `readline.Interface` 类来实现一个微型的命令行界面：

```
const readline = require('readline');
const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout,
  prompt: 'OHAI> '
});

rl.prompt();

rl.on('line', (line) => {
  switch (line.trim()) {
    case 'hello':
      console.log('world!');
      break;
    default:
      console.log(`Say what? I might have heard '${line.trim()}'`);
      break;
  }
  rl.prompt();
}).on('close', () => {
  console.log('Have a great day!');
  process.exit(0);
});
```

### 示例：逐行读取文件流[#](http://nodejs.cn/api-v12/readline.html#example-read-file-stream-line-by-line)

[中英对照](http://nodejs.cn/api-v12/readline/example_read_file_stream_line_by_line.html)

`readline` 的一个常见用例是每次一行地消费输入文件。 最简单的方式是利用 [`fs.ReadStream`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_readstream) API 和 `for await...of` 循环：

```
const fs = require('fs');
const readline = require('readline');

async function processLineByLine() {
  const fileStream = fs.createReadStream('input.txt');

  const rl = readline.createInterface({
    input: fileStream,
    crlfDelay: Infinity
  });
  // 注意：使用 crlfDelay 选项
  // 将 input.txt 中的所有 CR LF ('\r\n') 实例识别为单个换行符。

  for await (const line of rl) {
    // input.txt 中的每一行都将在此处作为 `line` 连续可用。
    console.log(`Line from file: ${line}`);
  }
}

processLineByLine();
```

或者，可以使用 [`'line'`](http://nodejs.cn/api-v12/readline.html#readline_event_line) 事件：

```
const fs = require('fs');
const readline = require('readline');

const rl = readline.createInterface({
  input: fs.createReadStream('sample.txt'),
  crlfDelay: Infinity
});

rl.on('line', (line) => {
  console.log(`Line from file: ${line}`);
});
```

目前，`for await...of` 循环可能会慢一点。 如果 `async` / `await` 流量和速度都必不可少，则可以应用混合方法：

```
const { once } = require('events');
const { createReadStream } = require('fs');
const { createInterface } = require('readline');

(async function processLineByLine() {
  try {
    const rl = createInterface({
      input: createReadStream('big-file.txt'),
      crlfDelay: Infinity
    });

    rl.on('line', (line) => {
      // 处理行。
    });

    await once(rl, 'close');

    console.log('File processed.');
  } catch (err) {
    console.error(err);
  }
})();
```

### TTY 快捷键[#](http://nodejs.cn/api-v12/readline.html#tty-keybindings)

[中英对照](http://nodejs.cn/api-v12/readline/tty_keybindings.html)

| 快捷键 | 描述 | 注意事项 |
| --- | --- | --- |
|  | 删除行左 | 不适用于 Linux、Mac 和 Windows |
|  | 删除行右 | 不适用于 Mac |
|  | 触发 `SIGINT` 或关闭逐行读取实例 |  |
|  | 删除左边 |  |
|  | 如果当前行为空或 EOF，则向右删除或关闭逐行读取实例 | 不适用于 Windows |
|  | 从当前位置删除到行首 |  |
|  | 从当前位置删除到行尾 |  |
|  | 转到行首 |  |
|  | 转到行尾 |  |
|  | 后退一个字符 |  |
|  | 前进一个字符 |  |
|  | 清屏 |  |
|  | 下一个历史子项 |  |
|  | 上一个历史子项 |  |
|  | 将正在运行的进程移到后台。 | 不适用于 Windows |
|  | 向后删除到单词边界 |  |
|  | 向前删除到单词边界 | 不适用于 Mac |
|  | 左边的单词 |  |
|  | 右边的单词 |  |
|  | 删除右边的单词 |  |
|  | 删除左边的单词 | 不适用于 Mac |
