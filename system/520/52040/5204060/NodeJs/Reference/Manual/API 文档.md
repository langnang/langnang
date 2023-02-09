---
created: 2022-07-29T13:12:51 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/index.html
author:
---

# API 文档 | Node.js 中文网

> ## Excerpt
>
> 返回顶部

---

- [关于本文档](http://nodejs.cn/api-v12/documentation.html)
- [用法与示例](http://nodejs.cn/api-v12/synopsis.html)

---

- [assert 断言](http://nodejs.cn/api-v12/assert.html)
- [async_hooks 异步钩子](http://nodejs.cn/api-v12/async_hooks.html)
- [buffer 缓冲区](http://nodejs.cn/api-v12/buffer.html)
- [C++插件](http://nodejs.cn/api-v12/addons.html)
- [C/C++插件(使用 Node-API)](http://nodejs.cn/api-v12/n-api.html)
- [C++嵌入器](http://nodejs.cn/api-v12/embedding.html)
- [child_process 子进程](http://nodejs.cn/api-v12/child_process.html)
- [cluster 集群](http://nodejs.cn/api-v12/cluster.html)
- [CLI 命令行](http://nodejs.cn/api-v12/cli.html)
- [console 控制台](http://nodejs.cn/api-v12/console.html)
- [crypto 加密](http://nodejs.cn/api-v12/crypto.html)
- [debugger 调试器](http://nodejs.cn/api-v12/debugger.html)
- [deprecation 弃用](http://nodejs.cn/api-v12/deprecations.html)
- [dgram 数据报](http://nodejs.cn/api-v12/dgram.html)
- [dns 域名服务器](http://nodejs.cn/api-v12/dns.html)
- [domain 域](http://nodejs.cn/api-v12/domain.html)
- [Error 错误](http://nodejs.cn/api-v12/errors.html)
- [events 事件触发器](http://nodejs.cn/api-v12/events.html)
- [fs 文件系统](http://nodejs.cn/api-v12/fs.html)
- [global 全局变量](http://nodejs.cn/api-v12/globals.html)
- [http 超文本传输协议](http://nodejs.cn/api-v12/http.html)
- [http2 超文本传输协议 2.0](http://nodejs.cn/api-v12/http2.html)
- [https 安全超文本传输协议](http://nodejs.cn/api-v12/https.html)
- [inspector 检查器](http://nodejs.cn/api-v12/inspector.html)
- [Intl 国际化](http://nodejs.cn/api-v12/intl.html)
- [module 模块](http://nodejs.cn/api-v12/module.html)
- [module/cjsCommonJS 模块](http://nodejs.cn/api-v12/modules.html)
- [module/esmECMAScript 模块](http://nodejs.cn/api-v12/esm.html)
- [module/package 包模块](http://nodejs.cn/api-v12/packages.html)
- [net 网络](http://nodejs.cn/api-v12/net.html)
- [os 操作系统](http://nodejs.cn/api-v12/os.html)
- [path 路径](http://nodejs.cn/api-v12/path.html)
- [perf_hooks 性能钩子](http://nodejs.cn/api-v12/perf_hooks.html)
- [policy 安全策略](http://nodejs.cn/api-v12/policy.html)
- [process 进程](http://nodejs.cn/api-v12/process.html)
- [punycode 域名代码](http://nodejs.cn/api-v12/punycode.html)
- [querystring 查询字符串](http://nodejs.cn/api-v12/querystring.html)
- [readline 逐行读取](http://nodejs.cn/api-v12/readline.html)
- [repl 交互式解释器](http://nodejs.cn/api-v12/repl.html)
- [report 诊断报告](http://nodejs.cn/api-v12/report.html)
- [stream 流](http://nodejs.cn/api-v12/stream.html)
- [string_decoder 字符串解码器](http://nodejs.cn/api-v12/string_decoder.html)
- [timers 定时器](http://nodejs.cn/api-v12/timers.html)
- [tls 安全传输层](http://nodejs.cn/api-v12/tls.html)
- [trace_events 跟踪事件](http://nodejs.cn/api-v12/tracing.html)
- [tty 终端](http://nodejs.cn/api-v12/tty.html)
- [url 网址](http://nodejs.cn/api-v12/url.html)
- [util 实用工具](http://nodejs.cn/api-v12/util.html)
- [v8 引擎](http://nodejs.cn/api-v12/v8.html)
- [vm 虚拟机](http://nodejs.cn/api-v12/vm.html)
- [wasi 网络汇编系统接口](http://nodejs.cn/api-v12/wasi.html)
- [worker_threads 工作线程](http://nodejs.cn/api-v12/worker_threads.html)
- [zlib 压缩](http://nodejs.cn/api-v12/zlib.html)

## Node.js v12.22.12 文档

- Node.js 12.22.12
- [►▼ 其他版本](http://nodejs.cn/api-v12/index.html#)

  1.  [18.7.0](http://nodejs.cn/api/index.html)
  2.  [16.16.0](http://nodejs.cn/api-v16/index.html)
  3.  [14.20.0](http://nodejs.cn/api-v14/index.html)
  4.  [12.22.12](http://nodejs.cn/api-v12/index.html)

- [文档搜索](http://api.nodejs.cn/?v=12)

---

- [关于本文档](http://nodejs.cn/api-v12/documentation.html)
- [用法与示例](http://nodejs.cn/api-v12/synopsis.html)

---

- [assert 断言](http://nodejs.cn/api-v12/assert.html)
- [async_hooks 异步钩子](http://nodejs.cn/api-v12/async_hooks.html)
- [buffer 缓冲区](http://nodejs.cn/api-v12/buffer.html)
- [C++插件](http://nodejs.cn/api-v12/addons.html)
- [C/C++插件(使用 Node-API)](http://nodejs.cn/api-v12/n-api.html)
- [C++嵌入器](http://nodejs.cn/api-v12/embedding.html)
- [child_process 子进程](http://nodejs.cn/api-v12/child_process.html)
- [cluster 集群](http://nodejs.cn/api-v12/cluster.html)
- [CLI 命令行](http://nodejs.cn/api-v12/cli.html)
- [console 控制台](http://nodejs.cn/api-v12/console.html)
- [crypto 加密](http://nodejs.cn/api-v12/crypto.html)
- [debugger 调试器](http://nodejs.cn/api-v12/debugger.html)
- [deprecation 弃用](http://nodejs.cn/api-v12/deprecations.html)
- [dgram 数据报](http://nodejs.cn/api-v12/dgram.html)
- [dns 域名服务器](http://nodejs.cn/api-v12/dns.html)
- [domain 域](http://nodejs.cn/api-v12/domain.html)
- [Error 错误](http://nodejs.cn/api-v12/errors.html)
- [events 事件触发器](http://nodejs.cn/api-v12/events.html)
- [fs 文件系统](http://nodejs.cn/api-v12/fs.html)
- [global 全局变量](http://nodejs.cn/api-v12/globals.html)
- [http 超文本传输协议](http://nodejs.cn/api-v12/http.html)
- [http2 超文本传输协议 2.0](http://nodejs.cn/api-v12/http2.html)
- [https 安全超文本传输协议](http://nodejs.cn/api-v12/https.html)
- [inspector 检查器](http://nodejs.cn/api-v12/inspector.html)
- [Intl 国际化](http://nodejs.cn/api-v12/intl.html)
- [module 模块](http://nodejs.cn/api-v12/module.html)
- [module/cjs CommonJS 模块](http://nodejs.cn/api-v12/modules.html)
- [module/esm ECMAScript 模块](http://nodejs.cn/api-v12/esm.html)
- [module/package 包模块](http://nodejs.cn/api-v12/packages.html)
- [net 网络](http://nodejs.cn/api-v12/net.html)
- [os 操作系统](http://nodejs.cn/api-v12/os.html)
- [path 路径](http://nodejs.cn/api-v12/path.html)
- [perf_hooks 性能钩子](http://nodejs.cn/api-v12/perf_hooks.html)
- [policy 安全策略](http://nodejs.cn/api-v12/policy.html)
- [process 进程](http://nodejs.cn/api-v12/process.html)
- [punycode 域名代码](http://nodejs.cn/api-v12/punycode.html)
- [querystring 查询字符串](http://nodejs.cn/api-v12/querystring.html)
- [readline 逐行读取](http://nodejs.cn/api-v12/readline.html)
- [repl 交互式解释器](http://nodejs.cn/api-v12/repl.html)
- [report 诊断报告](http://nodejs.cn/api-v12/report.html)
- [stream 流](http://nodejs.cn/api-v12/stream.html)
- [string_decoder 字符串解码器](http://nodejs.cn/api-v12/string_decoder.html)
- [timers 定时器](http://nodejs.cn/api-v12/timers.html)
- [tls 安全传输层](http://nodejs.cn/api-v12/tls.html)
- [trace_events 跟踪事件](http://nodejs.cn/api-v12/tracing.html)
- [tty 终端](http://nodejs.cn/api-v12/tty.html)
- [url 网址](http://nodejs.cn/api-v12/url.html)
- [util 实用工具](http://nodejs.cn/api-v12/util.html)
- [v8 引擎](http://nodejs.cn/api-v12/v8.html)
- [vm 虚拟机](http://nodejs.cn/api-v12/vm.html)
- [wasi 网络汇编系统接口](http://nodejs.cn/api-v12/wasi.html)
- [worker_threads 工作线程](http://nodejs.cn/api-v12/worker_threads.html)
- [zlib 压缩](http://nodejs.cn/api-v12/zlib.html)

返回顶部

