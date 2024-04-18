---
created: 2022-07-29T13:12:53 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/debugger.html
author: 
---

# debugger 调试器 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/debugger/debugger.html)

```
$ node inspect myscript.js
< Debugger listening on ws://127.0.0.1:9229/80e7a814-7cd3-49fb-921a-2e02228cd5ba
< For help, see: https://nodejs.org/en/docs/inspector
< Debugger attached.
Break on start in myscript.js:1
> 1 (function (exports, require, module, __filename, __dirname) { global.x = 5;
  2 setTimeout(() => {
  3   console.log('world');
debug>
```

Node.js 调试器客户端不是功能齐全的调试器，但可以进行简单的步骤和检查。

将语句 `debugger;` 插入脚本的源代码，则将在代码中的该位置启用断点：

```
// myscript.js
global.x = 5;
setTimeout(() => {
  debugger;
  console.log('world');
}, 1000);
console.log('hello');
```

一旦调试器运行，则断点将出现在第 3 行：

```
$ node inspect myscript.js
< Debugger listening on ws://127.0.0.1:9229/80e7a814-7cd3-49fb-921a-2e02228cd5ba
< For help, see: https://nodejs.org/en/docs/inspector
< Debugger attached.
Break on start in myscript.js:1
> 1 (function (exports, require, module, __filename, __dirname) { global.x = 5;
  2 setTimeout(() => {
  3   debugger;
debug> cont
< hello
break in myscript.js:3
  1 (function (exports, require, module, __filename, __dirname) { global.x = 5;
  2 setTimeout(() => {
> 3   debugger;
  4   console.log('world');
  5 }, 1000);
debug> next
break in myscript.js:4
  2 setTimeout(() => {
  3   debugger;
> 4   console.log('world');
  5 }, 1000);
  6 console.log('hello');
debug> repl
Press Ctrl + C to leave debug repl
> x
5
> 2 + 2
4
debug> next
< world
break in myscript.js:5
  3   debugger;
  4   console.log('world');
> 5 }, 1000);
  6 console.log('hello');
  7
debug> .exit
```

`repl` 命令允许远程评估代码。 `next` 命令步进下一行。 键入 `help` 以查看可用的其他命令。

在不输入命令的情况下按 `enter` 将重复之前的调试器命令。

### 监视器[#](http://nodejs.cn/api-v12/debugger.html#watchers)

[中英对照](http://nodejs.cn/api-v12/debugger/watchers.html)

可以在调试时监视表达式和变量值。 在每个断点上，监视器列表中的每个表达式都将在当前上下文中进行评估，并且立即显示在断点的源代码列表之前。

要开始监视表达式，则键入 `watch('my_expression')`。 命令 `watchers` 将打印活动的监视器。 要删除监视器，请键入 `unwatch('my_expression')`。

### 命令参考手册[#](http://nodejs.cn/api-v12/debugger.html#command-reference)

#### 单步执行[#](http://nodejs.cn/api-v12/debugger.html#stepping)

[中英对照](http://nodejs.cn/api-v12/debugger/stepping.html)

-   `cont`, `c`: 继续执行
-   `next`, `n`: 单步执行下一行
-   `step`, `s`: 单步进入
-   `out`, `o`: 单步退出
-   `pause`: 暂停正在运行的代码（类似于开发者工具中的暂停按钮）

#### 断点[#](http://nodejs.cn/api-v12/debugger.html#breakpoints)

[中英对照](http://nodejs.cn/api-v12/debugger/breakpoints.html)

-   `setBreakpoint()`, `sb()`: 在当前行上设置断点
-   `setBreakpoint(line)`, `sb(line)`: 在特定行上设置断点
-   `setBreakpoint('fn()')`, `sb(...)`:
-   `setBreakpoint('script.js', 1)`, `sb(...)`: 在 `script.js` 的第一行上设置断点
-   `clearBreakpoint('script.js', 1)`, `cb(...)`: 清除 `script.js` 中第 1 行上的断点

还可以在尚未加载的文件（模块）中设置断点：

```
$ node inspect main.js
< Debugger listening on ws://127.0.0.1:9229/4e3db158-9791-4274-8909-914f7facf3bd
< For help, see: https://nodejs.org/en/docs/inspector
< Debugger attached.
Break on start in main.js:1
> 1 (function (exports, require, module, __filename, __dirname) { const mod = require('./mod.js');
  2 mod.hello();
  3 mod.hello();
debug> setBreakpoint('mod.js', 22)
Warning: script 'mod.js' was not loaded yet.
debug> c
break in mod.js:22
 20 // USE OR OTHER DEALINGS IN THE SOFTWARE.
 21
>22 exports.hello = function() {
 23   return 'hello from module';
 24 };
debug>
```

#### 信息[#](http://nodejs.cn/api-v12/debugger.html#information)

[中英对照](http://nodejs.cn/api-v12/debugger/information.html)

-   `backtrace`, `bt`: 打印当前执行帧的回溯
-   `list(5)`: 列出脚本源代码的 5 行上下文（前后各 5 行）
-   `watch(expr)`: 将表达式添加到监视列表
-   `unwatch(expr)`: 从监视列表中删除表达式
-   `watchers`: 列出所有监视器及其值（在每个断点上自动列出）
-   `repl`: 打开调试器的交互式解释器，以在调试脚本的上下文中进行评估
-   `exec expr`: 在调试脚本的上下文中执行表达式

#### 执行的控制[#](http://nodejs.cn/api-v12/debugger.html#execution-control)

[中英对照](http://nodejs.cn/api-v12/debugger/execution_control.html)

-   `run`: 运行脚本（在调试器启动时自动运行）
-   `restart`: 重启脚本
-   `kill`: 杀死脚本

#### 杂项[#](http://nodejs.cn/api-v12/debugger.html#various)

[中英对照](http://nodejs.cn/api-v12/debugger/various.html)

-   `scripts`: 列出所有加载的脚本
-   `version`: 显示 V8 的版本

### 高级用法[#](http://nodejs.cn/api-v12/debugger.html#advanced-usage)

#### Node.js 的 V8 检查器集成[#](http://nodejs.cn/api-v12/debugger.html#v8-inspector-integration-for-nodejs)

[中英对照](http://nodejs.cn/api-v12/debugger/v8_inspector_integration_for_node_js.html)

V8 检查器集成允许将 Chrome 开发者工具绑定到 Node.js 实例以进行调试和分析。 它使用 [Chrome 开发者工具协议](http://url.nodejs.cn/YpFEVu)。

V8 检查器可以通过在启动 Node.js 应用程序时传入 `--inspect` 标志来启用。 也可以使用该标志提供自定义的端口，例如 `--inspect=9222` 将接受端口 9222 上的开发者工具连接。

要中断应用程序代码的第一行，则传入 `--inspect-brk` 标志而不是 `--inspect`。

```
$ node --inspect index.js
Debugger listening on ws://127.0.0.1:9229/dc9010dd-f8b8-4ac5-a510-c1a114ec7d29
For help, see: https://nodejs.org/en/docs/inspector
```

（在上面的示例中，网址末尾的 UUID dc9010dd-f8b8-4ac5-a510-c1a114ec7d29 是动态生成的，它在不同的调试会话中有所不同。）

如果 Chrome 浏览器版本低于 66.0.3345.0，则在上述网址中使用 `inspector.html` 而不是 `js_app.html`。

Chrome 开发者工具尚不支持调试[工作线程](http://nodejs.cn/api-v12/worker_threads.html)。 [ndb](http://url.nodejs.cn/iBCQ2L) 可用于调试它们。
