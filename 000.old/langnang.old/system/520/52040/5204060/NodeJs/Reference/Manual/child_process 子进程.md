---
created: 2022-07-29T13:12:51 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/child_process.html
author: 
---

# child_process 子进程 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/child_process/child_process.html)

**源代码:** [lib/child\_process.js](https://github.com/nodejs/node/blob/v12.22.12/lib/child_process.js)

此功能主要由 [`child_process.spawn()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawn_command_args_options) 函数提供：

```
const { spawn } = require('child_process');
const ls = spawn('ls', ['-lh', '/usr']);

ls.stdout.on('data', (data) => {
  console.log(`stdout: ${data}`);
});

ls.stderr.on('data', (data) => {
  console.error(`stderr: ${data}`);
});

ls.on('close', (code) => {
  console.log(`child process exited with code ${code}`);
});
```

这些管道的容量有限（且特定于平台）。

这与 shell 中管道的行为相同。 如果不消费输出，则使用 `{ stdio: 'ignore' }` 选项。

[`child_process.spawn()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawn_command_args_options) 方法异步衍生子进程，不会阻塞 Node.js 事件循环。 [`child_process.spawnSync()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawnsync_command_args_options) 函数以同步方式提供等效的功能，其会阻塞事件循环，直到衍生的进程退出或终止。

为方便起见，`child_process` 模块提供了一些同步和异步方法替代 [`child_process.spawn()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawn_command_args_options) 和 [`child_process.spawnSync()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawnsync_command_args_options)。 这些替代方法中的每一个都是基于 [`child_process.spawn()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawn_command_args_options) 或 [`child_process.spawnSync()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawnsync_command_args_options) 实现。

-   [`child_process.exec()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_exec_command_options_callback): 衍生 shell 并在该 shell 中运行命令，完成后将 `stdout` 和 `stderr` 传给回调函数。
-   [`child_process.execFile()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_execfile_file_args_options_callback): 与 [`child_process.exec()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_exec_command_options_callback) 类似，不同之处在于，默认情况下，它直接衍生命令，而不先衍生 shell。
-   [`child_process.fork()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_fork_modulepath_args_options): 衍生新的 Node.js 进程并使用建立的 IPC 通信通道（其允许在父子进程之间发送消息）调用指定的模块。
-   [`child_process.execSync()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_execsync_command_options): [`child_process.exec()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_exec_command_options_callback) 的同步版本，其将阻塞 Node.js 事件循环。
-   [`child_process.execFileSync()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_execfilesync_file_args_options): [`child_process.execFile()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_execfile_file_args_options_callback) 的同步版本，其将阻塞 Node.js 事件循环。

对于某些情况，例如自动化 shell 脚本，[同步的方法](http://nodejs.cn/api-v12/child_process.html#child_process_synchronous_process_creation)可能更方便。 但是，在许多情况下，由于在衍生的进程完成前会停止事件循环，同步方法会对性能产生重大影响。

### 异步进程的创建[#](http://nodejs.cn/api-v12/child_process.html#asynchronous-process-creation)

[中英对照](http://nodejs.cn/api-v12/child_process/asynchronous_process_creation.html)

[`child_process.spawn()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawn_command_args_options)、[`child_process.fork()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_fork_modulepath_args_options)、[`child_process.exec()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_exec_command_options_callback) 和 [`child_process.execFile()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_execfile_file_args_options_callback) 方法都遵循其他 Node.js API 典型的惯用异步编程模式。

每个方法都返回 [`ChildProcess`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process) 实例。 这些对象实现了 Node.js [`EventEmitter`](http://nodejs.cn/api-v12/events.html#events_class_eventemitter) API，允许父进程注册在子进程的生命周期中发生某些事件时调用的监听器函数。

[`child_process.exec()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_exec_command_options_callback) 和 [`child_process.execFile()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_execfile_file_args_options_callback) 方法还允许指定可选的 `callback` 函数，其在子进程终止时调用。

#### 在 Windows 上衍生 .bat 和 .cmd 文件[#](http://nodejs.cn/api-v12/child_process.html#spawning-bat-and-cmd-files-on-windows)

[中英对照](http://nodejs.cn/api-v12/child_process/spawning_bat_and_cmd_files_on_windows.html)

[`child_process.exec()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_exec_command_options_callback) 和 [`child_process.execFile()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_execfile_file_args_options_callback) 之间区别的重要性可能因平台而异。 在 Unix 类型的操作系统（Unix、Linux、macOS）上，[`child_process.execFile()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_execfile_file_args_options_callback) 可以更高效，因为它默认不衍生 shell。 但是，在 Windows 上，`.bat` 和 `.cmd` 文件在没有终端的情况下无法自行执行，因此无法使用 [`child_process.execFile()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_execfile_file_args_options_callback) 启动。 在 Windows 上运行时，`.bat` 和 `.cmd` 文件可以使用具有 `shell` 选项集的 [`child_process.spawn()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawn_command_args_options)、使用 [`child_process.exec()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_exec_command_options_callback)、或通过衍生 `cmd.exe` 并将 `.bat` 或 `.cmd` 文件作为参数传入（这也是 `shell` 选项和 [`child_process.exec()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_exec_command_options_callback) 所做的）来调用。 在任何情况下，如果脚本文件名包含空格，则需要加上引号。

```
// 仅在 Windows 上...
const { spawn } = require('child_process');
const bat = spawn('cmd.exe', ['/c', 'my.bat']);

bat.stdout.on('data', (data) => {
  console.log(data.toString());
});

bat.stderr.on('data', (data) => {
  console.error(data.toString());
});

bat.on('exit', (code) => {
  console.log(`Child exited with code ${code}`);
});
```

```
// 或者...
const { exec, spawn } = require('child_process');
exec('my.bat', (err, stdout, stderr) => {
  if (err) {
    console.error(err);
    return;
  }
  console.log(stdout);
});

// 文件名中带有空格的脚本：
const bat = spawn('"my script.cmd"', ['a', 'b'], { shell: true });
// 或者：
exec('"my script.cmd" a b', (err, stdout, stderr) => {
  // ...
});
```

#### `child_process.exec(command[, options][, callback])`[#](http://nodejs.cn/api-v12/child_process.html#child_processexeccommand-options-callback)

[中英对照](http://nodejs.cn/api-v12/child_process/child_process_exec_command_options_callback.html)

-   `command` [<string>](http://url.nodejs.cn/9Tw2bK) 要运行的命令，参数以空格分隔。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `cwd` [<string>](http://url.nodejs.cn/9Tw2bK) 子进程的当前工作目录。 **默认值:** `null`。
    -   `env` [<Object>](http://url.nodejs.cn/jzn6Ao) 环境变量键值对。 **默认值:** `process.env`。
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'utf8'`
    -   `shell` [<string>](http://url.nodejs.cn/9Tw2bK) 用于执行命令的 shell。 请参阅 [shell 的要求](http://nodejs.cn/api-v12/child_process.html#child_process_shell_requirements)和[默认的 Windows shell](http://nodejs.cn/api-v12/child_process.html#child_process_default_windows_shell)。 **默认值:** Unix 上是 `'/bin/sh'`，Windows 上是 `process.env.ComSpec`。
    -   `timeout` [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `0`
    -   `maxBuffer` [<number>](http://url.nodejs.cn/SXbo1v) 标准输出或标准错误上允许的最大数据量（以字节为单位）。 如果超过，则子进程将终止并截断任何输出。 请参阅 [maxBuffer 和 Unicode](http://nodejs.cn/api-v12/child_process.html#child_process_maxbuffer_and_unicode) 的注意事项。 **默认值:** `1024 * 1024`。
    -   `killSignal` [<string>](http://url.nodejs.cn/9Tw2bK) | [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `'SIGTERM'`
    -   `uid` [<number>](http://url.nodejs.cn/SXbo1v) 设置进程的用户标识（参见 [`setuid(2)`](http://url.nodejs.cn/bUGgha)）。
    -   `gid` [<number>](http://url.nodejs.cn/SXbo1v) 设置进程的群组标识（参见 [`setgid(2)`](http://url.nodejs.cn/64HRVx)）。
    -   `windowsHide` [<boolean>](http://url.nodejs.cn/jFbvuT) 隐藏通常在 Windows 系统上创建的子进程控制台窗口。 **默认值:** `false`。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 当进程终止时使用输出调用。
    -   `error` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `stdout` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)
    -   `stderr` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)
-   返回: [<ChildProcess>](http://nodejs.cn/api/child_process.html#class-childprocess)

衍生 shell，然后在该 shell 中执行 `command`，缓冲任何生成的输出。 传给执行函数的 `command` 字符串由 shell 直接处理，特殊字符（因 [shell](http://url.nodejs.cn/eUHhwc) 而异）需要进行相应处理：

```
exec('"/path/to/test file/test.sh" arg1 arg2');
// 使用双引号，这样路径中的空格就不会被解释为多个参数的分隔符。

exec('echo "The \\$HOME variable is $HOME"');
// $HOME 变量在第一个实例中被转义，但在第二个实例中没有。
```

**切勿将未经处理的用户输入传给此函数。 任何包含 shell 元字符的输入都可用于触发任意命令执行。**

如果提供了 `callback` 函数，则使用参数 `(error, stdout, stderr)` 调用它。 成功后，`error` 将是 `null`。 出错时，`error` 将是 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 的实例。 `error.code` 属性将是进程的退出码。 按照惯例，除 `0` 之外的任何退出码都表示错误。 `error.signal` 将是终止进程的信号。

传给回调的 `stdout` 和 `stderr` 参数将包含子进程的标准输出和标准错误的输出。 默认情况下，Node.js 会将输出解码为 UTF-8 并将字符串传给回调。 `encoding` 选项可用于指定用于解码标准输出和标准错误的输出的字符编码。 如果 `encoding` 是 `'buffer'` 或无法识别的字符编码，则 `Buffer` 对象将被传给回调。

```
const { exec } = require('child_process');
exec('cat *.js missing_file | wc -l', (error, stdout, stderr) => {
  if (error) {
    console.error(`exec error: ${error}`);
    return;
  }
  console.log(`stdout: ${stdout}`);
  console.error(`stderr: ${stderr}`);
});
```

如果 `timeout` 大于 `0`，则如果子进程运行时间超过 `timeout` 毫秒，父进程将发送由 `killSignal` 属性（默认为 `'SIGTERM'`）标识的信号。

与 [`exec(3)`](http://url.nodejs.cn/rVeqwf) POSIX 系统调用不同，`child_process.exec()` 不替换现有进程，而是使用 shell 来执行命令。

如果此方法作为其 [`util.promisify()`](http://nodejs.cn/api-v12/util.html#util_util_promisify_original) 版本被调用，则其将为具有 `stdout` 和 `stderr` 属性的 `Object` 返回 `Promise`。 返回的 `ChildProcess` 实例作为 `child` 属性附加到 `Promise`。 如果出现错误（包括任何导致退出码不是 0 的错误），则将返回被拒绝的 promise，其具有与回调中给定相同的 `error` 对象，但有两个额外的属性 `stdout` 和 `stderr`。

```
const util = require('util');
const exec = util.promisify(require('child_process').exec);

async function lsExample() {
  const { stdout, stderr } = await exec('ls');
  console.log('stdout:', stdout);
  console.error('stderr:', stderr);
}
lsExample();
```

#### `child_process.execFile(file[, args][, options][, callback])`[#](http://nodejs.cn/api-v12/child_process.html#child_processexecfilefile-args-options-callback)

[中英对照](http://nodejs.cn/api-v12/child_process/child_process_execfile_file_args_options_callback.html)

-   `file` [<string>](http://url.nodejs.cn/9Tw2bK) 要运行的可执行文件的名称或路径。
-   `args` [<string\[\]>](http://url.nodejs.cn/9Tw2bK) 字符串参数列表。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `cwd` [<string>](http://url.nodejs.cn/9Tw2bK) 子进程的当前工作目录。
    -   `env` [<Object>](http://url.nodejs.cn/jzn6Ao) 环境变量键值对。 **默认值:** `process.env`。
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'utf8'`
    -   `timeout` [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `0`
    -   `maxBuffer` [<number>](http://url.nodejs.cn/SXbo1v) 标准输出或标准错误上允许的最大数据量（以字节为单位）。 如果超过，则子进程将终止并截断任何输出。 请参阅 [maxBuffer 和 Unicode](http://nodejs.cn/api-v12/child_process.html#child_process_maxbuffer_and_unicode) 的注意事项。 **默认值:** `1024 * 1024`。
    -   `killSignal` [<string>](http://url.nodejs.cn/9Tw2bK) | [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `'SIGTERM'`
    -   `uid` [<number>](http://url.nodejs.cn/SXbo1v) 设置进程的用户标识（参见 [`setuid(2)`](http://url.nodejs.cn/bUGgha)）。
    -   `gid` [<number>](http://url.nodejs.cn/SXbo1v) 设置进程的群组标识（参见 [`setgid(2)`](http://url.nodejs.cn/64HRVx)）。
    -   `windowsHide` [<boolean>](http://url.nodejs.cn/jFbvuT) 隐藏通常在 Windows 系统上创建的子进程控制台窗口。 **默认值:** `false`。
    -   `windowsVerbatimArguments` [<boolean>](http://url.nodejs.cn/jFbvuT) 在 Windows 上不为参数加上引号或转义。 在 Unix 上被忽略。 **默认值:** `false`。
    -   `shell` [<boolean>](http://url.nodejs.cn/jFbvuT) | [<string>](http://url.nodejs.cn/9Tw2bK) 如果是 `true`，则在 shell 内运行 `command`。 在 Unix 上使用 `'/bin/sh'`，在 Windows 上使用 `process.env.ComSpec`。 可以将不同的 shell 指定为字符串。 请参阅 [shell 的要求](http://nodejs.cn/api-v12/child_process.html#child_process_shell_requirements)和[默认的 Windows shell](http://nodejs.cn/api-v12/child_process.html#child_process_default_windows_shell)。 **默认值:** `false` （没有 shell）
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 进程终止时使用输出调用。
    -   `error` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `stdout` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)
    -   `stderr` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)
-   返回: [<ChildProcess>](http://nodejs.cn/api/child_process.html#class-childprocess)

`child_process.execFile()` 函数与 [`child_process.exec()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_exec_command_options_callback) 类似，不同之处在于它默认不衍生 shell。 而是，指定的可执行文件 `file` 直接作为新进程衍生，使其比 [`child_process.exec()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_exec_command_options_callback) 略有效率。

支持与 [`child_process.exec()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_exec_command_options_callback) 相同的选项。 由于未衍生 shell，因此不支持 I/O 重定向和文件通配等行为。

```
const { execFile } = require('child_process');
const child = execFile('node', ['--version'], (error, stdout, stderr) => {
  if (error) {
    throw error;
  }
  console.log(stdout);
});
```

传给回调的 `stdout` 和 `stderr` 参数将包含子进程的标准输出和标准错误的输出。 默认情况下，Node.js 会将输出解码为 UTF-8 并将字符串传给回调。 `encoding` 选项可用于指定用于解码标准输出和标准错误的输出的字符编码。 如果 `encoding` 是 `'buffer'` 或无法识别的字符编码，则 `Buffer` 对象将被传给回调。

如果此方法作为其 [`util.promisify()`](http://nodejs.cn/api-v12/util.html#util_util_promisify_original) 版本被调用，则其将为具有 `stdout` 和 `stderr` 属性的 `Object` 返回 `Promise`。 返回的 `ChildProcess` 实例作为 `child` 属性附加到 `Promise`。 如果出现错误（包括任何导致退出码不是 0 的错误），则将返回被拒绝的 promise，其具有与回调中给定相同的 `error` 对象，但有两个额外的属性 `stdout` 和 `stderr`。

```
const util = require('util');
const execFile = util.promisify(require('child_process').execFile);
async function getVersion() {
  const { stdout } = await execFile('node', ['--version']);
  console.log(stdout);
}
getVersion();
```

**如果启用了 `shell` 选项，则请勿将未经处理的用户输入传递给此函数。 任何包含 shell 元字符的输入都可用于触发任意命令执行。**

#### `child_process.fork(modulePath[, args][, options])`[#](http://nodejs.cn/api-v12/child_process.html#child_processforkmodulepath-args-options)

[中英对照](http://nodejs.cn/api-v12/child_process/child_process_fork_modulepath_args_options.html)

-   `modulePath` [<string>](http://url.nodejs.cn/9Tw2bK) 要在子进程中运行的模块。
-   `args` [<string\[\]>](http://url.nodejs.cn/9Tw2bK) 字符串参数列表。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `cwd` [<string>](http://url.nodejs.cn/9Tw2bK) 子进程的当前工作目录。
    -   `detached` [<boolean>](http://url.nodejs.cn/jFbvuT) 准备子进程独立于其父进程运行。 具体行为取决于平台，参见 [`options.detached`](http://nodejs.cn/api-v12/child_process.html#child_process_options_detached)。
    -   `env` [<Object>](http://url.nodejs.cn/jzn6Ao) 环境变量键值对。 **默认值:** `process.env`。
    -   `execPath` [<string>](http://url.nodejs.cn/9Tw2bK) 用于创建子进程的可执行文件。
    -   `execArgv` [<string\[\]>](http://url.nodejs.cn/9Tw2bK) 传给可执行文件的字符串参数列表。 **默认值:** `process.execArgv`。
    -   `serialization` [<string>](http://url.nodejs.cn/9Tw2bK) 指定用于在进程之间发送消息的序列化类型。 可能的值为 `'json'` 和 `'advanced'`。 有关更多详细信息，请参阅[高级序列化](http://nodejs.cn/api-v12/child_process.html#child_process_advanced_serialization)。 **默认值:** `'json'`。
    -   `silent` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 `true`，则子进程的标准输入、标准输出和标准错误将通过管道传输到父进程，否则它们将从父进程继承，有关详细信息，请参阅 [`child_process.spawn()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawn_command_args_options) 的 [`stdio`](http://nodejs.cn/api-v12/child_process.html#child_process_options_stdio) 的 `'pipe'` 和 `'inherit'` 选项。 **默认值:** `false`。
    -   `stdio` [<Array>](http://url.nodejs.cn/ZJSz23) | [<string>](http://url.nodejs.cn/9Tw2bK) 参见 [`child_process.spawn()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawn_command_args_options) 的 [`stdio`](http://nodejs.cn/api-v12/child_process.html#child_process_options_stdio)。 提供此选项时，它会覆盖 `silent`。 如果使用数组变体，则它必须恰好包含一个值为 `'ipc'` 的条目，否则将抛出错误。 例如 `[0, 1, 2, 'ipc']`。
    -   `windowsVerbatimArguments` [<boolean>](http://url.nodejs.cn/jFbvuT) 在 Windows 上不为参数加上引号或转义。 在 Unix 上被忽略。 **默认值:** `false`。
    -   `uid` [<number>](http://url.nodejs.cn/SXbo1v) 设置进程的用户标识（参见 [`setuid(2)`](http://url.nodejs.cn/bUGgha)）。
    -   `gid` [<number>](http://url.nodejs.cn/SXbo1v) 设置进程的群组标识（参见 [`setgid(2)`](http://url.nodejs.cn/64HRVx)）。
-   返回: [<ChildProcess>](http://nodejs.cn/api/child_process.html#class-childprocess)

`child_process.fork()` 方法是 [`child_process.spawn()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawn_command_args_options) 的特例，专门用于衍生新的 Node.js 进程。 与 [`child_process.spawn()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawn_command_args_options) 一样，返回 [`ChildProcess`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process) 对象。 返回的 [`ChildProcess`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process) 将有额外的内置通信通道，允许消息在父进程和子进程之间来回传递。 详见 [`subprocess.send()`](http://nodejs.cn/api-v12/child_process.html#child_process_subprocess_send_message_sendhandle_options_callback)。

请记住，衍生的 Node.js 子进程独立于父进程，除了两者之间建立的 IPC 通信通道。 每个进程都有自己的内存，具有自己的 V8 实例。 由于需要额外的资源分配，不建议衍生大量子 Node.js 进程。

默认情况下，`child_process.fork()` 将使用父进程的 [`process.execPath`](http://nodejs.cn/api-v12/process.html#process_process_execpath) 衍生新的 Node.js 实例。 `options` 对象中的 `execPath` 属性允许使用替代的执行路径。

使用自定义 `execPath` 启动的 Node.js 进程将使用在子进程上使用环境变量 `NODE_CHANNEL_FD` 标识的文件描述符与父进程通信。

与 [`fork(2)`](http://url.nodejs.cn/mbvoBz) POSIX 系统调用不同，`child_process.fork()` 不克隆当前进程。

`child_process.fork()` 不支持 [`child_process.spawn()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawn_command_args_options) 中可用的 `shell` 选项，如果设置将被忽略。

#### `child_process.spawn(command[, args][, options])`[#](http://nodejs.cn/api-v12/child_process.html#child_processspawncommand-args-options)

[中英对照](http://nodejs.cn/api-v12/child_process/child_process_spawn_command_args_options.html)

-   `command` [<string>](http://url.nodejs.cn/9Tw2bK) 要运行的命令。
-   `args` [<string\[\]>](http://url.nodejs.cn/9Tw2bK) 字符串参数列表。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `cwd` [<string>](http://url.nodejs.cn/9Tw2bK) 子进程的当前工作目录。
    -   `env` [<Object>](http://url.nodejs.cn/jzn6Ao) 环境变量键值对。 **默认值:** `process.env`。
    -   `argv0` [<string>](http://url.nodejs.cn/9Tw2bK) 显式设置发送给子进程的 `argv[0]` 的值。 如果未指定，这将设置为 `command`。
    -   `stdio` [<Array>](http://url.nodejs.cn/ZJSz23) | [<string>](http://url.nodejs.cn/9Tw2bK) 子进程的标准输入输出配置（参见 [`options.stdio`](http://nodejs.cn/api-v12/child_process.html#child_process_options_stdio)）。
    -   `detached` [<boolean>](http://url.nodejs.cn/jFbvuT) 准备子进程独立于其父进程运行。 具体行为取决于平台，参见 [`options.detached`](http://nodejs.cn/api-v12/child_process.html#child_process_options_detached)。
    -   `uid` [<number>](http://url.nodejs.cn/SXbo1v) 设置进程的用户标识（参见 [`setuid(2)`](http://url.nodejs.cn/bUGgha)）。
    -   `gid` [<number>](http://url.nodejs.cn/SXbo1v) 设置进程的群组标识（参见 [`setgid(2)`](http://url.nodejs.cn/64HRVx)）。
    -   `serialization` [<string>](http://url.nodejs.cn/9Tw2bK) 指定用于在进程之间发送消息的序列化类型。 可能的值为 `'json'` 和 `'advanced'`。 有关更多详细信息，请参阅[高级序列化](http://nodejs.cn/api-v12/child_process.html#child_process_advanced_serialization)。 **默认值:** `'json'`。
    -   `shell` [<boolean>](http://url.nodejs.cn/jFbvuT) | [<string>](http://url.nodejs.cn/9Tw2bK) 如果是 `true`，则在 shell 内运行 `command`。 在 Unix 上使用 `'/bin/sh'`，在 Windows 上使用 `process.env.ComSpec`。 可以将不同的 shell 指定为字符串。 请参阅 [shell 的要求](http://nodejs.cn/api-v12/child_process.html#child_process_shell_requirements)和[默认的 Windows shell](http://nodejs.cn/api-v12/child_process.html#child_process_default_windows_shell)。 **默认值:** `false` （没有 shell）
    -   `windowsVerbatimArguments` [<boolean>](http://url.nodejs.cn/jFbvuT) 在 Windows 上不为参数加上引号或转义。 在 Unix 上被忽略。 当指定了 `shell` 并且是 CMD 时，则自动设置为 `true`。 **默认值:** `false`。
    -   `windowsHide` [<boolean>](http://url.nodejs.cn/jFbvuT) 隐藏通常在 Windows 系统上创建的子进程控制台窗口。 **默认值:** `false`。
-   返回: [<ChildProcess>](http://nodejs.cn/api/child_process.html#class-childprocess)

如果省略，`args` 默认为空数组。

**如果启用了 `shell` 选项，则请勿将未经处理的用户输入传递给此函数。 任何包含 shell 元字符的输入都可用于触发任意命令执行。**

第三个参数可用于指定其他选项，具有以下默认值：

```
const defaults = {
  cwd: undefined,
  env: process.env
};
```

使用 `cwd` 指定从中衍生进程的工作目录。 如果没有给定，则默认是继承当前工作目录。

使用 `env` 指定对新进程可见的环境变量，默认为 [`process.env`](http://nodejs.cn/api-v12/process.html#process_process_env)。

`env` 中的 `undefined` 值将被忽略。

运行 `ls -lh /usr`、捕获 `stdout`、`stderr` 和退出码的示例：

```
const { spawn } = require('child_process');
const ls = spawn('ls', ['-lh', '/usr']);

ls.stdout.on('data', (data) => {
  console.log(`stdout: ${data}`);
});

ls.stderr.on('data', (data) => {
  console.error(`stderr: ${data}`);
});

ls.on('close', (code) => {
  console.log(`child process exited with code ${code}`);
});
```

示例：一种非常精细的运行 `ps ax | grep ssh` 的方式

```
const { spawn } = require('child_process');
const ps = spawn('ps', ['ax']);
const grep = spawn('grep', ['ssh']);

ps.stdout.on('data', (data) => {
  grep.stdin.write(data);
});

ps.stderr.on('data', (data) => {
  console.error(`ps stderr: ${data}`);
});

ps.on('close', (code) => {
  if (code !== 0) {
    console.log(`ps process exited with code ${code}`);
  }
  grep.stdin.end();
});

grep.stdout.on('data', (data) => {
  console.log(data.toString());
});

grep.stderr.on('data', (data) => {
  console.error(`grep stderr: ${data}`);
});

grep.on('close', (code) => {
  if (code !== 0) {
    console.log(`grep process exited with code ${code}`);
  }
});
```

检查失败 `spawn` 的示例：

```
const { spawn } = require('child_process');
const subprocess = spawn('bad_command');

subprocess.on('error', (err) => {
  console.error('Failed to start subprocess.');
});
```

某些平台（macOS、Linux）将使用 `argv[0]` 的值作为进程标题，而其他平台（Windows、SunOS）将使用 `command`。

Node.js 当前在启动时用 `process.execPath` 覆盖 `argv[0]`，因此 Node.js 子进程中的 `process.argv[0]` 将不匹配从父进程传给 `spawn` 的 `argv0` 参数，而是使用 `process.argv0` 属性检索它。

##### `options.detached`[#](http://nodejs.cn/api-v12/child_process.html#optionsdetached)

[中英对照](http://nodejs.cn/api-v12/child_process/options_detached.html)

新增于: v0.7.10

在 Windows 上，将 `options.detached` 设置为 `true` 可以让子进程在父进程退出后继续运行。 子进程将有自己的控制台窗口。 一旦为子进程启用，则它就不能被禁用。

在非 Windows 平台上，如果 `options.detached` 设置为 `true`，则子进程将成为新进程组和会话的领导者。 子进程可以在父进程退出后继续运行，不管它们是否分离。 有关详细信息，请参阅 [`setsid(2)`](http://url.nodejs.cn/sJk7DY)。

默认情况下，父进程将等待分离的子进程退出。 为了防止父进程等待给定的 `subprocess` 退出，则使用 `subprocess.unref()` 方法。 这样做会使父进程的事件循环不将子进程包括在其引用计数中，从而允许父进程独立于子进程退出，除非在子进程和父进程之间建立了 IPC 通道。

当使用 `detached` 选项启动长时间运行的进程时，进程在父进程退出后不会一直在后台运行，除非提供了未连接到父进程的 `stdio` 配置。 如果继承了父进程的 `stdio`，则子进程将保持与控制终端的连接。

长时间运行的进程的示例，通过分离并忽略其父进程的 `stdio` 文件描述符，以忽略父进程的终止：

```
const { spawn } = require('child_process');

const subprocess = spawn(process.argv[0], ['child_program.js'], {
  detached: true,
  stdio: 'ignore'
});

subprocess.unref();
```

或者，可以将子进程的输出重定向到文件中：

```
const fs = require('fs');
const { spawn } = require('child_process');
const out = fs.openSync('./out.log', 'a');
const err = fs.openSync('./out.log', 'a');

const subprocess = spawn('prg', [], {
  detached: true,
  stdio: [ 'ignore', out, err ]
});

subprocess.unref();
```

##### `options.stdio`[#](http://nodejs.cn/api-v12/child_process.html#optionsstdio)

[中英对照](http://nodejs.cn/api-v12/child_process/options_stdio.html)

`options.stdio` 选项用于配置在父进程和子进程之间建立的管道。 默认情况下，子进程的标准输入、标准输出和标准错误被重定向到 [`ChildProcess`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process) 对象上相应的 [`subprocess.stdin`](http://nodejs.cn/api-v12/child_process.html#child_process_subprocess_stdin)、[`subprocess.stdout`](http://nodejs.cn/api-v12/child_process.html#child_process_subprocess_stdout) 和 [`subprocess.stderr`](http://nodejs.cn/api-v12/child_process.html#child_process_subprocess_stderr) 流。 这相当于将 `options.stdio` 设置为等于 `['pipe', 'pipe', 'pipe']`。

为方便起见，`options.stdio` 可能是以下字符串之一：

-   `'pipe'`: 相当于 `['pipe', 'pipe', 'pipe']`（默认）
-   `'ignore'`: 相当于 `['ignore', 'ignore', 'ignore']`
-   `'inherit'`: 相当于 `['inherit', 'inherit', 'inherit']` 或 `[0, 1, 2]`

否则，`options.stdio` 的值是一个数组，其中每个索引对应于子进程中的文件描述符。 文件描述符 0、1 和 2 分别对应于标准输入、标准输出和标准错误。 可以指定额外的文件描述符以在父进程和子进程之间创建额外的管道。 该值是以下之一：

1.  `'pipe'`：在子进程和父进程之间创建管道。 管道的父端作为 [`subprocess.stdio[fd]`](http://nodejs.cn/api-v12/child_process.html#child_process_subprocess_stdio) 的 `child_process` 对象的属性暴露给父进程。 为文件描述符 0、1 和 2 创建的管道也可分别用作 [`subprocess.stdin`](http://nodejs.cn/api-v12/child_process.html#child_process_subprocess_stdin)、[`subprocess.stdout`](http://nodejs.cn/api-v12/child_process.html#child_process_subprocess_stdout) 和 [`subprocess.stderr`](http://nodejs.cn/api-v12/child_process.html#child_process_subprocess_stderr)。
    
2.  `'ipc'`：创建 IPC 通道，用于在父子进程之间传递消息/文件描述符。 一个 [`ChildProcess`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process) 最多可以有一个 IPC 标准输入输出文件描述符。 设置此选项将启用 [`subprocess.send()`](http://nodejs.cn/api-v12/child_process.html#child_process_subprocess_send_message_sendhandle_options_callback) 方法。 如果子进程是 Node.js 进程，则 IPC 通道的存在将启用 [`process.send()`](http://nodejs.cn/api-v12/process.html#process_process_send_message_sendhandle_options_callback) 和 [`process.disconnect()`](http://nodejs.cn/api-v12/process.html#process_process_disconnect) 方法，以及子进程中的 [`'disconnect'`](http://nodejs.cn/api-v12/process.html#process_event_disconnect) 和 [`'message'`](http://nodejs.cn/api-v12/process.html#process_event_message) 事件。
    
    不支持以 [`process.send()`](http://nodejs.cn/api-v12/process.html#process_process_send_message_sendhandle_options_callback) 以外的任何方式访问 IPC 通道文件描述符、或者将 IPC 通道与非 Node.js 实例的子进程一起使用。
    
3.  `'ignore'`：指示 Node.js 忽略子进程中的文件描述符。 虽然 Node.js 将始终为其衍生的进程打开文件描述符 0、1 和 2，但将文件描述符设置为 `'ignore'` 将导致 Node.js 打开 `/dev/null` 并将其附加到子进程的文件描述符。
    
4.  `'inherit'`：通过相应的标准输入输出流传入/传出父进程。 在前三个位置，这分别相当于 `process.stdin`、`process.stdout` 和 `process.stderr`。 在任何其他位置，相当于 `'ignore'`。
    
5.  [<Stream>](http://nodejs.cn/api/stream.html#stream) 对象：与子进程共享引用终端、文件、套接字或管道的可读或可写流。 流的底层文件描述符在子进程中复制到对应于 `stdio` 数组中的索引的文件描述符。 流必须有底层描述符（文件流在 `'open'` 事件发生之前没有）。
    
6.  正整数：该整数值被解释为当前在父进程中打开的文件描述符。 它与子进程共享，类似于共享 [<Stream>](http://nodejs.cn/api/stream.html#stream) 对象的方式。 Windows 不支持传入套接字。
    
7.  `null`、`undefined`：使用默认值。 对于标准输入输出文件描述符 0、1 和 2（换句话说，标准输入、标准输出和标准错误），创建管道。 对于文件描述符 3 及以上，默认值为 `'ignore'`。
    

```
const { spawn } = require('child_process');

// 子进程将使用父进程的标准输入输出。
spawn('prg', [], { stdio: 'inherit' });

// 衍生仅共享标准错误的子进程。
spawn('prg', [], { stdio: ['pipe', 'pipe', process.stderr] });

// 打开额外的文件描述符=4，以与呈现 startd 风格界面的程序进行交互。
spawn('prg', [], { stdio: ['pipe', null, null, null, 'pipe'] });
```

_值得注意的是，当父子进程之间建立了 IPC 通道，并且子进程是 Node.js 进程时，则子进程会在未引用 IPC 通道的情况下启动（使用 `unref()` ），直到子进程为 [`'disconnect'`](http://nodejs.cn/api-v12/process.html#process_event_disconnect) 事件或 [`'message'`](http://nodejs.cn/api-v12/process.html#process_event_message) 事件注册事件句柄。 这允许子进程正常退出，而进程不会被打开的 IPC 通道保持打开状态。_

在类 Unix 操作系统上，[`child_process.spawn()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawn_command_args_options) 方法在将事件循环与子进程分离之前同步执行内存操作。 具有大量内存占用的应用程序可能会发现频繁的 [`child_process.spawn()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawn_command_args_options) 调用是一个瓶颈。 有关更多信息，请参阅 [V8 问题 7381](http://url.nodejs.cn/p8ZCVp)。

另见：[`child_process.exec()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_exec_command_options_callback) 和 [`child_process.fork()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_fork_modulepath_args_options)。

### 同步进程的创建[#](http://nodejs.cn/api-v12/child_process.html#synchronous-process-creation)

[中英对照](http://nodejs.cn/api-v12/child_process/synchronous_process_creation.html)

[`child_process.spawnSync()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawnsync_command_args_options)、[`child_process.execSync()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_execsync_command_options) 和 [`child_process.execFileSync()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_execfilesync_file_args_options) 方法是同步的，将阻塞 Node.js 事件循环，暂停任何其他代码的执行，直到衍生的进程退出。

像这样的阻塞调用对于简化通用脚本任务和在启动时简化应用程序配置的加载/处理非常有用。

#### `child_process.execFileSync(file[, args][, options])`[#](http://nodejs.cn/api-v12/child_process.html#child_processexecfilesyncfile-args-options)

[中英对照](http://nodejs.cn/api-v12/child_process/child_process_execfilesync_file_args_options.html)

-   `file` [<string>](http://url.nodejs.cn/9Tw2bK) 要运行的可执行文件的名称或路径。
-   `args` [<string\[\]>](http://url.nodejs.cn/9Tw2bK) 字符串参数列表。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `cwd` [<string>](http://url.nodejs.cn/9Tw2bK) 子进程的当前工作目录。
    -   `input` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) 将作为标准输入传给衍生进程的值。 提供此值将覆盖 `stdio[0]`。
    -   `stdio` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Array>](http://url.nodejs.cn/ZJSz23) 子进程的标准输入输出配置。 除非指定 `stdio`，否则默认情况下 `stderr` 将输出到父进程的标准错误。 **默认值:** `'pipe'`。
    -   `env` [<Object>](http://url.nodejs.cn/jzn6Ao) 环境变量键值对。 **默认值:** `process.env`。
    -   `uid` [<number>](http://url.nodejs.cn/SXbo1v) 设置进程的用户标识（参见 [`setuid(2)`](http://url.nodejs.cn/bUGgha)）。
    -   `gid` [<number>](http://url.nodejs.cn/SXbo1v) 设置进程的群组标识（参见 [`setgid(2)`](http://url.nodejs.cn/64HRVx)）。
    -   `timeout` [<number>](http://url.nodejs.cn/SXbo1v) 允许进程运行的最长时间（以毫秒为单位）。 **默认值:** `undefined`。
    -   `killSignal` [<string>](http://url.nodejs.cn/9Tw2bK) | [<integer>](http://url.nodejs.cn/SXbo1v) 衍生的进程将被终止时要使用的信号值。 **默认值:** `'SIGTERM'`。
    -   `maxBuffer` [<number>](http://url.nodejs.cn/SXbo1v) 标准输出或标准错误上允许的最大数据量（以字节为单位）。 如果超过，则终止子进程。 请参阅 [maxBuffer 和 Unicode](http://nodejs.cn/api-v12/child_process.html#child_process_maxbuffer_and_unicode) 的注意事项。 **默认值:** `1024 * 1024`。
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 用于所有标准输入输出的输入和输出的编码。 **默认值:** `'buffer'`。
    -   `windowsHide` [<boolean>](http://url.nodejs.cn/jFbvuT) 隐藏通常在 Windows 系统上创建的子进程控制台窗口。 **默认值:** `false`。
    -   `shell` [<boolean>](http://url.nodejs.cn/jFbvuT) | [<string>](http://url.nodejs.cn/9Tw2bK) 如果是 `true`，则在 shell 内运行 `command`。 在 Unix 上使用 `'/bin/sh'`，在 Windows 上使用 `process.env.ComSpec`。 可以将不同的 shell 指定为字符串。 请参阅 [shell 的要求](http://nodejs.cn/api-v12/child_process.html#child_process_shell_requirements)和[默认的 Windows shell](http://nodejs.cn/api-v12/child_process.html#child_process_default_windows_shell)。 **默认值:** `false` （没有 shell）
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK) 命令的标准输出。

`child_process.execFileSync()` 方法通常与 [`child_process.execFile()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_execfile_file_args_options_callback) 相同，不同之处在于该方法在子进程完全关闭之前不会返回。 当遇到超时并发送 `killSignal` 时，该方法在进程完全退出之前不会返回。

如果子进程拦截并处理了 `SIGTERM` 信号且没有退出，则父进程仍然会等待，直到子进程退出。

如果进程超时或具有非零退出码，则此方法将抛出 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)，其中包含底层 [`child_process.spawnSync()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawnsync_command_args_options) 的完整结果。

**如果启用了 `shell` 选项，则请勿将未经处理的用户输入传递给此函数。 任何包含 shell 元字符的输入都可用于触发任意命令执行。**

#### `child_process.execSync(command[, options])`[#](http://nodejs.cn/api-v12/child_process.html#child_processexecsynccommand-options)

[中英对照](http://nodejs.cn/api-v12/child_process/child_process_execsync_command_options.html)

-   `command` [<string>](http://url.nodejs.cn/9Tw2bK) 要运行的命令。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `cwd` [<string>](http://url.nodejs.cn/9Tw2bK) 子进程的当前工作目录。
    -   `input` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) 将作为标准输入传给衍生进程的值。 提供此值将覆盖 `stdio[0]`。
    -   `stdio` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Array>](http://url.nodejs.cn/ZJSz23) 子进程的标准输入输出配置。 除非指定 `stdio`，否则默认情况下 `stderr` 将输出到父进程的标准错误。 **默认值:** `'pipe'`。
    -   `env` [<Object>](http://url.nodejs.cn/jzn6Ao) 环境变量键值对。 **默认值:** `process.env`。
    -   `shell` [<string>](http://url.nodejs.cn/9Tw2bK) 用于执行命令的 shell。 请参阅 [shell 的要求](http://nodejs.cn/api-v12/child_process.html#child_process_shell_requirements)和[默认的 Windows shell](http://nodejs.cn/api-v12/child_process.html#child_process_default_windows_shell)。 **默认值:** Unix 上是 `'/bin/sh'`，Windows 上是 `process.env.ComSpec`。
    -   `uid` [<number>](http://url.nodejs.cn/SXbo1v) 设置进程的用户标识。 （参见 [`setuid(2)`](http://url.nodejs.cn/bUGgha)）。
    -   `gid` [<number>](http://url.nodejs.cn/SXbo1v) 设置进程的群组标识。 （参见 [`setgid(2)`](http://url.nodejs.cn/64HRVx)）。
    -   `timeout` [<number>](http://url.nodejs.cn/SXbo1v) 允许进程运行的最长时间（以毫秒为单位）。 **默认值:** `undefined`。
    -   `killSignal` [<string>](http://url.nodejs.cn/9Tw2bK) | [<integer>](http://url.nodejs.cn/SXbo1v) 衍生的进程将被终止时要使用的信号值。 **默认值:** `'SIGTERM'`。
    -   `maxBuffer` [<number>](http://url.nodejs.cn/SXbo1v) 标准输出或标准错误上允许的最大数据量（以字节为单位）。 如果超过，则子进程将终止并截断任何输出。 请参阅 [maxBuffer 和 Unicode](http://nodejs.cn/api-v12/child_process.html#child_process_maxbuffer_and_unicode) 的注意事项。 **默认值:** `1024 * 1024`。
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 用于所有标准输入输出的输入和输出的编码。 **默认值:** `'buffer'`。
    -   `windowsHide` [<boolean>](http://url.nodejs.cn/jFbvuT) 隐藏通常在 Windows 系统上创建的子进程控制台窗口。 **默认值:** `false`。
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK) 命令的标准输出。

`child_process.execSync()` 方法通常与 [`child_process.exec()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_exec_command_options_callback) 相同，不同之处在于该方法在子进程完全关闭之前不会返回。 当遇到超时并发送 `killSignal` 时，该方法在进程完全退出之前不会返回。 如果子进程拦截并处理了 `SIGTERM` 信号且没有退出，则父进程会一直等到子进程退出。

如果进程超时或具有非零退出码，则此方法将抛出错误。 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 对象将包含 [`child_process.spawnSync()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawnsync_command_args_options) 的整个结果。

**切勿将未经处理的用户输入传给此函数。 任何包含 shell 元字符的输入都可用于触发任意命令执行。**

#### `child_process.spawnSync(command[, args][, options])`[#](http://nodejs.cn/api-v12/child_process.html#child_processspawnsynccommand-args-options)

[中英对照](http://nodejs.cn/api-v12/child_process/child_process_spawnsync_command_args_options.html)

-   `command` [<string>](http://url.nodejs.cn/9Tw2bK) 要运行的命令。
-   `args` [<string\[\]>](http://url.nodejs.cn/9Tw2bK) 字符串参数列表。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `cwd` [<string>](http://url.nodejs.cn/9Tw2bK) 子进程的当前工作目录。
    -   `input` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) 将作为标准输入传给衍生进程的值。 提供此值将覆盖 `stdio[0]`。
    -   `argv0` [<string>](http://url.nodejs.cn/9Tw2bK) 显式设置发送给子进程的 `argv[0]` 的值。 如果未指定，这将设置为 `command`。
    -   `stdio` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Array>](http://url.nodejs.cn/ZJSz23) 子进程的标准输入输出配置。
    -   `env` [<Object>](http://url.nodejs.cn/jzn6Ao) 环境变量键值对。 **默认值:** `process.env`。
    -   `uid` [<number>](http://url.nodejs.cn/SXbo1v) 设置进程的用户标识（参见 [`setuid(2)`](http://url.nodejs.cn/bUGgha)）。
    -   `gid` [<number>](http://url.nodejs.cn/SXbo1v) 设置进程的群组标识（参见 [`setgid(2)`](http://url.nodejs.cn/64HRVx)）。
    -   `timeout` [<number>](http://url.nodejs.cn/SXbo1v) 允许进程运行的最长时间（以毫秒为单位）。 **默认值:** `undefined`。
    -   `killSignal` [<string>](http://url.nodejs.cn/9Tw2bK) | [<integer>](http://url.nodejs.cn/SXbo1v) 衍生的进程将被终止时要使用的信号值。 **默认值:** `'SIGTERM'`。
    -   `maxBuffer` [<number>](http://url.nodejs.cn/SXbo1v) 标准输出或标准错误上允许的最大数据量（以字节为单位）。 如果超过，则子进程将终止并截断任何输出。 请参阅 [maxBuffer 和 Unicode](http://nodejs.cn/api-v12/child_process.html#child_process_maxbuffer_and_unicode) 的注意事项。 **默认值:** `1024 * 1024`。
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 用于所有标准输入输出的输入和输出的编码。 **默认值:** `'buffer'`。
    -   `shell` [<boolean>](http://url.nodejs.cn/jFbvuT) | [<string>](http://url.nodejs.cn/9Tw2bK) 如果是 `true`，则在 shell 内运行 `command`。 在 Unix 上使用 `'/bin/sh'`，在 Windows 上使用 `process.env.ComSpec`。 可以将不同的 shell 指定为字符串。 请参阅 [shell 的要求](http://nodejs.cn/api-v12/child_process.html#child_process_shell_requirements)和[默认的 Windows shell](http://nodejs.cn/api-v12/child_process.html#child_process_default_windows_shell)。 **默认值:** `false` （没有 shell）
    -   `windowsVerbatimArguments` [<boolean>](http://url.nodejs.cn/jFbvuT) 在 Windows 上不为参数加上引号或转义。 在 Unix 上被忽略。 当指定了 `shell` 并且是 CMD 时，则自动设置为 `true`。 **默认值:** `false`。
    -   `windowsHide` [<boolean>](http://url.nodejs.cn/jFbvuT) 隐藏通常在 Windows 系统上创建的子进程控制台窗口。 **默认值:** `false`。
-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `pid` [<number>](http://url.nodejs.cn/SXbo1v) 子进程的 pid。
    -   `output` [<Array>](http://url.nodejs.cn/ZJSz23) 来自标准输入输出的输出的结果数组。
    -   `stdout` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK) `output[1]` 的内容。
    -   `stderr` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<string>](http://url.nodejs.cn/9Tw2bK) `output[2]` 的内容。
    -   `status` [<number>](http://url.nodejs.cn/SXbo1v) | [<null>](http://url.nodejs.cn/334hvC) 子进程的退出码，如果子进程因信号而终止，则为 `null`。
    -   `signal` [<string>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC) 用于终止子进程的信号，如果子进程没有因信号而终止，则为 `null`。
    -   `error` [<Error>](http://url.nodejs.cn/qZ873x) 如果子进程失败或超时，则为错误对象。

`child_process.spawnSync()` 方法通常与 [`child_process.spawn()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawn_command_args_options) 相同，不同之处在于该函数在子进程完全关闭之前不会返回。 当遇到超时并发送 `killSignal` 时，该方法在进程完全退出之前不会返回。 如果进程拦截并处理了 `SIGTERM` 信号并且没有退出，则父进程会一直等到子进程退出。

**如果启用了 `shell` 选项，则请勿将未经处理的用户输入传递给此函数。 任何包含 shell 元字符的输入都可用于触发任意命令执行。**

### `ChildProcess` 类[#](http://nodejs.cn/api-v12/child_process.html#class-childprocess)

[中英对照](http://nodejs.cn/api-v12/child_process/class_childprocess.html)

新增于: v2.2.0

-   继承自: [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter)

`ChildProcess` 的实例，表示衍生的子进程。

`ChildProcess` 的实例不是直接创建的。 而是，使用 [`child_process.spawn()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawn_command_args_options)、[`child_process.exec()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_exec_command_options_callback)、[`child_process.execFile()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_execfile_file_args_options_callback) 或 [`child_process.fork()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_fork_modulepath_args_options) 方法来创建 `ChildProcess` 的实例。

#### `'close'` 事件[#](http://nodejs.cn/api-v12/child_process.html#event-close)

[中英对照](http://nodejs.cn/api-v12/child_process/event_close.html)

新增于: v0.7.7

-   `code` [<number>](http://url.nodejs.cn/SXbo1v) 如果子进程自己退出，则为退出码。
-   `signal` [<string>](http://url.nodejs.cn/9Tw2bK) 终止子进程的信号。

这与 [`'exit'`](http://nodejs.cn/api-v12/child_process.html#child_process_event_exit) 事件不同，因为多个进程可能共享相同的标准输入输出流。

```
const { spawn } = require('child_process');
const ls = spawn('ls', ['-lh', '/usr']);

ls.stdout.on('data', (data) => {
  console.log(`stdout: ${data}`);
});

ls.on('close', (code) => {
  console.log(`child process close all stdio with code ${code}`);
});

ls.on('exit', (code) => {
  console.log(`child process exited with code ${code}`);
});
```

#### `'disconnect'` 事件[#](http://nodejs.cn/api-v12/child_process.html#event-disconnect)

[中英对照](http://nodejs.cn/api-v12/child_process/event_disconnect.html)

新增于: v0.7.2

调用父进程中的 [`subprocess.disconnect()`](http://nodejs.cn/api-v12/child_process.html#child_process_subprocess_disconnect) 方法或子进程中的 [`process.disconnect()`](http://nodejs.cn/api-v12/process.html#process_process_disconnect) 方法后会触发 `'disconnect'` 事件。 断开连接后就不能再发送或接收消息，且 [`subprocess.connected`](http://nodejs.cn/api-v12/child_process.html#child_process_subprocess_connected) 属性为 `false`。

#### `'error'` 事件[#](http://nodejs.cn/api-v12/child_process.html#event-error)

[中英对照](http://nodejs.cn/api-v12/child_process/event_error.html)

-   `err` [<Error>](http://url.nodejs.cn/qZ873x) 错误。

`'error'` 事件在以下情况下触发：

1.  无法衍生该进程，或
2.  进程无法终止，或
3.  向子进程发送消息失败。

发生错误后，`'exit'` 事件可能会也可能不会触发。 在监听 `'exit'` 和 `'error'` 事件时，防止多次意外调用句柄函数。

另见 [`subprocess.kill()`](http://nodejs.cn/api-v12/child_process.html#child_process_subprocess_kill_signal) 和 [`subprocess.send()`](http://nodejs.cn/api-v12/child_process.html#child_process_subprocess_send_message_sendhandle_options_callback)。

#### `'exit'` 事件[#](http://nodejs.cn/api-v12/child_process.html#event-exit)

[中英对照](http://nodejs.cn/api-v12/child_process/event_exit.html)

新增于: v0.1.90

-   `code` [<number>](http://url.nodejs.cn/SXbo1v) 如果子进程自己退出，则为退出码。
-   `signal` [<string>](http://url.nodejs.cn/9Tw2bK) 终止子进程的信号。

`'exit'` 事件在子进程结束后触发。 如果进程退出，则 `code` 为最终的进程退出码，否则为 `null`。 如果进程因收到信号而终止，则 `signal` 是信号的字符串名称，否则为 `null`。 两者之一将始终是非 `null`。

当 `'exit'` 事件被触发时，子进程标准输入输出流可能仍处于打开状态。

Node.js 为 `SIGINT` 和 `SIGTERM` 建立信号句柄，且 Node.js 进程不会因为收到这些信号而立即终止。 而是，Node.js 将执行一系列清理操作，然后重新触发已处理的信号。

参见 [`waitpid(2)`](http://url.nodejs.cn/amThCi)。

#### `'message'` 事件[#](http://nodejs.cn/api-v12/child_process.html#event-message)

[中英对照](http://nodejs.cn/api-v12/child_process/event_message.html)

新增于: v0.5.9

-   `message` [<Object>](http://url.nodejs.cn/jzn6Ao) 解析的 JSON 对象或原始值。
-   `sendHandle` [<Handle>](http://nodejs.cn/api/net.html#serverlistenhandle-backlog-callback) [`net.Socket`](http://nodejs.cn/api-v12/net.html#net_class_net_socket) 或 [`net.Server`](http://nodejs.cn/api-v12/net.html#net_class_net_server) 对象、或未定义。

当子进程使用 [`process.send()`](http://nodejs.cn/api-v12/process.html#process_process_send_message_sendhandle_options_callback) 发送消息时，则触发 `'message'` 事件。

消息经过序列化和解析。 结果消息可能与最初发送的消息不同。

如果在衍生子进程时将 `serialization` 选项设置为 `'advanced'`，则 `message` 参数可以包含 JSON 无法表示的数据。 有关更多详细信息，请参阅[高级序列化](http://nodejs.cn/api-v12/child_process.html#child_process_advanced_serialization)。

#### `subprocess.channel`[#](http://nodejs.cn/api-v12/child_process.html#subprocesschannel)

[中英对照](http://nodejs.cn/api-v12/child_process/subprocess_channel.html)

新增于: v7.1.0

-   [<Object>](http://url.nodejs.cn/jzn6Ao) 代表到子进程的 IPC 通道的管道。

`subprocess.channel` 属性是对子进程的 IPC 通道的引用。 如果当前不存在 IPC 通道，则此属性为 `undefined`。

#### `subprocess.connected`[#](http://nodejs.cn/api-v12/child_process.html#subprocessconnected)

[中英对照](http://nodejs.cn/api-v12/child_process/subprocess_connected.html)

新增于: v0.7.2

-   [<boolean>](http://url.nodejs.cn/jFbvuT) 调用 `subprocess.disconnect()` 后设置为 `false`。

`subprocess.connected` 属性指示是否仍然可以从子进程发送和接收消息。 当 `subprocess.connected` 为 `false` 时，不再可能发送或接收消息。

#### `subprocess.disconnect()`[#](http://nodejs.cn/api-v12/child_process.html#subprocessdisconnect)

[中英对照](http://nodejs.cn/api-v12/child_process/subprocess_disconnect.html)

新增于: v0.7.2

关闭父进程和子进程之间的 IPC 通道，一旦没有其他连接使其保持活动状态，则允许子进程正常退出。 调用此方法后，父子进程中的 `subprocess.connected` 和 `process.connected` 属性（分别）将设置为 `false`，进程之间将无法再传递消息。

当接收过程中没有消息时，将触发 `'disconnect'` 事件。 这通常会在调用 `subprocess.disconnect()` 后立即触发。

当子进程是 Node.js 实例（例如使用 [`child_process.fork()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_fork_modulepath_args_options) 衍生）时，则可以在子进程中调用 `process.disconnect()` 方法来关闭 IPC 通道。

#### `subprocess.exitCode`[#](http://nodejs.cn/api-v12/child_process.html#subprocessexitcode)

[中英对照](http://nodejs.cn/api-v12/child_process/subprocess_exitcode.html)

-   [<integer>](http://url.nodejs.cn/SXbo1v)

`subprocess.exitCode` 属性表示子进程的退出码。 如果子进程仍在运行，则该字段将为 `null`。

#### `subprocess.kill([signal])`[#](http://nodejs.cn/api-v12/child_process.html#subprocesskillsignal)

[中英对照](http://nodejs.cn/api-v12/child_process/subprocess_kill_signal.html)

新增于: v0.1.90

-   `signal` [<number>](http://url.nodejs.cn/SXbo1v) | [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

`subprocess.kill()` 方法向子进程发送信号。 如果没有给定参数，则进程将被发送 `'SIGTERM'` 信号。 有关可用信号的列表，请参阅 [`signal(7)`](http://url.nodejs.cn/Fj3tfw)。 如果 [`kill(2)`](http://url.nodejs.cn/KDV7jD) 成功，则此函数返回 `true`，否则返回 `false`。

```
const { spawn } = require('child_process');
const grep = spawn('grep', ['ssh']);

grep.on('close', (code, signal) => {
  console.log(
    `child process terminated due to receipt of signal ${signal}`);
});

// 发送 SIGHUP 到进程。
grep.kill('SIGHUP');
```

如果信号无法传达，则 [`ChildProcess`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process) 对象可能会触发 [`'error'`](http://nodejs.cn/api-v12/child_process.html#child_process_event_error) 事件。 向已经退出的子进程发送信号不是错误，但可能会产生不可预见的结果。 具体来说，如果进程标识符 (PID) 已重新分配给另一个进程，则信号将传给该进程，而这可能会产生意外结果。

虽然该函数被称为 `kill`，但传给子进程的信号实际上可能不会终止该进程。

请参阅 [`kill(2)`](http://url.nodejs.cn/KDV7jD) 以供参考。

在 Linux 上，子进程的子进程在试图杀死其父进程时不会被终止。 当在 shell 中运行新进程或使用 `ChildProcess` 的 `shell` 选项时，可能会发生这种情况：

```
'use strict';
const { spawn } = require('child_process');

const subprocess = spawn(
  'sh',
  [
    '-c',
    `node -e "setInterval(() => {
      console.log(process.pid, 'is alive')
    }, 500);"`
  ], {
    stdio: ['inherit', 'inherit', 'inherit']
  }
);

setTimeout(() => {
  subprocess.kill(); // 不会终止 shell 中的 Node.js 进程。
}, 2000);
```

#### `subprocess.killed`[#](http://nodejs.cn/api-v12/child_process.html#subprocesskilled)

[中英对照](http://nodejs.cn/api-v12/child_process/subprocess_killed.html)

新增于: v0.5.10

-   [<boolean>](http://url.nodejs.cn/jFbvuT) 使用 `subprocess.kill()` 成功发送信号给子进程后设置为 `true`。

`subprocess.killed` 属性指示子进程是否成功接收到来自 `subprocess.kill()` 的信号。 `killed` 属性并不表示子进程已终止。

#### `subprocess.pid`[#](http://nodejs.cn/api-v12/child_process.html#subprocesspid)

[中英对照](http://nodejs.cn/api-v12/child_process/subprocess_pid.html)

新增于: v0.1.90

-   [<integer>](http://url.nodejs.cn/SXbo1v)

返回子进程的进程标识符 (PID)。

```
const { spawn } = require('child_process');
const grep = spawn('grep', ['ssh']);

console.log(`Spawned child pid: ${grep.pid}`);
grep.stdin.end();
```

#### `subprocess.ref()`[#](http://nodejs.cn/api-v12/child_process.html#subprocessref)

[中英对照](http://nodejs.cn/api-v12/child_process/subprocess_ref.html)

新增于: v0.7.10

在调用 `subprocess.unref()` 后调用 `subprocess.ref()` 将为子进程恢复删除的引用计数，迫使父进程在退出之前等待子进程退出。

```
const { spawn } = require('child_process');

const subprocess = spawn(process.argv[0], ['child_program.js'], {
  detached: true,
  stdio: 'ignore'
});

subprocess.unref();
subprocess.ref();
```

#### `subprocess.send(message[, sendHandle[, options]][, callback])`[#](http://nodejs.cn/api-v12/child_process.html#subprocesssendmessage-sendhandle-options-callback)

[中英对照](http://nodejs.cn/api-v12/child_process/subprocess_send_message_sendhandle_options_callback.html)

-   `message` [<Object>](http://url.nodejs.cn/jzn6Ao)
-   `sendHandle` [<Handle>](http://nodejs.cn/api/net.html#serverlistenhandle-backlog-callback)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) `options` 参数（如果存在）是用于参数化某些类型句柄的发送的对象。 `options` 支持以下属性：
    -   `keepOpen` [<boolean>](http://url.nodejs.cn/jFbvuT) 当传入 `net.Socket` 实例时可以使用的值。 当为 `true` 时，套接字在发送过程中保持打开状态。 **默认值:** `false`。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

当父进程和子进程之间建立了 IPC 通道时（即当使用 [`child_process.fork()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_fork_modulepath_args_options) 时），可以使用 `subprocess.send()` 方法向子进程发送消息。 当子进程是 Node.js 实例时，可以通过 [`'message'`](http://nodejs.cn/api-v12/process.html#process_event_message) 事件接收这些消息。

消息经过序列化和解析。 结果消息可能与最初发送的消息不同。

例如，在父进程脚本中：

```
const cp = require('child_process');
const n = cp.fork(`${__dirname}/sub.js`);

n.on('message', (m) => {
  console.log('PARENT got message:', m);
});

// 引起子进程打印：CHILD got message: { hello: 'world' }
n.send({ hello: 'world' });
```

然后子进程脚本 `'sub.js'` 可能如下所示：

```
process.on('message', (m) => {
  console.log('CHILD got message:', m);
});

// 引起父进程打印：PARENT got message: { foo: 'bar', baz: null }
process.send({ foo: 'bar', baz: NaN });
```

子 Node.js 进程将拥有自己的 [`process.send()`](http://nodejs.cn/api-v12/process.html#process_process_send_message_sendhandle_options_callback) 方法，允许子进程将消息发送回父进程。

当发送 `{cmd: 'NODE_foo'}` 消息时是一种特殊情况。 在 `cmd` 属性中包含 `NODE_` 前缀的消息是 Node.js 核心预留使用的，不会在子进程的 [`'message'`](http://nodejs.cn/api-v12/process.html#process_event_message) 事件中触发。 而是，此类消息使用 `'internalMessage'` 事件触发，并由 Node.js 在内部使用。 应用程序应避免使用此类消息或监听 `'internalMessage'` 事件，因为它可能随时更改，恕不另行通知。

可以传给 `subprocess.send()` 的可选 `sendHandle` 参数用于将 TCP 服务器或套接字对象传给子进程。 子进程将接收该对象作为传给在 [`'message'`](http://nodejs.cn/api-v12/process.html#process_event_message) 事件上注册的回调函数的第二个参数。 在套接字中接收和缓冲的任何数据都不会发送给子进程。

可选的 `callback` 函数将在消息发送之后但在子进程可能接收到它之前调用。 该函数使用单个参数调用：成功时为 `null`，失败时为 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 对象。

如果没有提供 `callback` 函数且无法发送消息，则 [`ChildProcess`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process) 对象将触发 `'error'` 事件。 例如，当子进程已经退出时，就会发生这种情况。

如果通道已关闭或未发送消息的积压超过阈值（这使得发送更多消息是不明智的），则 `subprocess.send()` 将返回 `false`。 否则，该方法返回 `true`。 `callback` 函数可用于实现流量控制。

##### 示例：发送服务器对象[#](http://nodejs.cn/api-v12/child_process.html#example-sending-a-server-object)

[中英对照](http://nodejs.cn/api-v12/child_process/example_sending_a_server_object.html)

例如，可以使用 `sendHandle` 参数将 TCP 服务器对象的句柄传给子进程，如下例所示：

```
const subprocess = require('child_process').fork('subprocess.js');

// 打开服务器对象并发送句柄。
const server = require('net').createServer();
server.on('connection', (socket) => {
  socket.end('handled by parent');
});
server.listen(1337, () => {
  subprocess.send('server', server);
});
```

然后子进程将收到服务器对象：

```
process.on('message', (m, server) => {
  if (m === 'server') {
    server.on('connection', (socket) => {
      socket.end('handled by child');
    });
  }
});
```

一旦服务器现在在父进程和子进程之间共享，则一些连接可以由父进程处理，一些连接由子进程处理。

虽然上面的示例使用使用 `net` 模块创建的服务器，但 `dgram` 模块服务器使用完全相同的工作流程，除了监听 `'message'` 事件而不是 `'connection'` 和使用 `server.bind()` 而不是 `server.listen()`。 但是，目前仅在 Unix 平台上支持。

##### 示例：发送套接字对象[#](http://nodejs.cn/api-v12/child_process.html#example-sending-a-socket-object)

[中英对照](http://nodejs.cn/api-v12/child_process/example_sending_a_socket_object.html)

同样，`sendHandler` 参数可用于将套接字的句柄传给子进程。 下面的例子产生了两个子进程，每个子进程都处理具有“normal”或“special”优先级的连接：

```
const { fork } = require('child_process');
const normal = fork('subprocess.js', ['normal']);
const special = fork('subprocess.js', ['special']);

// 打开服务器并将套接字发送给子进程。
// 使用 pauseOnConnect 防止套接字在发送到子进程之前被读取。
const server = require('net').createServer({ pauseOnConnect: true });
server.on('connection', (socket) => {

  // 如果这是 special 优先级...
  if (socket.remoteAddress === '74.125.127.100') {
    special.send('socket', socket);
    return;
  }
  // 这是 normal 优先级。
  normal.send('socket', socket);
});
server.listen(1337);
```

`subprocess.js` 将接收套接字句柄作为传给事件回调函数的第二个参数：

```
process.on('message', (m, socket) => {
  if (m === 'socket') {
    if (socket) {
      // 检查客户端套接字是否存在。
      // 套接字可能会在发送和在子进程中接收到它之间关闭。
      socket.end(`Request handled with ${process.argv[2]} priority`);
    }
  }
});
```

不要在已传给子进程的套接字上使用 `.maxConnections`。 父进程无法跟踪套接字何时被销毁。

子进程中的任何 `'message'` 句柄都应验证 `socket` 是否存在，因为在将连接发送到子进程所需的时间内，连接可能已关闭。

#### `subprocess.signalCode`[#](http://nodejs.cn/api-v12/child_process.html#subprocesssignalcode)

-   [<integer>](http://url.nodejs.cn/SXbo1v)

The `subprocess.signalCode` property indicates the signal number received by the child process if any, else `null`.

#### `subprocess.spawnargs`[#](http://nodejs.cn/api-v12/child_process.html#subprocessspawnargs)

-   [<Array>](http://url.nodejs.cn/ZJSz23)

The `subprocess.spawnargs` property represents the full list of command line arguments the child process was launched with.

#### `subprocess.spawnfile`[#](http://nodejs.cn/api-v12/child_process.html#subprocessspawnfile)

[中英对照](http://nodejs.cn/api-v12/child_process/subprocess_spawnfile.html)

-   [<string>](http://url.nodejs.cn/9Tw2bK)

`subprocess.spawnfile` 属性表示启动的子进程的可执行文件名。

对于 [`child_process.fork()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_fork_modulepath_args_options)，其值将等于 [`process.execPath`](http://nodejs.cn/api-v12/process.html#process_process_execpath)。 对于 [`child_process.spawn()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawn_command_args_options)，它的值将是可执行文件的名称。 对于 [`child_process.exec()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_exec_command_options_callback)，它的值将是启动子进程的 shell 的名称。

#### `subprocess.stderr`[#](http://nodejs.cn/api-v12/child_process.html#subprocessstderr)

[中英对照](http://nodejs.cn/api-v12/child_process/subprocess_stderr.html)

新增于: v0.1.90

-   [<stream.Readable>](http://nodejs.cn/api/stream.html#class-streamreadable)

代表子进程的 `stderr` 的 `Readable Stream`。

如果子进程衍生时 `stdio[2]` 设置为 `'pipe'` 以外的任何值，则此将是 `null`。

`subprocess.stderr` 是 `subprocess.stdio[2]` 的别名。 这两个属性将引用相同的值。

#### `subprocess.stdin`[#](http://nodejs.cn/api-v12/child_process.html#subprocessstdin)

[中英对照](http://nodejs.cn/api-v12/child_process/subprocess_stdin.html)

新增于: v0.1.90

-   [<stream.Writable>](http://nodejs.cn/api/stream.html#class-streamwritable)

代表子进程的 `stdin` 的 `Writable Stream`。

如果子进程等待读取其所有输入，则在通过 `end()` 关闭此流之前，子进程将不会继续。

如果子进程衍生时 `stdio[0]` 设置为 `'pipe'` 以外的任何值，则此将是 `null`。

`subprocess.stdin` 是 `subprocess.stdio[0]` 的别名。 这两个属性将引用相同的值。

#### `subprocess.stdio`[#](http://nodejs.cn/api-v12/child_process.html#subprocessstdio)

[中英对照](http://nodejs.cn/api-v12/child_process/subprocess_stdio.html)

新增于: v0.7.10

-   [<Array>](http://url.nodejs.cn/ZJSz23)

到子进程的稀疏管道数组，对应于传给 [`child_process.spawn()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawn_command_args_options) 的 [`stdio`](http://nodejs.cn/api-v12/child_process.html#child_process_options_stdio) 选项中的位置，这些位置已设置为值 `'pipe'`。 `subprocess.stdio[0]`、`subprocess.stdio[1]` 和 `subprocess.stdio[2]` 也可分别用作 `subprocess.stdin`、`subprocess.stdout` 和 `subprocess.stderr`。

在下面的例子中，只有子进程的文件描述符 `1` (标准输出) 被配置为管道，所以只有进程的 `subprocess.stdio[1]` 是流，数组中的所有其他值都是 `null`。

```
const assert = require('assert');
const fs = require('fs');
const child_process = require('child_process');

const subprocess = child_process.spawn('ls', {
  stdio: [
    0, // 为子进程使用父进程的标准输入。
    'pipe', // 管道子进程的标准输出到父进程。
    fs.openSync('err.out', 'w') // 将子进程的标准错误定向到文件。
  ]
});

assert.strictEqual(subprocess.stdio[0], null);
assert.strictEqual(subprocess.stdio[0], subprocess.stdin);

assert(subprocess.stdout);
assert.strictEqual(subprocess.stdio[1], subprocess.stdout);

assert.strictEqual(subprocess.stdio[2], null);
assert.strictEqual(subprocess.stdio[2], subprocess.stderr);
```

#### `subprocess.stdout`[#](http://nodejs.cn/api-v12/child_process.html#subprocessstdout)

[中英对照](http://nodejs.cn/api-v12/child_process/subprocess_stdout.html)

新增于: v0.1.90

-   [<stream.Readable>](http://nodejs.cn/api/stream.html#class-streamreadable)

代表子进程的 `stdout` 的 `Readable Stream`。

如果子进程衍生时 `stdio[1]` 设置为 `'pipe'` 以外的任何值，则此将是 `null`。

`subprocess.stdout` 是 `subprocess.stdio[1]` 的别名。 这两个属性将引用相同的值。

```
const { spawn } = require('child_process');

const subprocess = spawn('ls');

subprocess.stdout.on('data', (data) => {
  console.log(`Received chunk ${data}`);
});
```

#### `subprocess.unref()`[#](http://nodejs.cn/api-v12/child_process.html#subprocessunref)

[中英对照](http://nodejs.cn/api-v12/child_process/subprocess_unref.html)

新增于: v0.7.10

默认情况下，父进程将等待分离的子进程退出。 为了防止父进程等待给定的 `subprocess` 退出，则使用 `subprocess.unref()` 方法。 这样做会使父进程的事件循环不将子进程包括在其引用计数中，从而允许父进程独立于子进程退出，除非在子进程和父进程之间建立了 IPC 通道。

```
const { spawn } = require('child_process');

const subprocess = spawn(process.argv[0], ['child_program.js'], {
  detached: true,
  stdio: 'ignore'
});

subprocess.unref();
```

### maxBuffer 和 Unicode[#](http://nodejs.cn/api-v12/child_process.html#maxbuffer-and-unicode)

[中英对照](http://nodejs.cn/api-v12/child_process/maxbuffer_and_unicode.html)

`maxBuffer` 选项指定 `stdout` 或 `stderr` 上允许的最大字节数。 如果超过此值，则终止子进程。 这会影响包含多字节字符编码（例如 UTF-8 或 UTF-16）的输出。 例如，`console.log('中文测试')` 将向 `stdout` 发送 13 个 UTF-8 编码字节，尽管只有 4 个字符。

### shell 的要求[#](http://nodejs.cn/api-v12/child_process.html#shell-requirements)

[中英对照](http://nodejs.cn/api-v12/child_process/shell_requirements.html)

shell 应该理解 `-c` 开关。

### 默认的 Windows shell[#](http://nodejs.cn/api-v12/child_process.html#default-windows-shell)

[中英对照](http://nodejs.cn/api-v12/child_process/default_windows_shell.html)

尽管微软指定 `%COMSPEC%` 必须包含根环境中到 `'cmd.exe'` 的路径，但子进程并不总是受到相同的要求。 因此，在可以衍生 shell 的 `child_process` 函数中，如果 `process.env.ComSpec` 不可用，则使用 `'cmd.exe'` 作为后备。

### 高级序列化[#](http://nodejs.cn/api-v12/child_process.html#advanced-serialization)

[中英对照](http://nodejs.cn/api-v12/child_process/advanced_serialization.html)

新增于: v12.16.0

子进程支持 IPC 的序列化机制，该机制基于 [`v8` 模块的序列化 API](http://nodejs.cn/api-v12/v8.html#v8_serialization_api)，基于 [HTML 结构化克隆算法](http://url.nodejs.cn/SLsDHc)。 这通常功能更强大，支持更多内置的 JavaScript 对象类型，例如 `BigInt`、`Map` 和 `Set`、`ArrayBuffer` 和 `TypedArray`、`Buffer`、`Error`、`RegExp` 等。

但是，这种格式不是 JSON 的完整超集，例如 在此类内置类型的对象上设置的属性不会通过序列化步骤传递。 此外，性能可能不等同于 JSON，具体取决于传递数据的结构。 因此，此功能需要在调用 [`child_process.spawn()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawn_command_args_options) 或 [`child_process.fork()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_fork_modulepath_args_options) 时通过将 `serialization` 选项设置为 `'advanced'` 来选择加入。
