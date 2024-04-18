---
created: 2022-07-29T13:12:54 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/report.html
author: 
---

# report 诊断报告 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/report/diagnostic_report.html)

提供 JSON 格式的诊断摘要，写入文件。

该报告旨在用于开发、测试和生产用途，以捕获和保存用于问题确定的信息。 它包括 JavaScript 和原生堆栈跟踪、堆统计、平台信息、资源使用情况等。 启用报告选项后，除了通过 API 调用以编程方式触发之外，还可以在未处理的异常、致命错误和用户信号上触发诊断报告。

下面提供了针对未捕获异常生成的完整示例报告以供参考。

```
{
  "header": {
    "reportVersion": 1,
    "event": "exception",
    "trigger": "Exception",
    "filename": "report.20181221.005011.8974.0.001.json",
    "dumpEventTime": "2018-12-21T00:50:11Z",
    "dumpEventTimeStamp": "1545371411331",
    "processId": 8974,
    "cwd": "/home/nodeuser/project/node",
    "commandLine": [
      "/home/nodeuser/project/node/out/Release/node",
      "--report-uncaught-exception",
      "/home/nodeuser/project/node/test/report/test-exception.js",
      "child"
    ],
    "nodejsVersion": "v12.0.0-pre",
    "glibcVersionRuntime": "2.17",
    "glibcVersionCompiler": "2.17",
    "wordSize": "64 bit",
    "arch": "x64",
    "platform": "linux",
    "componentVersions": {
      "node": "12.0.0-pre",
      "v8": "7.1.302.28-node.5",
      "uv": "1.24.1",
      "zlib": "1.2.11",
      "ares": "1.15.0",
      "modules": "68",
      "nghttp2": "1.34.0",
      "napi": "3",
      "llhttp": "1.0.1",
      "http_parser": "2.8.0",
      "openssl": "1.1.0j"
    },
    "release": {
      "name": "node"
    },
    "osName": "Linux",
    "osRelease": "3.10.0-862.el7.x86_64",
    "osVersion": "#1 SMP Wed Mar 21 18:14:51 EDT 2018",
    "osMachine": "x86_64",
    "cpus": [
      {
        "model": "Intel(R) Core(TM) i7-6820HQ CPU @ 2.70GHz",
        "speed": 2700,
        "user": 88902660,
        "nice": 0,
        "sys": 50902570,
        "idle": 241732220,
        "irq": 0
      },
      {
        "model": "Intel(R) Core(TM) i7-6820HQ CPU @ 2.70GHz",
        "speed": 2700,
        "user": 88902660,
        "nice": 0,
        "sys": 50902570,
        "idle": 241732220,
        "irq": 0
      }
    ],
    "networkInterfaces": [
      {
        "name": "en0",
        "internal": false,
        "mac": "13:10:de:ad:be:ef",
        "address": "10.0.0.37",
        "netmask": "255.255.255.0",
        "family": "IPv4"
      }
    ],
    "host": "test_machine"
  },
  "javascriptStack": {
    "message": "Error: *** test-exception.js: throwing uncaught Error",
    "stack": [
      "at myException (/home/nodeuser/project/node/test/report/test-exception.js:9:11)",
      "at Object.<anonymous> (/home/nodeuser/project/node/test/report/test-exception.js:12:3)",
      "at Module._compile (internal/modules/cjs/loader.js:718:30)",
      "at Object.Module._extensions..js (internal/modules/cjs/loader.js:729:10)",
      "at Module.load (internal/modules/cjs/loader.js:617:32)",
      "at tryModuleLoad (internal/modules/cjs/loader.js:560:12)",
      "at Function.Module._load (internal/modules/cjs/loader.js:552:3)",
      "at Function.Module.runMain (internal/modules/cjs/loader.js:771:12)",
      "at executeUserCode (internal/bootstrap/node.js:332:15)"
    ]
  },
  "nativeStack": [
    {
      "pc": "0x000055b57f07a9ef",
      "symbol": "report::GetNodeReport(v8::Isolate*, node::Environment*, char const*, char const*, v8::Local<v8::String>, std::ostream&) [./node]"
    },
    {
      "pc": "0x000055b57f07cf03",
      "symbol": "report::GetReport(v8::FunctionCallbackInfo<v8::Value> const&) [./node]"
    },
    {
      "pc": "0x000055b57f1bccfd",
      "symbol": " [./node]"
    },
    {
      "pc": "0x000055b57f1be048",
      "symbol": "v8::internal::Builtin_HandleApiCall(int, v8::internal::Object**, v8::internal::Isolate*) [./node]"
    },
    {
      "pc": "0x000055b57feeda0e",
      "symbol": " [./node]"
    }
  ],
  "javascriptHeap": {
    "totalMemory": 6127616,
    "totalCommittedMemory": 4357352,
    "usedMemory": 3221136,
    "availableMemory": 1521370240,
    "memoryLimit": 1526909922,
    "heapSpaces": {
      "read_only_space": {
        "memorySize": 524288,
        "committedMemory": 39208,
        "capacity": 515584,
        "used": 30504,
        "available": 485080
      },
      "new_space": {
        "memorySize": 2097152,
        "committedMemory": 2019312,
        "capacity": 1031168,
        "used": 985496,
        "available": 45672
      },
      "old_space": {
        "memorySize": 2273280,
        "committedMemory": 1769008,
        "capacity": 1974640,
        "used": 1725488,
        "available": 249152
      },
      "code_space": {
        "memorySize": 696320,
        "committedMemory": 184896,
        "capacity": 152128,
        "used": 152128,
        "available": 0
      },
      "map_space": {
        "memorySize": 536576,
        "committedMemory": 344928,
        "capacity": 327520,
        "used": 327520,
        "available": 0
      },
      "large_object_space": {
        "memorySize": 0,
        "committedMemory": 0,
        "capacity": 1520590336,
        "used": 0,
        "available": 1520590336
      },
      "new_large_object_space": {
        "memorySize": 0,
        "committedMemory": 0,
        "capacity": 0,
        "used": 0,
        "available": 0
      }
    }
  },
  "resourceUsage": {
    "userCpuSeconds": 0.069595,
    "kernelCpuSeconds": 0.019163,
    "cpuConsumptionPercent": 0.000000,
    "maxRss": 18079744,
    "pageFaults": {
      "IORequired": 0,
      "IONotRequired": 4610
    },
    "fsActivity": {
      "reads": 0,
      "writes": 0
    }
  },
  "uvthreadResourceUsage": {
    "userCpuSeconds": 0.068457,
    "kernelCpuSeconds": 0.019127,
    "cpuConsumptionPercent": 0.000000,
    "fsActivity": {
      "reads": 0,
      "writes": 0
    }
  },
  "libuv": [
    {
      "type": "async",
      "is_active": true,
      "is_referenced": false,
      "address": "0x0000000102910900",
      "details": ""
    },
    {
      "type": "timer",
      "is_active": false,
      "is_referenced": false,
      "address": "0x00007fff5fbfeab0",
      "repeat": 0,
      "firesInMsFromNow": 94403548320796,
      "expired": true
    },
    {
      "type": "check",
      "is_active": true,
      "is_referenced": false,
      "address": "0x00007fff5fbfeb48"
    },
    {
      "type": "idle",
      "is_active": false,
      "is_referenced": true,
      "address": "0x00007fff5fbfebc0"
    },
    {
      "type": "prepare",
      "is_active": false,
      "is_referenced": false,
      "address": "0x00007fff5fbfec38"
    },
    {
      "type": "check",
      "is_active": false,
      "is_referenced": false,
      "address": "0x00007fff5fbfecb0"
    },
    {
      "type": "async",
      "is_active": true,
      "is_referenced": false,
      "address": "0x000000010188f2e0"
    },
    {
      "type": "tty",
      "is_active": false,
      "is_referenced": true,
      "address": "0x000055b581db0e18",
      "width": 204,
      "height": 55,
      "fd": 17,
      "writeQueueSize": 0,
      "readable": true,
      "writable": true
    },
    {
      "type": "signal",
      "is_active": true,
      "is_referenced": false,
      "address": "0x000055b581d80010",
      "signum": 28,
      "signal": "SIGWINCH"
    },
    {
      "type": "tty",
      "is_active": true,
      "is_referenced": true,
      "address": "0x000055b581df59f8",
      "width": 204,
      "height": 55,
      "fd": 19,
      "writeQueueSize": 0,
      "readable": true,
      "writable": true
    },
    {
      "type": "loop",
      "is_active": true,
      "address": "0x000055fc7b2cb180"
    }
  ],
  "workers": [],
  "environmentVariables": {
    "REMOTEHOST": "REMOVED",
    "MANPATH": "/opt/rh/devtoolset-3/root/usr/share/man:",
    "XDG_SESSION_ID": "66126",
    "HOSTNAME": "test_machine",
    "HOST": "test_machine",
    "TERM": "xterm-256color",
    "SHELL": "/bin/csh",
    "SSH_CLIENT": "REMOVED",
    "PERL5LIB": "/opt/rh/devtoolset-3/root//usr/lib64/perl5/vendor_perl:/opt/rh/devtoolset-3/root/usr/lib/perl5:/opt/rh/devtoolset-3/root//usr/share/perl5/vendor_perl",
    "OLDPWD": "/home/nodeuser/project/node/src",
    "JAVACONFDIRS": "/opt/rh/devtoolset-3/root/etc/java:/etc/java",
    "SSH_TTY": "/dev/pts/0",
    "PCP_DIR": "/opt/rh/devtoolset-3/root",
    "GROUP": "normaluser",
    "USER": "nodeuser",
    "LD_LIBRARY_PATH": "/opt/rh/devtoolset-3/root/usr/lib64:/opt/rh/devtoolset-3/root/usr/lib",
    "HOSTTYPE": "x86_64-linux",
    "XDG_CONFIG_DIRS": "/opt/rh/devtoolset-3/root/etc/xdg:/etc/xdg",
    "MAIL": "/var/spool/mail/nodeuser",
    "PATH": "/home/nodeuser/project/node:/opt/rh/devtoolset-3/root/usr/bin:/usr/local/bin:/usr/bin:/usr/local/sbin:/usr/sbin",
    "PWD": "/home/nodeuser/project/node",
    "LANG": "en_US.UTF-8",
    "PS1": "\\u@\\h : \\[\\e[31m\\]\\w\\[\\e[m\\] >  ",
    "SHLVL": "2",
    "HOME": "/home/nodeuser",
    "OSTYPE": "linux",
    "VENDOR": "unknown",
    "PYTHONPATH": "/opt/rh/devtoolset-3/root/usr/lib64/python2.7/site-packages:/opt/rh/devtoolset-3/root/usr/lib/python2.7/site-packages",
    "MACHTYPE": "x86_64",
    "LOGNAME": "nodeuser",
    "XDG_DATA_DIRS": "/opt/rh/devtoolset-3/root/usr/share:/usr/local/share:/usr/share",
    "LESSOPEN": "||/usr/bin/lesspipe.sh %s",
    "INFOPATH": "/opt/rh/devtoolset-3/root/usr/share/info",
    "XDG_RUNTIME_DIR": "/run/user/50141",
    "_": "./node"
  },
  "userLimits": {
    "core_file_size_blocks": {
      "soft": "",
      "hard": "unlimited"
    },
    "data_seg_size_kbytes": {
      "soft": "unlimited",
      "hard": "unlimited"
    },
    "file_size_blocks": {
      "soft": "unlimited",
      "hard": "unlimited"
    },
    "max_locked_memory_bytes": {
      "soft": "unlimited",
      "hard": 65536
    },
    "max_memory_size_kbytes": {
      "soft": "unlimited",
      "hard": "unlimited"
    },
    "open_files": {
      "soft": "unlimited",
      "hard": 4096
    },
    "stack_size_bytes": {
      "soft": "unlimited",
      "hard": "unlimited"
    },
    "cpu_time_seconds": {
      "soft": "unlimited",
      "hard": "unlimited"
    },
    "max_user_processes": {
      "soft": "unlimited",
      "hard": 4127290
    },
    "virtual_memory_kbytes": {
      "soft": "unlimited",
      "hard": "unlimited"
    }
  },
  "sharedObjects": [
    "/lib64/libdl.so.2",
    "/lib64/librt.so.1",
    "/lib64/libstdc++.so.6",
    "/lib64/libm.so.6",
    "/lib64/libgcc_s.so.1",
    "/lib64/libpthread.so.0",
    "/lib64/libc.so.6",
    "/lib64/ld-linux-x86-64.so.2"
  ]
}
```

