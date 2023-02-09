---
created: 2022-07-29T13:12:54 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/embedding.html
author: 
---

# C++ 嵌入器 | Node.js API 文档

> ## Excerpt
> 中英对照

---
-   [关于本文档](http://nodejs.cn/api-v12/documentation.html)
-   [用法与示例](http://nodejs.cn/api-v12/synopsis.html)

___

-   [assert断言](http://nodejs.cn/api-v12/assert.html)
-   [async\_hooks异步钩子](http://nodejs.cn/api-v12/async_hooks.html)
-   [buffer缓冲区](http://nodejs.cn/api-v12/buffer.html)
-   [C++插件](http://nodejs.cn/api-v12/addons.html)
-   [C/C++插件(使用Node-API)](http://nodejs.cn/api-v12/n-api.html)
-   [C++嵌入器](http://nodejs.cn/api-v12/embedding.html)
-   [child\_process子进程](http://nodejs.cn/api-v12/child_process.html)
-   [cluster集群](http://nodejs.cn/api-v12/cluster.html)
-   [CLI命令行](http://nodejs.cn/api-v12/cli.html)
-   [console控制台](http://nodejs.cn/api-v12/console.html)
-   [crypto加密](http://nodejs.cn/api-v12/crypto.html)
-   [debugger调试器](http://nodejs.cn/api-v12/debugger.html)
-   [deprecation弃用](http://nodejs.cn/api-v12/deprecations.html)
-   [dgram数据报](http://nodejs.cn/api-v12/dgram.html)
-   [dns域名服务器](http://nodejs.cn/api-v12/dns.html)
-   [domain域](http://nodejs.cn/api-v12/domain.html)
-   [Error错误](http://nodejs.cn/api-v12/errors.html)
-   [events事件触发器](http://nodejs.cn/api-v12/events.html)
-   [fs文件系统](http://nodejs.cn/api-v12/fs.html)
-   [global全局变量](http://nodejs.cn/api-v12/globals.html)
-   [http超文本传输协议](http://nodejs.cn/api-v12/http.html)
-   [http2超文本传输协议2.0](http://nodejs.cn/api-v12/http2.html)
-   [https安全超文本传输协议](http://nodejs.cn/api-v12/https.html)
-   [inspector检查器](http://nodejs.cn/api-v12/inspector.html)
-   [Intl国际化](http://nodejs.cn/api-v12/intl.html)
-   [module模块](http://nodejs.cn/api-v12/module.html)
-   [module/cjsCommonJS模块](http://nodejs.cn/api-v12/modules.html)
-   [module/esmECMAScript模块](http://nodejs.cn/api-v12/esm.html)
-   [module/package包模块](http://nodejs.cn/api-v12/packages.html)
-   [net网络](http://nodejs.cn/api-v12/net.html)
-   [os操作系统](http://nodejs.cn/api-v12/os.html)
-   [path路径](http://nodejs.cn/api-v12/path.html)
-   [perf\_hooks性能钩子](http://nodejs.cn/api-v12/perf_hooks.html)
-   [policy安全策略](http://nodejs.cn/api-v12/policy.html)
-   [process进程](http://nodejs.cn/api-v12/process.html)
-   [punycode域名代码](http://nodejs.cn/api-v12/punycode.html)
-   [querystring查询字符串](http://nodejs.cn/api-v12/querystring.html)
-   [readline逐行读取](http://nodejs.cn/api-v12/readline.html)
-   [repl交互式解释器](http://nodejs.cn/api-v12/repl.html)
-   [report诊断报告](http://nodejs.cn/api-v12/report.html)
-   [stream流](http://nodejs.cn/api-v12/stream.html)
-   [string\_decoder字符串解码器](http://nodejs.cn/api-v12/string_decoder.html)
-   [timers定时器](http://nodejs.cn/api-v12/timers.html)
-   [tls安全传输层](http://nodejs.cn/api-v12/tls.html)
-   [trace\_events跟踪事件](http://nodejs.cn/api-v12/tracing.html)
-   [tty终端](http://nodejs.cn/api-v12/tty.html)
-   [url网址](http://nodejs.cn/api-v12/url.html)
-   [util实用工具](http://nodejs.cn/api-v12/util.html)
-   [v8引擎](http://nodejs.cn/api-v12/v8.html)
-   [vm虚拟机](http://nodejs.cn/api-v12/vm.html)
-   [wasi网络汇编系统接口](http://nodejs.cn/api-v12/wasi.html)
-   [worker\_threads工作线程](http://nodejs.cn/api-v12/worker_threads.html)
-   [zlib压缩](http://nodejs.cn/api-v12/zlib.html)

目录

-   [C++ 嵌入器](http://nodejs.cn/api-v12/embedding.html#c-embedder-api)
    -   [嵌入式应用程序的示例](http://nodejs.cn/api-v12/embedding.html#example-embedding-application)
        -   [设置每个进程的状态](http://nodejs.cn/api-v12/embedding.html#setting-up-per-process-state)
        -   [每个实例的状态](http://nodejs.cn/api-v12/embedding.html#per-instance-state)

[中英对照](http://nodejs.cn/api-v12/embedding/c_embedder_api.html)

Node.js 提供了许多 C++ API，可用于在 Node.js 环境中从其他 C++ 软件执行 JavaScript。

这些 API 的文档可以在 Node.js 源代码树的 [src/node.h](http://url.nodejs.cn/RrEfEU) 中找到。 除了 Node.js 暴露的 API，V8 嵌入器 API 还提供了一些必需的概念。

因为使用 Node.js 作为嵌入式库与编写由 Node.js 执行的代码不同，破坏性更改不遵循典型的 Node.js [弃用策略](http://nodejs.cn/api-v12/deprecations.html)，并且可能在每个语义化主版本上发生，而没有事先警告.

### 嵌入式应用程序的示例[#](http://nodejs.cn/api-v12/embedding.html#example-embedding-application)

[中英对照](http://nodejs.cn/api-v12/embedding/example_embedding_application.html)

以下章节将概述如何使用这些 API 从头开始创建应用程序，该应用程序将执行相当于 `node -e <code>` 的操作，也就是将使用一段 JavaScript 并在特定于 Node.js 的环境中运行。

可以在 [Node.js 源代码树](http://url.nodejs.cn/zZQsng)中找到完整的代码。

#### 设置每个进程的状态[#](http://nodejs.cn/api-v12/embedding.html#setting-up-per-process-state)

[中英对照](http://nodejs.cn/api-v12/embedding/setting_up_per_process_state.html)

Node.js 需要一些每个进程的状态管理才能运行：

-   为 Node.js [命令行选项](http://nodejs.cn/api-v12/cli.html)解析的参数，
-   V8 每个进程要求，例如 `v8::Platform` 实例。

下面的示例展示了如何设置这些。 一些类名分别来自 `node` 和 `v8` C++ 命名空间。

```
int main(int argc, char** argv) {
  argv = uv_setup_args(argc, argv);
  std::vector<std::string> args(argv, argv + argc);
  std::vector<std::string> exec_args;
  std::vector<std::string> errors;
  // 解析 Node.js 命令行选项，
  // 并打印尝试解析它们时发生的任何错误。
  int exit_code = node::InitializeNodeWithArgs(&args, &exec_args, &errors);
  for (const std::string& error : errors)
    fprintf(stderr, "%s: %s\n", args[0].c_str(), error.c_str());
  if (exit_code != 0) {
    return exit_code;
  }

  // 创建 v8::Platform 实例。
  // `MultiIsolatePlatform::Create()` 是一种创建 v8::Platform 实例的方法，Node.js 在创建时可以使用它
  // 工作线程。当没有 `MultiIsolatePlatform` 实例时，
  // 工作线程被禁用。
  std::unique_ptr<MultiIsolatePlatform> platform =
      MultiIsolatePlatform::Create(4);
  V8::InitializePlatform(platform.get());
  V8::Initialize();

  // 此函数的内容见下文。
  int ret = RunNodeInstance(platform.get(), args, exec_args);

  V8::Dispose();
  V8::ShutdownPlatform();
  return ret;
}
```

#### 每个实例的状态[#](http://nodejs.cn/api-v12/embedding.html#per-instance-state)

[中英对照](http://nodejs.cn/api-v12/embedding/per_instance_state.html)

Node.js 有“Node.js 实例”的概念，通常被称为 `node::Environment`。 每个 `node::Environment` 都与：

-   正好是 `v8::Isolate`，即 JS 引擎实例，
-   正好是 `uv_loop_t`，即事件循环，并且
-   许多 `v8::Context`，但只有一个主要的 `v8::Context`。
-   `node::IsolateData` 实例包含的信息可以由使用相同 `v8::Isolate` 的多个 `node::Environment` 共享。 目前，没有针对此场景执行测试。

为了设置 `v8::Isolate`，需要提供 `v8::ArrayBuffer::Allocator`。 一种可能的选择是默认的 Node.js 分配器，它可以通过 `node::ArrayBufferAllocator::Create()` 创建。 当插件使用 Node.js C++ `Buffer` API 时，使用 Node.js 分配器可以实现较小的性能优化，并且需要在 [`process.memoryUsage()`](http://nodejs.cn/api-v12/process.html#process_process_memoryusage) 中跟踪 `ArrayBuffer` 内存。

此外，每个用于 Node.js 实例的 `v8::Isolate` 都需要在 `MultiIsolatePlatform` 实例中注册和注销（如果正在使用），以便平台知道对于 `v8::Isolate` 调度的任务使用哪个事件循环。

`node::NewIsolate()` 辅助函数创建 `v8::Isolate`，使用一些 Node.js 特定的钩子（例如 Node.js 错误句柄）设置，并自动将其注册到平台。

```
int RunNodeInstance(MultiIsolatePlatform* platform,
                    const std::vector<std::string>& args,
                    const std::vector<std::string>& exec_args) {
  int exit_code = 0;
  // 设置 libuv 事件循环。
  uv_loop_t loop;
  int ret = uv_loop_init(&loop);
  if (ret != 0) {
    fprintf(stderr, "%s: Failed to initialize loop: %s\n",
            args[0].c_str(),
            uv_err_name(ret));
    return 1;
  }

  std::shared_ptr<ArrayBufferAllocator> allocator =
      ArrayBufferAllocator::Create();

  Isolate* isolate = NewIsolate(allocator, &loop, platform);
  if (isolate == nullptr) {
    fprintf(stderr, "%s: Failed to initialize V8 Isolate\n", args[0].c_str());
    return 1;
  }

  {
    Locker locker(isolate);
    Isolate::Scope isolate_scope(isolate);

    // 创建 node::IsolateData 实例，
    // 稍后将使用 node::FreeIsolateData() 释放该实例。
    std::unique_ptr<IsolateData, decltype(&node::FreeIsolateData)> isolate_data(
        node::CreateIsolateData(isolate, &loop, platform, allocator.get()),
        node::FreeIsolateData);

    // 设置新的 v8::Context。
    HandleScope handle_scope(isolate);
    Local<Context> context = node::NewContext(isolate);
    if (context.IsEmpty()) {
      fprintf(stderr, "%s: Failed to initialize V8 Context\n", args[0].c_str());
      return 1;
    }

    // 当调用 node::CreateEnvironment() 和 node::LoadEnvironment() 时，
    // 需要输入 v8::Context。
    Context::Scope context_scope(context);

    // 创建 node::Environment 实例，
    // 稍后将使用 node::FreeEnvironment() 释放该实例。
    std::unique_ptr<Environment, decltype(&node::FreeEnvironment)> env(
        node::CreateEnvironment(isolate_data.get(), context, args, exec_args),
        node::FreeEnvironment);

    // 设置要执行的 Node.js 实例，并在其中运行代码。
    // 还有一个变体接受回调
    // 并为其提供 `require` 和 `process` 对象，
    // 以便它可以根据需要手动编译和运行脚本。
    // 此脚本中的 `require` 函数不访问文件系统，
    // 并且只能加载 Node.js 内置模块。
    // `module.createRequire()` 被用来创建能够从磁盘加载文件的文件，
    // 并使用标准的 CommonJS 文件加载器
    // 而不是内部的 `require` 函数。
    MaybeLocal<Value> loadenv_ret = node::LoadEnvironment(
        env.get(),
        "const publicRequire ="
        "  require('module').createRequire(process.cwd() + '/');"
        "globalThis.require = publicRequire;"
        "require('vm').runInThisContext(process.argv[1]);");

    if (loadenv_ret.IsEmpty())  // 出现了 JS 异常。
      return 1;

    {
      // SealHandleScope 防止来自回调的句柄泄漏。
      SealHandleScope seal(isolate);
      bool more;
      do {
        uv_run(&loop, UV_RUN_DEFAULT);

        // 后台线程上的 V8 任务可能最终会在前台调度新任务，从而使事件循环继续进行。
        // 例如，
        // WebAssembly.compile() 可能会这样做。
        platform->DrainTasks(isolate);

        // 如果有新任务，则继续。
        more = uv_loop_alive(&loop);
        if (more) continue;

        // 
        node::EmitBeforeExit(env.get());

        // 'beforeExit' 还可以调度新的新工作，
        // 以使事件循环保持运行。
        more = uv_loop_alive(&loop);
      } while (more == true);
    }

    // 
    exit_code = node::EmitExit(env.get());

    // node::Stop() 可用于显式停止事件循环并阻止进一步的 JavaScript 运行。
    // 它可以从任何线程调用，
    // 如果从另一个线程调用，则像 worker.terminate() 一样。
    node::Stop(env.get());
  }

  // 取消向平台注册 Isolate 并添加监听器，
  // 当平台完成清理它与 Isolate 关联的任何状态时，
  // 则调用该监听器。
  bool platform_finished = false;
  platform->AddIsolateFinishedCallback(isolate, [](void* data) {
    *static_cast<bool*>(data) = true;
  }, &platform_finished);
  platform->UnregisterIsolate(isolate);
  isolate->Dispose();

  // 等到平台清理完所有相关资源。
  while (!platform_finished)
    uv_run(&loop, UV_RUN_ONCE);
  int err = uv_loop_close(&loop);
  assert(err == 0);

  return exit_code;
}
```
