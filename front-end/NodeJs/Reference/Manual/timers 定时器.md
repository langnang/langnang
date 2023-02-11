---
created: 2022-07-29T13:12:53 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/timers.html
author: 
---

# timers 定时器 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/timers/timers.html)

**源代码:** [lib/timers.js](https://github.com/nodejs/node/blob/v12.22.12/lib/timers.js)

`timer` 模块暴露了一个全局的用于在未来某个时间点调用的调度函数的 API。 因为定时器函数是全局的，所以不需要调用 `require('timers')` 来使用该 API。

Node.js 中的定时器函数实现了与网络浏览器提供的定时器 API 类似的 API，但使用的是围绕 Node.js [事件循环](http://url.nodejs.cn/eeiBdr)构建的不同的内部实现。

### `Immediate` 类[#](http://nodejs.cn/api-v12/timers.html#class-immediate)

[中英对照](http://nodejs.cn/api-v12/timers/class_immediate.html)

此对象是在 [`setImmediate()`](http://nodejs.cn/api-v12/timers.html#timers_setimmediate_callback_args) 内部创建并返回。 它可以传给 [`clearImmediate()`](http://nodejs.cn/api-v12/timers.html#timers_clearimmediate_immediate) 以取消调度的行动。

默认情况下，当立即调度时，只要立即处于活动状态，则 Node.js 事件循环就会继续运行。 [`setImmediate()`](http://nodejs.cn/api-v12/timers.html#timers_setimmediate_callback_args) 返回的 `Immediate` 对象导出可用于控制此默认行为的 `immediate.ref()` 和 `immediate.unref()` 函数。

#### `immediate.hasRef()`[#](http://nodejs.cn/api-v12/timers.html#immediatehasref)

[中英对照](http://nodejs.cn/api-v12/timers/immediate_hasref.html)

新增于: v11.0.0

-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果为 true，则 `Immediate` 对象将使 Node.js 事件循环保持活动状态。

#### `immediate.ref()`[#](http://nodejs.cn/api-v12/timers.html#immediateref)

[中英对照](http://nodejs.cn/api-v12/timers/immediate_ref.html)

新增于: v9.7.0

-   返回: [<Immediate>](http://nodejs.cn/api/timers.html#class-immediate) `immediate` 的引用

调用时，只要 `Immediate` 处于活动状态，就请求 Node.js 事件循环不退出。 多次调用 `immediate.ref()` 将不起作用。

默认情况下，所有 `Immediate` 对象都被“引用”，这使得通常不需要调用 `immediate.ref()` 除非之前已经调用过 `immediate.unref()`。

#### `immediate.unref()`[#](http://nodejs.cn/api-v12/timers.html#immediateunref)

[中英对照](http://nodejs.cn/api-v12/timers/immediate_unref.html)

新增于: v9.7.0

-   返回: [<Immediate>](http://nodejs.cn/api/timers.html#class-immediate) `immediate` 的引用

调用时，活动的 `Immediate` 对象不需要 Node.js 事件循环保持活动状态。 如果没有其他活动保持事件循环运行，则进程可能会在调用 `Immediate` 对象的回调之前退出。 多次调用 `immediate.unref()` 将不起作用。

### `Timeout` 类[#](http://nodejs.cn/api-v12/timers.html#class-timeout)

[中英对照](http://nodejs.cn/api-v12/timers/class_timeout.html)

此对象是在 [`setTimeout()`](http://nodejs.cn/api-v12/timers.html#timers_settimeout_callback_delay_args) 和 [`setInterval()`](http://nodejs.cn/api-v12/timers.html#timers_setinterval_callback_delay_args) 内部创建并返回。 它可以传给 [`clearTimeout()`](http://nodejs.cn/api-v12/timers.html#timers_cleartimeout_timeout) 或 [`clearInterval()`](http://nodejs.cn/api-v12/timers.html#timers_clearinterval_timeout) 以取消调度的行动。

默认情况下，当使用 [`setTimeout()`](http://nodejs.cn/api-v12/timers.html#timers_settimeout_callback_delay_args) 或 [`setInterval()`](http://nodejs.cn/api-v12/timers.html#timers_setinterval_callback_delay_args) 调度定时器时，只要定时器处于活动状态，则 Node.js 事件循环就会继续运行。 这些函数返回的每个 `Timeout` 对象都导出可用于控制此默认行为的 `timeout.ref()` 和 `timeout.unref()` 函数。

#### `timeout.hasRef()`[#](http://nodejs.cn/api-v12/timers.html#timeouthasref)

[中英对照](http://nodejs.cn/api-v12/timers/timeout_hasref.html)

新增于: v11.0.0

-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果为 true，则 `Timeout` 对象将使 Node.js 事件循环保持活动状态。

#### `timeout.ref()`[#](http://nodejs.cn/api-v12/timers.html#timeoutref)

[中英对照](http://nodejs.cn/api-v12/timers/timeout_ref.html)

新增于: v0.9.1

-   返回: [<Timeout>](http://nodejs.cn/api/timers.html#class-timeout) `timeout` 的引用

调用时，只要 `Timeout` 处于活动状态，就请求 Node.js 事件循环不退出。 多次调用 `timeout.ref()` 将不起作用。

默认情况下，所有 `Timeout` 对象都被“引用”，这使得通常不需要调用 `timeout.ref()` 除非之前已经调用过 `timeout.unref()`。

#### `timeout.refresh()`[#](http://nodejs.cn/api-v12/timers.html#timeoutrefresh)

[中英对照](http://nodejs.cn/api-v12/timers/timeout_refresh.html)

新增于: v10.2.0

-   返回: [<Timeout>](http://nodejs.cn/api/timers.html#class-timeout) `timeout` 的引用

将定时器的开始时间设置为当前时间，并重新调度定时器在调整为当前时间的先前指定的时长调用其回调。 这对于在不分配新的 JavaScript 对象的情况下刷新定时器很有用。

在已经调用其回调的定时器上使用它会重新激活定时器。

#### `timeout.unref()`[#](http://nodejs.cn/api-v12/timers.html#timeoutunref)

[中英对照](http://nodejs.cn/api-v12/timers/timeout_unref.html)

新增于: v0.9.1

-   返回: [<Timeout>](http://nodejs.cn/api/timers.html#class-timeout) `timeout` 的引用

调用时，活动的 `Timeout` 对象不需要 Node.js 事件循环保持活动状态。 如果没有其他活动保持事件循环运行，则进程可能会在调用 `Timeout` 对象的回调之前退出。 多次调用 `timeout.unref()` 将不起作用。

调用 `timeout.unref()` 创建内部的定时器，其将唤醒 Node.js 事件循环。 创建过多的这些会对 Node.js 应用程序的性能产生不利影响。

#### `timeout[Symbol.toPrimitive]()`[#](http://nodejs.cn/api-v12/timers.html#timeoutsymboltoprimitive)

[中英对照](http://nodejs.cn/api-v12/timers/timeout_symbol_toprimitive.html)

新增于: v12.19.0

-   返回: [<integer>](http://url.nodejs.cn/SXbo1v) 可用于引用此 `timeout` 的数字

将 `Timeout` 强制为原始类型。 该原始类型可用于清除 `Timeout`。 该原始类型只能在创建超时的同一线程中使用。 因此，要在 [`worker_threads`](http://nodejs.cn/api-v12/worker_threads.html) 上使用它，则必须首先将其传给正确的线程。 这允许增强与浏览器 `setTimeout()` 和 `setInterval()` 实现的兼容性。

### 调度定时器[#](http://nodejs.cn/api-v12/timers.html#scheduling-timers)

[中英对照](http://nodejs.cn/api-v12/timers/scheduling_timers.html)

Node.js 中的定时器是一种会在一段时间后调用给定函数的内部构造。 定时器函数的调用时间取决于用于创建定时器的方法以及 Node.js 事件循环正在执行的其他工作。

#### `setImmediate(callback[, ...args])`[#](http://nodejs.cn/api-v12/timers.html#setimmediatecallback-args)

[中英对照](http://nodejs.cn/api-v12/timers/setimmediate_callback_args.html)

新增于: v0.9.1

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 在本轮 Node.js [事件循环](http://url.nodejs.cn/eeiBdr)结束时调用的函数
-   `...args` [<any>](http://url.nodejs.cn/6sTGdS) 调用 `callback` 时要传入的可选参数。
-   返回: [<Immediate>](http://nodejs.cn/api/timers.html#class-immediate) 用于 [`clearImmediate()`](http://nodejs.cn/api-v12/timers.html#timers_clearimmediate_immediate)

在 I/O 事件的回调之后调度 `callback` 的“立即”执行。

当多次调用 `setImmediate()` 时，则 `callback` 函数会按照它们的创建顺序排队执行。 每次事件循环迭代都会处理整个回调队列。 如果立即定时器从正在执行的回调中排队，则直到下一次事件循环迭代才会触发该定时器。

如果 `callback` 不是函数，则将抛出 [`TypeError`](http://nodejs.cn/api-v12/errors.html#errors_class_typeerror)。

此方法具有可使用 [`util.promisify()`](http://nodejs.cn/api-v12/util.html#util_util_promisify_original) 获得的 promise 的自定义变体。

```
const util = require('util');
const setImmediatePromise = util.promisify(setImmediate);

setImmediatePromise('foobar').then((value) => {
  // value === 'foobar'（传入的值是可选的）
  // 这是在所有 I/O 回调之后执行的。
});

// 或者使用异步函数
async function timerExample() {
  console.log('Before I/O callbacks');
  await setImmediatePromise();
  console.log('After I/O callbacks');
}
timerExample();
```

#### `setInterval(callback, delay[, ...args])`[#](http://nodejs.cn/api-v12/timers.html#setintervalcallback-delay-args)

[中英对照](http://nodejs.cn/api-v12/timers/setinterval_callback_delay_args.html)

新增于: v0.0.1

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 当定时器结束时调用的函数。
-   `delay` [<number>](http://url.nodejs.cn/SXbo1v) 调用 `callback` 之前等待的毫秒数。
-   `...args` [<any>](http://url.nodejs.cn/6sTGdS) 调用 `callback` 时要传入的可选参数。
-   返回: [<Timeout>](http://nodejs.cn/api/timers.html#class-timeout) 用于 [`clearInterval()`](http://nodejs.cn/api-v12/timers.html#timers_clearinterval_timeout)

每 `delay` 毫秒调度重复执行 `callback`。

当 `delay` 大于 `2147483647` 或小于 `1` 时，则 `delay` 将设置为 `1`。 非整数延迟被截断为整数。

如果 `callback` 不是函数，则将抛出 [`TypeError`](http://nodejs.cn/api-v12/errors.html#errors_class_typeerror)。

#### `setTimeout(callback, delay[, ...args])`[#](http://nodejs.cn/api-v12/timers.html#settimeoutcallback-delay-args)

[中英对照](http://nodejs.cn/api-v12/timers/settimeout_callback_delay_args.html)

新增于: v0.0.1

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 当定时器结束时调用的函数。
-   `delay` [<number>](http://url.nodejs.cn/SXbo1v) 调用 `callback` 之前等待的毫秒数。
-   `...args` [<any>](http://url.nodejs.cn/6sTGdS) 调用 `callback` 时要传入的可选参数。
-   返回: [<Timeout>](http://nodejs.cn/api/timers.html#class-timeout) 用于 [`clearTimeout()`](http://nodejs.cn/api-v12/timers.html#timers_cleartimeout_timeout)

在 `delay` 毫秒后调度单次的 `callback` 的执行。

`callback` 可能不会在精确的 `delay` 毫秒内被调用。 Node.js 不保证回调将触发的确切时间，也不保证它们的顺序。 回调将在尽可能接近指定的时间时调用。

当 `delay` 大于 `2147483647` 或小于 `1` 时，则 `delay` 将设置为 `1`。 非整数延迟被截断为整数。

如果 `callback` 不是函数，则将抛出 [`TypeError`](http://nodejs.cn/api-v12/errors.html#errors_class_typeerror)。

此方法具有可使用 [`util.promisify()`](http://nodejs.cn/api-v12/util.html#util_util_promisify_original) 获得的 promise 的自定义变体。

```
const util = require('util');
const setTimeoutPromise = util.promisify(setTimeout);

setTimeoutPromise(40, 'foobar').then((value) => {
  // value === 'foobar'（传入的值是可选的）
  // 这是在大约 40 毫秒后执行的。
});
```

### 取消定时器[#](http://nodejs.cn/api-v12/timers.html#cancelling-timers)

[中英对照](http://nodejs.cn/api-v12/timers/cancelling_timers.html)

[`setImmediate()`](http://nodejs.cn/api-v12/timers.html#timers_setimmediate_callback_args)、[`setInterval()`](http://nodejs.cn/api-v12/timers.html#timers_setinterval_callback_delay_args) 和 [`setTimeout()`](http://nodejs.cn/api-v12/timers.html#timers_settimeout_callback_delay_args) 方法各自返回表示调度的定时器的对象。 这些可用于取消定时器并防止其触发。

#### `clearImmediate(immediate)`[#](http://nodejs.cn/api-v12/timers.html#clearimmediateimmediate)

[中英对照](http://nodejs.cn/api-v12/timers/clearimmediate_immediate.html)

新增于: v0.9.1

-   `immediate` [<Immediate>](http://nodejs.cn/api/timers.html#class-immediate) [`setImmediate()`](http://nodejs.cn/api-v12/timers.html#timers_setimmediate_callback_args) 返回的 `Immediate` 对象。

取消由 [`setImmediate()`](http://nodejs.cn/api-v12/timers.html#timers_setimmediate_callback_args) 创建的 `Immediate` 对象。

#### `clearInterval(timeout)`[#](http://nodejs.cn/api-v12/timers.html#clearintervaltimeout)

[中英对照](http://nodejs.cn/api-v12/timers/clearinterval_timeout.html)

新增于: v0.0.1

-   `timeout` [<Timeout>](http://nodejs.cn/api/timers.html#class-timeout)

取消由 [`setInterval()`](http://nodejs.cn/api-v12/timers.html#timers_setinterval_callback_delay_args) 创建的 `Timeout` 对象。

#### `clearTimeout(timeout)`[#](http://nodejs.cn/api-v12/timers.html#cleartimeouttimeout)

[中英对照](http://nodejs.cn/api-v12/timers/cleartimeout_timeout.html)

新增于: v0.0.1

-   `timeout` [<Timeout>](http://nodejs.cn/api/timers.html#class-timeout)

取消由 [`setTimeout()`](http://nodejs.cn/api-v12/timers.html#timers_settimeout_callback_delay_args) 创建的 `Timeout` 对象。
