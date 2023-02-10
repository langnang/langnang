---
created: 2022-07-29T13:12:54 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/perf_hooks.html
author: 
---

# perf_hooks 性能钩子 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/perf_hooks/performance_measurement_apis.html)

**源代码:** [lib/perf\_hooks.js](https://github.com/nodejs/node/blob/v12.22.12/lib/perf_hooks.js)

此模块提供了 W3C [Web 性能 API](http://url.nodejs.cn/YVxQCq) 子集的实现，以及用于 Node.js 特定性能测量的其他 API。

Node.js 支持以下的 [Web 性能 API](http://url.nodejs.cn/YVxQCq)：

-   [高解析度时间](http://url.nodejs.cn/ZNcM3v)
-   [性能时间轴](http://url.nodejs.cn/ds56gw)
-   [用户计时](http://url.nodejs.cn/j6SkJP)

```
const { PerformanceObserver, performance } = require('perf_hooks');

const obs = new PerformanceObserver((items) => {
  console.log(items.getEntries()[0].duration);
  performance.clearMarks();
});
obs.observe({ entryTypes: ['measure'] });
performance.measure('Start to Now');

performance.mark('A');
doSomeLongRunningProcess(() => {
  performance.measure('A to Now', 'A');

  performance.mark('B');
  performance.measure('A to B', 'A', 'B');
});
```

### `perf_hooks.performance`[#](http://nodejs.cn/api-v12/perf_hooks.html#perf_hooksperformance)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/perf_hooks_performance.html)

新增于: v8.5.0

可用于从当前 Node.js 实例收集性能指标的对象。 类似于浏览器中的 [`window.performance`](http://url.nodejs.cn/WnJqii)。

#### `performance.clearMarks([name])`[#](http://nodejs.cn/api-v12/perf_hooks.html#performanceclearmarksname)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performance_clearmarks_name.html)

新增于: v8.5.0

-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)

如果未提供 `name`，则从性能时间轴中删除所有 `PerformanceMark` 对象。 如果提供了 `name`，则仅删除命名标记。

#### `performance.eventLoopUtilization([utilization1[, utilization2]])`[#](http://nodejs.cn/api-v12/perf_hooks.html#performanceeventlooputilizationutilization1-utilization2)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performance_eventlooputilization_utilization1_utilization2.html)

新增于: v14.10.0, v12.19.0

-   `utilization1` [<Object>](http://url.nodejs.cn/jzn6Ao) 上一次调用 `eventLoopUtilization()` 的结果。
-   `utilization2` [<Object>](http://url.nodejs.cn/jzn6Ao) 在 `utilization1` 之前调用 `eventLoopUtilization()` 的结果。
-   返回 [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `idle` [<number>](http://url.nodejs.cn/SXbo1v)
    -   `active` [<number>](http://url.nodejs.cn/SXbo1v)
    -   `utilization` [<number>](http://url.nodejs.cn/SXbo1v)

`eventLoopUtilization()` 方法返回包含事件循环作为高解析度毫秒计时器的既空闲又活动的累积持续时间的对象。 `utilization` 值是计算的事件循环利用率 (ELU)。

如果主线程上的引导尚未完成，则属性的值为 `0`。 由于引导发生在事件循环内，所以 ELU 立即在[工作线程](http://url.nodejs.cn/6jQc84)上可用。

`utilization1` 和 `utilization2` 都是可选参数。

如果传入了 `utilization1`，则计算当前调用的 `active` 和 `idle` 之间的差值，以及对应的 `utilization` 值(类似于 [`process.hrtime()`](http://nodejs.cn/api-v12/process.html#process_process_hrtime_time))。

如果传入了 `utilization1` 和 `utilization2`，则计算两个参数之间的增量。 这是便捷的选项，因为与 [`process.hrtime()`](http://nodejs.cn/api-v12/process.html#process_process_hrtime_time) 不同，计算 ELU 比单个减法更复杂。

ELU 类似于 CPU 使用率，不同之处在于它只测量事件循环统计信息而不是 CPU 使用率。 它表示事件循环在事件循环的事件提供者（例如 `epoll_wait`）之外花费的时间百分比。 不考虑其他 CPU 空闲时间。 以下是主要空闲进程如何具有高 ELU 的示例。

```
'use strict';
const { eventLoopUtilization } = require('perf_hooks').performance;
const { spawnSync } = require('child_process');

setImmediate(() => {
  const elu = eventLoopUtilization();
  spawnSync('sleep', ['5']);
  console.log(eventLoopUtilization(elu).utilization);
});
```

虽然运行这个脚本时 CPU 大部分是空闲的，但 `utilization` 的值为 `1`。 这是因为对 [`child_process.spawnSync()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawnsync_command_args_options) 的调用阻止了事件循环的进行。

传入用户定义的对象而不是先前调用 `eventLoopUtilization()` 的结果将导致未定义的行为。 不保证返回值反映事件循环的任何正确状态。

#### `performance.mark([name])`[#](http://nodejs.cn/api-v12/perf_hooks.html#performancemarkname)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performance_mark_name.html)

新增于: v8.5.0

-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)

在性能时间轴中创建新的 `PerformanceMark` 条目。 `PerformanceMark` 是 `PerformanceEntry` 的子类，其 `performanceEntry.entryType` 始终为 `'mark'`，而其 `performanceEntry.duration` 始终为 `0`。 性能标记用于标记性能时间轴中的特定重要时刻。

#### `performance.measure(name[, startMark[, endMark]])`[#](http://nodejs.cn/api-v12/perf_hooks.html#performancemeasurename-startmark-endmark)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performance_measure_name_startmark_endmark.html)

-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `startMark` [<string>](http://url.nodejs.cn/9Tw2bK) 可选的。
-   `endMark` [<string>](http://url.nodejs.cn/9Tw2bK) 可选的。

在性能时间轴中创建新的 `PerformanceMeasure` 条目。 `PerformanceMeasure` 是 `PerformanceEntry` 的子类，其 `performanceEntry.entryType` 始终为 `'measure'`，其 `performanceEntry.duration` 测量自 `startMark` 和 `endMark` 以来经过的毫秒数。

`startMark` 参数可以标识性能时间轴中的任何现有的 `PerformanceMark`，或者可能标识由 `PerformanceNodeTiming` 类提供的任何时间戳属性。 如果命名的 `startMark` 不存在，则默认情况下将 `startMark` 设置为 [`timeOrigin`](http://url.nodejs.cn/WSrFaU)。

可选的 `endMark` 参数必须标识性能时间轴中的任何现有的 `PerformanceMark` 或 `PerformanceNodeTiming` 类提供的任何时间戳属性。 不传入参数则 `endMark` 为 `performance.now()`，否则如果命名的 `endMark` 不存在，则抛出错误。

#### `performance.nodeTiming`[#](http://nodejs.cn/api-v12/perf_hooks.html#performancenodetiming)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performance_nodetiming.html)

新增于: v8.5.0

-   [<PerformanceNodeTiming>](http://nodejs.cn/api/perf_hooks.html#class-performancenodetiming)

_此属性是 Node.js 的扩展。 它在 Web 浏览器中不可用。_

`PerformanceNodeTiming` 类的实例，为特定的 Node.js 操作里程碑提供性能指标。

#### `performance.now()`[#](http://nodejs.cn/api-v12/perf_hooks.html#performancenow)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performance_now.html)

新增于: v8.5.0

-   返回: [<number>](http://url.nodejs.cn/SXbo1v)

返回当前的高解析度毫秒时间戳，其中 0 表示当前的 `node` 进程的开始。

#### `performance.timeOrigin`[#](http://nodejs.cn/api-v12/perf_hooks.html#performancetimeorigin)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performance_timeorigin.html)

新增于: v8.5.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

[`timeOrigin`](http://url.nodejs.cn/WSrFaU) 指定了当前的 `node` 进程开始的高解析度毫秒时间戳，以 Unix 时间度量。

#### `performance.timerify(fn)`[#](http://nodejs.cn/api-v12/perf_hooks.html#performancetimerifyfn)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performance_timerify_fn.html)

新增于: v8.5.0

-   `fn` [<Function>](http://url.nodejs.cn/ceTQa6)

_此属性是 Node.js 的扩展。 它在 Web 浏览器中不可用。_

将函数封装在测量被封装函数运行时间的新函数中。 `PerformanceObserver` 必须订阅 `'function'` 事件类型才能访问时间细节。

```
const {
  performance,
  PerformanceObserver
} = require('perf_hooks');

function someFunction() {
  console.log('hello world');
}

const wrapped = performance.timerify(someFunction);

const obs = new PerformanceObserver((list) => {
  console.log(list.getEntries()[0].duration);
  obs.disconnect();
});
obs.observe({ entryTypes: ['function'] });

// 将创建性能时间轴条目
wrapped();
```

#### `performance.eventLoopUtilization([util1][,util2])`[#](http://nodejs.cn/api-v12/perf_hooks.html#performanceeventlooputilizationutil1util2)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performance_eventlooputilization_util1_util2.html)

新增于: v12.19.0

-   `util1` [<Object>](http://url.nodejs.cn/jzn6Ao) 先前调用 `eventLoopUtilization()` 的结果
-   `util2` [<Object>](http://url.nodejs.cn/jzn6Ao)
-   返回 [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `idle` [<number>](http://url.nodejs.cn/SXbo1v)
    -   `active` [<number>](http://url.nodejs.cn/SXbo1v)
    -   `utilization` [<number>](http://url.nodejs.cn/SXbo1v)

`eventLoopUtilization()` 方法返回包含事件循环作为高解析度毫秒计时器的既空闲又活动的累积持续时间的对象。 `utilization` 值是计算的事件循环利用率 (ELU)。

它表示事件循环在事件循环的事件提供者（例如 `epoll_wait`）之外花费的时间百分比。 不考虑其他 CPU 空闲时间。 以下是主要空闲进程如何具有高 ELU 的示例。

```
'use strict';
const { eventLoopUtilization } = require('perf_hooks').performance;
const { spawnSync } = require('child_process');

setImmediate(() => {
  const elu = eventLoopUtilization();
  spawnSync('sleep', ['5']);
  console.log(eventLoopUtilization(elu).utilization);
});
```

这是因为对 [`child_process.spawnSync()`](http://nodejs.cn/api-v12/child_process.html#child_process_child_process_spawnsync_command_args_options) 的调用阻止了事件循环的进行。

传入用户定义的对象而不是先前调用 `eventLoopUtilization()` 的结果将导致未定义的行为。 不保证返回值反映事件循环的任何正确状态。

### `PerformanceEntry` 类[#](http://nodejs.cn/api-v12/perf_hooks.html#class-performanceentry)

新增于: v8.5.0

#### `performanceEntry.duration`[#](http://nodejs.cn/api-v12/perf_hooks.html#performanceentryduration)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performanceentry_duration.html)

新增于: v8.5.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

此条目经过的总毫秒数。 此值对所有性能条目类型都没有意义。

#### `performanceEntry.name`[#](http://nodejs.cn/api-v12/perf_hooks.html#performanceentryname)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performanceentry_name.html)

新增于: v8.5.0

-   [<string>](http://url.nodejs.cn/9Tw2bK)

性能条目的名称。

#### `performanceEntry.startTime`[#](http://nodejs.cn/api-v12/perf_hooks.html#performanceentrystarttime)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performanceentry_starttime.html)

新增于: v8.5.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

标记性能条目开始时间的高解析度毫秒时间戳。

#### `performanceEntry.entryType`[#](http://nodejs.cn/api-v12/perf_hooks.html#performanceentryentrytype)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performanceentry_entrytype.html)

新增于: v8.5.0

-   [<string>](http://url.nodejs.cn/9Tw2bK)

性能条目的类型。 它可能是以下之一：

-   `'node'`（仅限 Node.js）
-   `'mark'`（在 Web 上可用）
-   `'measure'`（在 Web 上可用）
-   `'gc'`（仅限 Node.js）
-   `'function'`（仅限 Node.js）
-   `'http2'`（仅限 Node.js）
-   `'http'`（仅限 Node.js）

#### `performanceEntry.kind`[#](http://nodejs.cn/api-v12/perf_hooks.html#performanceentrykind)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performanceentry_kind.html)

新增于: v8.5.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

_此属性是 Node.js 的扩展。 它在 Web 浏览器中不可用。_

当 `performanceEntry.entryType` 等于 `'gc'` 时，则 `performance.kind` 属性标识发生的垃圾收集操作的类型。 该值可能是以下之一：

-   `perf_hooks.constants.NODE_PERFORMANCE_GC_MAJOR`
-   `perf_hooks.constants.NODE_PERFORMANCE_GC_MINOR`
-   `perf_hooks.constants.NODE_PERFORMANCE_GC_INCREMENTAL`
-   `perf_hooks.constants.NODE_PERFORMANCE_GC_WEAKCB`

#### performanceEntry.flags[#](http://nodejs.cn/api-v12/perf_hooks.html#performanceentryflags)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performanceentry_flags.html)

新增于: v12.17.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

_此属性是 Node.js 的扩展。 它在 Web 浏览器中不可用。_

当 `performanceEntry.entryType` 等于 `'gc'` 时，则 `performance.flags` 属性包含有关垃圾收集操作的附加信息。 该值可能是以下之一：

-   `perf_hooks.constants.NODE_PERFORMANCE_GC_FLAGS_NO`
-   `perf_hooks.constants.NODE_PERFORMANCE_GC_FLAGS_CONSTRUCT_RETAINED`
-   `perf_hooks.constants.NODE_PERFORMANCE_GC_FLAGS_FORCED`
-   `perf_hooks.constants.NODE_PERFORMANCE_GC_FLAGS_SYNCHRONOUS_PHANTOM_PROCESSING`
-   `perf_hooks.constants.NODE_PERFORMANCE_GC_FLAGS_ALL_AVAILABLE_GARBAGE`
-   `perf_hooks.constants.NODE_PERFORMANCE_GC_FLAGS_ALL_EXTERNAL_MEMORY`
-   `perf_hooks.constants.NODE_PERFORMANCE_GC_FLAGS_SCHEDULE_IDLE`

### `PerformanceNodeTiming extends PerformanceEntry` 类[#](http://nodejs.cn/api-v12/perf_hooks.html#class-performancenodetiming-extends-performanceentry)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/class_performancenodetiming_extends_performanceentry.html)

新增于: v8.5.0

_此属性是 Node.js 的扩展。 它在 Web 浏览器中不可用。_

为 Node.js 本身提供计时细节。 此类的构造函数不会暴露给用户。

#### `performanceNodeTiming.bootstrapComplete`[#](http://nodejs.cn/api-v12/perf_hooks.html#performancenodetimingbootstrapcomplete)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performancenodetiming_bootstrapcomplete.html)

新增于: v8.5.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

Node.js 进程完成引导的高解析度毫秒时间戳。 如果引导尚未完成，则该属性的值为 -1。

#### `performanceNodeTiming.environment`[#](http://nodejs.cn/api-v12/perf_hooks.html#performancenodetimingenvironment)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performancenodetiming_environment.html)

新增于: v8.5.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

Node.js 环境初始化的高解析度毫秒时间戳。

#### `performanceNodeTiming.loopExit`[#](http://nodejs.cn/api-v12/perf_hooks.html#performancenodetimingloopexit)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performancenodetiming_loopexit.html)

新增于: v8.5.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

Node.js 事件循环退出时的高解析度毫秒时间戳。 如果事件循环尚未退出，则该属性的值为 -1。 它只能在 [`'exit'`](http://nodejs.cn/api-v12/process.html#process_event_exit) 事件的句柄中具有非 -1 的值。

#### `performanceNodeTiming.loopStart`[#](http://nodejs.cn/api-v12/perf_hooks.html#performancenodetimingloopstart)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performancenodetiming_loopstart.html)

新增于: v8.5.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

Node.js 事件循环开始的高解析度毫秒时间戳。 如果事件循环尚未开始（例如，在主脚本的第一个滴答中），则该属性的值为 -1。

#### `performanceNodeTiming.nodeStart`[#](http://nodejs.cn/api-v12/perf_hooks.html#performancenodetimingnodestart)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performancenodetiming_nodestart.html)

新增于: v8.5.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

Node.js 进程初始化的高解析度毫秒时间戳。

#### `performanceNodeTiming.v8Start`[#](http://nodejs.cn/api-v12/perf_hooks.html#performancenodetimingv8start)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performancenodetiming_v8start.html)

新增于: v8.5.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

V8 平台初始化的高解析度毫秒时间戳。

#### `performanceNodeTiming.idleTime`[#](http://nodejs.cn/api-v12/perf_hooks.html#performancenodetimingidletime)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performancenodetiming_idletime.html)

新增于: v12.19.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

事件循环在事件循环的事件提供者（例如 `epoll_wait`）中空闲的时间量的高解析度毫秒时间戳。 这不考虑 CPU 使用率。 如果事件循环尚未开始（例如，在主脚本的第一个滴答中），则该属性的值为 0。

### `perf_hooks.PerformanceObserver` 类[#](http://nodejs.cn/api-v12/perf_hooks.html#class-perf_hooksperformanceobserver)

#### `new PerformanceObserver(callback)`[#](http://nodejs.cn/api-v12/perf_hooks.html#new-performanceobservercallback)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/new_performanceobserver_callback.html)

新增于: v8.5.0

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `list` [<PerformanceObserverEntryList>](http://nodejs.cn/api/perf_hooks.html#class-performanceobserverentrylist)
    -   `observer` [<PerformanceObserver>](http://nodejs.cn/api/perf_hooks.html#class-perf_hooksperformanceobserver)

当新的 `PerformanceEntry` 实例被添加到性能时间线时，则 `PerformanceObserver` 对象会提供通知。

```
const {
  performance,
  PerformanceObserver
} = require('perf_hooks');

const obs = new PerformanceObserver((list, observer) => {
  console.log(list.getEntries());
  observer.disconnect();
});
obs.observe({ entryTypes: ['mark'], buffered: true });

performance.mark('test');
```

因为 `PerformanceObserver` 实例引入了它们自己的额外性能开销，实例不应无限期地订阅通知。 一旦不再需要观察者，则用户应立即断开观察者的连接。

当 `PerformanceObserver` 接收到有关新的 `PerformanceEntry` 实例的通知时，则会调用 `callback`。 回调接收到 `PerformanceObserverEntryList` 实例和对 `PerformanceObserver` 的引用。

#### `performanceObserver.disconnect()`[#](http://nodejs.cn/api-v12/perf_hooks.html#performanceobserverdisconnect)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performanceobserver_disconnect.html)

新增于: v8.5.0

断开 `PerformanceObserver` 实例与所有通知的连接。

#### `performanceObserver.observe(options)`[#](http://nodejs.cn/api-v12/perf_hooks.html#performanceobserverobserveoptions)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performanceobserver_observe_options.html)

新增于: v8.5.0

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `entryTypes` [<string\[\]>](http://url.nodejs.cn/9Tw2bK) 标识观察者感兴趣的 `PerformanceEntry` 实例类型的字符串数组。 如果未提供，将抛出错误。
    -   `buffered` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 true，则通知回调将使用 `setImmediate()` 调用，多个 `PerformanceEntry` 实例通知将在内部缓冲。 如果为 `false`，则通知将是即时和同步的。 **默认值:** `false`。

为 `PerformanceObserver` 实例订阅由 `options.entryTypes` 标识的新 `PerformanceEntry` 实例的通知。

当 `options.buffered` 为 `false` 时，则 `callback` 会为每个 `PerformanceEntry` 实例调用一次：

```
const {
  performance,
  PerformanceObserver
} = require('perf_hooks');

const obs = new PerformanceObserver((list, observer) => {
  // 同步地调用 3 次。`list` 包含一项。
});
obs.observe({ entryTypes: ['mark'] });

for (let n = 0; n < 3; n++)
  performance.mark(`test${n}`);
```

```
const {
  performance,
  PerformanceObserver
} = require('perf_hooks');

const obs = new PerformanceObserver((list, observer) => {
  // 调用一次。`list` 包含三个条目。
});
obs.observe({ entryTypes: ['mark'], buffered: true });

for (let n = 0; n < 3; n++)
  performance.mark(`test${n}`);
```

### `PerformanceObserverEntryList` 类[#](http://nodejs.cn/api-v12/perf_hooks.html#class-performanceobserverentrylist)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/class_performanceobserverentrylist.html)

新增于: v8.5.0

`PerformanceObserverEntryList` 类用于提供对传给 `PerformanceObserver` 的 `PerformanceEntry` 实例的访问。 此类的构造函数不会暴露给用户。

#### `performanceObserverEntryList.getEntries()`[#](http://nodejs.cn/api-v12/perf_hooks.html#performanceobserverentrylistgetentries)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performanceobserverentrylist_getentries.html)

新增于: v8.5.0

-   返回: [<PerformanceEntry\[\]>](http://nodejs.cn/api/perf_hooks.html#class-performanceentry)

返回 `PerformanceEntry` 对象的列表，按照相对于 `performanceEntry.startTime` 的时间顺序排列。

#### `performanceObserverEntryList.getEntriesByName(name[, type])`[#](http://nodejs.cn/api-v12/perf_hooks.html#performanceobserverentrylistgetentriesbynamename-type)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performanceobserverentrylist_getentriesbyname_name_type.html)

新增于: v8.5.0

-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `type` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<PerformanceEntry\[\]>](http://nodejs.cn/api/perf_hooks.html#class-performanceentry)

返回按时间顺序的 `PerformanceEntry` 对象列表，其中 `performanceEntry.startTime` 的 `performanceEntry.name` 等于 `name`，并且可选地，其 `performanceEntry.entryType` 等于 `type`。

#### `performanceObserverEntryList.getEntriesByType(type)`[#](http://nodejs.cn/api-v12/perf_hooks.html#performanceobserverentrylistgetentriesbytypetype)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/performanceobserverentrylist_getentriesbytype_type.html)

新增于: v8.5.0

-   `type` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<PerformanceEntry\[\]>](http://nodejs.cn/api/perf_hooks.html#class-performanceentry)

返回按时间顺序排列的 `PerformanceEntry` 对象列表，其中 `performanceEntry.startTime` 的 `performanceEntry.entryType` 等于 `type`。

### `perf_hooks.monitorEventLoopDelay([options])`[#](http://nodejs.cn/api-v12/perf_hooks.html#perf_hooksmonitoreventloopdelayoptions)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/perf_hooks_monitoreventloopdelay_options.html)

新增于: v11.10.0

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `resolution` [<number>](http://url.nodejs.cn/SXbo1v) 以毫秒为单位的采样率。 必须大于零。 **默认值:** `10`。
-   返回: [<Histogram>](http://nodejs.cn/api/perf_hooks.html#class-histogram)

_此属性是 Node.js 的扩展。 它在 Web 浏览器中不可用。_

延迟将以纳秒为单位报告。

使用计时器来检测近似的事件循环延迟是有效的，因为计时器的执行与 libuv 事件循环的生命周期特别相关。 也就是说，循环中的延迟会导致计时器执行的延迟，而这些延迟正是此 API 旨在检测的。

```
const { monitorEventLoopDelay } = require('perf_hooks');
const h = monitorEventLoopDelay({ resolution: 20 });
h.enable();
// 做点什么。
h.disable();
console.log(h.min);
console.log(h.max);
console.log(h.mean);
console.log(h.stddev);
console.log(h.percentiles);
console.log(h.percentile(50));
console.log(h.percentile(99));
```

#### `Histogram` 类[#](http://nodejs.cn/api-v12/perf_hooks.html#class-histogram)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/class_histogram.html)

新增于: v11.10.0

_此属性是 Node.js 的扩展。 它在 Web 浏览器中不可用。_

##### `histogram.disable()`[#](http://nodejs.cn/api-v12/perf_hooks.html#histogramdisable)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/histogram_disable.html)

新增于: v11.10.0

-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果计时器被停止，则返回 `true`，如果已被停止，则返回 `false`。

##### `histogram.enable()`[#](http://nodejs.cn/api-v12/perf_hooks.html#histogramenable)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/histogram_enable.html)

新增于: v11.10.0

-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果计时器被启动，则返回 `true`，如果已被启动，则返回 `false`。

##### `histogram.exceeds`[#](http://nodejs.cn/api-v12/perf_hooks.html#histogramexceeds)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/histogram_exceeds.html)

新增于: v11.10.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

事件循环延迟超过最大 1 小时事件循环延迟阈值的次数。

##### `histogram.max`[#](http://nodejs.cn/api-v12/perf_hooks.html#histogrammax)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/histogram_max.html)

新增于: v11.10.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

记录的事件循环延迟的最大值。

##### `histogram.mean`[#](http://nodejs.cn/api-v12/perf_hooks.html#histogrammean)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/histogram_mean.html)

新增于: v11.10.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

记录的事件循环延迟的平均值。

##### `histogram.min`[#](http://nodejs.cn/api-v12/perf_hooks.html#histogrammin)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/histogram_min.html)

新增于: v11.10.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

记录的事件循环延迟的最小值。

##### `histogram.percentile(percentile)`[#](http://nodejs.cn/api-v12/perf_hooks.html#histogrampercentilepercentile)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/histogram_percentile_percentile.html)

新增于: v11.10.0

-   `percentile` [<number>](http://url.nodejs.cn/SXbo1v)
-   返回: [<number>](http://url.nodejs.cn/SXbo1v)

返回给定的百分位数的值。

##### `histogram.percentiles`[#](http://nodejs.cn/api-v12/perf_hooks.html#histogrampercentiles)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/histogram_percentiles.html)

新增于: v11.10.0

-   [<Map>](http://url.nodejs.cn/EnuJtG)

返回详细说明累积的百分位分布的 `Map` 对象。

##### `histogram.reset()`[#](http://nodejs.cn/api-v12/perf_hooks.html#histogramreset)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/histogram_reset.html)

新增于: v11.10.0

重置收集的直方图数据。

##### `histogram.stddev`[#](http://nodejs.cn/api-v12/perf_hooks.html#histogramstddev)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/histogram_stddev.html)

新增于: v11.10.0

-   [<number>](http://url.nodejs.cn/SXbo1v)

记录的事件循环延迟的标准偏差。

### 示例[#](http://nodejs.cn/api-v12/perf_hooks.html#examples)

#### 测量异步操作的时长[#](http://nodejs.cn/api-v12/perf_hooks.html#measuring-the-duration-of-async-operations)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/measuring_the_duration_of_async_operations.html)

以下示例使用[异步钩子](http://nodejs.cn/api-v12/async_hooks.html)和性能 API 来测量超时操作的实际持续时间（包括执行回调所花费的时间）。

```
'use strict';
const async_hooks = require('async_hooks');
const {
  performance,
  PerformanceObserver
} = require('perf_hooks');

const set = new Set();
const hook = async_hooks.createHook({
  init(id, type) {
    if (type === 'Timeout') {
      performance.mark(`Timeout-${id}-Init`);
      set.add(id);
    }
  },
  destroy(id) {
    if (set.has(id)) {
      set.delete(id);
      performance.mark(`Timeout-${id}-Destroy`);
      performance.measure(`Timeout-${id}`,
                          `Timeout-${id}-Init`,
                          `Timeout-${id}-Destroy`);
    }
  }
});
hook.enable();

const obs = new PerformanceObserver((list, observer) => {
  console.log(list.getEntries()[0]);
  performance.clearMarks();
  observer.disconnect();
});
obs.observe({ entryTypes: ['measure'], buffered: true });

setTimeout(() => {}, 1000);
```

#### 测量加载依赖的耗时[#](http://nodejs.cn/api-v12/perf_hooks.html#measuring-how-long-it-takes-to-load-dependencies)

[中英对照](http://nodejs.cn/api-v12/perf_hooks/measuring_how_long_it_takes_to_load_dependencies.html)

以下示例测量加载依赖项的 `require()` 操作的持续时间：

```
'use strict';
const {
  performance,
  PerformanceObserver
} = require('perf_hooks');
const mod = require('module');

// Monkey 修补 require 函数
mod.Module.prototype.require =
  performance.timerify(mod.Module.prototype.require);
require = performance.timerify(require);

// 激活观察者
const obs = new PerformanceObserver((list) => {
  const entries = list.getEntries();
  entries.forEach((entry) => {
    console.log(`require('${entry[0]}')`, entry.duration);
  });
  obs.disconnect();
});
obs.observe({ entryTypes: ['function'], buffered: true });

require('some-module');
```