### 用法[#](http://nodejs.cn/api-v12/report.html#usage)

[中英对照](http://nodejs.cn/api-v12/report/usage.html)

```
node --report-uncaught-exception --report-on-signal \
--report-on-fatalerror app.js
```

-   `--report-uncaught-exception` 启用对未捕获的异常生成报告。 当结合原生堆栈和其他运行时环境数据检查 JavaScript 堆栈时很有用。
    
-   `--report-on-signal` 允许在接收到正在运行的 Node.js 进程的指定（或预定义）信号时生成报告。 （有关如何修改触发报告的信号，请参见下文。）默认信号为 `SIGUSR2`。 当需要从另一个程序触发报告时很有用。 应用程序监视器可以利用此特性定期收集报告并将丰富的内部运行时数据集绘制到其视图中。
    

Windows 不支持基于信号的报告生成。

一般情况下，不需要修改上报触发信号。 然而，如果 `SIGUSR2` 已经被用于其他目的，则此标志有助于改变报告生成的信号，并为上述目的保留 `SIGUSR2` 的原始含义。

-   `--report-on-fatalerror` 允许在导致应用程序终止的致命错误（Node.js 运行时中的内部错误，例如内存不足）时触发报告。 用于检查各种诊断数据元素，例如堆、堆栈、事件循环状态、资源消耗等 推断致命错误。
    
-   `--report-compact` 以紧凑的单行 JSON 格式编写报告，与为人类设计的默认多行格式相比，日志处理系统更容易使用。
    
-   `--report-directory` 生成报告的位置。
    
-   `--report-filename` 将写入报告的文件的名称。
    
-   `--report-signal` 设置或重置报告生成信号（Windows 不支持）。 默认信号为 `SIGUSR2`。
    

报告也可以通过 JavaScript 应用程序的 API 调用触发：

```
process.report.writeReport();
```

此函数接受可选的额外参数 `filename`，其是写入报告的文件的名称。

```
process.report.writeReport('./foo.json');
```

此函数接受可选的额外参数 `err`，其是 `Error` 对象，将用作报告中打印的 JavaScript 堆栈的上下文。 当使用报告处理回调或异常句柄中的错误时，这允许报告包括原始错误的位置以及处理它的位置。

```
try {
  process.chdir('/non-existent-path');
} catch (err) {
  process.report.writeReport(err);
}
// 任何其他代码
```

如果文件名和错误对象都传给 `writeReport()`，则错误对象必须是第二个参数。

```
try {
  process.chdir('/non-existent-path');
} catch (err) {
  process.report.writeReport(filename, err);
}
// 任何其他代码
```

诊断报告的内容可以通过 JavaScript 应用程序的 API 调用作为 JavaScript 对象返回：

```
const report = process.report.getReport();
console.log(typeof report === 'object'); // true

// 类似于 process.report.writeReport() 输出
console.log(JSON.stringify(report, null, 2));
```

此函数接受可选的额外参数 `err`，其是 `Error` 对象，将用作报告中打印的 JavaScript 堆栈的上下文。

```
const report = process.report.getReport(new Error('custom error'));
console.log(typeof report === 'object'); // true
```

API 版本在从应用程序内部检查运行时状态时很有用，期望自我调整资源消耗、负载平衡、监控等。

报告的内容的组成部分是：包含事件类型、日期、时间、进程标识 和 Node.js 版本的标题部分，包含 JavaScript 和原生堆栈跟踪的部分，包含 V8 堆信息的部分，包含 `libuv` 句柄信息的部分，以及显示 CPU 和内存使用情况以及系统限制的操作系统平台信息部分。 可以使用 Node.js 交互式解释器触发的示例报告：

```
$ node
> process.report.writeReport();
Writing Node.js report to file: report.20181126.091102.8480.0.001.json
Node.js report completed
>
```

当写入报告时，将开始和结束消息发送到标准错误，并将报告的文件名返回给调用者。 默认文件名包括日期、时间、进程标识、以及序列号。 如果为同一个 Node.js 进程多次生成，则序列号有助于将报告转储与运行时状态相关联

### 配置[#](http://nodejs.cn/api-v12/report.html#configuration)

[中英对照](http://nodejs.cn/api-v12/report/configuration.html)

报告生成的其他运行时配置可通过 `process.report` 的以下属性获得：

当为 `true` 时，`reportOnFatalError` 触发致命错误的诊断报告。 默认为 `false`。

当为 `true` 时，`reportOnSignal` 触发信号的诊断报告。 Windows 不支持此。 默认为 `false`。

当为 `true` 时，`reportOnUncaughtException` 触发未捕获异常的诊断报告。 默认为 `false`。

`signal` 指定将用于拦截外部触发器以生成报告的 POSIX 信号标识符 默认为 `'SIGUSR2'`。

`filename` 指定文件系统中输出文件的名称。 `stdout` 和 `stderr` 附有特殊含义。 使用这些将导致报告被写入相关的标准流。 在使用标准流的情况下，`directory` 中的值将被忽略。 不支持网址。 默认为包含时间戳、进程标识、以及序列号的复合文件名。

`directory` 指定将写入报告的文件系统目录。 不支持网址。 默认为 Node.js 进程的当前工作目录。

```
// 仅触发未捕获异常上的报告。
process.report.reportOnFatalError = false;
process.report.reportOnSignal = false;
process.report.reportOnUncaughtException = true;

// 触发内部错误和外部信号的报告。
process.report.reportOnFatalError = true;
process.report.reportOnSignal = true;
process.report.reportOnUncaughtException = false;

// 将默认信号更改为 'SIGQUIT' 并启用。
process.report.reportOnFatalError = false;
process.report.reportOnUncaughtException = false;
process.report.reportOnSignal = true;
process.report.signal = 'SIGQUIT';
```

模块初始化的配置也可以通过环境变量获得：

```
NODE_OPTIONS="--report-uncaught-exception \
  --report-on-fatalerror --report-on-signal \
  --report-signal=SIGUSR2  --report-filename=./report.json \
  --report-directory=/home/nodeuser"
```

具体的 API 文档可以在 [`process API documentation`](http://nodejs.cn/api-v12/process.html) 章节下找到。

### 与工作线程的交互[#](http://nodejs.cn/api-v12/report.html#interaction-with-workers)

[中英对照](http://nodejs.cn/api-v12/report/interaction_with_workers.html)

[`Worker`](http://nodejs.cn/api-v12/worker_threads.html) 线程可以像主线程一样创建报告。

报告将包括作为 `workers` 部分的一部分的当前线程的子线程的任何工作线程的信息，每个工作线程以标准报告格式生成报告。

生成报告的线程将等待工作线程的报告完成。 但是，由于运行 JavaScript 和事件循环都被中断以生成报告，因此延迟通常很低。
