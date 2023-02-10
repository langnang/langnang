---
created: 2022-07-29T13:12:54 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/worker_threads.html
author: 
---

# worker_threads 工作线程 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/worker_threads/worker_threads.html)

**源代码:** [lib/worker\_threads.js](https://github.com/nodejs/node/blob/v12.22.12/lib/worker_threads.js)

`worker_threads` 模块允许使用并行执行 JavaScript 的线程。 要访问它：

```
const worker = require('worker_threads');
```

工作线程对于执行 CPU 密集型的 JavaScript 操作很有用。 它们对 I/O 密集型工作帮助不大。 Node.js 内置的异步 I/O 操作比工作线程更高效。

与 `child_process` 或 `cluster` 不同，`worker_threads` 可以共享内存。 它们通过传输 `ArrayBuffer` 实例或共享 `SharedArrayBuffer` 实例来实现。

```
const {
  Worker, isMainThread, parentPort, workerData
} = require('worker_threads');

if (isMainThread) {
  module.exports = function parseJSAsync(script) {
    return new Promise((resolve, reject) => {
      const worker = new Worker(__filename, {
        workerData: script
      });
      worker.on('message', resolve);
      worker.on('error', reject);
      worker.on('exit', (code) => {
        if (code !== 0)
          reject(new Error(`Worker stopped with exit code ${code}`));
      });
    });
  };
} else {
  const { parse } = require('some-js-parsing-library');
  const script = workerData;
  parentPort.postMessage(parse(script));
}
```

上面的示例为每个 `parse()` 调用衍生工作线程。 在实际操作中，请使用工作线程池来代替这些类型的任务 否则，创建工作线程的开销可能会超过其收益。

当实现工作线程池时，使用 [`AsyncResource`](http://nodejs.cn/api-v12/async_hooks.html#async_hooks_class_asyncresource) API 通知诊断工具（例如，为了提供异步堆栈跟踪）任务与其结果之间的相关性。 有关示例实现，请参阅 `async_hooks` 文档中的[“将 `AsyncResource` 用于 `Worker` 线程池”](http://nodejs.cn/api-v12/async_hooks.html#async-resource-worker-pool)

默认情况下，工作线程继承非进程特定的选项。 参考 [`Worker` 构造函数选项](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_new_worker_filename_options) 了解如何自定义工作线程选项，特别是 `argv` 和 `execArgv` 选项。

### `worker.isMainThread`[#](http://nodejs.cn/api-v12/worker_threads.html#workerismainthread)

[中英对照](http://nodejs.cn/api-v12/worker_threads/worker_ismainthread.html)

新增于: v10.5.0

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

如果此代码不在 [`Worker`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_class_worker) 线程内运行，则为 `true`。

```
const { Worker, isMainThread } = require('worker_threads');

if (isMainThread) {
  // 这会在工作线程实例中重新加载当前文件。
  new Worker(__filename);
} else {
  console.log('Inside Worker!');
  console.log(isMainThread);  // 打印 'false'。
}
```

### `worker.markAsUntransferable(object)`[#](http://nodejs.cn/api-v12/worker_threads.html#workermarkasuntransferableobject)

[中英对照](http://nodejs.cn/api-v12/worker_threads/worker_markasuntransferable_object.html)

新增于: v12.19.0

将对象标记为不可传输。 如果 `object` 出现在 [`port.postMessage()`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_port_postmessage_value_transferlist) 调用的传输列表中，则它将被忽略。

特别是，这对于可以克隆而不是传输的对象，以及被发送方的其他对象使用的对象来说是有意义的。 例如，Node.js 用这个标记了它用于 [`Buffer` 池](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafe_size)的 `ArrayBuffer`。

此操作无法撤消。

```
const { MessageChannel, markAsUntransferable } = require('worker_threads');

const pooledBuffer = new ArrayBuffer(8);
const typedArray1 = new Uint8Array(pooledBuffer);
const typedArray2 = new Float64Array(pooledBuffer);

markAsUntransferable(pooledBuffer);

const { port1 } = new MessageChannel();
port1.postMessage(typedArray1, [ typedArray1.buffer ]);

// 以下行打印 typedArray1 的内容，
// 它仍然拥有它的内存并且已经被克隆，而不是传输。
// 没有 `markAsUntransferable()`，这将打印空的 Uint8Array。
// typedArray2 也完好无损。
console.log(typedArray1);
console.log(typedArray2);
```

浏览器中没有与此 API 等效的 API。

### `worker.moveMessagePortToContext(port, contextifiedSandbox)`[#](http://nodejs.cn/api-v12/worker_threads.html#workermovemessageporttocontextport-contextifiedsandbox)

[中英对照](http://nodejs.cn/api-v12/worker_threads/worker_movemessageporttocontext_port_contextifiedsandbox.html)

新增于: v11.13.0

-   `port` [<MessagePort>](http://nodejs.cn/api/worker_threads.html#class-messageport) 将要传输的消息端口。
    
-   `contextifiedSandbox` [<Object>](http://url.nodejs.cn/jzn6Ao) `vm.createContext()` 方法返回的[上下文隔离化的](http://nodejs.cn/api-v12/vm.html#vm_what_does_it_mean_to_contextify_an_object)对象。
    
-   返回: [<MessagePort>](http://nodejs.cn/api/worker_threads.html#class-messageport)
    

将 `MessagePort` 传输到不同的 [`vm`](http://nodejs.cn/api-v12/vm.html) 上下文 原始的 `port` 对象将无法使用，返回的 `MessagePort` 实例将取而代之。

返回的 `MessagePort` 将是目标上下文中的对象，并将继承自其全局 `Object` 类。 传给 [`port.onmessage()`](http://url.nodejs.cn/4K42hk) 监听器的对象也将在目标上下文中创建并从其全局 `Object` 类继承。

但是，创建的 `MessagePort` 将不再继承 [`EventEmitter`](http://nodejs.cn/api-v12/events.html)，只能使用 [`port.onmessage()`](http://url.nodejs.cn/4K42hk) 来接收使用它的事件。

### `worker.parentPort`[#](http://nodejs.cn/api-v12/worker_threads.html#workerparentport)

[中英对照](http://nodejs.cn/api-v12/worker_threads/worker_parentport.html)

新增于: v10.5.0

-   [<null>](http://url.nodejs.cn/334hvC) | [<MessagePort>](http://nodejs.cn/api/worker_threads.html#class-messageport)

如果此线程是作为 [`Worker`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_class_worker) 衍生的，这将是允许与父线程通信的 [`MessagePort`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_class_messageport)。 使用 `parentPort.postMessage()` 发送的消息将在使用 `worker.on('message')` 的父线程中可用，使用 `worker.postMessage()` 从父线程发送的消息将在使用 `parentPort.on('message')` 的该线程中可用。

```
const { Worker, isMainThread, parentPort } = require('worker_threads');

if (isMainThread) {
  const worker = new Worker(__filename);
  worker.once('message', (message) => {
    console.log(message);  // 打印 'Hello, world!'。
  });
  worker.postMessage('Hello, world!');
} else {
  // 当收到来自父线程的消息时，则将其发回：
  parentPort.once('message', (message) => {
    parentPort.postMessage(message);
  });
}
```

### `worker.receiveMessageOnPort(port)`[#](http://nodejs.cn/api-v12/worker_threads.html#workerreceivemessageonportport)

[中英对照](http://nodejs.cn/api-v12/worker_threads/worker_receivemessageonport_port.html)

新增于: v12.3.0

-   `port` [<MessagePort>](http://nodejs.cn/api/worker_threads.html#class-messageport)
    
-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao) | [<undefined>](http://url.nodejs.cn/8ym6ow)
    

从给定的 `MessagePort` 接收消息。 如果没有消息可用，则返回 `undefined`，否则返回具有单个 `message` 属性的对象，其中包含消息有效负载，对应于 `MessagePort` 队列中最旧的消息。

```
const { MessageChannel, receiveMessageOnPort } = require('worker_threads');
const { port1, port2 } = new MessageChannel();
port1.postMessage({ hello: 'world' });

console.log(receiveMessageOnPort(port2));
// 打印: { message: { hello: 'world' } }
console.log(receiveMessageOnPort(port2));
// 打印: undefined
```

当使用此函数时，不会触发 `'message'` 事件，也不会调用 `onmessage` 监听器。

### `worker.resourceLimits`[#](http://nodejs.cn/api-v12/worker_threads.html#workerresourcelimits)

[中英对照](http://nodejs.cn/api-v12/worker_threads/worker_resourcelimits.html)

新增于: v12.16.0

-   [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `maxYoungGenerationSizeMb` [<number>](http://url.nodejs.cn/SXbo1v)
    -   `maxOldGenerationSizeMb` [<number>](http://url.nodejs.cn/SXbo1v)
    -   `codeRangeSizeMb` [<number>](http://url.nodejs.cn/SXbo1v)
    -   `stackSizeMb` [<number>](http://url.nodejs.cn/SXbo1v)

在这个工作线程中提供了一组 JS 引擎资源约束。 如果将 `resourceLimits` 选项传给 [`Worker`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_class_worker) 构造函数，则这与其值匹配。

如果在主线程中使用此，则其值为空对象。

### `worker.SHARE_ENV`[#](http://nodejs.cn/api-v12/worker_threads.html#workershare_env)

[中英对照](http://nodejs.cn/api-v12/worker_threads/worker_share_env.html)

新增于: v11.14.0

-   [<symbol>](http://url.nodejs.cn/i5E1UH)

可以作为 [`Worker`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_class_worker) 构造函数的 `env` 选项传入的特殊值，表示当前线程和工作线程应该共享对同一组环境变量的读写访问。

```
const { Worker, SHARE_ENV } = require('worker_threads');
new Worker('process.env.SET_IN_WORKER = "foo"', { eval: true, env: SHARE_ENV })
  .on('exit', () => {
    console.log(process.env.SET_IN_WORKER);  // 打印 'foo'。
  });
```

### `worker.threadId`[#](http://nodejs.cn/api-v12/worker_threads.html#workerthreadid)

[中英对照](http://nodejs.cn/api-v12/worker_threads/worker_threadid.html)

新增于: v10.5.0

-   [<integer>](http://url.nodejs.cn/SXbo1v)

当前线程的整数标识符。 在对应的工作线程对象上（如果有的话），可以作为 [`worker.threadId`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_worker_threadid_1) 使用。 此值对于单个进程中的每个 [`Worker`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_class_worker) 实例都是唯一的。

### `worker.workerData`[#](http://nodejs.cn/api-v12/worker_threads.html#workerworkerdata)

[中英对照](http://nodejs.cn/api-v12/worker_threads/worker_workerdata.html)

新增于: v10.5.0

任意 JavaScript 值，其中包含传给该线程的 `Worker` 构造函数的数据的副本。

根据 [HTML 结构化克隆算法](http://url.nodejs.cn/SLsDHc)，数据如同使用 [`postMessage()`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_port_postmessage_value_transferlist) 一样被克隆。

```
const { Worker, isMainThread, workerData } = require('worker_threads');

if (isMainThread) {
  const worker = new Worker(__filename, { workerData: 'Hello, world!' });
} else {
  console.log(workerData);  // 打印 'Hello, world!'。
}
```

### `MessageChannel` 类[#](http://nodejs.cn/api-v12/worker_threads.html#class-messagechannel)

[中英对照](http://nodejs.cn/api-v12/worker_threads/class_messagechannel.html)

新增于: v10.5.0

`worker.MessageChannel` 类的实例代表异步的双向通信通道。 `MessageChannel` 没有自己的方法。 `new MessageChannel()` 产生具有 `port1` 和 `port2` 属性的对象，其引用链接的 [`MessagePort`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_class_messageport) 实例。

```
const { MessageChannel } = require('worker_threads');

const { port1, port2 } = new MessageChannel();
port1.on('message', (message) => console.log('received', message));
port2.postMessage({ foo: 'bar' });
// 从 `port1.on('message')` 监听器打印 received { foo: 'bar' }
```

### `MessagePort` 类[#](http://nodejs.cn/api-v12/worker_threads.html#class-messageport)

[中英对照](http://nodejs.cn/api-v12/worker_threads/class_messageport.html)

新增于: v10.5.0

-   继承自: [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter)

`worker.MessagePort` 类的实例代表异步双向通信通道的一端。 它可以用来在不同的 [`Worker`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_class_worker) 之间传输结构化的数据、内存区域和其他 `MessagePort`

#### `'close'` 事件[#](http://nodejs.cn/api-v12/worker_threads.html#event-close)

[中英对照](http://nodejs.cn/api-v12/worker_threads/event_close.html)

新增于: v10.5.0

一旦通道的任一侧断开连接，则会触发 `'close'` 事件。

```
const { MessageChannel } = require('worker_threads');
const { port1, port2 } = new MessageChannel();

// 打印:
//   foobar
//   closed!
port2.on('message', (message) => console.log(message));
port2.on('close', () => console.log('closed!'));

port1.postMessage('foobar');
port1.close();
```

#### `'message'` 事件[#](http://nodejs.cn/api-v12/worker_threads.html#event-message)

[中英对照](http://nodejs.cn/api-v12/worker_threads/event_message.html)

新增于: v10.5.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS) 传输值

为任何传入消息触发 `'message'` 事件，其中包含 [`port.postMessage()`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_port_postmessage_value_transferlist) 的克隆输入。

此事件的监听器将收到传给 `postMessage()` 的 `value` 参数的副本，并且没有其他参数。

#### `'messageerror'` 事件[#](http://nodejs.cn/api-v12/worker_threads.html#event-messageerror)

[中英对照](http://nodejs.cn/api-v12/worker_threads/event_messageerror.html)

新增于: v12.19.0

-   `error` [<Error>](http://url.nodejs.cn/qZ873x) 错误对象

当反序列化消息失败时，则会触发 `'messageerror'` 事件。

#### `port.close()`[#](http://nodejs.cn/api-v12/worker_threads.html#portclose)

[中英对照](http://nodejs.cn/api-v12/worker_threads/port_close.html)

新增于: v10.5.0

禁止在连接的任一端进一步发送消息。 当此 `MessagePort` 上不会发生进一步的通信时，可以调用此方法。

[`'close'` 事件](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_event_close)将在作为通道一部分的两个 `MessagePort` 实例上触发。

#### `port.postMessage(value[, transferList])`[#](http://nodejs.cn/api-v12/worker_threads.html#portpostmessagevalue-transferlist)

[中英对照](http://nodejs.cn/api-v12/worker_threads/port_postmessage_value_transferlist.html)

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   `transferList` [<Object\[\]>](http://url.nodejs.cn/jzn6Ao)

向该通道的接收端发送 JavaScript 值。 `value` 将以与 [HTML 结构化克隆算法](http://url.nodejs.cn/SLsDHc)兼容的方式传输。

特别是与 `JSON` 的显着区别是：

-   `value` 可能包含循环引用。
-   `value` 可能包含内置 JS 类型的实例，例如 `RegExp`、`BigInt`、`Map`、`Set` 等。
-   `value` 可能包含类型化数组，都使用 `ArrayBuffer` 和 `SharedArrayBuffer`。
-   `value` 可能包含 [`WebAssembly.Module`](http://url.nodejs.cn/jrrZmy) 实例。

```
const { MessageChannel } = require('worker_threads');
const { port1, port2 } = new MessageChannel();

port1.on('message', (message) => console.log(message));

const circularData = {};
circularData.foo = circularData;
// 打印: { foo: [Circular] }
port2.postMessage(circularData);
```

`transferList` 可能是 [`ArrayBuffer`](http://url.nodejs.cn/mUbfvF)、[`MessagePort`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_class_messageport) 和 [`FileHandle`](http://nodejs.cn/api-v12/fs.html#fs_class_filehandle) 对象的列表。 传输后，它们将不再能在通道的发送端使用（即使它们不包含在 `value` 中） 与[子进程](http://nodejs.cn/api-v12/child_process.html)不同，当前不支持传输句柄，例如网络套接字。

如果 `value` 包含 [`SharedArrayBuffer`](http://url.nodejs.cn/6J6LBy) 实例，则可以从任一线程访问这些实例。 它们不能在 `transferList` 中列出。

`value` 可能仍然包含不在 `transferList` 中的 `ArrayBuffer` 实例；在这种情况下，底层内存被复制而不是移动。

```
const { MessageChannel } = require('worker_threads');
const { port1, port2 } = new MessageChannel();

port1.on('message', (message) => console.log(message));

const uint8Array = new Uint8Array([ 1, 2, 3, 4 ]);
// 此发送 `uint8Array` 的副本：
port2.postMessage(uint8Array);
// 这不会复制数据，但会使 `uint8Array` 无法使用：
port2.postMessage(uint8Array, [ uint8Array.buffer ]);

// `sharedUint8Array` 的内存可以从
// `.on('message')` 收到的原件和副本中访问：
const sharedUint8Array = new Uint8Array(new SharedArrayBuffer(4));
port2.postMessage(sharedUint8Array);

// 这会将新创建的消息端口传输到接收器。
// 例如，这可用于在作为同一父线程的子线程的多个 `Worker` 线程之间
// 创建通信通道。
const otherChannel = new MessageChannel();
port2.postMessage({ port: otherChannel.port1 }, [ otherChannel.port1 ]);
```

因为对象克隆使用结构化克隆算法，不可枚举的属性、属性访问器和对象原型不会被保留。 特别是，[`Buffer`](http://nodejs.cn/api-v12/buffer.html) 对象将在接收方读取为普通的 [`Uint8Array`](http://url.nodejs.cn/ZbDkpm)。

消息对象会被立即克隆，发布后可以修改，没有副作用。

关于此 API 背后的序列化和反序列化机制的更多信息，请参见 [`v8` 模块的序列化 API](http://nodejs.cn/api-v12/v8.html#v8_serialization_api)。

##### 传输 TypedArray 和 Buffer 时的注意事项[#](http://nodejs.cn/api-v12/worker_threads.html#considerations-when-transferring-typedarrays-and-buffers)

[中英对照](http://nodejs.cn/api-v12/worker_threads/considerations_when_transferring_typedarrays_and_buffers.html)

所有 `TypedArray` 和 `Buffer` 实例都是对底层 `ArrayBuffer` 的视图。 也就是说，实际存储原始数据的是 `ArrayBuffer`，而 `TypedArray` 和 `Buffer` 对象提供了查看和操作数据的方式。 在同一个 `ArrayBuffer` 实例上创建多个视图是可能且常见的。 使用传输列表传输 `ArrayBuffer` 时必须非常小心，因为这样做会导致共享同一个 `ArrayBuffer` 的所有 `TypedArray` 和 `Buffer` 实例变得不可用。

```
const ab = new ArrayBuffer(10);

const u1 = new Uint8Array(ab);
const u2 = new Uint16Array(ab);

console.log(u2.length);  // 打印 5

port.postMessage(u1, [u1.buffer]);

console.log(u2.length);  // 打印 0
```

对于 `Buffer` 实例，具体来说，底层 `ArrayBuffer` 是否可以被传输或克隆完全取决于实例是如何创建的，这通常无法可靠地确定。

`ArrayBuffer` 可以用 [`markAsUntransferable()`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_worker_markasuntransferable_object) 标记来表示它应该总是被克隆并且永远不会被传输。

根据 `Buffer` 实例的创建方式，它可能拥有也可能不拥有其底层 `ArrayBuffer`。 除非知道 `Buffer` 实例拥有它，否则不得传输 `ArrayBuffer`。 特别是，对于从内部 `Buffer` 池（使用，例如 `Buffer.from()` 或 `Buffer.alloc()`）创建的 `Buffer`，传输它们是不可能的，它们将始终被克隆，这会发送整个 `Buffer` 池的副本。 此行为可能会带来意想不到的更高内存使用率和可能的安全问题。

有关 `Buffer` 池化的更多详细信息，请参阅 [`Buffer.allocUnsafe()`](http://nodejs.cn/api-v12/buffer.html#buffer_static_method_buffer_allocunsafe_size)。

使用 `Buffer.alloc()` 或 `Buffer.allocUnsafeSlow()` 创建的 `Buffer` 实例的 `ArrayBuffer` 始终可以传输，但这样做会使那些 `ArrayBuffer` 的所有其他现有视图无法使用。

#### `port.ref()`[#](http://nodejs.cn/api-v12/worker_threads.html#portref)

[中英对照](http://nodejs.cn/api-v12/worker_threads/port_ref.html)

新增于: v10.5.0

`unref()` 的相反。 如果它是唯一剩下的活动句柄（默认行为），则在以前的 `unref()` 的端口上调用 `ref()` 不会让程序退出。 如果端口是 `ref()` 的，则再次调用 `ref()` 将无效。

如果使用 `.on('message')` 绑定或删除监听器，则端口将根据事件的监听器是否存在自动进行 `ref()` 和 `unref()`。

#### `port.start()`[#](http://nodejs.cn/api-v12/worker_threads.html#portstart)

[中英对照](http://nodejs.cn/api-v12/worker_threads/port_start.html)

新增于: v10.5.0

开始在此 `MessagePort` 上接收消息。 当将此端口用作事件触发器时，一旦绑定了 `'message'` 监听器，则就会自动调用它。

此方法与 Web `MessagePort` API 相同。 在 Node.js 中，只有在没有事件监听器时才用于忽略消息。 Node.js 在处理 `.onmessage` 方面也有分歧。 设置它会自动调用 `.start()`，但取消设置它会让消息排队直到设置新的句柄或端口被丢弃。

#### `port.unref()`[#](http://nodejs.cn/api-v12/worker_threads.html#portunref)

[中英对照](http://nodejs.cn/api-v12/worker_threads/port_unref.html)

新增于: v10.5.0

如果这是事件系统中唯一的活动句柄，则在端口上调用 `unref()` 将允许线程退出。 如果端口已经 `unref()`，则再次调用 `unref()` 将无效。

如果使用 `.on('message')` 绑定或删除监听器，则端口将根据事件的监听器是否存在自动进行 `ref()` 和 `unref()`。

### `Worker` 类[#](http://nodejs.cn/api-v12/worker_threads.html#class-worker)

[中英对照](http://nodejs.cn/api-v12/worker_threads/class_worker.html)

新增于: v10.5.0

-   继承自: [<EventEmitter>](http://nodejs.cn/api/events.html#class-eventemitter)

`Worker` 类代表独立的 JavaScript 执行线程。 大多数 Node.js API 都可以在其中使用。

工作线程环境中的显着差异是：

-   [`process.stdin`](http://nodejs.cn/api-v12/process.html#process_process_stdin)、[`process.stdout`](http://nodejs.cn/api-v12/process.html#process_process_stdout) 和 [`process.stderr`](http://nodejs.cn/api-v12/process.html#process_process_stderr) 可能被父线程重定向。
-   [`require('worker_threads').isMainThread`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_worker_ismainthread) 属性被设置为 `false`。
-   [`require('worker_threads').parentPort`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_worker_parentport) 消息端口可用。
-   [`process.exit()`](http://nodejs.cn/api-v12/process.html#process_process_exit_code) 不会停止整个程序，只是单个线程，且 [`process.abort()`](http://nodejs.cn/api-v12/process.html#process_process_abort) 不可用。
-   设置群组或用户标识的 [`process.chdir()`](http://nodejs.cn/api-v12/process.html#process_process_chdir_directory) 和 `process` 方法不可用。
-   [`process.env`](http://nodejs.cn/api-v12/process.html#process_process_env) 是父线程的环境变量的副本，除非另有说明。 对副本的更改在其他线程中不可见，对原生插件也不可见（除非 [`worker.SHARE_ENV`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_worker_share_env) 已作为 `env` 选项传给 [`Worker`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_class_worker) 构造函数）。
-   [`process.title`](http://nodejs.cn/api-v12/process.html#process_process_title) 不能修改。
-   信号不会通过 [`process.on('...')`](http://nodejs.cn/api-v12/process.html#process_signal_events) 传送。
-   [`worker.terminate()`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_worker_terminate) 被调用时，执行可能在任何时候停止。
-   来自父进程的进程间通信通道不可访问。
-   不支持 [`trace_events`](http://nodejs.cn/api-v12/tracing.html) 模块。
-   如果满足[某些条件](http://nodejs.cn/api-v12/addons.html#addons_worker_support)，则原生插件只能从多个线程加载。

可以在其他 `Worker` 内部创建 `Worker` 实例。

和[网络工作线程](http://url.nodejs.cn/skL7X7)和 [`cluster` 模块](http://nodejs.cn/api-v12/cluster.html)一样，可以通过线程间消息传递来实现双向通信。 在内部，`Worker` 有一对内置的 [`MessagePort`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_class_messageport)，在创建 `Worker` 时它们已经相互关联。 虽然父端的 `MessagePort` 对象没有直接暴露，但其功能通过父线程 `Worker` 对象上的 [`worker.postMessage()`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_worker_postmessage_value_transferlist) 和 [`worker.on('message')`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_event_message_1) 事件暴露。

要创建自定义的消息通道（鼓励使用默认的全局通道，因为它有助于分离关注点），用户可以在任一线程上创建 `MessageChannel` 对象，并通过预先存在的通道（例如全局通道）将该 `MessageChannel` 上的 `MessagePort` 之一传给另一个线程。

有关如何传递消息以及可以成功通过线程屏障传输的 JavaScript 值类型的更多信息，请参阅 [`port.postMessage()`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_port_postmessage_value_transferlist)。

```
const assert = require('assert');
const {
  Worker, MessageChannel, MessagePort, isMainThread, parentPort
} = require('worker_threads');
if (isMainThread) {
  const worker = new Worker(__filename);
  const subChannel = new MessageChannel();
  worker.postMessage({ hereIsYourPort: subChannel.port1 }, [subChannel.port1]);
  subChannel.port2.on('message', (value) => {
    console.log('received:', value);
  });
} else {
  parentPort.once('message', (value) => {
    assert(value.hereIsYourPort instanceof MessagePort);
    value.hereIsYourPort.postMessage('the worker is sending this');
    value.hereIsYourPort.close();
  });
}
```

#### `new Worker(filename[, options])`[#](http://nodejs.cn/api-v12/worker_threads.html#new-workerfilename-options)

[中英对照](http://nodejs.cn/api-v12/worker_threads/new_worker_filename_options.html)

-   `filename` [<string>](http://url.nodejs.cn/9Tw2bK) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) 工作线程主脚本或模块的路径。
    
    如果 `options.eval` 是 `true`，则这是包含 JavaScript 代码（而不是路径）的字符串。
    
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    
    -   `argv` [<any\[\]>](http://url.nodejs.cn/6sTGdS) 将被字符串化并附加到工作线程中的 `process.argv` 的参数列表。 这与 `workerData` 非常相似，但这些值将在全局 `process.argv` 上可用，就像它们作为命令行选项传给脚本一样。
    -   `env` [<Object>](http://url.nodejs.cn/jzn6Ao) 如果设置，则指定工作线程内 `process.env` 的初始值。 作为特殊值，[`worker.SHARE_ENV`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_worker_share_env) 可用于指定父线程和子线程应该共享它们的环境变量；在这种情况下，对一个线程的 `process.env` 对象的更改也会影响另一个线程。 **默认值:** `process.env`。
    -   `eval` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果 `true` 并且第一个参数是 `string`，则将构造函数的第一个参数解释为一旦工作线程在线就执行的脚本。
    -   `execArgv` [<string\[\]>](http://url.nodejs.cn/9Tw2bK) 传给工作线程的 node CLI 选项的列表。 不支持 V8 选项（如 `--max-old-space-size`）和影响进程的选项（如 `--title`）。 如果设置，则这将在工作线程内部提供为 [`process.execArgv`](http://nodejs.cn/api-v12/process.html#process_process_execargv)。 默认情况下，选项将从父线程继承。
    -   `stdin` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果设置为 `true`，则 `worker.stdin` 将提供其内容将在工作线程中显示为 `process.stdin` 的可写流。 默认情况下，不提供任何数据。
    -   `stdout` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果设置为 `true`，则 `worker.stdout` 将不会自动通过管道传输到父线程中的 `process.stdout`。
    -   `stderr` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果设置为 `true`，则 `worker.stderr` 将不会自动通过管道传输到父线程中的 `process.stderr`。
    -   `workerData` [<any>](http://url.nodejs.cn/6sTGdS) 任何将被克隆并作为 [`require('worker_threads').workerData`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_worker_workerdata) 可用的 JavaScript 值。 克隆将按照 [HTML 结构化克隆算法](http://url.nodejs.cn/SLsDHc)中的描述进行，如果无法克隆对象（例如，因为它包含 `function`），则会抛出错误。
    -   `trackUnmanagedFds` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果设置为 `true`，则工作线程将跟踪通过 [`fs.open()`](http://nodejs.cn/api-v12/fs.html#fs_fs_open_path_flags_mode_callback) 和 [`fs.close()`](http://nodejs.cn/api-v12/fs.html#fs_fs_close_fd_callback) 管理的原始文件描述符，并在工作线程退出时关闭它们，类似于网络套接字或通过 [`FileHandle`](http://nodejs.cn/api-v12/fs.html#fs_class_filehandle) API 管理的文件描述符等其他资源。 此选项会被所有嵌套的 `Worker` 自动继承。 **默认值**: `false`.
    -   `transferList` [<Object\[\]>](http://url.nodejs.cn/jzn6Ao) 如果在 `workerData` 中传入了一个或多个类似 `MessagePort` 的对象，则这些条目需要 `transferList`，否则将抛出 [`ERR_MISSING_MESSAGE_PORT_IN_TRANSFER_LIST`](http://nodejs.cn/api-v12/errors.html#errors_err_missing_message_port_in_transfer_list)。 有关详细信息，请参阅 [`port.postMessage()`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_port_postmessage_value_transferlist)。
    -   `resourceLimits` [<Object>](http://url.nodejs.cn/jzn6Ao) 新的 JS 引擎实例的一组可选资源限制。 达到这些限制将导致 `Worker` 实例终止。 这些限制只影响 JS 引擎，不影响外部数据，不包括 `ArrayBuffer`。 即使设置了这些限制，如果遇到全局内存不足的情况，进程仍可能会中止。
        -   `maxOldGenerationSizeMb` [<number>](http://url.nodejs.cn/SXbo1v) 主堆的最大大小 (以 MB 为单位)。
        -   `maxYoungGenerationSizeMb` [<number>](http://url.nodejs.cn/SXbo1v) 最近创建的对象的最大堆空间大小。
        -   `codeRangeSizeMb` [<number>](http://url.nodejs.cn/SXbo1v) 用于生成代码的预分配内存范围的大小。
        -   `stackSizeMb` [<number>](http://url.nodejs.cn/SXbo1v) 线程的默认最大堆栈大小。 较小的值可能会导致工作线程实例无法使用。 **默认值:** `4`。

#### `'error'` 事件[#](http://nodejs.cn/api-v12/worker_threads.html#event-error)

[中英对照](http://nodejs.cn/api-v12/worker_threads/event_error.html)

新增于: v10.5.0

-   `err` [<Error>](http://url.nodejs.cn/qZ873x)

如果工作线程抛出未捕获的异常，则会触发 `'error'` 事件。 在这种情况下，工作线程将被终止。

#### `'exit'` 事件[#](http://nodejs.cn/api-v12/worker_threads.html#event-exit)

[中英对照](http://nodejs.cn/api-v12/worker_threads/event_exit.html)

新增于: v10.5.0

-   `exitCode` [<integer>](http://url.nodejs.cn/SXbo1v)

一旦工作线程停止，则会触发 `'exit'` 事件。 如果工作线程通过调用 [`process.exit()`](http://nodejs.cn/api-v12/process.html#process_process_exit_code) 退出，则 `exitCode` 参数将是传入的退出码。 如果工作线程被终止，则 `exitCode` 参数将为 `1`。

这是任何 `Worker` 实例触发的最终事件。

#### `'message'` 事件[#](http://nodejs.cn/api-v12/worker_threads.html#event-message_1)

[中英对照](http://nodejs.cn/api-v12/worker_threads/event_message_1.html)

新增于: v10.5.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS) 传输值

当工作线程调用 [`require('worker_threads').parentPort.postMessage()`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_worker_postmessage_value_transferlist) 时，则会触发 `'message'` 事件。 详情请见 [`port.on('message')`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_event_message) 事件。

从工作线程发送的所有消息都将在 `Worker` 对象上触发 [`'exit'` 事件](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_event_exit)之前触发。

#### `'messageerror'` 事件[#](http://nodejs.cn/api-v12/worker_threads.html#event-messageerror_1)

[中英对照](http://nodejs.cn/api-v12/worker_threads/event_messageerror_1.html)

新增于: v12.19.0

-   `error` [<Error>](http://url.nodejs.cn/qZ873x) 错误对象

当反序列化消息失败时，则会触发 `'messageerror'` 事件。

#### `'online'` 事件[#](http://nodejs.cn/api-v12/worker_threads.html#event-online)

[中英对照](http://nodejs.cn/api-v12/worker_threads/event_online.html)

新增于: v10.5.0

当工作线程开始执行 JavaScript 代码时，则会触发 `'online'` 事件。

#### `worker.getHeapSnapshot()`[#](http://nodejs.cn/api-v12/worker_threads.html#workergetheapsnapshot)

[中英对照](http://nodejs.cn/api-v12/worker_threads/worker_getheapsnapshot.html)

新增于: v12.17.0

-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8) 对包含 V8 堆快照的可读流的 promise

返回工作线程当前状态的 V8 快照的可读流。 有关详细信息，请参阅 [`v8.getHeapSnapshot()`](http://nodejs.cn/api-v12/v8.html#v8_v8_getheapsnapshot)。

如果工作线程不再运行（这可能发生在 [`'exit'` 事件](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_event_exit)触发之前），则返回的 `Promise` 将立即被使用 [`ERR_WORKER_NOT_RUNNING`](http://nodejs.cn/api-v12/errors.html#ERR_WORKER_NOT_RUNNING) 错误拒绝。

#### `worker.performance`[#](http://nodejs.cn/api-v12/worker_threads.html#workerperformance)

[中英对照](http://nodejs.cn/api-v12/worker_threads/worker_performance.html)

新增于: v12.22.0

可用于从工作线程实例查询性能信息的对象。 类似于[`perf_hooks.performance`](http://nodejs.cn/api-v12/worker_threads.html#perf_hooks.md#perf_hooks_perf_hooks_performance)。

##### `performance.eventLoopUtilization([utilization1[, utilization2]])`[#](http://nodejs.cn/api-v12/worker_threads.html#performanceeventlooputilizationutilization1-utilization2)

[中英对照](http://nodejs.cn/api-v12/worker_threads/performance_eventlooputilization_utilization1_utilization2.html)

新增于: v12.22.0

-   `utilization1` [<Object>](http://url.nodejs.cn/jzn6Ao) 上一次调用 `eventLoopUtilization()` 的结果。
-   `utilization2` [<Object>](http://url.nodejs.cn/jzn6Ao) 在 `utilization1` 之前调用 `eventLoopUtilization()` 的结果。
-   返回 [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `idle` [<number>](http://url.nodejs.cn/SXbo1v)
    -   `active` [<number>](http://url.nodejs.cn/SXbo1v)
    -   `utilization` [<number>](http://url.nodejs.cn/SXbo1v)

与 [`perf_hooks` `eventLoopUtilization()`](http://url.nodejs.cn/utFFex) 相同的调用，除了返回工作线程实例的值。

一个区别是，与主线程不同，工作线程内的引导是在事件循环内完成的。 因此，一旦工作线程的脚本开始执行，则事件循环利用率将立即可用。

不增加的 `idle` 时间并不表示工作线程卡在引导中。 下面的示例展示了工作线程的整个生命周期永远不会累积任何 `idle` 时间，但仍然能够处理消息。

```
const { Worker, isMainThread, parentPort } = require('worker_threads');

if (isMainThread) {
  const worker = new Worker(__filename);
  setInterval(() => {
    worker.postMessage('hi');
    console.log(worker.performance.eventLoopUtilization());
  }, 100).unref();
  return;
}

parentPort.on('message', () => console.log('msg')).unref();
(function r(n) {
  if (--n < 0) return;
  const t = Date.now();
  while (Date.now() - t < 300);
  setImmediate(r, n);
})(10);
```

工作线程的事件循环利用率仅在 [`'online'` 事件](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_event_online)触发后可用，如果在此之前或在 [`'exit'` 事件](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_event_exit)之后调用，则所有属性的值都为 `0`。

#### `worker.postMessage(value[, transferList])`[#](http://nodejs.cn/api-v12/worker_threads.html#workerpostmessagevalue-transferlist)

[中英对照](http://nodejs.cn/api-v12/worker_threads/worker_postmessage_value_transferlist.html)

新增于: v10.5.0

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   `transferList` [<Object\[\]>](http://url.nodejs.cn/jzn6Ao)

向将通过 [`require('worker_threads').parentPort.on('message')`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_event_message) 接收的工作线程发送消息。 有关详细信息，请参阅 [`port.postMessage()`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_port_postmessage_value_transferlist)。

#### `worker.ref()`[#](http://nodejs.cn/api-v12/worker_threads.html#workerref)

[中英对照](http://nodejs.cn/api-v12/worker_threads/worker_ref.html)

新增于: v10.5.0

与 `unref()` 相反，如果它是唯一剩下的活动句柄（默认行为），则在先前 `unref()` 的工作线程上调用 `ref()` 将不会让程序退出。 如果工作线程是 `ref()` 的，则再次调用 `ref()` 将不起作用。

#### `worker.resourceLimits`[#](http://nodejs.cn/api-v12/worker_threads.html#workerresourcelimits_1)

[中英对照](http://nodejs.cn/api-v12/worker_threads/worker_resourcelimits_1.html)

新增于: v12.16.0

-   [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `maxYoungGenerationSizeMb` [<number>](http://url.nodejs.cn/SXbo1v)
    -   `maxOldGenerationSizeMb` [<number>](http://url.nodejs.cn/SXbo1v)
    -   `codeRangeSizeMb` [<number>](http://url.nodejs.cn/SXbo1v)
    -   `stackSizeMb` [<number>](http://url.nodejs.cn/SXbo1v)

为此工作线程提供了一组 JS 引擎资源约束。 如果将 `resourceLimits` 选项传给 [`Worker`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_class_worker) 构造函数，则这与其值匹配。

如果工作线程已经停止，则返回值是空对象。

#### `worker.stderr`[#](http://nodejs.cn/api-v12/worker_threads.html#workerstderr)

[中英对照](http://nodejs.cn/api-v12/worker_threads/worker_stderr.html)

新增于: v10.5.0

-   [<stream.Readable>](http://nodejs.cn/api/stream.html#class-streamreadable)

这是包含工作线程内写入 [`process.stderr`](http://nodejs.cn/api-v12/process.html#process_process_stderr) 的数据的可读流。 如果 `stderr: true` 没有传给 [`Worker`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_class_worker) 构造函数，则数据将通过管道传输到父线程的 [`process.stderr`](http://nodejs.cn/api-v12/process.html#process_process_stderr) 流。

#### `worker.stdin`[#](http://nodejs.cn/api-v12/worker_threads.html#workerstdin)

[中英对照](http://nodejs.cn/api-v12/worker_threads/worker_stdin.html)

新增于: v10.5.0

-   [<null>](http://url.nodejs.cn/334hvC) | [<stream.Writable>](http://nodejs.cn/api/stream.html#class-streamwritable)

如果将 `stdin: true` 传给 [`Worker`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_class_worker) 构造函数，则这是可写流。 写入此流的数据将在工作线程中作为 [`process.stdin`](http://nodejs.cn/api-v12/process.html#process_process_stdin) 可用。

#### `worker.stdout`[#](http://nodejs.cn/api-v12/worker_threads.html#workerstdout)

[中英对照](http://nodejs.cn/api-v12/worker_threads/worker_stdout.html)

新增于: v10.5.0

-   [<stream.Readable>](http://nodejs.cn/api/stream.html#class-streamreadable)

这是包含工作线程内写入 [`process.stdout`](http://nodejs.cn/api-v12/process.html#process_process_stdout) 的数据的可读流。 如果 `stdout: true` 没有传给 [`Worker`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_class_worker) 构造函数，则数据将通过管道传输到父线程的 [`process.stdout`](http://nodejs.cn/api-v12/process.html#process_process_stdout) 流。

#### `worker.terminate()`[#](http://nodejs.cn/api-v12/worker_threads.html#workerterminate)

[中英对照](http://nodejs.cn/api-v12/worker_threads/worker_terminate.html)

-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

尽快停止工作线程中的所有 JavaScript 执行。 返回在触发 [`'exit'` 事件](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_event_exit)时履行退出码的 Promise。

#### `worker.threadId`[#](http://nodejs.cn/api-v12/worker_threads.html#workerthreadid_1)

[中英对照](http://nodejs.cn/api-v12/worker_threads/worker_threadid_1.html)

新增于: v10.5.0

-   [<integer>](http://url.nodejs.cn/SXbo1v)

引用线程的整数标识符。 在工作线程内部，它作为 [`require('worker_threads').threadId`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_worker_threadid) 可用。 此值对于单个进程中的每个 `Worker` 实例都是唯一的。

#### `worker.unref()`[#](http://nodejs.cn/api-v12/worker_threads.html#workerunref)

[中英对照](http://nodejs.cn/api-v12/worker_threads/worker_unref.html)

新增于: v10.5.0

如果这是事件系统中唯一的活动句柄，则在工作线程上调用 `unref()` 将允许线程退出。 如果工作线程已经 `unref()`，则再次调用 `unref()` 将无效。
