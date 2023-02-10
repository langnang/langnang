---
created: 2022-07-29T13:12:53 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/domain.html
author: 
---

# domain 域 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/domain/domain.html)

**源代码:** [lib/domain.js](https://github.com/nodejs/node/blob/v12.22.12/lib/domain.js)

**此模块正在等待弃用**。 一旦替代 API 完成，则该模块将被完全弃用。 大多数开发者应该**没有**理由使用此模块。 绝对必须拥有域提供的功能的用户可能暂时依赖它，但预计将来必须迁移到不同的解决方案。

域提供了一种将多个不同的 IO 操作作为一组来处理的方法。 如果任何注册到域的事件触发器或回调触发 `'error'` 事件，或抛出错误，则将通知域对象，而不是丢失 `process.on('uncaughtException')` 句柄中的错误上下文，或导致程序立即使用错误码退出。

### 注意：不要无视错误[#](http://nodejs.cn/api-v12/domain.html#warning-dont-ignore-errors)

[中英对照](http://nodejs.cn/api-v12/domain/warning_don_t_ignore_errors.html)

发生错误时，域错误句柄不能替代关闭进程。

由于 [`throw`](http://url.nodejs.cn/qrRqBn) 在 JavaScript 中的工作方式，几乎没有任何方法可以安全地“从中断的地方重新开始”，而不会泄漏引用或创建其他类型的未定义脆弱状态。

响应抛出的错误最安全的方法是关闭进程。 但是，在正常的 web 服务器中，可能有很多打开的连接，因为别人触发了错误而突然关闭这些连接是不合理的。

更好的方法是向触发错误的请求发送错误响应，同时让其他人在正常时间完成，并停止在该工作进程中监听新的请求。

通过这种方式，`domain` 的使用与集群模块齐头并进，因为当工作进程遇到错误时，主进程可以衍生新的工作进程。 对于扩展到多台机器的 Node.js 程序，终止的代理或服务仓库可以记录故障，并做出相应的反应。

例如，这不是一个好主意：

```
// XXX 警告！坏主意！

const d = require('domain').create();
d.on('error', (er) => {
  // 该错误不会使进程崩溃，但它所做的更糟！
  // 
  // 这并不比 process.on('uncaughtException') 好！
  console.log(`error, but oh well ${er.message}`);
});
d.run(() => {
  require('http').createServer((req, res) => {
    handleRequest(req, res);
  }).listen(PORT);
});
```

通过使用域的上下文，以及将我们的程序分成多个工作进程的弹性，我们可以做出更适当的反应，并以更高的安全性处理错误。

```
// 好多了！

const cluster = require('cluster');
const PORT = +process.env.PORT || 1337;

if (cluster.isMaster) {
  // 更现实的情况是有 2 个以上的工作进程，
  // 并且可能不会将主进程和工作进程放在同一个文件中。
  //
  // 还可以对日志记录更感兴趣，
  // 并实现任何需要的自定义逻辑，
  // 来防止 DoS 攻击和其他不良行为。
  //
  // 请参阅集群文档中的选项。
  //
  // 重要的是主进程做的很少，
  // 增加了我们对意外错误的适应能力。

  cluster.fork();
  cluster.fork();

  cluster.on('disconnect', (worker) => {
    console.error('disconnect!');
    cluster.fork();
  });

} else {
  // 工作进程
  //
  // 这是我们放置缺陷的地方！

  const domain = require('domain');

  // 有关使用工作进程处理请求的更多详细信息，请参阅集群文档。
  // 它的工作原理、注意事项等。

  const server = require('http').createServer((req, res) => {
    const d = domain.create();
    d.on('error', (er) => {
      console.error(`error ${er.stack}`);

      // 我们处于危险境地！
      // 根据定义，发生了一些意想不到的事情，
      // 这可能是我们不想要的。
      // 现在什么都可能发生！小心点！

      try {
        // 确保我们在 30 秒内关闭
        const killtimer = setTimeout(() => {
          process.exit(1);
        }, 30000);
        // 但不要仅仅为此而保持进程开放！
        killtimer.unref();

        // 停止接受新的请求。
        server.close();

        // 让主进程知道我们已经死了。
        // 这将触发集群主进程的‘断开连接’，
        // 然后它会衍生新的工作进程。
        cluster.worker.disconnect();

        // 尝试向触发问题的请求发送错误
        res.statusCode = 500;
        res.setHeader('content-type', 'text/plain');
        res.end('Oops, there was a problem!\n');
      } catch (er2) {
        // 哦，好吧，目前我们无能为力。
        console.error(`Error sending 500! ${er2.stack}`);
      }
    });

    // 因为 req 和 res 是在此域存在之前创建的，
    // 所以我们需要显式地添加它们。
    // 请参阅下面对隐式与显式绑定的解释。
    d.add(req);
    d.add(res);

    // 现在在域中运行处理函数。
    d.run(() => {
      handleRequest(req, res);
    });
  });
  server.listen(PORT);
}

// 这部分并不重要。只是一个示例路由。
// 把花哨的应用程序逻辑放在这里。
function handleRequest(req, res) {
  switch (req.url) {
    case '/error':
      // 我们做一些异步的事情，然后...
      setTimeout(() => {
        // 哎呀！
        flerb.bark();
      }, timeout);
      break;
    default:
      res.end('ok');
  }
}
```

### 错误对象的补充[#](http://nodejs.cn/api-v12/domain.html#additions-to-error-objects)

[中英对照](http://nodejs.cn/api-v12/domain/additions_to_error_objects.html)

每当 `Error` 对象通过域路由时，都会向其中添加一些额外的字段。

-   `error.domain` 最先处理错误的域。
-   `error.domainEmitter` 触发带有错误对象的 `'error'` 事件的事件触发器。
-   `error.domainBound` 绑定到域的回调函数，并且传入一个错误作为其第一个参数。
-   `error.domainThrown` 布尔值，指示错误是被抛出、触发、还是传给绑定的回调函数。

### 隐式的绑定[#](http://nodejs.cn/api-v12/domain.html#implicit-binding)

[中英对照](http://nodejs.cn/api-v12/domain/implicit_binding.html)

如果域正在使用中，则所有**新的** `EventEmitter` 对象（包括流对象、请求、响应等）将在创建时隐式地绑定到活动域。

此外，传给低层事件循环请求的回调（例如 `fs.open()`、或其他回调接受的方法）将自动绑定到活动域。 如果它们抛出，则域将捕获错误。

为了防止过多的内存使用，`Domain` 对象本身没有被隐式地添加为活动域的子域。 如果是这样，则阻止请求和响应对象被正确地垃圾收集就太容易了。

要将 `Domain` 对象嵌套为父 `Domain` 的子对象，则必须显式地添加它们。

隐式的绑定路由向 `Domain` 的 `'error'` 事件抛出错误和 `'error'` 事件，但没有在 `Domain` 上注册 `EventEmitter`。 隐式的绑定只处理抛出的错误和 `'error'` 事件。

### 显式的绑定[#](http://nodejs.cn/api-v12/domain.html#explicit-binding)

[中英对照](http://nodejs.cn/api-v12/domain/explicit_binding.html)

有时，使用的域不是应该用于特定事件触发器的域。 或者，事件触发器可以在域的上下文中创建，但可以绑定到其他域。

例如，可能有一个域用于 HTTP 服务器，但也许我们希望为每个请求使用单独的域。

这可以通过显式绑定来实现。

```
// 为服务器创建顶层的域
const domain = require('domain');
const http = require('http');
const serverDomain = domain.create();

serverDomain.run(() => {
  // 服务器是在 serverDomain 的作用域中创建
  http.createServer((req, res) => {
    // req 和 res 也在 serverDomain 的作用域中创建，
    // 但是，我们希望每个请求都有单独的域。
    // 首先创建它，然后添加 req 和 res。
    const reqd = domain.create();
    reqd.add(req);
    reqd.add(res);
    reqd.on('error', (er) => {
      console.error('Error', er, req.url);
      try {
        res.writeHead(500);
        res.end('Error occurred, sorry.');
      } catch (er2) {
        console.error('Error sending 500', er2, req.url);
      }
    });
  }).listen(1337);
});
```

### `domain.create()`[#](http://nodejs.cn/api-v12/domain.html#domaincreate)

-   返回: [<Domain>](http://nodejs.cn/api/domain.html#class-domain)

### `Domain` 类[#](http://nodejs.cn/api-v12/domain.html#class-domain)

[中英对照](http://nodejs.cn/api-v12/domain/class_domain.html)

-   继承自: [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter)

`Domain` 类封装了路由错误和未捕获异常到活动 `Domain` 对象的功能。

要处理其捕获的错误，则监听其 `'error'` 事件。

#### `domain.members`[#](http://nodejs.cn/api-v12/domain.html#domainmembers)

[中英对照](http://nodejs.cn/api-v12/domain/domain_members.html)

-   [<Array>](http://url.nodejs.cn/ZJSz23)

已显式地添加到域的定时器和事件触发器数组。

#### `domain.add(emitter)`[#](http://nodejs.cn/api-v12/domain.html#domainaddemitter)

[中英对照](http://nodejs.cn/api-v12/domain/domain_add_emitter.html)

-   `emitter` [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter) | [<Timer>](http://nodejs.cn/api/timers.html#timers) 要添加到域中的触发器或定时器

显式地添加触发器到域中。 如果触发器调用的任何事件句柄抛出错误，或者触发器触发 `'error'` 事件，则它将被路由到域的 `'error'` 事件，就像隐式绑定一样。

这也适用于从 [`setInterval()`](http://nodejs.cn/api-v12/timers.html#timers_setinterval_callback_delay_args) 和 [`setTimeout()`](http://nodejs.cn/api-v12/timers.html#timers_settimeout_callback_delay_args) 返回的定时器。 如果其回调函数抛出异常，则其将被域 `'error'` 句柄捕获。

如果定时器或 `EventEmitter` 已绑定到某个域，则将其从该域中删除，并改为绑定到该域。

#### `domain.bind(callback)`[#](http://nodejs.cn/api-v12/domain.html#domainbindcallback)

[中英对照](http://nodejs.cn/api-v12/domain/domain_bind_callback.html)

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 回调函数
-   返回: [<Function>](http://url.nodejs.cn/ceTQa6) 绑定的函数

返回的函数将是提供的回调函数的封装器。 当调用返回的函数时，抛出的任何错误都会被路由到域的 `'error'` 事件。

```
const d = domain.create();

function readSomeFile(filename, cb) {
  fs.readFile(filename, 'utf8', d.bind((er, data) => {
    // 如果这个抛出，则它也会被传给域。
    return cb(er, data ? JSON.parse(data) : null);
  }));
}

d.on('error', (er) => {
  // 某处发生了错误。如果我们现在抛出，
  // 则其会以正常的行号和堆栈消息使程序崩溃。
});
```

#### `domain.enter()`[#](http://nodejs.cn/api-v12/domain.html#domainenter)

[中英对照](http://nodejs.cn/api-v12/domain/domain_enter.html)

`enter()` 方法是 `run()`、`bind()` 和 `intercept()` 方法用来设置活动域的管道。 它将 `domain.active` 和 `process.domain` 设置为域，并将域隐式推送到域模块管理的域堆栈上（有关域堆栈的详细信息，请参见 [`domain.exit()`](http://nodejs.cn/api-v12/domain.html#domain_domain_exit)）。 对 `enter()` 的调用界定了一系列异步调用和绑定到域的 I/O 操作的开始。

调用 `enter()` 只改变活动域，不改变域本身。 `enter()` 和 `exit()` 可以在单个域上调用任意次数。

#### `domain.exit()`[#](http://nodejs.cn/api-v12/domain.html#domainexit)

[中英对照](http://nodejs.cn/api-v12/domain/domain_exit.html)

`exit()` 方法退出当前域，将其从域堆栈中弹出。 任何时候执行将切换到不同异步调用链的上下文，确保退出当前域很重要。 对 `exit()` 的调用界定了异步调用链和绑定到域的 I/O 操作链的结束或中断。

如果有多个嵌套域绑定到当前执行上下文，则 `exit()` 将退出任何嵌套在该域中的域。

调用 `exit()` 只改变活动域，不改变域本身。 `enter()` 和 `exit()` 可以在单个域上调用任意次数。

#### `domain.intercept(callback)`[#](http://nodejs.cn/api-v12/domain.html#domaininterceptcallback)

[中英对照](http://nodejs.cn/api-v12/domain/domain_intercept_callback.html)

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 回调函数
-   返回: [<Function>](http://url.nodejs.cn/ceTQa6) 截获的函数

此方法和 [`domain.bind(callback)`](http://nodejs.cn/api-v12/domain.html#domain_domain_bind_callback) 差不多。 但是，除了捕获抛出的错误外，它还会拦截作为第一个参数发送给函数的 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 对象。

这样，常见的 `if (err) return callback(err);` 模式可以在一个地方用单个错误句柄替换。

```
const d = domain.create();

function readSomeFile(filename, cb) {
  fs.readFile(filename, 'utf8', d.intercept((data) => {
    // 注意，第一个参数永远不会传给回调，
    // 因为它被假定为 'Error' 参数，
    // 因此被域拦截。

    // 如果这抛出，
    // 则它也将被传到域，
    // 因此错误处理逻辑可以移动到域上的 'error' 事件，
    // 而不是在整个程序中重复。
    return cb(null, JSON.parse(data));
  }));
}

d.on('error', (er) => {
  // 某处发生了错误。如果我们现在抛出，
  // 则其会以正常的行号和堆栈消息使程序崩溃。
});
```

#### `domain.remove(emitter)`[#](http://nodejs.cn/api-v12/domain.html#domainremoveemitter)

[中英对照](http://nodejs.cn/api-v12/domain/domain_remove_emitter.html)

-   `emitter` [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter) | [<Timer>](http://nodejs.cn/api/timers.html#timers) 要从域中删除的触发器或定时器

[`domain.add(emitter)`](http://nodejs.cn/api-v12/domain.html#domain_domain_add_emitter) 的反义词。 从指定的触发器中删除域处理。

#### `domain.run(fn[, ...args])`[#](http://nodejs.cn/api-v12/domain.html#domainrunfn-args)

[中英对照](http://nodejs.cn/api-v12/domain/domain_run_fn_args.html)

-   `fn` [<Function>](http://url.nodejs.cn/ceTQa6)
-   `...args` [<any>](http://url.nodejs.cn/6sTGdS)

在域的上下文中运行提供的函数，隐式地绑定在该上下文中创建的所有事件触发器、定时器和低层请求。 可选地，参数可以传给函数。

这是使用域的最基本方式。

```
const domain = require('domain');
const fs = require('fs');
const d = domain.create();
d.on('error', (er) => {
  console.error('Caught error!', er);
});
d.run(() => {
  process.nextTick(() => {
    setTimeout(() => { // 模拟各种异步的东西
      fs.open('non-existent file', 'r', (er, fd) => {
        if (er) throw er;
        // 继续...
      });
    }, 100);
  });
});
```

在本例中，将触发 `d.on('error')` 句柄，而不是使程序崩溃。

### domain 与 Promise[#](http://nodejs.cn/api-v12/domain.html#domains-and-promises)

[中英对照](http://nodejs.cn/api-v12/domain/domains_and_promises.html)

从 Node.js 8.0.0 开始，promise 的句柄在调用 `.then()` 或 `.catch()` 本身的域内运行：

```
const d1 = domain.create();
const d2 = domain.create();

let p;
d1.run(() => {
  p = Promise.resolve(42);
});

d2.run(() => {
  p.then((v) => {
    // 在 d2 中运行
  });
});
```

可以使用 [`domain.bind(callback)`](http://nodejs.cn/api-v12/domain.html#domain_domain_bind_callback) 将回调绑定到特定域：

```
const d1 = domain.create();
const d2 = domain.create();

let p;
d1.run(() => {
  p = Promise.resolve(42);
});

d2.run(() => {
  p.then(p.domain.bind((v) => {
    // 在 d1 中运行
  }));
});
```

域不会干扰 promise 的错误处理机制。 换句话说，对于未处理的 `Promise` 拒绝，不会触发 `'error'` 事件。
