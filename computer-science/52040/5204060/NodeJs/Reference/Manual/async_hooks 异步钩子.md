---
created: 2022-07-29T13:12:53 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/async_hooks.html
author: 
---

# async_hooks 异步钩子 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/async_hooks/async_hooks.html)

**源代码:** [lib/async\_hooks.js](https://github.com/nodejs/node/blob/v12.22.12/lib/async_hooks.js)

`async_hooks`模块提供了 API 来跟踪异步的资源。 可以使用以下方式访问它：

```
const async_hooks = require('async_hooks');
```

### 术语[#](http://nodejs.cn/api-v12/async_hooks.html#terminology)

[中英对照](http://nodejs.cn/api-v12/async_hooks/terminology.html)

异步的资源表示具有关联回调的对象。

资源也可以在调用回调之前关闭。 `AsyncHook` 没有明确区分这些不同的情况，而是将它们表示为抽象的概念，即资源。

如果使用 [`Worker`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_class_worker)，则每个线程都有独立的 `async_hooks` 接口，并且每个线程都会使用一组新的异步 ID。

### Public API[#](http://nodejs.cn/api-v12/async_hooks.html#public-api)

#### 概述[#](http://nodejs.cn/api-v12/async_hooks.html#overview)

[中英对照](http://nodejs.cn/api-v12/async_hooks/overview.html)

以下是公共 API 的简单概述。

```
const async_hooks = require('async_hooks');

// 返回当前执行上下文的 ID。
const eid = async_hooks.executionAsyncId();

// 返回负责触发当前
// 执行范围回调的句柄ID。
const tid = async_hooks.triggerAsyncId();

// 创建新的 AsyncHook 实例。所有这些回调都是可选的。
const asyncHook =
    async_hooks.createHook({ init, before, after, destroy, promiseResolve });

// 允许调用此 AsyncHook 实例的回调。
// 这不是运行构造函数后的隐式操作，
// 必须显式运行才能开始执行回调。
asyncHook.enable();

// 禁用监听新的异步事件。
asyncHook.disable();

//
// 以下是可以传给 createHook() 的回调。
//

// init 在对象构造过程中被调用。
// 当此回调运行时，资源可能尚未完成构造，
// 因此 "asyncId" 引用的资源的所有字段可能尚未填充。
function init(asyncId, type, triggerAsyncId, resource) { }

// 
function before(asyncId) { }

// After 在资源的回调完成后被调用。
function after(asyncId) { }

// 资源销毁时调用销毁。
function destroy(asyncId) { }

// promiseResolve 仅在调用传给 `Promise` 构造函数的 `resolve` 函数时
// （直接或通过其他解决 promise）
// 时调用 promise 资源。
function promiseResolve(asyncId) { }
```

##### `async_hooks.createHook(callbacks)`[#](http://nodejs.cn/api-v12/async_hooks.html#async_hookscreatehookcallbacks)

[中英对照](http://nodejs.cn/api-v12/async_hooks/async_hooks_createhook_callbacks.html)

新增于: v8.1.0

-   `callbacks` [<Object>](http://url.nodejs.cn/jzn6Ao) 要注册的[钩子回调](http://nodejs.cn/api-v12/async_hooks.html#async_hooks_hook_callbacks)
    -   `init` [<Function>](http://url.nodejs.cn/ceTQa6) [`init` 回调](http://nodejs.cn/api-v12/async_hooks.html#async_hooks_init_asyncid_type_triggerasyncid_resource)。
    -   `before` [<Function>](http://url.nodejs.cn/ceTQa6) [`before` 回调](http://nodejs.cn/api-v12/async_hooks.html#async_hooks_before_asyncid)。
    -   `after` [<Function>](http://url.nodejs.cn/ceTQa6) [`after` 回调](http://nodejs.cn/api-v12/async_hooks.html#async_hooks_after_asyncid)。
    -   `destroy` [<Function>](http://url.nodejs.cn/ceTQa6) [`destroy` 回调](http://nodejs.cn/api-v12/async_hooks.html#async_hooks_destroy_asyncid)。
    -   `promiseResolve` [<Function>](http://url.nodejs.cn/ceTQa6) [`promiseResolve` 回调](http://nodejs.cn/api-v12/async_hooks.html#async_hooks_promiseresolve_asyncid)。
-   返回: [<AsyncHook>](http://nodejs.cn/api/async_hooks.html#async_hookscreatehookcallbacks) 用于禁用和启用钩子的实例

为每个异步操作的不同生命周期事件注册要调用的函数。

回调 `init()`/`before()`/`after()`/`destroy()` 在资源的生命周期内为相应的异步事件调用。

所有回调都是可选的。 比如，如果只需要跟踪资源清理，则只需要传入 `destroy` 回调。 可以传给 `callbacks` 的所有函数的细节都在[钩子回调](http://nodejs.cn/api-v12/async_hooks.html#async_hooks_hook_callbacks)章节。

```
const async_hooks = require('async_hooks');

const asyncHook = async_hooks.createHook({
  init(asyncId, type, triggerAsyncId, resource) { },
  destroy(asyncId) { }
});
```

回调将通过原型链继承：

```
class MyAsyncCallbacks {
  init(asyncId, type, triggerAsyncId, resource) { }
  destroy(asyncId) {}
}

class MyAddedCallbacks extends MyAsyncCallbacks {
  before(asyncId) { }
  after(asyncId) { }
}

const asyncHook = async_hooks.createHook(new MyAddedCallbacks());
```

###### 异常处理[#](http://nodejs.cn/api-v12/async_hooks.html#error-handling)

[中英对照](http://nodejs.cn/api-v12/async_hooks/error_handling.html)

如果任何 `AsyncHook` 回调抛出，则应用程序将打印堆栈跟踪并退出。 退出路径确实遵循未捕获异常的路径，但所有 `'uncaughtException'` 监听器都被删除，从而强制进程退出。 除非应用程序使用 `--abort-on-uncaught-exception` 运行，否则仍将调用 `'exit'` 回调，在这种情况下，将打印堆栈跟踪并且应用程序退出，留下核心文件。

这种错误处理行为的原因是这些回调在对象生命周期中的潜在不稳定点运行，例如在类构造和销毁期间。 因此，认为有必要迅速关闭进程，以防止将来意外中止。 如果进行综合分析以确保异常可以遵循正常的控制流程而不会产生意外的副作用，这可能会在未来发生变化。

###### 在异步钩子回调中打印日志[#](http://nodejs.cn/api-v12/async_hooks.html#printing-in-asynchooks-callbacks)

[中英对照](http://nodejs.cn/api-v12/async_hooks/printing_in_asynchooks_callbacks.html)

当调试时，一个简单的解决方案是使用同步的日志记录操作，例如 `fs.writeFileSync(file, msg, flag)`。

```
const fs = require('fs');
const util = require('util');

function debug(...args) {
  // 
  fs.writeFileSync('log.out', `${util.format(...args)}\n`, { flag: 'a' });
}
```

#### `AsyncHook` 类[#](http://nodejs.cn/api-v12/async_hooks.html#class-asynchook)

[中英对照](http://nodejs.cn/api-v12/async_hooks/class_asynchook.html)

`AsyncHook` 类公开了一个用于跟踪异步操作的生命周期事件的接口。

##### `asyncHook.enable()`[#](http://nodejs.cn/api-v12/async_hooks.html#asynchookenable)

[中英对照](http://nodejs.cn/api-v12/async_hooks/asynchook_enable.html)

-   返回: [<AsyncHook>](http://nodejs.cn/api/async_hooks.html#async_hookscreatehookcallbacks) `asyncHook` 的引用。

启用给定 `AsyncHook` 实例的回调。

默认禁用 `AsyncHook` 实例。 如果 `AsyncHook` 实例应该在创建后立即启用，则可以使用以下模式。

```
const async_hooks = require('async_hooks');

const hook = async_hooks.createHook(callbacks).enable();
```

##### `asyncHook.disable()`[#](http://nodejs.cn/api-v12/async_hooks.html#asynchookdisable)

[中英对照](http://nodejs.cn/api-v12/async_hooks/asynchook_disable.html)

-   返回: [<AsyncHook>](http://nodejs.cn/api/async_hooks.html#async_hookscreatehookcallbacks) `asyncHook` 的引用。

从要执行的 `AsyncHook` 回调全局池中禁用给定 `AsyncHook` 实例的回调。 一旦一个钩子被禁用，则它在启用之前不会被再次调用。

为了 API 一致性，`disable()` 也返回 `AsyncHook` 实例。

##### 钩子回调[#](http://nodejs.cn/api-v12/async_hooks.html#hook-callbacks)

[中英对照](http://nodejs.cn/api-v12/async_hooks/hook_callbacks.html)

异步事件生命周期中的关键事件分为四个区域：实例化、回调调用前后、实例销毁时。

###### `init(asyncId, type, triggerAsyncId, resource)`[#](http://nodejs.cn/api-v12/async_hooks.html#initasyncid-type-triggerasyncid-resource)

[中英对照](http://nodejs.cn/api-v12/async_hooks/init_asyncid_type_triggerasyncid_resource.html)

-   `asyncId` [<number>](http://url.nodejs.cn/SXbo1v) 异步资源的唯一 ID。
-   `type` [<string>](http://url.nodejs.cn/9Tw2bK) 异步资源的类型。
-   `triggerAsyncId` [<number>](http://url.nodejs.cn/SXbo1v) 在其执行上下文中创建此异步资源的异步资源的唯一 ID。
-   `resource` [<Object>](http://url.nodejs.cn/jzn6Ao) 对代表异步操作的资源的引用，需要在销毁时释放。

当构造有可能触发异步事件的类时调用。 这并不意味着实例必须在调用 `destroy` 之前调用 `before`/`after`，只是存在这种可能性。

此行为可以通过打开资源然后在资源可以使用之前关闭它来观察。 以下代码片段演示了这一点。

```
require('net').createServer().listen(function() { this.close(); });
// 或者
clearTimeout(setTimeout(() => {}, 10));
```

每个新资源都分配了一个在当前 Node.js 实例范围内唯一的 ID。

###### `type`[#](http://nodejs.cn/api-v12/async_hooks.html#type)

[中英对照](http://nodejs.cn/api-v12/async_hooks/type.html)

`type` 是字符串，标识导致调用 `init` 的资源类型。 一般会对应资源的构造函数名。

```
FSEVENTWRAP, FSREQCALLBACK, GETADDRINFOREQWRAP, GETNAMEINFOREQWRAP, HTTPINCOMINGMESSAGE,
HTTPCLIENTREQUEST, JSSTREAM, PIPECONNECTWRAP, PIPEWRAP, PROCESSWRAP, QUERYWRAP,
SHUTDOWNWRAP, SIGNALWRAP, STATWATCHER, TCPCONNECTWRAP, TCPSERVERWRAP, TCPWRAP,
TTYWRAP, UDPSENDWRAP, UDPWRAP, WRITEWRAP, ZLIB, SSLCONNECTION, PBKDF2REQUEST,
RANDOMBYTESREQUEST, TLSWRAP, Microtask, Timeout, Immediate, TickObject
```

还有 `PROMISE` 资源类型，用于跟踪 `Promise` 实例以及它们调度的异步工作。

用户可以在使用公共嵌入器 API 时定义自己的 `type`。

可能存在类型名称冲突。 鼓励嵌入器使用唯一的前缀，例如 npm 包名，以防止在监听钩子时发生冲突。

###### `triggerAsyncId`[#](http://nodejs.cn/api-v12/async_hooks.html#triggerasyncid)

[中英对照](http://nodejs.cn/api-v12/async_hooks/triggerasyncid.html)

`triggerAsyncId` 是导致（或“触发”）新资源初始化并导致 `init` 调用的资源的 `asyncId`。

下面是 `triggerAsyncId` 的简单演示：

```
async_hooks.createHook({
  init(asyncId, type, triggerAsyncId) {
    const eid = async_hooks.executionAsyncId();
    fs.writeSync(
      process.stdout.fd,
      `${type}(${asyncId}): trigger: ${triggerAsyncId} execution: ${eid}\n`);
  }
}).enable();

require('net').createServer((conn) => {}).listen(8080);
```

当使用 `nc localhost 8080` 访问服务器时的输出：

```
TCPSERVERWRAP(5): trigger: 1 execution: 1
TCPWRAP(7): trigger: 5 execution: 0
```

`TCPSERVERWRAP` 是接收连接的服务器。

`TCPWRAP` 是来自客户端的新连接。 当建立新连接时，则立即构造 `TCPWrap` 实例。 这发生在任何 JavaScript 堆栈之外。 （`0` 的 `executionAsyncId()` 表示其是从 C++ 执行的，上面没有 JavaScript 堆栈。）只有这些信息，就不可能将资源链接在一起，因为它们是什么导致它们被创建，所以 `triggerAsyncId` 被赋予传播什么资源对新资源的存在负责的任务。

###### `resource`[#](http://nodejs.cn/api-v12/async_hooks.html#resource)

[中英对照](http://nodejs.cn/api-v12/async_hooks/resource.html)

`resource` 是一个对象，表示已初始化的实际异步资源。 这可能包含有用的信息，这些信息可能会根据 `type` 的值而有所不同。 例如，对于 `GETADDRINFOREQWRAP` 资源类型，`resource` 提供了在 `net.Server.listen()` 中查找主机 IP 地址时使用的主机名。 不支持访问此信息的 API，但使用 Embedder API，用户可以提供和记录自己的资源对象。 例如，这样的资源对象可能包含正在执行的 SQL 查询。

在某些情况下，出于性能原因，资源对象会被重用，因此将其用作 `WeakMap` 中的键或向其添加属性是不安全的。

###### 异步上下文的示例[#](http://nodejs.cn/api-v12/async_hooks.html#asynchronous-context-example)

[中英对照](http://nodejs.cn/api-v12/async_hooks/asynchronous_context_example.html)

以下是一个示例，其中包含有关 `before` 和 `after` 调用之间对 `init` 的调用的附加信息，特别是对 `listen()` 的回调将是什么样子。 输出格式稍微复杂一点，使调用上下文更容易看到。

```
let indent = 0;
async_hooks.createHook({
  init(asyncId, type, triggerAsyncId) {
    const eid = async_hooks.executionAsyncId();
    const indentStr = ' '.repeat(indent);
    fs.writeSync(
      process.stdout.fd,
      `${indentStr}${type}(${asyncId}):` +
      ` trigger: ${triggerAsyncId} execution: ${eid}\n`);
  },
  before(asyncId) {
    const indentStr = ' '.repeat(indent);
    fs.writeSync(process.stdout.fd, `${indentStr}before:  ${asyncId}\n`);
    indent += 2;
  },
  after(asyncId) {
    indent -= 2;
    const indentStr = ' '.repeat(indent);
    fs.writeSync(process.stdout.fd, `${indentStr}after:  ${asyncId}\n`);
  },
  destroy(asyncId) {
    const indentStr = ' '.repeat(indent);
    fs.writeSync(process.stdout.fd, `${indentStr}destroy:  ${asyncId}\n`);
  },
}).enable();

require('net').createServer(() => {}).listen(8080, () => {
  // 让我们在记录服务器启动之前等待 10 毫秒。
  setTimeout(() => {
    console.log('>>>', async_hooks.executionAsyncId());
  }, 10);
});
```

仅启动服务器的输出：

```
TCPSERVERWRAP(5): trigger: 1 execution: 1
TickObject(6): trigger: 5 execution: 1
before:  6
  Timeout(7): trigger: 6 execution: 6
after:   6
destroy: 6
before:  7
>>> 7
  TickObject(8): trigger: 7 execution: 7
after:   7
before:  8
after:   8
```

如示例所示，`executionAsyncId()` 和 `execution` 各自指定当前执行上下文的值；通过调用 `before` 和 `after` 来描述。

仅使用 `execution` 绘制资源分配图结果如下：

```
  root(1)
     ^
     |
TickObject(6)
     ^
     |
 Timeout(7)
```

`TCPSERVERWRAP` 不是这个图表的一部分，尽管它是调用 `console.log()` 的原因。

这就是为什么 `TickObject` 出现在输出中并且是 `.listen()` 回调的'父调用'。

可以用下图表示：

```
 bootstrap(1)
     |
     ˅
TCPSERVERWRAP(5)
     |
     ˅
 TickObject(6)
     |
     ˅
  Timeout(7)
```

###### `before(asyncId)`[#](http://nodejs.cn/api-v12/async_hooks.html#beforeasyncid)

[中英对照](http://nodejs.cn/api-v12/async_hooks/before_asyncid.html)

-   `asyncId` [<number>](http://url.nodejs.cn/SXbo1v)

当异步操作启动（如 TCP 服务器接收新连接）或完成（如将数据写入磁盘）时，会调用回调通知用户。 `before` 回调在所述回调执行之前被调用。 `asyncId` 是分配给即将执行回调的资源的唯一标识符。

`before` 回调将被调用 0 到 N 次。 如果异步操作被取消，或者例如，如果 TCP 服务器没有接收到连接，则 `before` 回调通常会被调用 0 次。 像 TCP 服务器这样的持久异步资源通常会多次调用 `before` 回调，而像 `fs.open()` 等其他操作只会调用一次。

###### `after(asyncId)`[#](http://nodejs.cn/api-v12/async_hooks.html#afterasyncid)

[中英对照](http://nodejs.cn/api-v12/async_hooks/after_asyncid.html)

-   `asyncId` [<number>](http://url.nodejs.cn/SXbo1v)

在 `before` 中指定的回调完成后立即调用。

###### `destroy(asyncId)`[#](http://nodejs.cn/api-v12/async_hooks.html#destroyasyncid)

[中英对照](http://nodejs.cn/api-v12/async_hooks/destroy_asyncid.html)

-   `asyncId` [<number>](http://url.nodejs.cn/SXbo1v)

`asyncId` 对应的资源销毁后调用。 它也从嵌入器 API `emitDestroy()` 异步调用。

有些资源依赖垃圾回收来清理，所以如果引用传给 `init` 的 `resource` 对象，可能永远不会调用 `destroy`，从而导致应用程序内存泄漏。 如果资源不依赖垃圾回收，则这不是问题。

###### `promiseResolve(asyncId)`[#](http://nodejs.cn/api-v12/async_hooks.html#promiseresolveasyncid)

[中英对照](http://nodejs.cn/api-v12/async_hooks/promiseresolve_asyncid.html)

新增于: v8.6.0

-   `asyncId` [<number>](http://url.nodejs.cn/SXbo1v)

当调用传给 `Promise` 构造函数的 `resolve` 函数时调用（直接或通过其他解决 promise 的方法）。

`resolve()` 不做任何可观察到的同步工作。

如果 `Promise` 是通过假设另一个 `Promise` 的状态来解决的，则此时 `Promise` 不一定满足或拒绝。

```
new Promise((resolve) => resolve(true)).then((a) => {});
```

调用以下回调：

```
init for PROMISE with id 5, trigger id: 1
  promise resolve 5      # 对应于 resolve(true)
init for PROMISE with id 6, trigger id: 5  # then() 返回的 Promise
  before 6               # 输入 then() 回调
  promise resolve 6      # then() 回调通过返回来解决 promise
  after 6
```

##### `async_hooks.executionAsyncResource()`[#](http://nodejs.cn/api-v12/async_hooks.html#async_hooksexecutionasyncresource)

[中英对照](http://nodejs.cn/api-v12/async_hooks/async_hooks_executionasyncresource.html)

新增于: v12.17.0

-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao) 代表当前执行的资源。 用于在资源中存储数据。

`executionAsyncResource()` 返回的资源对象通常是带有未记录 API 的内部 Node.js 句柄对象。 在对象上使用任何函数或属性都可能使您的应用程序崩溃，应该避免。

在顶层执行上下文中使用 `executionAsyncResource()` 将返回空的对象，因为没有要使用的句柄或请求对象，但是有一个代表顶层的对象可能会有所帮助。

```
const { open } = require('fs');
const { executionAsyncId, executionAsyncResource } = require('async_hooks');

console.log(executionAsyncId(), executionAsyncResource());  // 1 {}
open(__filename, 'r', (err, fd) => {
  console.log(executionAsyncId(), executionAsyncResource());  // 7 FSReqWrap
});
```

这可用于实现连续本地存储，无需使用跟踪 `Map` 来存储元数据：

```
const { createServer } = require('http');
const {
  executionAsyncId,
  executionAsyncResource,
  createHook
} = require('async_hooks');
const sym = Symbol('state'); // 避免污染的私有符号

createHook({
  init(asyncId, type, triggerAsyncId, resource) {
    const cr = executionAsyncResource();
    if (cr) {
      resource[sym] = cr[sym];
    }
  }
}).enable();

const server = createServer((req, res) => {
  executionAsyncResource()[sym] = { state: req.url };
  setTimeout(function() {
    res.end(JSON.stringify(executionAsyncResource()[sym]));
  }, 100);
}).listen(3000);
```

##### `async_hooks.executionAsyncId()`[#](http://nodejs.cn/api-v12/async_hooks.html#async_hooksexecutionasyncid)

[中英对照](http://nodejs.cn/api-v12/async_hooks/async_hooks_executionasyncid.html)

-   返回: [<number>](http://url.nodejs.cn/SXbo1v) 当前执行上下文的 `asyncId`。 当有调用时对跟踪很有用。

```
const async_hooks = require('async_hooks');

console.log(async_hooks.executionAsyncId());  // 1 - 引导
fs.open(path, 'r', (err, fd) => {
  console.log(async_hooks.executionAsyncId());  // 6 - open()
});
```

`executionAsyncId()` 返回的 ID 与执行时机有关，与因果无关（被 `triggerAsyncId()` 涵盖）：

```
const server = net.createServer((conn) => {
  // 返回服务器的 ID，而不是新连接的 ID，
  // 因为回调在服务器的 MakeCallback() 的执行范围内运行。
  async_hooks.executionAsyncId();

}).listen(port, () => {
  // 
  async_hooks.executionAsyncId();
});
```

默认情况下，promise 上下文可能无法获得精确的 `executionAsyncIds`。 请参阅 [promise 执行跟踪](http://nodejs.cn/api-v12/async_hooks.html#async_hooks_promise_execution_tracking)部分。

##### `async_hooks.triggerAsyncId()`[#](http://nodejs.cn/api-v12/async_hooks.html#async_hookstriggerasyncid)

[中英对照](http://nodejs.cn/api-v12/async_hooks/async_hooks_triggerasyncid.html)

-   返回: [<number>](http://url.nodejs.cn/SXbo1v) 负责调用当前正在执行的回调的资源 ID。

```
const server = net.createServer((conn) => {
  // 导致（或触发）此回调被调用的资源是新连接的资源。
  // 因此 triggerAsyncId() 的返回值是 "conn" 的 asyncId。
  async_hooks.triggerAsyncId();

}).listen(port, () => {
  // 即使传给 .listen() 的所有回调都包含在 nextTick() 中，
  // 但回调本身仍然存在，因为对服务器的 .listen() 进行了调用。
  // 所以返回值将是服务器的 ID。
  async_hooks.triggerAsyncId();
});
```

默认情况下，promise 上下文可能无法获得有效的 `triggerAsyncId`。 请参阅 [promise 执行跟踪](http://nodejs.cn/api-v12/async_hooks.html#async_hooks_promise_execution_tracking)部分。

### Promise 执行跟踪[#](http://nodejs.cn/api-v12/async_hooks.html#promise-execution-tracking)

[中英对照](http://nodejs.cn/api-v12/async_hooks/promise_execution_tracking.html)

默认情况下，由于 V8 提供的 [promise 自省 API](http://url.nodejs.cn/YyWiBo) 相对昂贵，因此不会为 promise 执行分配 `asyncId`。 这意味着默认情况下，使用 promise 或 `async`/`await` 的程序将无法正确执行并触发 promise 回调上下文的 id。

```
const ah = require('async_hooks');
Promise.resolve(1729).then(() => {
  console.log(`eid ${ah.executionAsyncId()} tid ${ah.triggerAsyncId()}`);
});
// 产生：
// eid 1 tid 0
```

注意 `then()` 回调声称已在外部范围的上下文中执行，即使涉及异步的跃点。 另外，`triggerAsyncId` 的值是 `0`，这意味着我们缺少有关导致（触发）`then()` 回调被执行的资源的上下文。

通过 `async_hooks.createHook` 安装异步钩子启用 promise 执行跟踪：

```
const ah = require('async_hooks');
ah.createHook({ init() {} }).enable(); // 强制启用 PromiseHooks。
Promise.resolve(1729).then(() => {
  console.log(`eid ${ah.executionAsyncId()} tid ${ah.triggerAsyncId()}`);
});
// 产生：
// eid 7 tid 6
```

在这个示例中，添加任何实际的钩子函数启用了对 promise 的跟踪。 上面的示例中有两个 promise；由 `Promise.resolve()` 创建的 promise 和调用 `then()` 返回的 promise。 在上面的示例中，第一个 promise 得到 `asyncId` `6`，后者得到 `asyncId` `7`。 在执行 `then()` 回调期间，我们在 `asyncId` `7` 的 promise 上下文中执行。 此 promise 由异步资源 `6` 触发。

promise 的另一个微妙之处是 `before` 和 `after` 回调仅在链式 promise 上运行。 这意味着不是由 `then()`/`catch()` 创建的 promise 不会触发 `before` 和 `after` 回调。 更多详细信息请参见 V8 [PromiseHooks](http://url.nodejs.cn/YyWiBo) API 的详细信息。

### JavaScript 嵌入的接口[#](http://nodejs.cn/api-v12/async_hooks.html#javascript-embedder-api)

[中英对照](http://nodejs.cn/api-v12/async_hooks/javascript_embedder_api.html)

处理自己的异步资源执行 I/O、连接池或管理回调队列等任务的库开发者可以使用 `AsyncResource` JavaScript API 以便调用所有适当的回调。

#### `AsyncResource` 类[#](http://nodejs.cn/api-v12/async_hooks.html#class-asyncresource)

The class `AsyncResource` is designed to be extended by the embedder's async resources. Using this, users can easily trigger the lifetime events of their own resources.

The `init` hook will trigger when an `AsyncResource` is instantiated.

The following is an overview of the `AsyncResource` API.

```
const { AsyncResource, executionAsyncId } = require('async_hooks');

// AsyncResource() is meant to be extended. Instantiating a
// new AsyncResource() also triggers init. If triggerAsyncId is omitted then
// async_hook.executionAsyncId() is used.
const asyncResource = new AsyncResource(
  type, { triggerAsyncId: executionAsyncId(), requireManualDestroy: false }
);

// Run a function in the execution context of the resource. This will
// * establish the context of the resource
// * trigger the AsyncHooks before callbacks
// * call the provided function `fn` with the supplied arguments
// * trigger the AsyncHooks after callbacks
// * restore the original execution context
asyncResource.runInAsyncScope(fn, thisArg, ...args);

// Call AsyncHooks destroy callbacks.
asyncResource.emitDestroy();

// Return the unique ID assigned to the AsyncResource instance.
asyncResource.asyncId();

// Return the trigger ID for the AsyncResource instance.
asyncResource.triggerAsyncId();
```

##### `new AsyncResource(type[, options])`[#](http://nodejs.cn/api-v12/async_hooks.html#new-asyncresourcetype-options)

[中英对照](http://nodejs.cn/api-v12/async_hooks/new_asyncresource_type_options.html)

-   `type` [<string>](http://url.nodejs.cn/9Tw2bK) 异步事件的类型。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `triggerAsyncId` [<number>](http://url.nodejs.cn/SXbo1v) 创建此异步事件的执行上下文的 ID。 **默认值:** `executionAsyncId()`。
    -   `requireManualDestroy` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果设置为 `true`，则当对象被垃圾回收时禁用 `emitDestroy`。 这通常不需要设置（即使手动调用 `emitDestroy`），除非检索到资源的 `asyncId` 并调用敏感 API 的 `emitDestroy`。 当设置为 `false` 时，则只有在至少有一个活动的 `destroy` 钩子时才会调用 `emitDestroy` 垃圾回收。 **默认值:** `false`。

用法示例：

```
class DBQuery extends AsyncResource {
  constructor(db) {
    super('DBQuery');
    this.db = db;
  }

  getInfo(query, callback) {
    this.db.get(query, (err, data) => {
      this.runInAsyncScope(callback, null, err, data);
    });
  }

  close() {
    this.db = null;
    this.emitDestroy();
  }
}
```

##### `AsyncResource.bind(fn[, type])`[#](http://nodejs.cn/api-v12/async_hooks.html#static-method-asyncresourcebindfn-type)

新增于: v12.19.0

-   `fn` [<Function>](http://url.nodejs.cn/ceTQa6) The function to bind to the current execution context.
-   `type` [<string>](http://url.nodejs.cn/9Tw2bK) An optional name to associate with the underlying `AsyncResource`.

Binds the given function to the current execution context.

The returned function will have an `asyncResource` property referencing the `AsyncResource` to which the function is bound.

##### `asyncResource.bind(fn)`[#](http://nodejs.cn/api-v12/async_hooks.html#asyncresourcebindfn)

新增于: v12.19.0

-   `fn` [<Function>](http://url.nodejs.cn/ceTQa6) The function to bind to the current `AsyncResource`.

Binds the given function to execute to this `AsyncResource`'s scope.

The returned function will have an `asyncResource` property referencing the `AsyncResource` to which the function is bound.

##### `asyncResource.runInAsyncScope(fn[, thisArg, ...args])`[#](http://nodejs.cn/api-v12/async_hooks.html#asyncresourceruninasyncscopefn-thisarg-args)

新增于: v9.6.0

-   `fn` [<Function>](http://url.nodejs.cn/ceTQa6) The function to call in the execution context of this async resource.
-   `thisArg` [<any>](http://url.nodejs.cn/6sTGdS) The receiver to be used for the function call.
-   `...args` [<any>](http://url.nodejs.cn/6sTGdS) Optional arguments to pass to the function.

Call the provided function with the provided arguments in the execution context of the async resource. This will establish the context, trigger the AsyncHooks before callbacks, call the function, trigger the AsyncHooks after callbacks, and then restore the original execution context.

##### `asyncResource.emitDestroy()`[#](http://nodejs.cn/api-v12/async_hooks.html#asyncresourceemitdestroy)

[中英对照](http://nodejs.cn/api-v12/async_hooks/asyncresource_emitdestroy.html)

-   返回: [<AsyncResource>](http://nodejs.cn/api/async_hooks.html#class-asyncresource) `asyncResource` 的引用。

调用所有的 `destroy` 钩子。 这应该只被调用一次。 如果多次调用，则会报错。 这个**必须**手动调用。 如果资源留给 GC 收集，则永远不会调用 `destroy` 钩子。

##### `asyncResource.asyncId()`[#](http://nodejs.cn/api-v12/async_hooks.html#asyncresourceasyncid)

[中英对照](http://nodejs.cn/api-v12/async_hooks/asyncresource_asyncid.html)

-   返回: [<number>](http://url.nodejs.cn/SXbo1v) 分配给资源的唯一 `asyncId`。

##### `asyncResource.triggerAsyncId()`[#](http://nodejs.cn/api-v12/async_hooks.html#asyncresourcetriggerasyncid)

[中英对照](http://nodejs.cn/api-v12/async_hooks/asyncresource_triggerasyncid.html)

-   返回: [<number>](http://url.nodejs.cn/SXbo1v) 传给 `AsyncResource` 构造函数的同一个 `triggerAsyncId`。

#### 对工作线程池使用 AsyncResource[#](http://nodejs.cn/api-v12/async_hooks.html#using-asyncresource-for-a-worker-thread-pool)

The following example shows how to use the `AsyncResource` class to properly provide async tracking for a [`Worker`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_class_worker) pool. Other resource pools, such as database connection pools, can follow a similar model.

Assuming that the task is adding two numbers, using a file named `task_processor.js` with the following content:

```
const { parentPort } = require('worker_threads');
parentPort.on('message', (task) => {
  parentPort.postMessage(task.a + task.b);
});
```

a Worker pool around it could use the following structure:

```
const { AsyncResource } = require('async_hooks');
const { EventEmitter } = require('events');
const path = require('path');
const { Worker } = require('worker_threads');

const kTaskInfo = Symbol('kTaskInfo');
const kWorkerFreedEvent = Symbol('kWorkerFreedEvent');

class WorkerPoolTaskInfo extends AsyncResource {
  constructor(callback) {
    super('WorkerPoolTaskInfo');
    this.callback = callback;
  }

  done(err, result) {
    this.runInAsyncScope(this.callback, null, err, result);
    this.emitDestroy();  // `TaskInfo`s are used only once.
  }
}

class WorkerPool extends EventEmitter {
  constructor(numThreads) {
    super();
    this.numThreads = numThreads;
    this.workers = [];
    this.freeWorkers = [];

    for (let i = 0; i < numThreads; i++)
      this.addNewWorker();
  }

  addNewWorker() {
    const worker = new Worker(path.resolve(__dirname, 'task_processor.js'));
    worker.on('message', (result) => {
      // In case of success: Call the callback that was passed to `runTask`,
      // remove the `TaskInfo` associated with the Worker, and mark it as free
      // again.
      worker[kTaskInfo].done(null, result);
      worker[kTaskInfo] = null;
      this.freeWorkers.push(worker);
      this.emit(kWorkerFreedEvent);
    });
    worker.on('error', (err) => {
      // In case of an uncaught exception: Call the callback that was passed to
      // `runTask` with the error.
      if (worker[kTaskInfo])
        worker[kTaskInfo].done(err, null);
      else
        this.emit('error', err);
      // Remove the worker from the list and start a new Worker to replace the
      // current one.
      this.workers.splice(this.workers.indexOf(worker), 1);
      this.addNewWorker();
    });
    this.workers.push(worker);
    this.freeWorkers.push(worker);
    this.emit(kWorkerFreedEvent);
  }

  runTask(task, callback) {
    if (this.freeWorkers.length === 0) {
      // No free threads, wait until a worker thread becomes free.
      this.once(kWorkerFreedEvent, () => this.runTask(task, callback));
      return;
    }

    const worker = this.freeWorkers.pop();
    worker[kTaskInfo] = new WorkerPoolTaskInfo(callback);
    worker.postMessage(task);
  }

  close() {
    for (const worker of this.workers) worker.terminate();
  }
}

module.exports = WorkerPool;
```

Without the explicit tracking added by the `WorkerPoolTaskInfo` objects, it would appear that the callbacks are associated with the individual `Worker` objects. However, the creation of the `Worker`s is not associated with the creation of the tasks and does not provide information about when tasks were scheduled.

This pool could be used as follows:

```
const WorkerPool = require('./worker_pool.js');
const os = require('os');

const pool = new WorkerPool(os.cpus().length);

let finished = 0;
for (let i = 0; i < 10; i++) {
  pool.runTask({ a: 42, b: 100 }, (err, result) => {
    console.log(i, err, result);
    if (++finished === 10)
      pool.close();
  });
}
```

#### 将 EventEmitter 集成到 AsyncResource[#](http://nodejs.cn/api-v12/async_hooks.html#integrating-asyncresource-with-eventemitter)

Event listeners triggered by an [`EventEmitter`](http://nodejs.cn/api-v12/events.html#events_class_eventemitter) may be run in a different execution context than the one that was active when `eventEmitter.on()` was called.

The following example shows how to use the `AsyncResource` class to properly associate an event listener with the correct execution context. The same approach can be applied to a [`Stream`](http://nodejs.cn/api-v12/stream.html#stream_stream) or a similar event-driven class.

```
const { createServer } = require('http');
const { AsyncResource, executionAsyncId } = require('async_hooks');

const server = createServer((req, res) => {
  req.on('close', AsyncResource.bind(() => {
    // Execution context is bound to the current outer scope.
  }));
  req.on('close', () => {
    // Execution context is bound to the scope that caused 'close' to emit.
  });
  res.end();
}).listen(3000);
```

### `AsyncLocalStorage` 类[#](http://nodejs.cn/api-v12/async_hooks.html#class-asynclocalstorage)

新增于: v12.17.0

This class is used to create asynchronous state within callbacks and promise chains. It allows storing data throughout the lifetime of a web request or any other asynchronous duration. It is similar to thread-local storage in other languages.

The following example uses `AsyncLocalStorage` to build a simple logger that assigns IDs to incoming HTTP requests and includes them in messages logged within each request.

```
const http = require('http');
const { AsyncLocalStorage } = require('async_hooks');

const asyncLocalStorage = new AsyncLocalStorage();

function logWithId(msg) {
  const id = asyncLocalStorage.getStore();
  console.log(`${id !== undefined ? id : '-'}:`, msg);
}

let idSeq = 0;
http.createServer((req, res) => {
  asyncLocalStorage.run(idSeq++, () => {
    logWithId('start');
    // Imagine any chain of async operations here
    setImmediate(() => {
      logWithId('finish');
      res.end();
    });
  });
}).listen(8080);

http.get('http://localhost:8080');
http.get('http://localhost:8080');
// Prints:
//   0: start
//   1: start
//   0: finish
//   1: finish
```

When having multiple instances of `AsyncLocalStorage`, they are independent from each other. It is safe to instantiate this class multiple times.

#### `new AsyncLocalStorage()`[#](http://nodejs.cn/api-v12/async_hooks.html#new-asynclocalstorage)

新增于: v12.17.0

Creates a new instance of `AsyncLocalStorage`. Store is only provided within a `run` method call.

#### `asyncLocalStorage.disable()`[#](http://nodejs.cn/api-v12/async_hooks.html#asynclocalstoragedisable)

新增于: v12.17.0

This method disables the instance of `AsyncLocalStorage`. All subsequent calls to `asyncLocalStorage.getStore()` will return `undefined` until `asyncLocalStorage.run()` is called again.

When calling `asyncLocalStorage.disable()`, all current contexts linked to the instance will be exited.

Calling `asyncLocalStorage.disable()` is required before the `asyncLocalStorage` can be garbage collected. This does not apply to stores provided by the `asyncLocalStorage`, as those objects are garbage collected along with the corresponding async resources.

This method is to be used when the `asyncLocalStorage` is not in use anymore in the current process.

#### `asyncLocalStorage.getStore()`[#](http://nodejs.cn/api-v12/async_hooks.html#asynclocalstoragegetstore)

新增于: v12.17.0

-   返回: [<any>](http://url.nodejs.cn/6sTGdS)

This method returns the current store. If this method is called outside of an asynchronous context initialized by calling `asyncLocalStorage.run`, it will return `undefined`.

#### `asyncLocalStorage.enterWith(store)`[#](http://nodejs.cn/api-v12/async_hooks.html#asynclocalstorageenterwithstore)

[中英对照](http://nodejs.cn/api-v12/async_hooks/asynclocalstorage_enterwith_store.html)

新增于: v12.17.0

-   `store` [<any>](http://url.nodejs.cn/6sTGdS)

示例：

```
const store = { id: 1 };
asyncLocalStorage.enterWith(store);
asyncLocalStorage.getStore(); // 
someAsyncOperation(() => {
  asyncLocalStorage.getStore(); // 
});
```

```
const store = { id: 1 };

emitter.on('my-event', () => {
  asyncLocalStorage.enterWith(store);
});
emitter.on('my-event', () => {
  asyncLocalStorage.getStore(); // 
});

asyncLocalStorage.getStore(); // 
emitter.emit('my-event');
asyncLocalStorage.getStore(); // 
```

#### `asyncLocalStorage.run(store, callback[, ...args])`[#](http://nodejs.cn/api-v12/async_hooks.html#asynclocalstoragerunstore-callback-args)

[中英对照](http://nodejs.cn/api-v12/async_hooks/asynclocalstorage_run_store_callback_args.html)

新增于: v12.17.0

-   `store` [<any>](http://url.nodejs.cn/6sTGdS)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   `...args` [<any>](http://url.nodejs.cn/6sTGdS)

可选地，参数可以传给函数。

示例：

```
const store = { id: 2 };
try {
  asyncLocalStorage.run(store, () => {
    asyncLocalStorage.getStore(); // 
    throw new Error();
  });
} catch (e) {
  asyncLocalStorage.getStore(); // 
  // 
}
```

#### `asyncLocalStorage.exit(callback[, ...args])`[#](http://nodejs.cn/api-v12/async_hooks.html#asynclocalstorageexitcallback-args)

[中英对照](http://nodejs.cn/api-v12/async_hooks/asynclocalstorage_exit_callback_args.html)

新增于: v12.17.0

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   `...args` [<any>](http://url.nodejs.cn/6sTGdS)

可选地，参数可以传给函数。

示例：

```
// 
try {
  asyncLocalStorage.getStore(); // 
  asyncLocalStorage.exit(() => {
    asyncLocalStorage.getStore(); // 
    throw new Error();
  });
} catch (e) {
  asyncLocalStorage.getStore(); // 
  // 
}
```

#### async/await 的用法[#](http://nodejs.cn/api-v12/async_hooks.html#usage-with-asyncawait)

If, within an async function, only one `await` call is to run within a context, the following pattern should be used:

```
async function fn() {
  await asyncLocalStorage.run(new Map(), () => {
    asyncLocalStorage.getStore().set('key', value);
    return foo(); // The return value of foo will be awaited
  });
}
```

In this example, the store is only available in the callback function and the functions called by `foo`. Outside of `run`, calling `getStore` will return `undefined`.

#### 故障排除[#](http://nodejs.cn/api-v12/async_hooks.html#troubleshooting)

In most cases your application or library code should have no issues with `AsyncLocalStorage`. But in rare cases you may face situations when the current store is lost in one of asynchronous operations. In those cases, consider the following options.

If your code is callback-based, it is enough to promisify it with [`util.promisify()`](http://nodejs.cn/api-v12/util.html#util_util_promisify_original), so it starts working with native promises.

If you need to keep using callback-based API, or your code assumes a custom thenable implementation, use the [`AsyncResource`](http://nodejs.cn/api-v12/async_hooks.html#async_hooks_class_asyncresource) class to associate the asynchronous operation with the correct execution context.
