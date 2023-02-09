---
created: 2022-07-29T13:12:53 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/addons.html
author: 
---

# C++ 插件 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/addons/c_addons.html)

插件是用 C++ 编写的动态链接共享对象。 [`require()`](http://nodejs.cn/api-v12/modules.html#modules_require_id) 函数可以将插件加载为普通的 Node.js 模块。 插件提供了 JavaScript 和 C/C++ 库之间的接口。

-   V8 提供了创建对象、调用函数等的机制。 V8 的 API 主要记录在 `v8.h` 头文件（Node.js 源代码树中的 `deps/v8/include/v8.h`）中，该文件也可[在线](http://url.nodejs.cn/FngRok)获取。
    
-   [libuv](http://url.nodejs.cn/QX7BGi): 实现 Node.js 事件循环、其工作线程和平台所有异步行为的 C 库。 它还可以作为跨平台的抽象库，提供跨所有主要操作系统对许多常见系统任务的简单的、类似于 POSIX 的访问，例如与文件系统、套接字、定时器和系统事件的交互。
    
-   内部 Node.js 库。 Node.js 自身导出了插件可以使用的 C++ API，其中最重要的是 `node::ObjectWrap` 类。
    
-   Node.js 包括了其他静态链接库，包括 OpenSSL。 这些其他库位于 Node.js 源代码树的 `deps/` 目录中。 只有 libuv、OpenSSL、V8 和 zlib 符号被 Node.js 有目的地重新导出，并且可以被插件在不同程度上使用。 有关其他信息，请参阅[链接到 Node.js 中包含的库](http://nodejs.cn/api-v12/addons.html#addons_linking_to_libraries_included_with_node_js)。
    

以下所有示例均可[下载](http://url.nodejs.cn/DPXXU9)，并可用作插件的起点。

### 你好世界[#](http://nodejs.cn/api-v12/addons.html#hello-world)

[中英对照](http://nodejs.cn/api-v12/addons/hello_world.html)

这个 "Hello world" 示例是一个简单的插件，用 C++ 编写，相当于以下 JavaScript 代码：

```
module.exports.hello = () => 'world';
```

首先，创建文件 `hello.cc`：

```
// hello.cc
#include <node.h>

namespace demo {

using v8::FunctionCallbackInfo;
using v8::Isolate;
using v8::Local;
using v8::NewStringType;
using v8::Object;
using v8::String;
using v8::Value;

void Method(const FunctionCallbackInfo<Value>& args) {
  Isolate* isolate = args.GetIsolate();
  args.GetReturnValue().Set(String::NewFromUtf8(
      isolate, "world", NewStringType::kNormal).ToLocalChecked());
}

void Initialize(Local<Object> exports) {
  NODE_SET_METHOD(exports, "hello", Method);
}

NODE_MODULE(NODE_GYP_MODULE_NAME, Initialize)

}  // namespace demo
```

所有 Node.js 插件都必须按照以下模式导出初始化函数：

```
void Initialize(Local<Object> exports);
NODE_MODULE(NODE_GYP_MODULE_NAME, Initialize)
```

`NODE_MODULE` 后面没有分号，因为它不是函数（参见 `node.h`）。

`module_name` 必须与最终二进制文件的文件名匹配（不包括 `.node` 后缀）。

在 `hello.cc` 示例中，初始化函数为 `Initialize`，插件模块名称为 `addon`。

使用 `node-gyp` 构建插件时，使用宏 `NODE_GYP_MODULE_NAME` 作为 `NODE_MODULE()` 的第一个参数将确保最终二进制文件的名称将传给 `NODE_MODULE()`。

#### 上下文感知的插件[#](http://nodejs.cn/api-v12/addons.html#context-aware-addons)

[中英对照](http://nodejs.cn/api-v12/addons/context_aware_addons.html)

在某些环境中，可能需要在多个上下文中多次加载 Node.js 插件。 例如，[Electron](http://url.nodejs.cn/Fvw7Aa) 运行时在单个进程中运行多个 Node.js 实例。 每个实例都有自己的 `require()` 缓存，因此当通过 `require()` 加载时，每个实例都需要原生插件才能正确运行。

可以使用宏 `NODE_MODULE_INITIALIZER` 构建上下文感知插件，该宏扩展为 Node.js 在加载插件时期望找到的函数的名称。 因此可以像下面的示例一样初始化插件：

```
using namespace v8;

extern "C" NODE_MODULE_EXPORT void
NODE_MODULE_INITIALIZER(Local<Object> exports,
                        Local<Value> module,
                        Local<Context> context) {
  /* 在此处执行插件初始化步骤。 */
}
```

另一种选择是使用宏 `NODE_MODULE_INIT()`，它也将构建上下文感知插件。 与 `NODE_MODULE()` 不同，`NODE_MODULE()` 用于围绕给定的 addon 初始化函数构造插件，而 `NODE_MODULE_INIT()` 用作此类初始化器的声明，然后是函数体。

在调用 `NODE_MODULE_INIT()` 之后，可以在函数体内使用以下三个变量：

-   `Local<Object> exports`，
-   `Local<Value> module`，和
-   `Local<Context> context`

选择构建上下文感知插件承担着仔细管理全局静态数据的责任。 由于插件可能被多次加载，甚至可能来自不同的线程，因此必须适当保护存储在插件中的任何全局静态数据，并且不得包含对 JavaScript 对象的任何持久引用。 这样做的原因是 JavaScript 对象仅在上下文中有效，并且当从错误的上下文或从与创建它们的线程不同的线程访问时，可能会导致崩溃。

通过执行以下步骤，可以构造上下文感知插件以避免全局静态数据：

-   定义一个类，该类将保存每个插件实例数据并具有该形式的静态成员
    
    ```
    static void DeleteInstance(void* data) {
      // 将 `data` 转换为类的实例并将其删除。
    }
    ```
    
-   在插件初始值设定项中堆分配此类的实例。 这可以使用 `new` 关键字来完成。
-   调用 `node::AddEnvironmentCleanupHook()`，将上面创建的实例和指向 `DeleteInstance()` 的指针传给它。 这将确保在拆除环境时删除实例。
-   将类的实例存储在 `v8::External` 中，并且
-   通过将 `v8::External` 传给创建原生支持的 JavaScript 函数的 `v8::FunctionTemplate::New()` 或 `v8::Function::New()`，将 `v8::External` 传给所有暴露给 JavaScript 的方法。 `v8::FunctionTemplate::New()` 或 `v8::Function::New()` 的第三个参数接受 `v8::External` 并使用 `v8::FunctionCallbackInfo::Data()` 方法使其在原生回调中可用。

这将确保每个插件实例数据到达可以从 JavaScript 调用的每个绑定。 每个插件实例数据还必须传入到插件可能创建的任何异步回调中。

以下示例说明了上下文感知插件的实现：

```
#include <node.h>

using namespace v8;

class AddonData {
 public:
  explicit AddonData(Isolate* isolate):
      call_count(0) {
    // 确保在环境清理时删除此每个插件实例的数据。
    node::AddEnvironmentCleanupHook(isolate, DeleteInstance, this);
  }

  // 每个插件的数据。
  int call_count;

  static void DeleteInstance(void* data) {
    delete static_cast<AddonData*>(data);
  }
};

static void Method(const v8::FunctionCallbackInfo<v8::Value>& info) {
  // 检索每个插件实例的数据。
  AddonData* data =
      reinterpret_cast<AddonData*>(info.Data().As<External>()->Value());
  data->call_count++;
  info.GetReturnValue().Set((double)data->call_count);
}

// 将此插件初始化为上下文感知。
NODE_MODULE_INIT(/* exports, module, context */) {
  Isolate* isolate = context->GetIsolate();

  // 为该插件实例创建新的 `AddonData` 实例，
  // 并将其生命周期与 Node.js 环境的生命周期联系起来。
  AddonData* data = new AddonData(isolate);

  // 将数据包装在 `v8::External` 中，
  // 以便可以将其传给暴露的方法。
  Local<External> external = External::New(isolate, data);

  // 将方法 `Method` 暴露给 JavaScript，
  // 并通过将 `external` 作为第三个参数传给 `FunctionTemplate` 构造函数
  // 来确保它接收到上面创建的每个插件实例的数据。
  exports->Set(context,
               String::NewFromUtf8(isolate, "method", NewStringType::kNormal)
                  .ToLocalChecked(),
               FunctionTemplate::New(isolate, Method, external)
                  ->GetFunction(context).ToLocalChecked()).FromJust();
}
```

##### 工作线程的支持[#](http://nodejs.cn/api-v12/addons.html#worker-support)

[中英对照](http://nodejs.cn/api-v12/addons/worker_support.html)

为了从多个 Node.js 环境（例如主线程和工作线程）加载，插件需要：

-   如上所述使用 `NODE_MODULE_INIT()` 声明为上下文感知

为了支持 [`Worker`](http://nodejs.cn/api-v12/worker_threads.html#worker_threads_class_worker) 线程，插件需要清理它们可能在此类线程存在时分配的任何资源。 这可以通过使用 `AddEnvironmentCleanupHook()` 函数来实现：

```
void AddEnvironmentCleanupHook(v8::Isolate* isolate,
                               void (*fun)(void* arg),
                               void* arg);
```

此函数添加了一个钩子，该钩子将在给定的 Node.js 实例关闭之前运行。 如有必要，可以在使用具有相同签名的 `RemoveEnvironmentCleanupHook()` 运行这些钩子之前将其删除。 回调按后进先出的顺序运行。

如有必要，还有一对额外的 `AddEnvironmentCleanupHook()` 和 `RemoveEnvironmentCleanupHook()` 重载，其中清理钩子采用回调函数。 这可用于关闭异步资源，例如插件注册的任何 libuv 句柄。

以下 `addon.cc` 使用 `AddEnvironmentCleanupHook`：

```
// addon.cc
#include <assert.h>
#include <stdlib.h>
#include <node.h>

using node::AddEnvironmentCleanupHook;
using v8::HandleScope;
using v8::Isolate;
using v8::Local;
using v8::Object;

// 注意：在实际应用程序中，不要依赖静态/全局数据。
static char cookie[] = "yum yum";
static int cleanup_cb1_called = 0;
static int cleanup_cb2_called = 0;

static void cleanup_cb1(void* arg) {
  Isolate* isolate = static_cast<Isolate*>(arg);
  HandleScope scope(isolate);
  Local<Object> obj = Object::New(isolate);
  assert(!obj.IsEmpty());  // 断言 VM 仍旧存活
  assert(obj->IsObject());
  cleanup_cb1_called++;
}

static void cleanup_cb2(void* arg) {
  assert(arg == static_cast<void*>(cookie));
  cleanup_cb2_called++;
}

static void sanity_check(void*) {
  assert(cleanup_cb1_called == 1);
  assert(cleanup_cb2_called == 1);
}

// 将此插件初始化为上下文感知。
NODE_MODULE_INIT(/* exports, module, context */) {
  Isolate* isolate = context->GetIsolate();

  AddEnvironmentCleanupHook(isolate, sanity_check, nullptr);
  AddEnvironmentCleanupHook(isolate, cleanup_cb2, cookie);
  AddEnvironmentCleanupHook(isolate, cleanup_cb1, isolate);
}
```

通过运行在 JavaScript 中进行测试：

```
// test.js
require('./build/Release/addon');
```

#### 构建[#](http://nodejs.cn/api-v12/addons.html#building)

[中英对照](http://nodejs.cn/api-v12/addons/building.html)

编写源代码后，必须将其编译为二进制 `addon.node` 文件。 为此，请在项目的顶层创建名为 `binding.gyp` 的文件，使用类似 JSON 的格式描述模块的构建配置。 该文件由 [node-gyp](http://url.nodejs.cn/kLHA2r) 使用，这是一个专门为编译 Node.js 插件而编写的工具。

```
{
  "targets": [
    {
      "target_name": "addon",
      "sources": [ "hello.cc" ]
    }
  ]
}
```

`node-gyp` 实用工具的一个版本作为 `npm` 的一部分与 Node.js 捆绑和分发。 此版本不直接提供给开发人员使用，仅旨在支持使用 `npm install` 命令编译和安装插件的能力。 希望直接使用 `node-gyp` 的开发人员可以使用命令 `npm install -g node-gyp` 安装它。 有关更多信息，包括特定于平台的要求，请参阅 `node-gyp` [安装说明](http://url.nodejs.cn/QTF5Te)。

创建 `binding.gyp` 文件后，使用 `node-gyp configure` 为当前平台生成适当的项目构建文件。 这将在 `build/` 目录中生成 `Makefile`（在 Unix 平台上）或 `vcxproj` 文件（在 Windows 上）。

接下来，调用 `node-gyp build` 命令生成编译后的 `addon.node` 文件。 这将被放入 `build/Release/` 目录。

当使用 `npm install` 安装 Node.js 插件时，npm 使用它自己的 `node-gyp` 捆绑版本来执行相同的一组操作，按需为用户平台生成插件的编译版本。

构建完成后，可以通过将 [`require()`](http://nodejs.cn/api-v12/modules.html#modules_require_id) 指向构建的 `addon.node` 模块在 Node.js 中使用二进制插件：

```
// hello.js
const addon = require('./build/Release/addon');

console.log(addon.hello());
// 打印: 'world'
```

因为编译的插件二进制文件的确切路径可能会因编译方式而异（即有时它可能在 `./build/Debug/` 中），插件可以使用[绑定](http://url.nodejs.cn/WHKP77)包来加载已编译的模块。

虽然 `bindings` 包实现在如何定位插件模块方面更为复杂，但它本质上使用了类似于以下内容的 `try…catch` 模式：

```
try {
  return require('./build/Release/addon.node');
} catch (err) {
  return require('./build/Debug/addon.node');
}
```

#### 链接到 Node.js 自带的库[#](http://nodejs.cn/api-v12/addons.html#linking-to-libraries-included-with-nodejs)

[中英对照](http://nodejs.cn/api-v12/addons/linking_to_libraries_included_with_node_js.html)

Node.js 使用静态链接库，例如 V8、libuv 和 OpenSSL。 所有插件都需要链接到 V8，也可以链接到任何其他依赖项。 通常，这就像包含适当的 `#include <...>` 语句（例如 `#include <v8.h>`）一样简单，`node-gyp` 将自动定位适当的头文件。 但是，有一些注意事项需要注意：

-   当 `node-gyp` 运行时，它会检测 Node.js 的特定发布版本并下载完整的源代码压缩包或仅下载头文件。 如果下载了完整的源代码，插件将可以完全访问完整的 Node.js 依赖项集。 但是，如果只下载 Node.js 头文件，则只有 Node.js 导出的符号可用。
    
-   `node-gyp` 可以使用指向本地 Node.js 源镜像的 `--nodedir` 标志运行。 使用此选项，插件将可以访问完整的依赖项集。
    

#### 使用 require() 加载插件[#](http://nodejs.cn/api-v12/addons.html#loading-addons-using-require)

[中英对照](http://nodejs.cn/api-v12/addons/loading_addons_using_require.html)

已编译的插件二进制文件的文件扩展名是 `.node`（与 `.dll` 或 `.so` 相反）。 [`require()`](http://nodejs.cn/api-v12/modules.html#modules_require_id) 函数用于查找具有 `.node` 文件扩展名的文件并将它们初始化为动态链接库。

调用 [`require()`](http://nodejs.cn/api-v12/modules.html#modules_require_id) 时，通常可以省略 `.node` 扩展名，Node.js 仍会找到并初始化插件。 但是，有一个注意事项，Node.js 将首先尝试定位和加载碰巧共享相同基本名称的模块或 JavaScript 文件。 例如，如果在与二进制 `addon.node` 相同的目录中有一个文件 `addon.js`，那么 [`require('addon')`](http://nodejs.cn/api-v12/modules.html#modules_require_id) 将优先于 `addon.js` 文件并加载它。

### Node.js 的原生抽象[#](http://nodejs.cn/api-v12/addons.html#native-abstractions-for-nodejs)

[中英对照](http://nodejs.cn/api-v12/addons/native_abstractions_for_node_js.html)

本文档中说明的每个示例都直接使用 Node.js 和 V8 API 来实现插件。 从一个 V8 版本到下一个版本（以及一个主要的 Node.js 版本到下一个版本），V8 API 可能并且已经发生了巨大的变化。 每次更改时，插件可能需要更新和重新编译才能继续运行。 Node.js 发布计划旨在最小化此类更改的频率和影响，但 Node.js 几乎无法确保 V8 API 的稳定性。

[Node.js 的原生抽象](http://url.nodejs.cn/TMQ3WL)（或 `nan`）提供了一组工具，建议插件开发人员使用这些工具来保持 V8 和 Node.js 过去和未来版本之间的兼容性。 有关如何使用它的说明，请参见 `nan` [示例](http://url.nodejs.cn/BmESTr)。

### N-API[#](http://nodejs.cn/api-v12/addons.html#n-api)

[中英对照](http://nodejs.cn/api-v12/addons/n_api.html)

它独立于底层 JavaScript 运行时（例如 V8），并作为 Node.js 自身的一部分进行维护。 此 API 将在 Node.js 的各个版本中保持稳定的应用程序二进制接口 (ABI)。 它旨在将插件与底层 JavaScript 引擎中的更改隔离开来，并允许为一个版本编译的模块无需重新编译即可在更高版本的 Node.js 上运行。 插件是使用本文档中概述的相同方法/工具（node-gyp 等）构建/打包的。唯一的区别是原生代码使用的 API 集。

所有其他指令保持不变。

```
// 
#include <node_api.h>

namespace demo {

napi_value Method(napi_env env, napi_callback_info args) {
  napi_value greeting;
  napi_status status;

  status = napi_create_string_utf8(env, "world", NAPI_AUTO_LENGTH, &greeting);
  if (status != napi_ok) return nullptr;
  return greeting;
}

napi_value init(napi_env env, napi_value exports) {
  napi_status status;
  napi_value fn;

  status = napi_create_function(env, nullptr, 0, Method, nullptr, &fn);
  if (status != napi_ok) return nullptr;

  status = napi_set_named_property(env, exports, "hello", fn);
  if (status != napi_ok) return nullptr;
  return exports;
}

NAPI_MODULE(NODE_GYP_MODULE_NAME, init)

}  // namespace demo
```

### 插件示例[#](http://nodejs.cn/api-v12/addons.html#addon-examples)

[中英对照](http://nodejs.cn/api-v12/addons/addon_examples.html)

以下是一些旨在帮助开发人员入门的示例插件。 这些示例使用 V8 API。 请参阅在线 [V8 手册](http://url.nodejs.cn/FngRok)以获取有关各种 V8 调用的帮助，以及 V8 的[嵌入器指南](http://url.nodejs.cn/k6sAad)以获取对所使用的几个概念（例如句柄、作用域、函数模板等）的解释。

这些示例中的每一个都使用以下 `binding.gyp` 文件：

```
{
  "targets": [
    {
      "target_name": "addon",
      "sources": [ "addon.cc" ]
    }
  ]
}
```

如果有多个 `.cc` 文件，只需将附加文件名添加到 `sources` 数组：

```
"sources": ["addon.cc", "myexample.cc"]
```

一旦 `binding.gyp` 文件准备就绪，就可以使用 `node-gyp` 配置和构建示例插件：

```
$ node-gyp configure build
```

#### 函数的参数[#](http://nodejs.cn/api-v12/addons.html#function-arguments)

[中英对照](http://nodejs.cn/api-v12/addons/function_arguments.html)

插件通常会暴露可以从 Node.js 中运行的 JavaScript 访问的对象和函数。 当从 JavaScript 调用函数时，输入参数和返回值必须映射到 C/C++ 代码和从 C/C++ 代码映射。

以下示例说明了如何读取从 JavaScript 传入的函数参数以及如何返回结果：

```
// addon.cc
#include <node.h>

namespace demo {

using v8::Exception;
using v8::FunctionCallbackInfo;
using v8::Isolate;
using v8::Local;
using v8::NewStringType;
using v8::Number;
using v8::Object;
using v8::String;
using v8::Value;

// 这是 "add" 方法的实现
// 输入参数使用
// const FunctionCallbackInfo<Value>& args 结构传入
void Add(const FunctionCallbackInfo<Value>& args) {
  Isolate* isolate = args.GetIsolate();

  // 检查传入的参数数量。
  if (args.Length() < 2) {
    // 抛出传回 JavaScript 的错误
    isolate->ThrowException(Exception::TypeError(
        String::NewFromUtf8(isolate,
                            "Wrong number of arguments",
                            NewStringType::kNormal).ToLocalChecked()));
    return;
  }

  // 检查参数类型
  if (!args[0]->IsNumber() || !args[1]->IsNumber()) {
    isolate->ThrowException(Exception::TypeError(
        String::NewFromUtf8(isolate,
                            "Wrong arguments",
                            NewStringType::kNormal).ToLocalChecked()));
    return;
  }

  // 执行操作
  double value =
      args[0].As<Number>()->Value() + args[1].As<Number>()->Value();
  Local<Number> num = Number::New(isolate, value);

  // 设置返回值
  // （使用传入的 FunctionCallbackInfo<Value>&）
  args.GetReturnValue().Set(num);
}

void Init(Local<Object> exports) {
  NODE_SET_METHOD(exports, "add", Add);
}

NODE_MODULE(NODE_GYP_MODULE_NAME, Init)

}  // namespace demo
```

编译后，可以在 Node.js 中加载和使用示例插件：

```
// test.js
const addon = require('./build/Release/addon');

console.log('This should be eight:', addon.add(3, 5));
```

#### 回调[#](http://nodejs.cn/api-v12/addons.html#callbacks)

[中英对照](http://nodejs.cn/api-v12/addons/callbacks.html)

插件中的常见做法是将 JavaScript 函数传给 C++ 函数并从那里执行它们。 以下示例说明了如何调用此类回调：

```
// addon.cc
#include <node.h>

namespace demo {

using v8::Context;
using v8::Function;
using v8::FunctionCallbackInfo;
using v8::Isolate;
using v8::Local;
using v8::NewStringType;
using v8::Null;
using v8::Object;
using v8::String;
using v8::Value;

void RunCallback(const FunctionCallbackInfo<Value>& args) {
  Isolate* isolate = args.GetIsolate();
  Local<Context> context = isolate->GetCurrentContext();
  Local<Function> cb = Local<Function>::Cast(args[0]);
  const unsigned argc = 1;
  Local<Value> argv[argc] = {
      String::NewFromUtf8(isolate,
                          "hello world",
                          NewStringType::kNormal).ToLocalChecked() };
  cb->Call(context, Null(isolate), argc, argv).ToLocalChecked();
}

void Init(Local<Object> exports, Local<Object> module) {
  NODE_SET_METHOD(module, "exports", RunCallback);
}

NODE_MODULE(NODE_GYP_MODULE_NAME, Init)

}  // namespace demo
```

此示例使用 `Init()` 的双参数形式，它接收完整的 `module` 对象作为第二个参数。 这允许插件使用单个函数完全覆盖 `exports`，而不是将该函数添加为 `exports` 的属性。

要测试它，则运行以下 JavaScript：

```
// test.js
const addon = require('./build/Release/addon');

addon((msg) => {
  console.log(msg);
// 打印: 'hello world'
});
```

在这个例子中，回调函数是同步调用的。

#### 对象工厂[#](http://nodejs.cn/api-v12/addons.html#object-factory)

[中英对照](http://nodejs.cn/api-v12/addons/object_factory.html)

插件可以从 C++ 函数中创建和返回新对象，如下例所示。 创建并返回带有属性 `msg` 的对象，该属性与传给 `createObject()` 的字符串相呼应：

```
// addon.cc
#include <node.h>

namespace demo {

using v8::Context;
using v8::FunctionCallbackInfo;
using v8::Isolate;
using v8::Local;
using v8::NewStringType;
using v8::Object;
using v8::String;
using v8::Value;

void CreateObject(const FunctionCallbackInfo<Value>& args) {
  Isolate* isolate = args.GetIsolate();
  Local<Context> context = isolate->GetCurrentContext();

  Local<Object> obj = Object::New(isolate);
  obj->Set(context,
           String::NewFromUtf8(isolate,
                               "msg",
                               NewStringType::kNormal).ToLocalChecked(),
                               args[0]->ToString(context).ToLocalChecked())
           .FromJust();

  args.GetReturnValue().Set(obj);
}

void Init(Local<Object> exports, Local<Object> module) {
  NODE_SET_METHOD(module, "exports", CreateObject);
}

NODE_MODULE(NODE_GYP_MODULE_NAME, Init)

}  // namespace demo
```

在 JavaScript 中测试它：

```
// test.js
const addon = require('./build/Release/addon');

const obj1 = addon('hello');
const obj2 = addon('world');
console.log(obj1.msg, obj2.msg);
// 打印: 'hello world'
```

#### 函数工厂[#](http://nodejs.cn/api-v12/addons.html#function-factory)

[中英对照](http://nodejs.cn/api-v12/addons/function_factory.html)

另一个常见的场景是创建封装 C++ 函数并将它们返回给 JavaScript 的 JavaScript 函数：

```
// addon.cc
#include <node.h>

namespace demo {

using v8::Context;
using v8::Function;
using v8::FunctionCallbackInfo;
using v8::FunctionTemplate;
using v8::Isolate;
using v8::Local;
using v8::NewStringType;
using v8::Object;
using v8::String;
using v8::Value;

void MyFunction(const FunctionCallbackInfo<Value>& args) {
  Isolate* isolate = args.GetIsolate();
  args.GetReturnValue().Set(String::NewFromUtf8(
      isolate, "hello world", NewStringType::kNormal).ToLocalChecked());
}

void CreateFunction(const FunctionCallbackInfo<Value>& args) {
  Isolate* isolate = args.GetIsolate();

  Local<Context> context = isolate->GetCurrentContext();
  Local<FunctionTemplate> tpl = FunctionTemplate::New(isolate, MyFunction);
  Local<Function> fn = tpl->GetFunction(context).ToLocalChecked();

  // 省略它以使其匿名
  fn->SetName(String::NewFromUtf8(
      isolate, "theFunction", NewStringType::kNormal).ToLocalChecked());

  args.GetReturnValue().Set(fn);
}

void Init(Local<Object> exports, Local<Object> module) {
  NODE_SET_METHOD(module, "exports", CreateFunction);
}

NODE_MODULE(NODE_GYP_MODULE_NAME, Init)

}  // namespace demo
```

去测试：

```
// test.js
const addon = require('./build/Release/addon');

const fn = addon();
console.log(fn());
// 打印: 'hello world'
```

#### 封装 C++ 对象[#](http://nodejs.cn/api-v12/addons.html#wrapping-c-objects)

[中英对照](http://nodejs.cn/api-v12/addons/wrapping_c_objects.html)

还可以以允许使用 JavaScript `new` 运算符创建新实例的方式封装 C++ 对象/类：

```
// addon.cc
#include <node.h>
#include "myobject.h"

namespace demo {

using v8::Local;
using v8::Object;

void InitAll(Local<Object> exports) {
  MyObject::Init(exports);
}

NODE_MODULE(NODE_GYP_MODULE_NAME, InitAll)

}  // namespace demo
```

然后，在 `myobject.h` 中，封装类继承自 `node::ObjectWrap`：

```
// myobject.h
#ifndef MYOBJECT_H
#define MYOBJECT_H

#include <node.h>
#include <node_object_wrap.h>

namespace demo {

class MyObject : public node::ObjectWrap {
 public:
  static void Init(v8::Local<v8::Object> exports);

 private:
  explicit MyObject(double value = 0);
  ~MyObject();

  static void New(const v8::FunctionCallbackInfo<v8::Value>& args);
  static void PlusOne(const v8::FunctionCallbackInfo<v8::Value>& args);

  double value_;
};

}  // namespace demo

#endif
```

在 `myobject.cc` 中，实现要暴露的各种方法。 下面，方法 `plusOne()` 通过将其添加到构造函数的原型中来暴露：

```
// myobject.cc
#include "myobject.h"

namespace demo {

using v8::Context;
using v8::Function;
using v8::FunctionCallbackInfo;
using v8::FunctionTemplate;
using v8::Isolate;
using v8::Local;
using v8::NewStringType;
using v8::Number;
using v8::Object;
using v8::ObjectTemplate;
using v8::String;
using v8::Value;

MyObject::MyObject(double value) : value_(value) {
}

MyObject::~MyObject() {
}

void MyObject::Init(Local<Object> exports) {
  Isolate* isolate = exports->GetIsolate();
  Local<Context> context = isolate->GetCurrentContext();

  Local<ObjectTemplate> addon_data_tpl = ObjectTemplate::New(isolate);
  addon_data_tpl->SetInternalFieldCount(1);  // MyObject::New() 的 1 个字段
  Local<Object> addon_data =
      addon_data_tpl->NewInstance(context).ToLocalChecked();

  // 准备构造函数模板
  Local<FunctionTemplate> tpl = FunctionTemplate::New(isolate, New, addon_data);
  tpl->SetClassName(String::NewFromUtf8(
      isolate, "MyObject", NewStringType::kNormal).ToLocalChecked());
  tpl->InstanceTemplate()->SetInternalFieldCount(1);

  // 原型
  NODE_SET_PROTOTYPE_METHOD(tpl, "plusOne", PlusOne);

  Local<Function> constructor = tpl->GetFunction(context).ToLocalChecked();
  addon_data->SetInternalField(0, constructor);
  exports->Set(context, String::NewFromUtf8(
      isolate, "MyObject", NewStringType::kNormal).ToLocalChecked(),
               constructor).FromJust();
}

void MyObject::New(const FunctionCallbackInfo<Value>& args) {
  Isolate* isolate = args.GetIsolate();
  Local<Context> context = isolate->GetCurrentContext();

  if (args.IsConstructCall()) {
    // 作为构造函数调用：`new MyObject(...)`
    double value = args[0]->IsUndefined() ?
        0 : args[0]->NumberValue(context).FromMaybe(0);
    MyObject* obj = new MyObject(value);
    obj->Wrap(args.This());
    args.GetReturnValue().Set(args.This());
  } else {
    // 作为普通函数 `MyObject(...)` 调用，变成构造调用。
    const int argc = 1;
    Local<Value> argv[argc] = { args[0] };
    Local<Function> cons =
        args.Data().As<Object>()->GetInternalField(0).As<Function>();
    Local<Object> result =
        cons->NewInstance(context, argc, argv).ToLocalChecked();
    args.GetReturnValue().Set(result);
  }
}

void MyObject::PlusOne(const FunctionCallbackInfo<Value>& args) {
  Isolate* isolate = args.GetIsolate();

  MyObject* obj = ObjectWrap::Unwrap<MyObject>(args.Holder());
  obj->value_ += 1;

  args.GetReturnValue().Set(Number::New(isolate, obj->value_));
}

}  // namespace demo
```

要构建此示例，必须将 `myobject.cc` 文件添加到 `binding.gyp`：

```
{
  "targets": [
    {
      "target_name": "addon",
      "sources": [
        "addon.cc",
        "myobject.cc"
      ]
    }
  ]
}
```

测试它：

```
// test.js
const addon = require('./build/Release/addon');

const obj = new addon.MyObject(10);
console.log(obj.plusOne());
// 打印: 11
console.log(obj.plusOne());
// 打印: 12
console.log(obj.plusOne());
// 打印: 13
```

当对象被垃圾收集时，封装器对象的析构函数将运行。 对于析构函数测试，可以使用命令行标志来强制进行垃圾回收。 这些标志由底层 V8 JavaScript 引擎提供。 它们可能会随时更改或删除。 Node.js 或 V8 没有记录它们，并且它们不应该在测试之外使用。

#### 封装对象的工厂[#](http://nodejs.cn/api-v12/addons.html#factory-of-wrapped-objects)

[中英对照](http://nodejs.cn/api-v12/addons/factory_of_wrapped_objects.html)

另外，可以使用工厂模式来避免使用 JavaScript `new` 运算符显式创建对象实例：

```
const obj = addon.createObject();
// 而不是：
// const obj = new addon.Object();
```

首先，`createObject()` 方法在 `addon.cc` 中实现：

```
// addon.cc
#include <node.h>
#include "myobject.h"

namespace demo {

using v8::FunctionCallbackInfo;
using v8::Isolate;
using v8::Local;
using v8::Object;
using v8::String;
using v8::Value;

void CreateObject(const FunctionCallbackInfo<Value>& args) {
  MyObject::NewInstance(args);
}

void InitAll(Local<Object> exports, Local<Object> module) {
  MyObject::Init(exports->GetIsolate());

  NODE_SET_METHOD(module, "exports", CreateObject);
}

NODE_MODULE(NODE_GYP_MODULE_NAME, InitAll)

}  // namespace demo
```

在 `myobject.h` 中，添加了静态方法 `NewInstance()` 来处理对象的实例化。 这个方法代替了 JavaScript 中的 `new` ：

```
// myobject.h
#ifndef MYOBJECT_H
#define MYOBJECT_H

#include <node.h>
#include <node_object_wrap.h>

namespace demo {

class MyObject : public node::ObjectWrap {
 public:
  static void Init(v8::Isolate* isolate);
  static void NewInstance(const v8::FunctionCallbackInfo<v8::Value>& args);

 private:
  explicit MyObject(double value = 0);
  ~MyObject();

  static void New(const v8::FunctionCallbackInfo<v8::Value>& args);
  static void PlusOne(const v8::FunctionCallbackInfo<v8::Value>& args);
  static v8::Global<v8::Function> constructor;
  double value_;
};

}  // namespace demo

#endif
```

`myobject.cc` 中的实现类似于前面的例子：

```
// myobject.cc
#include <node.h>
#include "myobject.h"

namespace demo {

using node::AddEnvironmentCleanupHook;
using v8::Context;
using v8::Function;
using v8::FunctionCallbackInfo;
using v8::FunctionTemplate;
using v8::Global;
using v8::Isolate;
using v8::Local;
using v8::NewStringType;
using v8::Number;
using v8::Object;
using v8::String;
using v8::Value;

// 警告！这不是线程安全的，
// 这个插件不能用于工作线程。
Global<Function> MyObject::constructor;

MyObject::MyObject(double value) : value_(value) {
}

MyObject::~MyObject() {
}

void MyObject::Init(Isolate* isolate) {
  // 准备构造函数模板
  Local<FunctionTemplate> tpl = FunctionTemplate::New(isolate, New);
  tpl->SetClassName(String::NewFromUtf8(
      isolate, "MyObject", NewStringType::kNormal).ToLocalChecked());
  tpl->InstanceTemplate()->SetInternalFieldCount(1);

  // 原型
  NODE_SET_PROTOTYPE_METHOD(tpl, "plusOne", PlusOne);

  Local<Context> context = isolate->GetCurrentContext();
  constructor.Reset(isolate, tpl->GetFunction(context).ToLocalChecked());

  AddEnvironmentCleanupHook(isolate, [](void*) {
    constructor.Reset();
  }, nullptr);
}

void MyObject::New(const FunctionCallbackInfo<Value>& args) {
  Isolate* isolate = args.GetIsolate();
  Local<Context> context = isolate->GetCurrentContext();

  if (args.IsConstructCall()) {
    // 作为构造函数调用：`new MyObject(...)`
    double value = args[0]->IsUndefined() ?
        0 : args[0]->NumberValue(context).FromMaybe(0);
    MyObject* obj = new MyObject(value);
    obj->Wrap(args.This());
    args.GetReturnValue().Set(args.This());
  } else {
    // 作为普通函数 `MyObject(...)` 调用，变成构造调用。
    const int argc = 1;
    Local<Value> argv[argc] = { args[0] };
    Local<Function> cons = Local<Function>::New(isolate, constructor);
    Local<Object> instance =
        cons->NewInstance(context, argc, argv).ToLocalChecked();
    args.GetReturnValue().Set(instance);
  }
}

void MyObject::NewInstance(const FunctionCallbackInfo<Value>& args) {
  Isolate* isolate = args.GetIsolate();

  const unsigned argc = 1;
  Local<Value> argv[argc] = { args[0] };
  Local<Function> cons = Local<Function>::New(isolate, constructor);
  Local<Context> context = isolate->GetCurrentContext();
  Local<Object> instance =
      cons->NewInstance(context, argc, argv).ToLocalChecked();

  args.GetReturnValue().Set(instance);
}

void MyObject::PlusOne(const FunctionCallbackInfo<Value>& args) {
  Isolate* isolate = args.GetIsolate();

  MyObject* obj = ObjectWrap::Unwrap<MyObject>(args.Holder());
  obj->value_ += 1;

  args.GetReturnValue().Set(Number::New(isolate, obj->value_));
}

}  // namespace demo
```

再一次，要构建此示例，必须将 `myobject.cc` 文件添加到 `binding.gyp`：

```
{
  "targets": [
    {
      "target_name": "addon",
      "sources": [
        "addon.cc",
        "myobject.cc"
      ]
    }
  ]
}
```

测试它：

```
// test.js
const createObject = require('./build/Release/addon');

const obj = createObject(10);
console.log(obj.plusOne());
// 打印: 11
console.log(obj.plusOne());
// 打印: 12
console.log(obj.plusOne());
// 打印: 13

const obj2 = createObject(20);
console.log(obj2.plusOne());
// 打印: 21
console.log(obj2.plusOne());
// 打印: 22
console.log(obj2.plusOne());
// 打印: 23
```

#### 传递封装的对象[#](http://nodejs.cn/api-v12/addons.html#passing-wrapped-objects-around)

[中英对照](http://nodejs.cn/api-v12/addons/passing_wrapped_objects_around.html)

除了封装和返回 C++ 对象之外，还可以通过使用 Node.js 辅助函数 `node::ObjectWrap::Unwrap` 将它们解包来传递被包装的对象。 以下示例显示了函数 `add()`，它可以将两个 `MyObject` 对象作为输入参数：

```
// addon.cc
#include <node.h>
#include <node_object_wrap.h>
#include "myobject.h"

namespace demo {

using v8::Context;
using v8::FunctionCallbackInfo;
using v8::Isolate;
using v8::Local;
using v8::Number;
using v8::Object;
using v8::String;
using v8::Value;

void CreateObject(const FunctionCallbackInfo<Value>& args) {
  MyObject::NewInstance(args);
}

void Add(const FunctionCallbackInfo<Value>& args) {
  Isolate* isolate = args.GetIsolate();
  Local<Context> context = isolate->GetCurrentContext();

  MyObject* obj1 = node::ObjectWrap::Unwrap<MyObject>(
      args[0]->ToObject(context).ToLocalChecked());
  MyObject* obj2 = node::ObjectWrap::Unwrap<MyObject>(
      args[1]->ToObject(context).ToLocalChecked());

  double sum = obj1->value() + obj2->value();
  args.GetReturnValue().Set(Number::New(isolate, sum));
}

void InitAll(Local<Object> exports) {
  MyObject::Init(exports->GetIsolate());

  NODE_SET_METHOD(exports, "createObject", CreateObject);
  NODE_SET_METHOD(exports, "add", Add);
}

NODE_MODULE(NODE_GYP_MODULE_NAME, InitAll)

}  // namespace demo
```

在 `myobject.h` 中，添加了新的公共方法，以允许在解封装对象后访问私有值。

```
// myobject.h
#ifndef MYOBJECT_H
#define MYOBJECT_H

#include <node.h>
#include <node_object_wrap.h>

namespace demo {

class MyObject : public node::ObjectWrap {
 public:
  static void Init(v8::Isolate* isolate);
  static void NewInstance(const v8::FunctionCallbackInfo<v8::Value>& args);
  inline double value() const { return value_; }

 private:
  explicit MyObject(double value = 0);
  ~MyObject();

  static void New(const v8::FunctionCallbackInfo<v8::Value>& args);
  static v8::Global<v8::Function> constructor;
  double value_;
};

}  // namespace demo

#endif
```

`myobject.cc` 的实现与之前类似：

```
// myobject.cc
#include <node.h>
#include "myobject.h"

namespace demo {

using node::AddEnvironmentCleanupHook;
using v8::Context;
using v8::Function;
using v8::FunctionCallbackInfo;
using v8::FunctionTemplate;
using v8::Global;
using v8::Isolate;
using v8::Local;
using v8::NewStringType;
using v8::Object;
using v8::String;
using v8::Value;

// 警告！这不是线程安全的，
// 这个插件不能用于工作线程。
Global<Function> MyObject::constructor;

MyObject::MyObject(double value) : value_(value) {
}

MyObject::~MyObject() {
}

void MyObject::Init(Isolate* isolate) {
  // 准备构造函数模板
  Local<FunctionTemplate> tpl = FunctionTemplate::New(isolate, New);
  tpl->SetClassName(String::NewFromUtf8(
      isolate, "MyObject", NewStringType::kNormal).ToLocalChecked());
  tpl->InstanceTemplate()->SetInternalFieldCount(1);

  Local<Context> context = isolate->GetCurrentContext();
  constructor.Reset(isolate, tpl->GetFunction(context).ToLocalChecked());

  AddEnvironmentCleanupHook(isolate, [](void*) {
    constructor.Reset();
  }, nullptr);
}

void MyObject::New(const FunctionCallbackInfo<Value>& args) {
  Isolate* isolate = args.GetIsolate();
  Local<Context> context = isolate->GetCurrentContext();

  if (args.IsConstructCall()) {
    // 作为构造函数调用：`new MyObject(...)`
    double value = args[0]->IsUndefined() ?
        0 : args[0]->NumberValue(context).FromMaybe(0);
    MyObject* obj = new MyObject(value);
    obj->Wrap(args.This());
    args.GetReturnValue().Set(args.This());
  } else {
    // 作为普通函数 `MyObject(...)` 调用，变成构造调用。
    const int argc = 1;
    Local<Value> argv[argc] = { args[0] };
    Local<Function> cons = Local<Function>::New(isolate, constructor);
    Local<Object> instance =
        cons->NewInstance(context, argc, argv).ToLocalChecked();
    args.GetReturnValue().Set(instance);
  }
}

void MyObject::NewInstance(const FunctionCallbackInfo<Value>& args) {
  Isolate* isolate = args.GetIsolate();

  const unsigned argc = 1;
  Local<Value> argv[argc] = { args[0] };
  Local<Function> cons = Local<Function>::New(isolate, constructor);
  Local<Context> context = isolate->GetCurrentContext();
  Local<Object> instance =
      cons->NewInstance(context, argc, argv).ToLocalChecked();

  args.GetReturnValue().Set(instance);
}

}  // namespace demo
```

测试它：

```
// test.js
const addon = require('./build/Release/addon');

const obj1 = addon.createObject(10);
const obj2 = addon.createObject(20);
const result = addon.add(obj1, obj2);

console.log(result);
// 打印: 30
```
