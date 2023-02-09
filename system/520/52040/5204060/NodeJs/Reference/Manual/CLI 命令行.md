---
created: 2022-07-29T13:12:53 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/cli.html
author: #
---

# CLI 命令行 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/cli/command_line_options.html)

Node.js 具有各种各样的命令行选项。 这些选项暴露了内置调试、多种执行脚本的方式、以及其他有用的运行时选项。

要在终端中将本文档作为手册页查看，则运行 `man node`。

### 概要[#](http://nodejs.cn/api-v12/cli.html#synopsis)

[中英对照](http://nodejs.cn/api-v12/cli/synopsis.html)

`node [options] [V8 options] [script.js | -e "script" | -] [--] [arguments]`

`node inspect [script.js | -e "script" | <host>:<port>] …`

`node --v8-options`

不带参数执行以启动[交互式解释器](http://nodejs.cn/api-v12/repl.html)。

### 选项[#](http://nodejs.cn/api-v12/cli.html#options)

[中英对照](http://nodejs.cn/api-v12/cli/options.html)

所有选项，包括 V8 选项，都允许用破折号 (`-`) 或下划线 (`_`) 分隔单词。

例如，`--pending-deprecation` 等价于 `--pending_deprecation`。

来自命令行的选项优先于通过 [`NODE_OPTIONS`](http://nodejs.cn/api-v12/cli.html#cli_node_options_options) 环境变量传入的选项。

#### `-`[#](http://nodejs.cn/api-v12/cli.html#-)

[中英对照](http://nodejs.cn/api-v12/cli/_.html)

新增于: v8.0.0

标准输入的别名。

#### `--`[#](http://nodejs.cn/api-v12/cli.html#--)

[中英对照](http://nodejs.cn/api-v12/cli/1.html)

新增于: v6.11.0

指示 node 选项的结束。 将其余参数传给脚本。

#### `--abort-on-uncaught-exception`[#](http://nodejs.cn/api-v12/cli.html#--abort-on-uncaught-exception)

[中英对照](http://nodejs.cn/api-v12/cli/abort_on_uncaught_exception.html)

新增于: v0.10.8

中止而不是退出会导致使用调试器（例如 `lldb`、`gdb` 和 `mdb`）生成用于事后分析的核心文件。

如果传入了此标志，则该行为仍然可以设置为不通过 [`process.setUncaughtExceptionCaptureCallback()`](http://nodejs.cn/api-v12/process.html#process_process_setuncaughtexceptioncapturecallback_fn) 中止（以及通过使用使用它的 `domain` 模块）

#### `--completion-bash`[#](http://nodejs.cn/api-v12/cli.html#--completion-bash)

[中英对照](http://nodejs.cn/api-v12/cli/completion_bash.html)

新增于: v10.12.0

为 Node.js 打印可源代码的 bash 完成脚本。

```
$ node --completion-bash > node_bash_completion
$ source node_bash_completion
```

#### `--conditions=condition`[#](http://nodejs.cn/api-v12/cli.html#--conditionscondition)

[中英对照](http://nodejs.cn/api-v12/cli/conditions_condition.html)

新增于: v12.19.0

允许任意数量的自定义字符串条件名称。

`"node"`、`"default"`、`"import"` 和 `"require"` 的默认 Node.js 条件将始终按照定义应用。

#### `--cpu-prof`[#](http://nodejs.cn/api-v12/cli.html#--cpu-prof)

[中英对照](http://nodejs.cn/api-v12/cli/cpu_prof.html)

新增于: v12.0.0

启动时开始 V8 CPU 分析器，并且在退出前将 CPU 分析文件写入磁盘。

```
$ node --cpu-prof index.js
$ ls *.cpuprofile
CPU.20190409.202950.15293.0.0.cpuprofile
```

#### `--cpu-prof-dir`[#](http://nodejs.cn/api-v12/cli.html#--cpu-prof-dir)

[中英对照](http://nodejs.cn/api-v12/cli/cpu_prof_dir.html)

新增于: v12.0.0

指定放置 `--cpu-prof` 生成的 CPU 分析文件的目录

#### `--cpu-prof-interval`[#](http://nodejs.cn/api-v12/cli.html#--cpu-prof-interval)

[中英对照](http://nodejs.cn/api-v12/cli/cpu_prof_interval.html)

新增于: v12.2.0

为 `--cpu-prof` 生成的 CPU 分析文件指定以微秒为单位的采样间隔。 默认为 1000 微秒。

#### `--cpu-prof-name`[#](http://nodejs.cn/api-v12/cli.html#--cpu-prof-name)

[中英对照](http://nodejs.cn/api-v12/cli/cpu_prof_name.html)

新增于: v12.0.0

指定 `--cpu-prof` 生成的 CPU 分析文件的文件名。

#### `--diagnostic-dir=directory`[#](http://nodejs.cn/api-v12/cli.html#--diagnostic-dirdirectory)

[中英对照](http://nodejs.cn/api-v12/cli/diagnostic_dir_directory.html)

默认为当前工作目录。

影响默认输出目录：

-   [\--cpu-prof-dir](http://nodejs.cn/api-v12/cli.html#cli_cpu_prof_dir)
-   [\--heap-prof-dir](http://nodejs.cn/api-v12/cli.html#cli_heap_prof_dir)
-   [\--redirect-warnings](http://nodejs.cn/api-v12/cli.html#cli_redirect_warnings_file)

#### `--disable-proto=mode`[#](http://nodejs.cn/api-v12/cli.html#--disable-protomode)

[中英对照](http://nodejs.cn/api-v12/cli/disable_proto_mode.html)

禁用 `Object.prototype.__proto__` 属性。

#### `--disallow-code-generation-from-strings`[#](http://nodejs.cn/api-v12/cli.html#--disallow-code-generation-from-strings)

[中英对照](http://nodejs.cn/api-v12/cli/disallow_code_generation_from_strings.html)

新增于: v9.8.0

使从字符串生成代码的 `eval` 和 `new Function` 等内置语言功能抛出异常。 这不会影响 Node.js `vm` 模块。

#### `--enable-fips`[#](http://nodejs.cn/api-v12/cli.html#--enable-fips)

[中英对照](http://nodejs.cn/api-v12/cli/enable_fips.html)

新增于: v6.0.0

在启动时启用符合 FIPS 的加密。

#### `--enable-source-maps`[#](http://nodejs.cn/api-v12/cli.html#--enable-source-maps)

新增于: v12.12.0

Enable experimental Source Map v3 support for stack traces.

Currently, overriding `Error.prepareStackTrace` is ignored when the `--enable-source-maps` flag is set.

#### `--experimental-import-meta-resolve`[#](http://nodejs.cn/api-v12/cli.html#--experimental-import-meta-resolve)

[中英对照](http://nodejs.cn/api-v12/cli/experimental_import_meta_resolve.html)

新增于: v12.16.2

启用实验性 `import.meta.resolve()` 支持。

#### `--experimental-json-modules`[#](http://nodejs.cn/api-v12/cli.html#--experimental-json-modules)

[中英对照](http://nodejs.cn/api-v12/cli/experimental_json_modules.html)

新增于: v12.9.0

为 ES 模块加载器启用实验性 JSON 支持。

#### `--experimental-loader=module`[#](http://nodejs.cn/api-v12/cli.html#--experimental-loadermodule)

[中英对照](http://nodejs.cn/api-v12/cli/experimental_loader_module.html)

新增于: v9.0.0

`module` 可以是文件路径，也可以是 ECMAScript 模块名称。

#### `--experimental-modules`[#](http://nodejs.cn/api-v12/cli.html#--experimental-modules)

[中英对照](http://nodejs.cn/api-v12/cli/experimental_modules.html)

新增于: v8.5.0

启用最新的实验模块功能（已弃用）。

#### `--experimental-policy`[#](http://nodejs.cn/api-v12/cli.html#--experimental-policy)

[中英对照](http://nodejs.cn/api-v12/cli/experimental_policy.html)

新增于: v11.8.0

使用指定的文件作为安全策略。

#### `--experimental-repl-await`[#](http://nodejs.cn/api-v12/cli.html#--experimental-repl-await)

[中英对照](http://nodejs.cn/api-v12/cli/experimental_repl_await.html)

新增于: v10.0.0

在交互式解释器中启用实验性的顶层 `await` 关键字支持。

#### `--experimental-specifier-resolution=mode`[#](http://nodejs.cn/api-v12/cli.html#--experimental-specifier-resolutionmode)

[中英对照](http://nodejs.cn/api-v12/cli/experimental_specifier_resolution_mode.html)

新增于: v12.16.0

设置解析 ES 模块说明符的解析算法。 有效选项为 `explicit` 和 `node`。

默认为 `explicit`，需要提供模块的完整路径。

#### `--experimental-vm-modules`[#](http://nodejs.cn/api-v12/cli.html#--experimental-vm-modules)

[中英对照](http://nodejs.cn/api-v12/cli/experimental_vm_modules.html)

新增于: v9.6.0

在 `vm` 模块中启用实验性 ES 模块支持。

#### `--experimental-wasi-unstable-preview1`[#](http://nodejs.cn/api-v12/cli.html#--experimental-wasi-unstable-preview1)

[中英对照](http://nodejs.cn/api-v12/cli/experimental_wasi_unstable_preview1.html)

新增于: v12.16.0

启用实验性 WebAssembly 系统接口 (WASI) 支持。

#### `--experimental-wasm-modules`[#](http://nodejs.cn/api-v12/cli.html#--experimental-wasm-modules)

新增于: v12.3.0

#### `--force-context-aware`[#](http://nodejs.cn/api-v12/cli.html#--force-context-aware)

[中英对照](http://nodejs.cn/api-v12/cli/force_context_aware.html)

新增于: v12.12.0

禁用加载不是[上下文感知](http://nodejs.cn/api-v12/addons.html#addons_context_aware_addons)的原生插件。

启用实验性 WebAssembly 模块支持。

#### `--force-fips`[#](http://nodejs.cn/api-v12/cli.html#--force-fips)

[中英对照](http://nodejs.cn/api-v12/cli/force_fips.html)

新增于: v6.0.0

在启动时强制执行符合 FIPS 的加密。 （不能从脚本代码中禁用。）（与 `--enable-fips` 要求相同。）

#### `--frozen-intrinsics`[#](http://nodejs.cn/api-v12/cli.html#--frozen-intrinsics)

[中英对照](http://nodejs.cn/api-v12/cli/frozen_intrinsics.html)

新增于: v11.12.0

启用像 `Array` 和 `Object` 这样的实验性冻结内在函数。

目前只为根上下文提供支持，目前不保证 `global.Array` 确实是默认的内在引用。 代码可能会在此标志下被破坏。

`--require` 在冻结内部函数之前运行以允许添加 polyfill。

#### `--heapsnapshot-signal=signal`[#](http://nodejs.cn/api-v12/cli.html#--heapsnapshot-signalsignal)

[中英对照](http://nodejs.cn/api-v12/cli/heapsnapshot_signal_signal.html)

新增于: v12.0.0

启用信号句柄，当接收到指定的信号时，它会导致 Node.js 进程写入堆转储。 `signal` 必须是有效的信号名称。 默认禁用。

```
$ node --heapsnapshot-signal=SIGUSR2 index.js &
$ ps aux
USER       PID %CPU %MEM    VSZ   RSS TTY      STAT START   TIME COMMAND
node         1  5.5  6.1 787252 247004 ?       Ssl  16:43   0:02 node --heapsnapshot-signal=SIGUSR2 index.js
$ kill -USR2 1
$ ls
Heap.20190718.133405.15554.0.001.heapsnapshot
```

#### `--heap-prof`[#](http://nodejs.cn/api-v12/cli.html#--heap-prof)

[中英对照](http://nodejs.cn/api-v12/cli/heap_prof.html)

新增于: v12.4.0

在启动时开始 V8 堆分析器，并在退出前将堆分析器写入磁盘。

```
$ node --heap-prof index.js
$ ls *.heapprofile
Heap.20190409.202950.15293.0.001.heapprofile
```

#### `--heap-prof-dir`[#](http://nodejs.cn/api-v12/cli.html#--heap-prof-dir)

[中英对照](http://nodejs.cn/api-v12/cli/heap_prof_dir.html)

新增于: v12.4.0

指定 `--heap-prof` 生成的堆分析文件将被放置的目录。

#### `--heap-prof-interval`[#](http://nodejs.cn/api-v12/cli.html#--heap-prof-interval)

[中英对照](http://nodejs.cn/api-v12/cli/heap_prof_interval.html)

新增于: v12.4.0

指定 `--heap-prof` 生成的堆分析文件的平均采样间隔（以字节为单位）。 默认为 512 \* 1024 字节。

#### `--heap-prof-name`[#](http://nodejs.cn/api-v12/cli.html#--heap-prof-name)

[中英对照](http://nodejs.cn/api-v12/cli/heap_prof_name.html)

新增于: v12.4.0

指定 `--heap-prof` 生成的堆分析文件的文件名。

#### `--http-parser=library`[#](http://nodejs.cn/api-v12/cli.html#--http-parserlibrary)

Chooses an HTTP parser library. Available values are:

-   `llhttp` for [https://llhttp.org/](https://llhttp.org/)
-   `legacy` for [https://github.com/nodejs/http-parser](https://github.com/nodejs/http-parser)

The default is `llhttp`, unless otherwise specified when building Node.js.

The `legacy` HTTP parser is deprecated and will emit a deprecation warning.

This flag exists to aid in experimentation with the internal implementation of the Node.js http parser. This flag is likely to become a no-op and removed at some point in the future.

#### `--http-server-default-timeout=milliseconds`[#](http://nodejs.cn/api-v12/cli.html#--http-server-default-timeoutmilliseconds)

新增于: v12.4.0

Overrides the default value of `http`, `https` and `http2` server socket timeout. Setting the value to 0 disables server socket timeout. Unless provided, http server sockets timeout after 120s (2 minutes). Programmatic setting of the timeout takes precedence over the value set through this flag.

#### `--icu-data-dir=file`[#](http://nodejs.cn/api-v12/cli.html#--icu-data-dirfile)

[中英对照](http://nodejs.cn/api-v12/cli/icu_data_dir_file.html)

新增于: v0.11.15

指定 ICU 数据加载路径。 （覆盖 `NODE_ICU_DATA`。）

#### `--input-type=type`[#](http://nodejs.cn/api-v12/cli.html#--input-typetype)

[中英对照](http://nodejs.cn/api-v12/cli/input_type_type.html)

新增于: v12.0.0

这将 Node.js 配置为将字符串输入解释为 CommonJS 或 ES 模块。 字符串输入是通过 `--eval`、`--print` 或 `STDIN` 输入的。

有效值为 `"commonjs"` 和 `"module"`。 默认为 `"commonjs"`。

#### `--inspect-brk[=[host:]port]`[#](http://nodejs.cn/api-v12/cli.html#--inspect-brkhostport)

[中英对照](http://nodejs.cn/api-v12/cli/inspect_brk_host_port.html)

新增于: v7.6.0

在 `host:port` 上激活检查器并在用户脚本开始时中断。 默认 `host:port` 为 `127.0.0.1:9229`。

#### `--inspect-port=[host:]port`[#](http://nodejs.cn/api-v12/cli.html#--inspect-porthostport)

[中英对照](http://nodejs.cn/api-v12/cli/inspect_port_host_port.html)

新增于: v7.6.0

设置检查器激活时使用的 `host:port`。 在通过发送 `SIGUSR1` 信号激活检查器时很有用。

默认主机是 `127.0.0.1`。

请参阅下面有关 `host` 参数用法的[安全警告](http://nodejs.cn/api-v12/cli.html#inspector_security)。

#### `--inspect[=[host:]port]`[#](http://nodejs.cn/api-v12/cli.html#--inspecthostport)

[中英对照](http://nodejs.cn/api-v12/cli/inspect_host_port.html)

新增于: v6.3.0

在 `host:port` 上激活检查器。 默认为 `127.0.0.1:9229`。

V8 检查器集成允许 Chrome 开发者工具和 IDE 等工具调试和分析 Node.js 实例。 该工具通过 tcp 端口连接到 Node.js 实例，并使用 [Chrome 开发者工具协议](http://url.nodejs.cn/YpFEVu)进行通信。

##### 注意：绑定检查器到公共的“IP:端口”组合是不安全的[#](http://nodejs.cn/api-v12/cli.html#warning-binding-inspector-to-a-public-ipport-combination-is-insecure)

[中英对照](http://nodejs.cn/api-v12/cli/warning_binding_inspector_to_a_public_ip_port_combination_is_insecure.html)

将检查器绑定到具有开放端口的公共 IP（包括 `0.0.0.0`）是不安全的，因为它允许外部主机连接到检查器并执行[远程代码执行](http://url.nodejs.cn/JswVrV)攻击。

如果指定主机，请确保：

-   无法从公共网络访问该主机。
-   防火墙不允许端口上不需要的连接。 **更具体地说，如果端口（默认情况下为 `9229`）不受防火墙保护，则 `--inspect=0.0.0.0` 是不安全的。**

有关详细信息，请参阅[调试安全隐患](http://url.nodejs.cn/TAYzUg)章节。

#### `--inspect-publish-uid=stderr,http`[#](http://nodejs.cn/api-v12/cli.html#--inspect-publish-uidstderrhttp)

[中英对照](http://nodejs.cn/api-v12/cli/inspect_publish_uid_stderr_http.html)

指定检查器网络套接字网址的暴露方式。

默认情况下，检查器网络套接字网址在标准错误和 `http://host:port/json/list` 上的 `/json/list` 端点下可用。

#### `--insecure-http-parser`[#](http://nodejs.cn/api-v12/cli.html#--insecure-http-parser)

[中英对照](http://nodejs.cn/api-v12/cli/insecure_http_parser.html)

新增于: v12.15.0

使用接受无效 HTTP 标头的不安全 HTTP 解析器。 这可能允许与不一致的 HTTP 实现的互操作性。 它还可能允许请求走私和其他依赖于接受无效标头的 HTTP 攻击。 避免使用此选项。

#### `--jitless`[#](http://nodejs.cn/api-v12/cli.html#--jitless)

[中英对照](http://nodejs.cn/api-v12/cli/jitless.html)

新增于: v12.0.0

禁用[可执行内存的运行时分配](http://url.nodejs.cn/EKvv22)。 出于安全原因，某些平台可能需要这样做。 在其他平台上也可以减少攻击面，但性能影响可能比较严重。

此标志是从 V8 继承的，可能会在上游发生变化。 它可能会在非语义化主版本中消失。

#### `--max-http-header-size=size`[#](http://nodejs.cn/api-v12/cli.html#--max-http-header-sizesize)

[中英对照](http://nodejs.cn/api-v12/cli/max_http_header_size_size.html)

新增于: v11.6.0

指定 HTTP 标头的最大大小（以字节为单位）。 默认为 8KB。

#### `--napi-modules`[#](http://nodejs.cn/api-v12/cli.html#--napi-modules)

[中英对照](http://nodejs.cn/api-v12/cli/napi_modules.html)

新增于: v7.10.0

此选项为空操作。 它是为了兼容性而保留的。

#### `--no-deprecation`[#](http://nodejs.cn/api-v12/cli.html#--no-deprecation)

[中英对照](http://nodejs.cn/api-v12/cli/no_deprecation.html)

新增于: v0.8.0

静默弃用警告。

#### `--no-force-async-hooks-checks`[#](http://nodejs.cn/api-v12/cli.html#--no-force-async-hooks-checks)

[中英对照](http://nodejs.cn/api-v12/cli/no_force_async_hooks_checks.html)

新增于: v9.0.0

禁用 `async_hooks` 的运行时检查。 当启用 `async_hooks` 时，这些仍然会动态启用。

#### `--no-warnings`[#](http://nodejs.cn/api-v12/cli.html#--no-warnings)

[中英对照](http://nodejs.cn/api-v12/cli/no_warnings.html)

新增于: v6.0.0

静默所有进程警告（包括弃用的）。

#### `--openssl-config=file`[#](http://nodejs.cn/api-v12/cli.html#--openssl-configfile)

[中英对照](http://nodejs.cn/api-v12/cli/openssl_config_file.html)

新增于: v6.9.0

在启动时加载 OpenSSL 配置文件。 除其他用途外，如果 Node.js 是使用 `./configure --openssl-fips` 构建的，则可用于启用符合 FIPS 的加密。

#### `--pending-deprecation`[#](http://nodejs.cn/api-v12/cli.html#--pending-deprecation)

[中英对照](http://nodejs.cn/api-v12/cli/pending_deprecation.html)

新增于: v8.0.0

触发挂起的弃用警告。

待弃用用于提供一种选择性的"早期警告"机制，开发者可以利用该机制来检测弃用的 API 的使用情况。

#### `--policy-integrity=sri`[#](http://nodejs.cn/api-v12/cli.html#--policy-integritysri)

[中英对照](http://nodejs.cn/api-v12/cli/policy_integrity_sri.html)

新增于: v12.7.0

如果策略不具有指定的完整性，则指示 Node.js 在运行任何代码之前出错。 它需要[子资源完整性](http://url.nodejs.cn/me6fpf)字符串作为参数。

#### `--preserve-symlinks`[#](http://nodejs.cn/api-v12/cli.html#--preserve-symlinks)

[中英对照](http://nodejs.cn/api-v12/cli/preserve_symlinks.html)

新增于: v6.3.0

指示模块加载器在解析和缓存模块时保留符号链接。

默认情况下，当 Node.js 从符号链接到不同磁盘位置的路径加载模块时，Node.js 将取消引用该链接并使用模块的实际磁盘“真实路径”作为既是标识符又是定位其他依赖模块的根路径。 在大多数情况下，这种默认行为是可以接受的。 但是，当使用符号链接的对等依赖项时，如下例所示，如果 `moduleA` 尝试要求 `moduleB` 作为对等依赖项，则默认行为会引发异常：

```
{appDir}
 ├── app
 │   ├── index.js
 │   └── node_modules
 │       ├── moduleA -> {appDir}/moduleA
 │       └── moduleB
 │           ├── index.js
 │           └── package.json
 └── moduleA
     ├── index.js
     └── package.json
```

但是请注意，使用 `--preserve-symlinks` 会产生其他副作用。 具体来说，如果这些模块是从依赖树中的多个位置链接的，那么符号链接的原生模块可能无法加载（Node.js 会将它们视为两个单独的模块，并会尝试多次加载该模块，从而导致异常被抛出）。

`--preserve-symlinks` 标志不适用于允许 `node --preserve-symlinks node_module/.bin/<foo>` 工作的主模块。 要对主模块应用相同的行为，也请使用 `--preserve-symlinks-main`。

#### `--preserve-symlinks-main`[#](http://nodejs.cn/api-v12/cli.html#--preserve-symlinks-main)

[中英对照](http://nodejs.cn/api-v12/cli/preserve_symlinks_main.html)

新增于: v10.2.0

指示模块加载器在解析和缓存主模块 (`require.main`) 时保留符号链接。

此标志的存在是为了让主模块可以选择加入 `--preserve-symlinks` 为所有其他导入提供的相同行为；但是，它们是单独的标志，以便与旧的 Node.js 版本向后兼容。

有关详细信息，请参阅 `--preserve-symlinks`。

#### `--prof`[#](http://nodejs.cn/api-v12/cli.html#--prof)

[中英对照](http://nodejs.cn/api-v12/cli/prof.html)

新增于: v2.0.0

生成 V8 分析器输出。

#### `--prof-process`[#](http://nodejs.cn/api-v12/cli.html#--prof-process)

[中英对照](http://nodejs.cn/api-v12/cli/prof_process.html)

新增于: v5.2.0

处理使用 V8 选项 `--prof` 生成的 V8 分析器输出。

#### `--redirect-warnings=file`[#](http://nodejs.cn/api-v12/cli.html#--redirect-warningsfile)

[中英对照](http://nodejs.cn/api-v12/cli/redirect_warnings_file.html)

新增于: v8.0.0

将进程警告写入给定文件而不是打印到标准错误。 如果文件不存在则创建，如果存在则追加。 如果在尝试将警告写入文件时发生错误，则警告将改为写入标准错误。

`file` 名称可以是绝对路径。

#### `--report-compact`[#](http://nodejs.cn/api-v12/cli.html#--report-compact)

[中英对照](http://nodejs.cn/api-v12/cli/report_compact.html)

新增于: v12.17.0

以紧凑的单行 JSON 格式编写报告，与专为人类使用而设计的默认多行格式相比，日志处理系统更易于使用。

#### `--report-dir=directory`, `report-directory=directory`[#](http://nodejs.cn/api-v12/cli.html#--report-dirdirectory-report-directorydirectory)

[中英对照](http://nodejs.cn/api-v12/cli/report_dir_directory_report_directory_directory.html)

生成报告的位置。

#### `--report-filename=filename`[#](http://nodejs.cn/api-v12/cli.html#--report-filenamefilename)

[中英对照](http://nodejs.cn/api-v12/cli/report_filename_filename.html)

将写入报告的文件的名称。

#### `--report-on-fatalerror`[#](http://nodejs.cn/api-v12/cli.html#--report-on-fatalerror)

[中英对照](http://nodejs.cn/api-v12/cli/report_on_fatalerror.html)

使报告能够在导致应用程序终止的致命错误（Node.js 运行时中的内部错误，例如内存不足）时触发。 用于检查各种诊断数据元素，例如堆、堆栈、事件循环状态、资源消耗等 推断致命错误。

#### `--report-on-signal`[#](http://nodejs.cn/api-v12/cli.html#--report-on-signal)

[中英对照](http://nodejs.cn/api-v12/cli/report_on_signal.html)

在接收到正在运行的 Node.js 进程的指定（或预定义）信号时生成报告。 触发报告的信号通过 `--report-signal` 指定。

#### `--report-signal=signal`[#](http://nodejs.cn/api-v12/cli.html#--report-signalsignal)

[中英对照](http://nodejs.cn/api-v12/cli/report_signal_signal.html)

设置或重置报告生成信号（Windows 不支持）。 默认信号为 `SIGUSR2`。

#### `--report-uncaught-exception`[#](http://nodejs.cn/api-v12/cli.html#--report-uncaught-exception)

[中英对照](http://nodejs.cn/api-v12/cli/report_uncaught_exception.html)

启用对未捕获的异常生成报告。 在结合原生堆栈和其他运行时环境数据检查 JavaScript 堆栈时很有用。

#### `--throw-deprecation`[#](http://nodejs.cn/api-v12/cli.html#--throw-deprecation)

[中英对照](http://nodejs.cn/api-v12/cli/throw_deprecation.html)

新增于: v0.11.14

为弃用抛出错误。

#### `--title=title`[#](http://nodejs.cn/api-v12/cli.html#--titletitle)

[中英对照](http://nodejs.cn/api-v12/cli/title_title.html)

新增于: v10.7.0

在启动时设置 `process.title`。

#### `--tls-cipher-list=list`[#](http://nodejs.cn/api-v12/cli.html#--tls-cipher-listlist)

[中英对照](http://nodejs.cn/api-v12/cli/tls_cipher_list_list.html)

新增于: v4.0.0

指定替代的默认 TLS 密码列表。 需要使用加密支持构建 Node.js（默认）。

#### `--tls-keylog=file`[#](http://nodejs.cn/api-v12/cli.html#--tls-keylogfile)

[中英对照](http://nodejs.cn/api-v12/cli/tls_keylog_file.html)

新增于: v12.16.0

将 TLS 密钥材料记录到文件中。 密钥材料为 NSS `SSLKEYLOGFILE` 格式，可被软件（如 Wireshark）用于解密 TLS 流量。

#### `--tls-max-v1.2`[#](http://nodejs.cn/api-v12/cli.html#--tls-max-v12)

[中英对照](http://nodejs.cn/api-v12/cli/tls_max_v1_2.html)

新增于: v12.0.0

将 [`tls.DEFAULT_MAX_VERSION`](http://nodejs.cn/api-v12/tls.html#tls_tls_default_max_version) 设置为 'TLSv1.2'。 用于禁用对 TLSv1.3 的支持。

#### `--tls-max-v1.3`[#](http://nodejs.cn/api-v12/cli.html#--tls-max-v13)

[中英对照](http://nodejs.cn/api-v12/cli/tls_max_v1_3.html)

新增于: v12.0.0

将默认的 [`tls.DEFAULT_MAX_VERSION`](http://nodejs.cn/api-v12/tls.html#tls_tls_default_max_version) 设置为 'TLSv1.3'。 用于启用对 TLSv1.3 的支持。

#### `--tls-min-v1.0`[#](http://nodejs.cn/api-v12/cli.html#--tls-min-v10)

[中英对照](http://nodejs.cn/api-v12/cli/tls_min_v1_0.html)

新增于: v12.0.0

将默认的 [`tls.DEFAULT_MIN_VERSION`](http://nodejs.cn/api-v12/tls.html#tls_tls_default_min_version) 设置为 'TLSv1'。 用于与旧的 TLS 客户端或服务器兼容。

#### `--tls-min-v1.1`[#](http://nodejs.cn/api-v12/cli.html#--tls-min-v11)

[中英对照](http://nodejs.cn/api-v12/cli/tls_min_v1_1.html)

新增于: v12.0.0

将默认的 [`tls.DEFAULT_MIN_VERSION`](http://nodejs.cn/api-v12/tls.html#tls_tls_default_min_version) 设置为 'TLSv1.1'。 用于与旧的 TLS 客户端或服务器兼容。

#### `--tls-min-v1.2`[#](http://nodejs.cn/api-v12/cli.html#--tls-min-v12)

[中英对照](http://nodejs.cn/api-v12/cli/tls_min_v1_2.html)

新增于: v12.2.0

将默认的 [`tls.DEFAULT_MIN_VERSION`](http://nodejs.cn/api-v12/tls.html#tls_tls_default_min_version) 设置为 'TLSv1.2'。 这是 12.x 及更高版本的默认设置，但支持该选项是为了与较旧的 Node.js 版本兼容。

#### `--tls-min-v1.3`[#](http://nodejs.cn/api-v12/cli.html#--tls-min-v13)

[中英对照](http://nodejs.cn/api-v12/cli/tls_min_v1_3.html)

新增于: v12.0.0

将默认的 [`tls.DEFAULT_MIN_VERSION`](http://nodejs.cn/api-v12/tls.html#tls_tls_default_min_version) 设置为 'TLSv1.3'。 用于禁用对 TLSv1.2 的支持，它不如 TLSv1.3 安全。

#### `--trace-deprecation`[#](http://nodejs.cn/api-v12/cli.html#--trace-deprecation)

[中英对照](http://nodejs.cn/api-v12/cli/trace_deprecation.html)

新增于: v0.8.0

打印弃用的堆栈跟踪。

#### `--trace-event-categories`[#](http://nodejs.cn/api-v12/cli.html#--trace-event-categories)

[中英对照](http://nodejs.cn/api-v12/cli/trace_event_categories.html)

新增于: v7.7.0

使用 `--trace-events-enabled` 启用跟踪事件跟踪时应跟踪的逗号分隔的类别列表。

#### `--trace-event-file-pattern`[#](http://nodejs.cn/api-v12/cli.html#--trace-event-file-pattern)

[中英对照](http://nodejs.cn/api-v12/cli/trace_event_file_pattern.html)

新增于: v9.8.0

指定跟踪事件数据文件路径的模板字符串，它支持 `${rotation}` 和 `${pid}`。

#### `--trace-events-enabled`[#](http://nodejs.cn/api-v12/cli.html#--trace-events-enabled)

[中英对照](http://nodejs.cn/api-v12/cli/trace_events_enabled.html)

新增于: v7.7.0

启用跟踪事件跟踪信息的收集。

#### `--trace-exit`[#](http://nodejs.cn/api-v12/cli.html#--trace-exit)

[中英对照](http://nodejs.cn/api-v12/cli/trace_exit.html)

新增于: v12.16.0

每当主动退出环境时打印堆栈跟踪，即调用 `process.exit()`。

#### `--trace-sigint`[#](http://nodejs.cn/api-v12/cli.html#--trace-sigint)

[中英对照](http://nodejs.cn/api-v12/cli/trace_sigint.html)

新增于: v12.17.0

在 SIGINT 上打印堆栈跟踪。

#### `--trace-sync-io`[#](http://nodejs.cn/api-v12/cli.html#--trace-sync-io)

[中英对照](http://nodejs.cn/api-v12/cli/trace_sync_io.html)

新增于: v2.1.0

在第一轮事件循环后检测到同步 I/O 时打印堆栈跟踪。

#### `--trace-tls`[#](http://nodejs.cn/api-v12/cli.html#--trace-tls)

[中英对照](http://nodejs.cn/api-v12/cli/trace_tls.html)

新增于: v12.2.0

将 TLS 数据包跟踪信息打印到 `stderr`。 这可用于调试 TLS 连接问题。

#### `--trace-uncaught`[#](http://nodejs.cn/api-v12/cli.html#--trace-uncaught)

[中英对照](http://nodejs.cn/api-v12/cli/trace_uncaught.html)

新增于: v12.16.0

打印未捕获异常的堆栈跟踪；通常，打印与创建 `Error` 相关的堆栈跟踪，而这使得 Node.js 也打印与抛出值相关的堆栈跟踪（不需要是 `Error` 实例）

启用此选项可能会对垃圾回收行为产生负面影响。

#### `--trace-warnings`[#](http://nodejs.cn/api-v12/cli.html#--trace-warnings)

[中英对照](http://nodejs.cn/api-v12/cli/trace_warnings.html)

新增于: v6.0.0

打印进程警告的堆栈跟踪（包括弃用）。

#### `--track-heap-objects`[#](http://nodejs.cn/api-v12/cli.html#--track-heap-objects)

[中英对照](http://nodejs.cn/api-v12/cli/track_heap_objects.html)

新增于: v2.4.0

跟踪堆快照的堆对象分配。

#### `--unhandled-rejections=mode`[#](http://nodejs.cn/api-v12/cli.html#--unhandled-rejectionsmode)

[中英对照](http://nodejs.cn/api-v12/cli/unhandled_rejections_mode.html)

新增于: v12.0.0

默认情况下，如果未使用 [`unhandledRejection`](http://nodejs.cn/api-v12/process.html#process_event_unhandledrejection) 钩子，则所有未处理的拒绝都会触发警告以及第一个未处理的拒绝的弃用警告。

使用此标志可以改变发生未经处理的拒绝时应该发生的事情。

-   `strict`: 上升未处理的拒绝作为未捕获的异常。
-   `warn`: 始终触发警告，无论是否设置了 [`unhandledRejection`](http://nodejs.cn/api-v12/process.html#process_event_unhandledrejection) 钩子，但不打印弃用警告。
-   `none`: 静默所有警告。

#### `--use-bundled-ca`, `--use-openssl-ca`[#](http://nodejs.cn/api-v12/cli.html#--use-bundled-ca---use-openssl-ca)

[中英对照](http://nodejs.cn/api-v12/cli/use_bundled_ca_use_openssl_ca.html)

新增于: v6.11.0

使用当前 Node.js 版本提供的捆绑 Mozilla CA 存储或使用 OpenSSL 的默认 CA 存储。 在构建时可以选择默认存储。

Node.js 提供的捆绑 CA 存储是 Mozilla CA 存储的快照，在发布时已修复。 它在所有支持的平台上都是相同的。

使用 OpenSSL 存储允许对存储进行外部修改。 对于大多数 Linux 和 BSD 发行版，这个存储是由发行版维护者和系统管理员维护的。 OpenSSL CA 存储位置取决于 OpenSSL 库的配置，但这可以在运行时使用环境变量进行更改。

参见 `SSL_CERT_DIR` 和 `SSL_CERT_FILE`。

#### `--use-largepages=mode`[#](http://nodejs.cn/api-v12/cli.html#--use-largepagesmode)

[中英对照](http://nodejs.cn/api-v12/cli/use_largepages_mode.html)

新增于: v12.17.0

在启动时将 Node.js 静态代码重新映射到大内存页面。 如果目标系统支持，则将导致 Node.js 静态代码移动到 2 MiB 页而不是 4 KiB 页。

以下值对 `mode` 有效：

-   `off`: 不会尝试映射。 这是默认值。
-   `on`: 如果操作系统支持，则将尝试映射。 映射失败将被忽略，并且将向标准错误打印消息。
-   `silent`: 如果操作系统支持，则将尝试映射。 映射失败将被忽略，并且不会被报告。

#### `--v8-options`[#](http://nodejs.cn/api-v12/cli.html#--v8-options)

新增于: v0.1.3

Print V8 command line options.

#### `--v8-pool-size=num`[#](http://nodejs.cn/api-v12/cli.html#--v8-pool-sizenum)

[中英对照](http://nodejs.cn/api-v12/cli/v8_pool_size_num.html)

新增于: v5.10.0

设置 V8 的线程池大小，用于分配后台作业。

如果设置为 `0`，则 V8 将根据在线处理器的数量选择合适大小的线程池。

如果提供的值大于 V8 的最大值，则选择最大值。

#### `--zero-fill-buffers`[#](http://nodejs.cn/api-v12/cli.html#--zero-fill-buffers)

[中英对照](http://nodejs.cn/api-v12/cli/zero_fill_buffers.html)

新增于: v6.0.0

自动零填充所有新分配的 [`Buffer`](http://nodejs.cn/api-v12/buffer.html#buffer_class_buffer) 和 [`SlowBuffer`](http://nodejs.cn/api-v12/buffer.html#buffer_class_slowbuffer) 实例。

#### `-c`, `--check`[#](http://nodejs.cn/api-v12/cli.html#-c---check)

[中英对照](http://nodejs.cn/api-v12/cli/c_check.html)

语法检查脚本而不执行。

#### `-e`, `--eval "script"`[#](http://nodejs.cn/api-v12/cli.html#-e---eval-script)

[中英对照](http://nodejs.cn/api-v12/cli/e_eval_script.html)

将以下参数作为 JavaScript 评估。 交互式解释器中预定义的模块也可以在 `script` 中使用。

在 Windows 上，使用 `cmd.exe` 单引号将无法正常工作，因为它只能识别双 `"` 进行引用。 在 Powershell 或 Git bash 中，`'` 和 `"` 都可用。

#### `-h`, `--help`[#](http://nodejs.cn/api-v12/cli.html#-h---help)

[中英对照](http://nodejs.cn/api-v12/cli/h_help.html)

新增于: v0.1.3

此选项的输出不如本文档详细。

#### `-i`, `--interactive`[#](http://nodejs.cn/api-v12/cli.html#-i---interactive)

[中英对照](http://nodejs.cn/api-v12/cli/i_interactive.html)

新增于: v0.7.7

即使标准输入似乎不是终端，也会打开交互式解释器。

#### `-p`, `--print "script"`[#](http://nodejs.cn/api-v12/cli.html#-p---print-script)

[中英对照](http://nodejs.cn/api-v12/cli/p_print_script.html)

与 `-e` 相同，但打印结果。

#### `-r`, `--require module`[#](http://nodejs.cn/api-v12/cli.html#-r---require-module)

[中英对照](http://nodejs.cn/api-v12/cli/r_require_module.html)

新增于: v1.6.0

在启动时预加载指定的模块。

遵循 `require()` 的模块解析规则。 `module` 可以是文件路径，也可以是 node 模块名称。

#### `-v`, `--version`[#](http://nodejs.cn/api-v12/cli.html#-v---version)

[中英对照](http://nodejs.cn/api-v12/cli/v_version.html)

新增于: v0.1.3

打印 node 的版本。

### 环境变量[#](http://nodejs.cn/api-v12/cli.html#environment-variables)

#### `NODE_DEBUG=module[,…]`[#](http://nodejs.cn/api-v12/cli.html#node_debugmodule)

[中英对照](http://nodejs.cn/api-v12/cli/node_debug_module.html)

新增于: v0.1.32

`','` 分隔的应该打印调试信息的核心模块的列表。

#### `NODE_DEBUG_NATIVE=module[,…]`[#](http://nodejs.cn/api-v12/cli.html#node_debug_nativemodule)

[中英对照](http://nodejs.cn/api-v12/cli/node_debug_native_module.html)

`','` 分隔的应打印调试信息的核心 C++ 模块的列表。

#### `NODE_DISABLE_COLORS=1`[#](http://nodejs.cn/api-v12/cli.html#node_disable_colors1)

[中英对照](http://nodejs.cn/api-v12/cli/node_disable_colors_1.html)

新增于: v0.3.0

当设置时，颜色将不会在交互式解释器中使用。

#### `NODE_EXTRA_CA_CERTS=file`[#](http://nodejs.cn/api-v12/cli.html#node_extra_ca_certsfile)

[中英对照](http://nodejs.cn/api-v12/cli/node_extra_ca_certs_file.html)

新增于: v7.3.0

当设置时，众所周知的 "root" CA（如 VeriSign）将使用 `file` 中的额外证书进行扩展。 该文件应包含一个或多个 PEM 格式的可信证书。 如果文件丢失或格式不正确，则将使用 [`process.emitWarning()`](http://nodejs.cn/api-v12/process.html#process_process_emitwarning_warning_type_code_ctor) 触发消息消息（一次），否则将忽略任何错误。

当为 TLS 或 HTTPS 客户端或服务器显式指定 `ca` 选项属性时，则既不会使用众所周知的证书，也不会使用额外的证书。

当 `node` 作为 setuid root 运行或设置了 Linux 文件功能时，则将忽略此环境变量。

#### `NODE_ICU_DATA=file`[#](http://nodejs.cn/api-v12/cli.html#node_icu_datafile)

[中英对照](http://nodejs.cn/api-v12/cli/node_icu_data_file.html)

新增于: v0.11.15

ICU (`Intl` 对象) 数据的数据路径。 在使用 small-icu 支持编译时将扩展链接数据。

#### `NODE_NO_WARNINGS=1`[#](http://nodejs.cn/api-v12/cli.html#node_no_warnings1)

[中英对照](http://nodejs.cn/api-v12/cli/node_no_warnings_1.html)

新增于: v6.11.0

当设置为 `1` 时，则静默进程警告。

#### `NODE_OPTIONS=options...`[#](http://nodejs.cn/api-v12/cli.html#node_optionsoptions)

[中英对照](http://nodejs.cn/api-v12/cli/node_options_options.html)

新增于: v8.0.0

例如：

```
NODE_OPTIONS='--require "./my path/file.js"'
```

```
# 检查器将在端口 5555 上可用
NODE_OPTIONS='--inspect=localhost:4444' node --inspect=localhost:5555
```

```
NODE_OPTIONS='--require "./a.js"' node --require "./b.js"
# 相当于：
node --require "./a.js" --require "./b.js"
```

允许的 Node.js 选项是：

-   `--conditions`
-   `--diagnostic-dir`
-   `--disable-proto`
-   `--enable-fips`
-   `--enable-source-maps`
-   `--experimental-import-meta-resolve`
-   `--experimental-json-modules`
-   `--experimental-loader`
-   `--experimental-modules`
-   `--experimental-policy`
-   `--experimental-repl-await`
-   `--experimental-specifier-resolution`
-   `--experimental-vm-modules`
-   `--experimental-wasi-unstable-preview1`
-   `--experimental-wasm-modules`
-   `--force-context-aware`
-   `--force-fips`
-   `--frozen-intrinsics`
-   `--heapsnapshot-signal`
-   `--http-parser`
-   `--http-server-default-timeout`
-   `--icu-data-dir`
-   `--input-type`
-   `--insecure-http-parser`
-   `--inspect-brk`
-   `--inspect-port`、`--debug-port`
-   `--inspect-publish-uid`
-   `--inspect`
-   `--max-http-header-size`
-   `--napi-modules`
-   `--no-deprecation`
-   `--no-force-async-hooks-checks`
-   `--no-warnings`
-   `--openssl-config`
-   `--pending-deprecation`
-   `--policy-integrity`
-   `--preserve-symlinks-main`
-   `--preserve-symlinks`
-   `--prof-process`
-   `--redirect-warnings`
-   `--report-compact`
-   `--report-dir`、`--report-directory`
-   `--report-filename`
-   `--report-on-fatalerror`
-   `--report-on-signal`
-   `--report-signal`
-   `--report-uncaught-exception`
-   `--require`、`-r`
-   `--throw-deprecation`
-   `--title`
-   `--tls-cipher-list`
-   `--tls-keylog`
-   `--tls-max-v1.2`
-   `--tls-max-v1.3`
-   `--tls-min-v1.0`
-   `--tls-min-v1.1`
-   `--tls-min-v1.2`
-   `--tls-min-v1.3`
-   `--trace-deprecation`
-   `--trace-event-categories`
-   `--trace-event-file-pattern`
-   `--trace-events-enabled`
-   `--trace-exit`
-   `--trace-sigint`
-   `--trace-sync-io`
-   `--trace-tls`
-   `--trace-uncaught`
-   `--trace-warnings`
-   `--track-heap-objects`
-   `--unhandled-rejections`
-   `--use-bundled-ca`
-   `--use-largepages`
-   `--use-openssl-ca`
-   `--v8-pool-size`
-   `--zero-fill-buffers`

允许的 V8 选项是：

-   `--abort-on-uncaught-exception`
-   `--disallow-code-generation-from-strings`
-   `--huge-max-old-generation-size`
-   `--interpreted-frames-native-stack`
-   `--jitless`
-   `--max-old-space-size`
-   `--perf-basic-prof-only-functions`
-   `--perf-basic-prof`
-   `--perf-prof-unwinding-info`
-   `--perf-prof`
-   `--stack-trace-limit`

`--perf-basic-prof-only-functions`、`--perf-basic-prof`、`--perf-prof-unwinding-info` 和 `--perf-prof` 仅在 Linux 上可用。

#### `NODE_PATH=path[:…]`[#](http://nodejs.cn/api-v12/cli.html#node_pathpath)

[中英对照](http://nodejs.cn/api-v12/cli/node_path_path.html)

新增于: v0.1.32

`':'` 分隔的目录列表，以模块搜索路径为前缀。

在 Windows 上，这是 `';'` 分隔的列表。

#### `NODE_PENDING_DEPRECATION=1`[#](http://nodejs.cn/api-v12/cli.html#node_pending_deprecation1)

[中英对照](http://nodejs.cn/api-v12/cli/node_pending_deprecation_1.html)

新增于: v8.0.0

当设置为 `1` 时，触发挂起的弃用警告。

待弃用用于提供一种选择性的"早期警告"机制，开发者可以利用该机制来检测弃用的 API 的使用情况。

#### `NODE_PENDING_PIPE_INSTANCES=instances`[#](http://nodejs.cn/api-v12/cli.html#node_pending_pipe_instancesinstances)

[中英对照](http://nodejs.cn/api-v12/cli/node_pending_pipe_instances_instances.html)

设置管道服务器等待连接时挂起的管道实例句柄数。 此设置仅适用于 Windows。

#### `NODE_PRESERVE_SYMLINKS=1`[#](http://nodejs.cn/api-v12/cli.html#node_preserve_symlinks1)

[中英对照](http://nodejs.cn/api-v12/cli/node_preserve_symlinks_1.html)

新增于: v7.1.0

当设置为 `1` 时，指示模块加载器在解析和缓存模块时保留符号链接。

#### `NODE_REDIRECT_WARNINGS=file`[#](http://nodejs.cn/api-v12/cli.html#node_redirect_warningsfile)

[中英对照](http://nodejs.cn/api-v12/cli/node_redirect_warnings_file.html)

新增于: v8.0.0

当设置时，进程警告将触发到给定文件而不是打印到标准错误 如果文件不存在则创建，如果存在则追加。 如果在尝试将警告写入文件时发生错误，则警告将改为写入标准错误。 这相当于使用 `--redirect-warnings=file` 命令行标志。

#### `NODE_REPL_HISTORY=file`[#](http://nodejs.cn/api-v12/cli.html#node_repl_historyfile)

[中英对照](http://nodejs.cn/api-v12/cli/node_repl_history_file.html)

新增于: v3.0.0

用于存储持久的交互式解释器历史的文件路径。 默认路径是 `~/.node_repl_history`，会被此变量覆盖。 将值设置为空字符串（`''` 或 `' '`）会禁用持久的交互式解释器历史记录。

#### `NODE_REPL_EXTERNAL_MODULE=file`[#](http://nodejs.cn/api-v12/cli.html#node_repl_external_modulefile)

[中英对照](http://nodejs.cn/api-v12/cli/node_repl_external_module_file.html)

新增于: v12.16.0

Node.js 模块的路径，该模块将代替内置交互式解释器加载。 将此值覆盖为空字符串 (`''`) ，则将使用内置的交互式解释器。

#### `NODE_TLS_REJECT_UNAUTHORIZED=value`

[中英对照](http://nodejs.cn/api-v12/cli/node_tls_reject_unauthorized_value.html)

如果 `value` 等于 `'0'`，则对 TLS 连接禁用证书验证。 这使得 TLS 和 HTTPS 不安全。 强烈建议不要使用此环境变量。

#### `NODE_V8_COVERAGE=dir`[#](http://nodejs.cn/api-v12/cli.html#node_v8_coveragedir)

[中英对照](http://nodejs.cn/api-v12/cli/node_v8_coverage_dir.html)

当设置时，Node.js 将开始将 [V8 JavaScript 代码覆盖](http://url.nodejs.cn/fXHha2)和[源映射](http://url.nodejs.cn/GmS6fa)数据输出到作为参数提供的目录（覆盖信息以 JSON 格式写入带有 `coverage` 前缀的文件）。

`NODE_V8_COVERAGE` 将自动传播到子进程，从而更容易检测调用 `child_process.spawn()` 系列函数的应用程序。 `NODE_V8_COVERAGE` 可以设置为空字符串，防止传播。

##### 覆盖范围的输出[#](http://nodejs.cn/api-v12/cli.html#coverage-output)

[中英对照](http://nodejs.cn/api-v12/cli/coverage_output.html)

覆盖输出为顶层键 `result` 上的 [ScriptCoverage](http://url.nodejs.cn/mJFTWA) 对象数组：

```
{
  "result": [
    {
      "scriptId": "67",
      "url": "internal/tty.js",
      "functions": []
    }
  ]
}
```

##### 源码映射的缓存[#](http://nodejs.cn/api-v12/cli.html#source-map-cache)

[中英对照](http://nodejs.cn/api-v12/cli/source_map_cache.html)

如果找到，则源映射数据将附加到 JSON 覆盖对象上的顶层键 `source-map-cache`。

`source-map-cache` 是一个对象，其中的键代表从中提取源映射的文件，其值包括原始源映射网址（在键 `url` 中）、解析的 Source Map v3 信息（在键 `data` 中）和行长度源文件（在键 `lineLengths` 中）。

```
{
  "result": [
    {
      "scriptId": "68",
      "url": "file:///absolute/path/to/source.js",
      "functions": []
    }
  ],
  "source-map-cache": {
    "file:///absolute/path/to/source.js": {
      "url": "./path-to-map.json",
      "data": {
        "version": 3,
        "sources": [
          "file:///absolute/path/to/original.js"
        ],
        "names": [
          "Foo",
          "console",
          "info"
        ],
        "mappings": "MAAMA,IACJC,YAAaC",
        "sourceRoot": "./"
      },
      "lineLengths": [
        13,
        62,
        38,
        27
      ]
    }
  }
}
```

#### `OPENSSL_CONF=file`[#](http://nodejs.cn/api-v12/cli.html#openssl_conffile)

[中英对照](http://nodejs.cn/api-v12/cli/openssl_conf_file.html)

新增于: v6.11.0

在启动时加载 OpenSSL 配置文件。 除其他用途外，如果 Node.js 是使用 `./configure --openssl-fips` 构建的，则可用于启用符合 FIPS 的加密。

#### `SSL_CERT_DIR=dir`[#](http://nodejs.cn/api-v12/cli.html#ssl_cert_dirdir)

[中英对照](http://nodejs.cn/api-v12/cli/ssl_cert_dir_dir.html)

新增于: v7.7.0

如果启用了 `--use-openssl-ca`，则将覆盖并设置包含受信任证书的 OpenSSL 目录。

注意，除非显式设置子环境，否则任何子进程都会继承此环境变量，如果它们使用 OpenSSL，可能会导致它们信任与节点相同的 CA。

#### `SSL_CERT_FILE=file`[#](http://nodejs.cn/api-v12/cli.html#ssl_cert_filefile)

[中英对照](http://nodejs.cn/api-v12/cli/ssl_cert_file_file.html)

新增于: v7.7.0

如果启用了 `--use-openssl-ca`，则将覆盖并设置包含受信任证书的 OpenSSL 文件。

注意，除非显式设置子环境，否则任何子进程都会继承此环境变量，如果它们使用 OpenSSL，可能会导致它们信任与节点相同的 CA。

#### `UV_THREADPOOL_SIZE=size`[#](http://nodejs.cn/api-v12/cli.html#uv_threadpool_sizesize)

[中英对照](http://nodejs.cn/api-v12/cli/uv_threadpool_size_size.html)

将 libuv 的线程池中使用的线程数设置为 `size` 个线程。

Node.js 尽可能使用异步的系统 API，但在它们不存在的情况下，libuv 的线程池用于基于同步的系统 API 创建异步的 node API。 使用线程池的 Node.js API 有：

-   所有 `fs` API，除了文件监视器 API 和那些显式同步的
-   异步加密 API，例如 `crypto.pbkdf2()`、`crypto.scrypt()`、`crypto.randomBytes()`、`crypto.randomFill()`、`crypto.generateKeyPair()`
-   `dns.lookup()`
-   所有 `zlib` API，除了那些显式同步的

因为 libuv 的线程池有固定的大小，这意味着如果这些 API 中的任何一个由于某种原因需要很长时间，则在 libuv 的线程池中运行的其他（看似无关的）API 的性能将会下降。 为了缓解此问题，潜在的解决方案是通过将 `'UV_THREADPOOL_SIZE'` 环境变量设置为大于 `4`（其当前默认值）的值来增加 libuv 线程池的大小。 有关更多信息，请参阅 [libuv 线程池文档](http://url.nodejs.cn/TEvh5f)。

### 有用的 V8 选项[#](http://nodejs.cn/api-v12/cli.html#useful-v8-options)

[中英对照](http://nodejs.cn/api-v12/cli/useful_v8_options.html)

V8 有自己的一组命令行选项。 任何提供给 `node` 的 V8 命令行选项都将传给 V8 来处理。 V8 的选项没有稳定性保证。 V8 团队本身并不认为它们是其正式 API 的一部分，并保留随时更改它们的权利。 同样，它们也不在 Node.js 稳定性保证范围内。 许多 V8 选项只对 V8 开发者有用。 尽管如此，有一小组 V8 选项广泛适用于 Node.js，它们记录在此处：

#### \--max-old-space-size=SIZE[#](http://nodejs.cn/api-v12/cli.html#--max-old-space-sizesize-in-megabytes)

[中英对照](http://nodejs.cn/api-v12/cli/max_old_space_size_size_in_megabytes.html)

设置 V8 旧内存部分的最大内存大小。 随着内存消耗接近极限，V8 会花更多的时间在垃圾回收上，以释放未使用的内存。

在具有 2GB 内存的机器上，考虑将其设置为 1536 (1.5GB) 以保留一些内存用于其他用途并避免交换。

```
$ node --max-old-space-size=1536 index.js
```
