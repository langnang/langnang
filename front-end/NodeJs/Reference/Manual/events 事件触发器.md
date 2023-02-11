---
created: 2022-07-29T13:12:54 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/events.html
author: 
---

# events 事件触发器 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/events/events.html)

**源代码:** [lib/events.js](https://github.com/nodejs/node/blob/v12.22.12/lib/events.js)

Node.js 的大部分核心 API 都是围绕惯用的异步事件驱动架构构建的，在该架构中，某些类型的对象（称为"触发器"）触发命名事件，使 `Function` 对象（"监听器"）被调用。

例如：[`net.Server`](http://nodejs.cn/api-v12/net.html#net_class_net_server) 对象在每次有连接时触发事件；[`fs.ReadStream`](http://nodejs.cn/api-v12/fs.html#fs_class_fs_readstream) 在打开文件时触发事件；[流](http://nodejs.cn/api-v12/stream.html)在每当有数据可供读取时触发事件。

所有触发事件的对象都是 `EventEmitter` 类的实例。 这些对象暴露了 `eventEmitter.on()` 函数，允许将一个或多个函数绑定到对象触发的命名事件。 通常，事件名称是驼峰式字符串，但也可以使用任何有效的 JavaScript 属性键。

当 `EventEmitter` 对象触发事件时，所有绑定到该特定事件的函数都会被同步地调用。

以下示例展示了使用单个监听器的简单的 `EventEmitter` 实例。 `eventEmitter.on()` 方法用于注册监听器，`eventEmitter.emit()` 方法用于触发事件。

```
const EventEmitter = require('events');

class MyEmitter extends EventEmitter {}

const myEmitter = new MyEmitter();
myEmitter.on('event', () => {
  console.log('an event occurred!');
});
myEmitter.emit('event');
```

### 将参数和 this 传给监听器[#](http://nodejs.cn/api-v12/events.html#passing-arguments-and-this-to-listeners)

[中英对照](http://nodejs.cn/api-v12/events/passing_arguments_and_this_to_listeners.html)

`eventEmitter.emit()` 方法允许将任意一组参数传给监听器函数。 记住，当调用普通的监听器函数时，标准的 `this` 关键字会被有意地设置为引用监听器绑定到的 `EventEmitter` 实例。

```
const myEmitter = new MyEmitter();
myEmitter.on('event', function(a, b) {
  console.log(a, b, this, this === myEmitter);
  // 打印:
  //   a b MyEmitter {
  //     domain: null,
  //     _events: { event: [Function] },
  //     _eventsCount: 1,
  //     _maxListeners: undefined } true
});
myEmitter.emit('event', 'a', 'b');
```

可以使用 ES6 箭头函数作为监听器，但是，这样做时，`this` 关键字将不再引用 `EventEmitter` 实例：

```
const myEmitter = new MyEmitter();
myEmitter.on('event', (a, b) => {
  console.log(a, b, this);
  // 打印: a b {}
});
myEmitter.emit('event', 'a', 'b');
```

### 异步 VS 同步[#](http://nodejs.cn/api-v12/events.html#asynchronous-vs-synchronous)

[中英对照](http://nodejs.cn/api-v12/events/asynchronous_vs_synchronous.html)

`EventEmitter` 按照注册的顺序同步地调用所有监听器。 这确保了事件的正确排序，并有助于避免竞争条件和逻辑错误。 在适当的时候，监听器函数可以使用 `setImmediate()` 或 `process.nextTick()` 方法切换到异步的操作模式：

```
const myEmitter = new MyEmitter();
myEmitter.on('event', (a, b) => {
  setImmediate(() => {
    console.log('this happens asynchronously');
  });
});
myEmitter.emit('event', 'a', 'b');
```

### 仅处理事件一次[#](http://nodejs.cn/api-v12/events.html#handling-events-only-once)

[中英对照](http://nodejs.cn/api-v12/events/handling_events_only_once.html)

```
const myEmitter = new MyEmitter();
let m = 0;
myEmitter.on('event', () => {
  console.log(++m);
});
myEmitter.emit('event');
// 打印: 1
myEmitter.emit('event');
// 打印: 2
```

使用 `eventEmitter.once()` 方法，可以注册一个监听器，该监听器最多为特定事件调用一次。 一旦事件被触发，则监听器就会被注销然后被调用。

```
const myEmitter = new MyEmitter();
let m = 0;
myEmitter.once('event', () => {
  console.log(++m);
});
myEmitter.emit('event');
// 打印: 1
myEmitter.emit('event');
// 忽略
```

### 错误事件[#](http://nodejs.cn/api-v12/events.html#error-events)

[中英对照](http://nodejs.cn/api-v12/events/error_events.html)

当 `EventEmitter` 实例中发生错误时，典型的操作是触发 `'error'` 事件。 这些在 Node.js 中被视为特殊情况。

如果 `EventEmitter` 没有为 `'error'` 事件注册至少一个监听器，并且触发 `'error'` 事件，则会抛出错误，打印堆栈跟踪，然后退出 Node.js 进程。

```
const myEmitter = new MyEmitter();
myEmitter.emit('error', new Error('whoops!'));
// 抛出错误并使 Node.js 崩溃
```

为了防止 Node.js 进程崩溃，可以使用 [`domain`](http://nodejs.cn/api-v12/domain.html) 模块。 （但请注意，不推荐使用 `domain` 模块。）

作为最佳实践，应始终为 `'error'` 事件添加监听器。

```
const myEmitter = new MyEmitter();
myEmitter.on('error', (err) => {
  console.error('whoops! there was an error');
});
myEmitter.emit('error', new Error('whoops!'));
// 打印: whoops! there was an error
```

通过使用符号 `errorMonitor` 安装监听器，可以在不消费触发的错误的情况下监视 `'error'` 事件。

```
const myEmitter = new MyEmitter();
myEmitter.on(EventEmitter.errorMonitor, (err) => {
  MyMonitoringTool.log(err);
});
myEmitter.emit('error', new Error('whoops!'));
// 仍然抛出错误并使 Node.js 崩溃
```

### 捕捉 Promise 拒绝[#](http://nodejs.cn/api-v12/events.html#capture-rejections-of-promises)

[中英对照](http://nodejs.cn/api-v12/events/capture_rejections_of_promises.html)

[稳定性: 1](http://nodejs.cn/api/documentation.html#stability-index) - captureRejections 是实验的。

将 `async` 函数与事件句柄一起使用是有问题的，因为它会在抛出异常的情况下导致未处理的拒绝：

```
const ee = new EventEmitter();
ee.on('something', async (value) => {
  throw new Error('kaboom');
});
```

`EventEmitter` 构造函数中的 `captureRejections` 选项或全局的设置可以改变这种行为，在 `Promise` 上安装 `.then(undefined, handler)` 句柄。 此句柄将异常异步地路由到 [`Symbol.for('nodejs.rejection')`](http://nodejs.cn/api-v12/events.html#events_emitter_symbol_for_nodejs_rejection_err_eventname_args) 方法（如果有）或 [`'error'`](http://nodejs.cn/api-v12/events.html#events_error_events) 事件句柄（如果没有）。

```
const ee1 = new EventEmitter({ captureRejections: true });
ee1.on('something', async (value) => {
  throw new Error('kaboom');
});

ee1.on('error', console.log);

const ee2 = new EventEmitter({ captureRejections: true });
ee2.on('something', async (value) => {
  throw new Error('kaboom');
});

ee2[Symbol.for('nodejs.rejection')] = console.log;
```

设置 `EventEmitter.captureRejections = true` 将更改 `EventEmitter` 的所有新实例的默认值。

```
EventEmitter.captureRejections = true;
const ee1 = new EventEmitter();
ee1.on('something', async (value) => {
  throw new Error('kaboom');
});

ee1.on('error', console.log);
```

由 `captureRejections` 行为生成的 `'error'` 事件没有捕获句柄以避免无限的错误循环：建议不要使用 `async` 函数作为 `'error'` 事件句柄。

### `EventEmitter` 类[#](http://nodejs.cn/api-v12/events.html#class-eventemitter)

[中英对照](http://nodejs.cn/api-v12/events/class_eventemitter.html)

`EventEmitter` 类由 `events` 模块定义和暴露：

```
const EventEmitter = require('events');
```

所有的 `EventEmitter`，当添加新的监听器时触发事件 `'newListener'`，当删除现有的监听器时触发事件 `'removeListener'`。

它支持以下的选项：

-   `captureRejections` [<boolean>](http://url.nodejs.cn/jFbvuT) 启用[自动捕获 promise 拒绝](http://nodejs.cn/api-v12/events.html#events_capture_rejections_of_promises)。

#### 'newListener' 事件[#](http://nodejs.cn/api-v12/events.html#event-newlistener)

[中英对照](http://nodejs.cn/api-v12/events/event_newlistener.html)

新增于: v0.1.26

-   `eventName` [<string>](http://url.nodejs.cn/9Tw2bK) | [<symbol>](http://url.nodejs.cn/i5E1UH) 正在监听的事件的名称
-   `listener` [<Function>](http://url.nodejs.cn/ceTQa6) 事件处理函数

在将监听器添加到其内部监听器数组之前，`EventEmitter` 实例将触发自身的 `'newListener'` 事件。

```
const myEmitter = new MyEmitter();
// 只做一次，这样就不会永远循环
myEmitter.once('newListener', (event, listener) => {
  if (event === 'event') {
    // 在前面插入新的监听器
    myEmitter.on('event', () => {
      console.log('B');
    });
  }
});
myEmitter.on('event', () => {
  console.log('A');
});
myEmitter.emit('event');
// 打印:
//   B
//   A
```

#### `'removeListener'` 事件[#](http://nodejs.cn/api-v12/events.html#event-removelistener)

[中英对照](http://nodejs.cn/api-v12/events/event_removelistener.html)

-   `eventName` [<string>](http://url.nodejs.cn/9Tw2bK) | [<symbol>](http://url.nodejs.cn/i5E1UH) 事件名称
-   `listener` [<Function>](http://url.nodejs.cn/ceTQa6) 事件处理函数

在移除 `listener` 后触发 `'removeListener'` 事件。

#### `EventEmitter.listenerCount(emitter, eventName)`[#](http://nodejs.cn/api-v12/events.html#eventemitterlistenercountemitter-eventname)

[中英对照](http://nodejs.cn/api-v12/events/eventemitter_listenercount_emitter_eventname.html)

新增于: v0.9.12弃用于: v3.2.0

-   `emitter` [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter) 要查询的触发器
-   `eventName` [<string>](http://url.nodejs.cn/9Tw2bK) | [<symbol>](http://url.nodejs.cn/i5E1UH) 事件名称

返回在给定 `emitter` 上注册的给定 `eventName` 的监听器数量的类方法。

```
const myEmitter = new MyEmitter();
myEmitter.on('event', () => {});
myEmitter.on('event', () => {});
console.log(EventEmitter.listenerCount(myEmitter, 'event'));
// 打印: 2
```

#### `EventEmitter.defaultMaxListeners`[#](http://nodejs.cn/api-v12/events.html#eventemitterdefaultmaxlisteners)

[中英对照](http://nodejs.cn/api-v12/events/eventemitter_defaultmaxlisteners.html)

新增于: v0.11.2

默认情况下，最多可为任何单个事件注册 `10` 个监听器。 可以使用 [`emitter.setMaxListeners(n)`](http://nodejs.cn/api-v12/events.html#events_emitter_setmaxlisteners_n) 方法为单个 `EventEmitter` 实例更改此限制。 要更改所有 `EventEmitter` 实例的默认值，则可以使用 `EventEmitter.defaultMaxListeners` 属性。

设置 `EventEmitter.defaultMaxListeners` 时要小心，因为更改会影响所有 `EventEmitter` 实例，包括在进行更改之前创建的实例。 但是，调用 [`emitter.setMaxListeners(n)`](http://nodejs.cn/api-v12/events.html#events_emitter_setmaxlisteners_n) 仍然优先于 `EventEmitter.defaultMaxListeners`。

这不是硬性限制。 `EventEmitter` 实例将允许添加更多监听器，但会向标准错误输出跟踪警告，指示已检测到"可能的 EventEmitter 内存泄漏"。 对于任何单个 `EventEmitter`，可以使用 `emitter.getMaxListeners()` 和 `emitter.setMaxListeners()` 方法来暂时避免此警告：

```
emitter.setMaxListeners(emitter.getMaxListeners() + 1);
emitter.once('event', () => {
  // 做些事情
  emitter.setMaxListeners(Math.max(emitter.getMaxListeners() - 1, 0));
});
```

触发的警告可以使用 [`process.on('warning')`](http://nodejs.cn/api-v12/process.html#process_event_warning) 进行检查，并将具有额外的 `emitter`、`type` 和 `count` 属性，分别是指事件触发器实例、事件名称和绑定监听器的数量。 其 `name` 属性设置为 `'MaxListenersExceededWarning'`。

#### `EventEmitter.errorMonitor`[#](http://nodejs.cn/api-v12/events.html#eventemittererrormonitor)

[中英对照](http://nodejs.cn/api-v12/events/eventemitter_errormonitor.html)

新增于: v12.17.0

此符号应用于安装仅监视 `'error'` 事件的监听器。 在调用常规 `'error'` 监听器之前调用使用此符号安装的监听器。

一旦触发 `'error'` 事件，使用此符号安装监听器不会改变行为，因此如果未安装常规 `'error'` 监听器，则进程仍将崩溃。

#### `emitter.addListener(eventName, listener)`[#](http://nodejs.cn/api-v12/events.html#emitteraddlistenereventname-listener)

[中英对照](http://nodejs.cn/api-v12/events/emitter_addlistener_eventname_listener.html)

新增于: v0.1.26

-   `eventName` [<string>](http://url.nodejs.cn/9Tw2bK) | [<symbol>](http://url.nodejs.cn/i5E1UH)
-   `listener` [<Function>](http://url.nodejs.cn/ceTQa6)

`emitter.on(eventName, listener)` 的别名。

#### `emitter.emit(eventName[, ...args])`[#](http://nodejs.cn/api-v12/events.html#emitteremiteventname-args)

[中英对照](http://nodejs.cn/api-v12/events/emitter_emit_eventname_args.html)

新增于: v0.1.26

-   `eventName` [<string>](http://url.nodejs.cn/9Tw2bK) | [<symbol>](http://url.nodejs.cn/i5E1UH)
-   `...args` [<any>](http://url.nodejs.cn/6sTGdS)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

按注册顺序同步地调用为名为 `eventName` 的事件注册的每个监听器，并将提供的参数传给每个监听器。

如果事件有监听器，则返回 `true`，否则返回 `false`。

```
const EventEmitter = require('events');
const myEmitter = new EventEmitter();

// 第一个监听器
myEmitter.on('event', function firstListener() {
  console.log('Helloooo! first listener');
});
// 第二个监听器
myEmitter.on('event', function secondListener(arg1, arg2) {
  console.log(`event with parameters ${arg1}, ${arg2} in second listener`);
});
// 第三个监听器
myEmitter.on('event', function thirdListener(...args) {
  const parameters = args.join(', ');
  console.log(`event with parameters ${parameters} in third listener`);
});

console.log(myEmitter.listeners('event'));

myEmitter.emit('event', 1, 2, 3, 4, 5);

// 打印:
// [
//   [Function: firstListener],
//   [Function: secondListener],
//   [Function: thirdListener]
// ]
// Helloooo! first listener
// event with parameters 1, 2 in second listener
// event with parameters 1, 2, 3, 4, 5 in third listener
```

#### `emitter.eventNames()`[#](http://nodejs.cn/api-v12/events.html#emittereventnames)

[中英对照](http://nodejs.cn/api-v12/events/emitter_eventnames.html)

新增于: v6.0.0

-   返回: [<Array>](http://url.nodejs.cn/ZJSz23)

返回列出触发器已为其注册监听器的事件的数组。

```
const EventEmitter = require('events');
const myEE = new EventEmitter();
myEE.on('foo', () => {});
myEE.on('bar', () => {});

const sym = Symbol('symbol');
myEE.on(sym, () => {});

console.log(myEE.eventNames());
// 打印: [ 'foo', 'bar', Symbol(symbol) ]
```

#### `emitter.getMaxListeners()`[#](http://nodejs.cn/api-v12/events.html#emittergetmaxlisteners)

[中英对照](http://nodejs.cn/api-v12/events/emitter_getmaxlisteners.html)

新增于: v1.0.0

-   返回: [<integer>](http://url.nodejs.cn/SXbo1v)

返回 `EventEmitter` 的当前最大监听器数的值，该值由 [`emitter.setMaxListeners(n)`](http://nodejs.cn/api-v12/events.html#events_emitter_setmaxlisteners_n) 设置或默认为 [`EventEmitter.defaultMaxListeners`](http://nodejs.cn/api-v12/events.html#events_eventemitter_defaultmaxlisteners)。

#### `emitter.listenerCount(eventName)`[#](http://nodejs.cn/api-v12/events.html#emitterlistenercounteventname)

[中英对照](http://nodejs.cn/api-v12/events/emitter_listenercount_eventname.html)

新增于: v3.2.0

-   `eventName` [<string>](http://url.nodejs.cn/9Tw2bK) | [<symbol>](http://url.nodejs.cn/i5E1UH) 正在监听的事件的名称
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v)

返回监听名为 `eventName` 的事件的监听器数量。

#### `emitter.listeners(eventName)`[#](http://nodejs.cn/api-v12/events.html#emitterlistenerseventname)

[中英对照](http://nodejs.cn/api-v12/events/emitter_listeners_eventname.html)

-   `eventName` [<string>](http://url.nodejs.cn/9Tw2bK) | [<symbol>](http://url.nodejs.cn/i5E1UH)
-   返回: [<Function\[\]>](http://url.nodejs.cn/ceTQa6)

返回名为 `eventName` 的事件的监听器数组的副本。

```
server.on('connection', (stream) => {
  console.log('someone connected!');
});
console.log(util.inspect(server.listeners('connection')));
// 打印: [ [Function] ]
```

#### `emitter.off(eventName, listener)`[#](http://nodejs.cn/api-v12/events.html#emitteroffeventname-listener)

[中英对照](http://nodejs.cn/api-v12/events/emitter_off_eventname_listener.html)

新增于: v10.0.0

-   `eventName` [<string>](http://url.nodejs.cn/9Tw2bK) | [<symbol>](http://url.nodejs.cn/i5E1UH)
-   `listener` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter)

[`emitter.removeListener()`](http://nodejs.cn/api-v12/events.html#events_emitter_removelistener_eventname_listener) 的别名。

#### `emitter.on(eventName, listener)`[#](http://nodejs.cn/api-v12/events.html#emitteroneventname-listener)

[中英对照](http://nodejs.cn/api-v12/events/emitter_on_eventname_listener.html)

新增于: v0.1.101

-   `eventName` [<string>](http://url.nodejs.cn/9Tw2bK) | [<symbol>](http://url.nodejs.cn/i5E1UH) 事件的名称。
-   `listener` [<Function>](http://url.nodejs.cn/ceTQa6) 回调函数
-   返回: [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter)

将 `listener` 函数添加到名为 `eventName` 的事件的监听器数组的末尾。 不检查是否已添加 `listener`。 多次调用传入相同的 `eventName` 和 `listener` 组合将导致多次添加和调用 `listener`。

```
server.on('connection', (stream) => {
  console.log('someone connected!');
});
```

返回对 `EventEmitter` 的引用，以便可以链式调用。

默认情况下，事件监听器按添加顺序调用。 `emitter.prependListener()` 方法可用作将事件监听器添加到监听器数组开头的替代方法。

```
const myEE = new EventEmitter();
myEE.on('foo', () => console.log('a'));
myEE.prependListener('foo', () => console.log('b'));
myEE.emit('foo');
// 打印:
//   b
//   a
```

#### `emitter.once(eventName, listener)`[#](http://nodejs.cn/api-v12/events.html#emitteronceeventname-listener)

[中英对照](http://nodejs.cn/api-v12/events/emitter_once_eventname_listener.html)

新增于: v0.3.0

-   `eventName` [<string>](http://url.nodejs.cn/9Tw2bK) | [<symbol>](http://url.nodejs.cn/i5E1UH) 事件的名称。
-   `listener` [<Function>](http://url.nodejs.cn/ceTQa6) 回调函数
-   返回: [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter)

为名为 `eventName` 的事件添加单次的 `listener` 函数。 下次触发 `eventName` 时，将移除此监听器，然后再调用。

```
server.once('connection', (stream) => {
  console.log('Ah, we have our first user!');
});
```

返回对 `EventEmitter` 的引用，以便可以链式调用。

默认情况下，事件监听器按添加顺序调用。 `emitter.prependOnceListener()` 方法可用作将事件监听器添加到监听器数组开头的替代方法。

```
const myEE = new EventEmitter();
myEE.once('foo', () => console.log('a'));
myEE.prependOnceListener('foo', () => console.log('b'));
myEE.emit('foo');
// 打印:
//   b
//   a
```

#### `emitter.prependListener(eventName, listener)`[#](http://nodejs.cn/api-v12/events.html#emitterprependlistenereventname-listener)

[中英对照](http://nodejs.cn/api-v12/events/emitter_prependlistener_eventname_listener.html)

新增于: v6.0.0

-   `eventName` [<string>](http://url.nodejs.cn/9Tw2bK) | [<symbol>](http://url.nodejs.cn/i5E1UH) 事件的名称。
-   `listener` [<Function>](http://url.nodejs.cn/ceTQa6) 回调函数
-   返回: [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter)

将 `listener` 函数添加到名为 `eventName` 的事件的监听器数组的开头。 不检查是否已添加 `listener`。 多次调用传入相同的 `eventName` 和 `listener` 组合将导致多次添加和调用 `listener`。

```
server.prependListener('connection', (stream) => {
  console.log('someone connected!');
});
```

返回对 `EventEmitter` 的引用，以便可以链式调用。

#### `emitter.prependOnceListener(eventName, listener)`[#](http://nodejs.cn/api-v12/events.html#emitterprependoncelistenereventname-listener)

[中英对照](http://nodejs.cn/api-v12/events/emitter_prependoncelistener_eventname_listener.html)

新增于: v6.0.0

-   `eventName` [<string>](http://url.nodejs.cn/9Tw2bK) | [<symbol>](http://url.nodejs.cn/i5E1UH) 事件的名称。
-   `listener` [<Function>](http://url.nodejs.cn/ceTQa6) 回调函数
-   返回: [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter)

将名为 `eventName` 的事件的单次 `listener` 函数添加到监听器数组的开头。 下次触发 `eventName` 时，将移除此监听器，然后再调用。

```
server.prependOnceListener('connection', (stream) => {
  console.log('Ah, we have our first user!');
});
```

返回对 `EventEmitter` 的引用，以便可以链式调用。

#### `emitter.removeAllListeners([eventName])`[#](http://nodejs.cn/api-v12/events.html#emitterremovealllistenerseventname)

[中英对照](http://nodejs.cn/api-v12/events/emitter_removealllisteners_eventname.html)

新增于: v0.1.26

-   `eventName` [<string>](http://url.nodejs.cn/9Tw2bK) | [<symbol>](http://url.nodejs.cn/i5E1UH)
-   返回: [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter)

删除所有监听器，或指定 `eventName` 的监听器。

删除在代码其他地方添加的监听器是不好的做法，特别是当 `EventEmitter` 实例是由其他组件或模块（例如套接字或文件流）创建时。

返回对 `EventEmitter` 的引用，以便可以链式调用。

#### `emitter.removeListener(eventName, listener)`[#](http://nodejs.cn/api-v12/events.html#emitterremovelistenereventname-listener)

[中英对照](http://nodejs.cn/api-v12/events/emitter_removelistener_eventname_listener.html)

新增于: v0.1.26

-   `eventName` [<string>](http://url.nodejs.cn/9Tw2bK) | [<symbol>](http://url.nodejs.cn/i5E1UH)
-   `listener` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter)

从名为 `eventName` 的事件的监听器数组中移除指定的 `listener`。

```
const callback = (stream) => {
  console.log('someone connected!');
};
server.on('connection', callback);
// ...
server.removeListener('connection', callback);
```

`removeListener()` 最多从监听器数组中删除一个监听器实例。 如果任何单个监听器已多次添加到指定 `eventName` 的监听器数组中，则必须多次调用 `removeListener()` 以删除每个实例。

这意味着在触发之后和最后一个监听器完成执行之前的任何 `removeListener()` 或 `removeAllListeners()` 调用都不会从正在进行的 `emit()` 中删除它们。

```
const myEmitter = new MyEmitter();

const callbackA = () => {
  console.log('A');
  myEmitter.removeListener('event', callbackB);
};

const callbackB = () => {
  console.log('B');
};

myEmitter.on('event', callbackA);

myEmitter.on('event', callbackB);

// callbackA 删除监听器 callbackB，但它仍将被调用。
// 触发时的内部监听器数组 [callbackA, callbackB]
myEmitter.emit('event');
// 打印:
//   A
//   B

// callbackB 现在被删除了。
// 内部监听器数组 [callbackA]
myEmitter.emit('event');
// 打印:
//   A
```

由于使用内部数组管理监听器，因此调用此方法将更改在移除监听器后注册的任何监听器的位置索引。 这不会影响调用监听器的顺序，但这意味着需要重新创建 `emitter.listeners()` 方法返回的监听器数组的任何副本。

当单个函数被多次添加为单个事件的句柄时（如下例所示），则 `removeListener()` 将删除最近添加的实例。 在示例中，删除了 `once('ping')` 监听器：

```
const ee = new EventEmitter();

function pong() {
  console.log('pong');
}

ee.on('ping', pong);
ee.once('ping', pong);
ee.removeListener('ping', pong);

ee.emit('ping');
ee.emit('ping');
```

返回对 `EventEmitter` 的引用，以便可以链式调用。

#### `emitter.setMaxListeners(n)`[#](http://nodejs.cn/api-v12/events.html#emittersetmaxlistenersn)

[中英对照](http://nodejs.cn/api-v12/events/emitter_setmaxlisteners_n.html)

新增于: v0.3.5

-   `n` [<integer>](http://url.nodejs.cn/SXbo1v)
-   返回: [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter)

默认情况下，如果为特定事件添加了 `10` 个以上的监听器，则 `EventEmitter` 将打印警告。 这是一个有用的默认值，有助于查找内存泄漏。 `emitter.setMaxListeners()` 方法允许修改此特定 `EventEmitter` 实例的限制。 该值可以设置为 `Infinity`（或 `0`）以指示无限数量的监听器。

返回对 `EventEmitter` 的引用，以便可以链式调用。

#### `emitter.rawListeners(eventName)`[#](http://nodejs.cn/api-v12/events.html#emitterrawlistenerseventname)

[中英对照](http://nodejs.cn/api-v12/events/emitter_rawlisteners_eventname.html)

新增于: v9.4.0

-   `eventName` [<string>](http://url.nodejs.cn/9Tw2bK) | [<symbol>](http://url.nodejs.cn/i5E1UH)
-   返回: [<Function\[\]>](http://url.nodejs.cn/ceTQa6)

返回名为 `eventName` 的事件的监听器数组的副本，包括任何封装器（例如由 `.once()` 创建的封装器）。

```
const emitter = new EventEmitter();
emitter.once('log', () => console.log('log once'));

// 返回具有函数 `onceWrapper` 的新数组，
// 该函数具有属性 `listener`，其中包含上面绑定的原始监听器
const listeners = emitter.rawListeners('log');
const logFnWrapper = listeners[0];

// 将"log once"记录到控制台并且不会解除 `once` 事件的绑定
logFnWrapper.listener();

// 将"log once"记录到控制台并删除监听器
logFnWrapper();

emitter.on('log', () => console.log('log persistently'));
// 将返回新数组，其中包含由上面的 `.on()` 绑定的函数
const newListeners = emitter.rawListeners('log');

// 记录"log persistently"两次
newListeners[0]();
emitter.emit('log');
```

#### `emitter[Symbol.for('nodejs.rejection')](err, eventName[, ...args])`[#](http://nodejs.cn/api-v12/events.html#emittersymbolfornodejsrejectionerr-eventname-args)

[中英对照](http://nodejs.cn/api-v12/events/emitter_symbol_for_nodejs_rejection_err_eventname_args.html)

新增于: v12.16.0

[稳定性: 1](http://nodejs.cn/api/documentation.html#stability-index) - captureRejections 是实验的。

-   `err` 错误
-   `eventName` [<string>](http://url.nodejs.cn/9Tw2bK) | [<symbol>](http://url.nodejs.cn/i5E1UH)
-   `...args` [<any>](http://url.nodejs.cn/6sTGdS)

`Symbol.for('nodejs.rejection')` 方法被调用，以防在触发事件时发生 promise 拒绝，并且在触发器上启用了 [`captureRejections`](http://nodejs.cn/api-v12/events.html#events_capture_rejections_of_promises)。 可以使用 [`events.captureRejectionSymbol`](http://nodejs.cn/api-v12/events.html#events_events_capturerejectionsymbol) 代替 `Symbol.for('nodejs.rejection')`。

```
const { EventEmitter, captureRejectionSymbol } = require('events');

class MyClass extends EventEmitter {
  constructor() {
    super({ captureRejections: true });
  }

  [captureRejectionSymbol](err, event, ...args) {
    console.log('rejection happened for', event, 'with', err, ...args);
    this.destroy(err);
  }

  destroy(err) {
    // 把这里的资源卸除。
  }
}
```

### `events.once(emitter, name)`[#](http://nodejs.cn/api-v12/events.html#eventsonceemitter-name)

[中英对照](http://nodejs.cn/api-v12/events/events_once_emitter_name.html)

新增于: v11.13.0

-   `emitter` [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter)
-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

创建 `Promise`，其在 `EventEmitter` 触发给定事件时被履行，或者如果 `EventEmitter` 在等待时触发 `'error'` 则被拒绝。 `Promise` 将使用触发给定事件的所有参数的数组解决。

此方法有意通用，与 Web 平台 [EventTarget](http://url.nodejs.cn/zSu9eM) 接口配合使用，该接口没有特殊的 `'error'` 事件语义，也不监听 `'error'` 事件。

```
const { once, EventEmitter } = require('events');

async function run() {
  const ee = new EventEmitter();

  process.nextTick(() => {
    ee.emit('myevent', 42);
  });

  const [value] = await once(ee, 'myevent');
  console.log(value);

  const err = new Error('kaboom');
  process.nextTick(() => {
    ee.emit('error', err);
  });

  try {
    await once(ee, 'myevent');
  } catch (err) {
    console.log('error happened', err);
  }
}

run();
```

`'error'` 事件的特殊处理仅在 `events.once()` 用于等待另一个事件时使用。 如果 `events.once()` 用于等待 `error'` 事件本身，则它将被视为任何其他类型的事件而无需特殊处理：

```
const { EventEmitter, once } = require('events');

const ee = new EventEmitter();

once(ee, 'error')
  .then(([err]) => console.log('ok', err.message))
  .catch((err) => console.log('error', err.message));

ee.emit('error', new Error('boom'));

// 打印: ok boom
```

#### 等待 process.nextTick() 上触发的多个事件[#](http://nodejs.cn/api-v12/events.html#awaiting-multiple-events-emitted-on-processnexttick)

[中英对照](http://nodejs.cn/api-v12/events/awaiting_multiple_events_emitted_on_process_nexttick.html)

当使用 `events.once()` 函数等待在同一批 `process.nextTick()` 操作中触发的多个事件时，或者同步触发多个事件时，有一个边缘情况值得注意。 具体来说，因为 `process.nextTick()` 队列在 `Promise` 微任务队列之前被排空，并且因为 `EventEmitter` 同步触发所有事件，所以 `events.once()` 有可能错过事件。

```
const { EventEmitter, once } = require('events');

const myEE = new EventEmitter();

async function foo() {
  await once(myEE, 'bar');
  console.log('bar');

  // 此 Promise 永远不会被解决，
  // 因为 'foo' 事件在 Promise 被创建之前就已经触发了。
  await once(myEE, 'foo');
  console.log('foo');
}

process.nextTick(() => {
  myEE.emit('bar');
  myEE.emit('foo');
});

foo().then(() => console.log('done'));
```

要捕获这两个事件，则在等待其中一个之前创建每个 Promise，然后可以使用 `Promise.all()`、`Promise.race()` 或 `Promise.allSettled()`：

```
const { EventEmitter, once } = require('events');

const myEE = new EventEmitter();

async function foo() {
  await Promise.all([once(myEE, 'bar'), once(myEE, 'foo')]);
  console.log('foo', 'bar');
}

process.nextTick(() => {
  myEE.emit('bar');
  myEE.emit('foo');
});

foo().then(() => console.log('done'));
```

### `events.captureRejections`[#](http://nodejs.cn/api-v12/events.html#eventscapturerejections)

[中英对照](http://nodejs.cn/api-v12/events/events_capturerejections.html)

新增于: v12.16.0

[稳定性: 1](http://nodejs.cn/api/documentation.html#stability-index) - captureRejections 是实验的。

值: [<boolean>](http://url.nodejs.cn/jFbvuT)

更改所有新的 `EventEmitter` 对象的默认 `captureRejections` 选项。

### events.captureRejectionSymbol[#](http://nodejs.cn/api-v12/events.html#eventscapturerejectionsymbol)

[中英对照](http://nodejs.cn/api-v12/events/events_capturerejectionsymbol.html)

新增于: v12.16.0

[稳定性: 1](http://nodejs.cn/api/documentation.html#stability-index) - captureRejections 是实验的。

值: `Symbol.for('nodejs.rejection')`

了解如何编写自定义的[拒绝句柄](http://nodejs.cn/api-v12/events.html#events_emitter_symbol_for_nodejs_rejection_err_eventname_args)。

### events.on(emitter, eventName)[#](http://nodejs.cn/api-v12/events.html#eventsonemitter-eventname)

[中英对照](http://nodejs.cn/api-v12/events/events_on_emitter_eventname.html)

新增于: v12.16.0

-   `emitter` [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter)
-   `eventName` [<string>](http://url.nodejs.cn/9Tw2bK) | [<symbol>](http://url.nodejs.cn/i5E1UH) 正在监听的事件的名称
-   返回: [<AsyncIterator>](http://url.nodejs.cn/HnG4ws) 迭代由 `emitter` 触发的 `eventName` 事件

```
const { on, EventEmitter } = require('events');

(async () => {
  const ee = new EventEmitter();

  // 稍后触发
  process.nextTick(() => {
    ee.emit('foo', 'bar');
    ee.emit('foo', 42);
  });

  for await (const event of on(ee, 'foo')) {
    // 此内部块的执行是同步的，
    // 且每次处理一个事件（即使有等待）。
    // 如果需要并发执行，则不要使用。
    console.log(event); // 打印 ['bar'] [42]
  }
  // 此处无法到达
})();
```

返回迭代 `eventName` 事件的 `AsyncIterator`。 如果 `EventEmitter` 触发 `'error'`，则将抛出错误。 它在退出循环时删除所有监听器。 每次迭代返回的 `value` 是由触发的事件参数组成的数组。
