---
created: 2022-07-29T13:12:55 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/vm.html
author: 
---

# vm 虚拟机 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/vm/vm_executing_javascript.html)

**源代码:** [lib/vm.js](https://github.com/nodejs/node/blob/v12.22.12/lib/vm.js)

`vm` 模块允许在 V8 虚拟机上下文中编译和运行代码。 **`vm` 模块不是安全的机制。 不要使用它来运行不受信任的代码。**

JavaScript 代码可以立即编译并运行，也可以编译、保存并稍后运行。

常见的用例是在不同的 V8 上下文中运行代码。 这意味着被调用的代码与调用代码具有不同的全局对象。

可以通过[上下文隔离化](http://nodejs.cn/api-v12/vm.html#vm_what_does_it_mean_to_contextify_an_object)一个对象来提供上下文。 调用的代码将上下文中的任何属性视为全局变量。 由调用的代码引起的对全局变量的任何更改都反映在上下文对象中。

```
const vm = require('vm');

const x = 1;

const context = { x: 2 };
vm.createContext(context); // 上下文隔离化对象。

const code = 'x += 40; var y = 17;';
// `x` 和 `y` 是上下文中的全局变量。
// 最初，x 的值为 2，因为这是 context.x 的值。
vm.runInContext(code, context);

console.log(context.x); // 42
console.log(context.y); // 17

console.log(x); // 1; y 未定义。
```

### `vm.Script` 类[#](http://nodejs.cn/api-v12/vm.html#class-vmscript)

[中英对照](http://nodejs.cn/api-v12/vm/class_vm_script.html)

新增于: v0.3.1

`vm.Script` 类的实例包含可以在特定上下文中执行的预编译脚本。

#### `new vm.Script(code[, options])`[#](http://nodejs.cn/api-v12/vm.html#new-vmscriptcode-options)

[中英对照](http://nodejs.cn/api-v12/vm/new_vm_script_code_options.html)

-   `code` [<string>](http://url.nodejs.cn/9Tw2bK) 要编译的 JavaScript 代码。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `filename` [<string>](http://url.nodejs.cn/9Tw2bK) 指定此脚本生成的堆栈跟踪中使用的文件名。 **默认值:** `'evalmachine.<anonymous>'`。
    -   `lineOffset` [<number>](http://url.nodejs.cn/SXbo1v) 指定在此脚本生成的堆栈跟踪中显示的行号偏移量。 **默认值:** `0`。
    -   `columnOffset` [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `0`。
    -   `cachedData` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) 为所提供的源提供可选的 `Buffer` 或 `TypedArray` 或 `DataView`，其中包含 V8 的代码缓存数据。 当提供时，`cachedDataRejected` 值将设置为 `true` 或 `false`，具体取决于 V8 对数据的接受程度。
    -   `produceCachedData` [<boolean>](http://url.nodejs.cn/jFbvuT) 当 `true` 且没有 `cachedData` 存在时，则 V8 将尝试为 `code` 生成代码缓存数据。 当成功后，会生成带有 V8 代码缓存数据的 `Buffer` 并存储在返回的 `vm.Script` 实例的 `cachedData` 属性中。 `cachedDataProduced` 值将设置为 `true` 或 `false`，这取决于代码缓存数据是否成功生成。 此选项**已弃用**，支持 `script.createCachedData()`。 **默认值:** `false`。
    -   `importModuleDynamically` [<Function>](http://url.nodejs.cn/ceTQa6) 在调用 `import()` 时在评估此模块期间调用。 如果未指定此选项，则调用 `import()` 将使用 [`ERR_VM_DYNAMIC_IMPORT_CALLBACK_MISSING`](http://nodejs.cn/api-v12/errors.html#ERR_VM_DYNAMIC_IMPORT_CALLBACK_MISSING) 拒绝。 此选项是实验模块 API 的一部分，不应被视为稳定的。
        -   `specifier` [<string>](http://url.nodejs.cn/9Tw2bK) 传给 `import()` 的说明符
        -   `module` [<vm.Module>](http://nodejs.cn/api/vm.html#class-vmmodule)
        -   返回: [<Module Namespace Object>](http://url.nodejs.cn/uwQPrn) | [<vm.Module>](http://nodejs.cn/api/vm.html#class-vmmodule) 建议返回 `vm.Module` 以利用错误跟踪，并避免包含 `then` 函数导出的命名空间出现问题。

如果 `options` 是字符串，则指定文件名。

创建新的 `vm.Script` 对象编译 `code` 但不运行它。 编译后的 `vm.Script` 可以多次运行。 `code` 没有绑定到任何全局对象；相反，它在每次运行之前绑定，只是为了那次运行。

#### `script.createCachedData()`[#](http://nodejs.cn/api-v12/vm.html#scriptcreatecacheddata)

[中英对照](http://nodejs.cn/api-v12/vm/script_createcacheddata.html)

新增于: v10.6.0

-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

此方法可以随时调用任意次数。

```
const script = new vm.Script(`
function add(a, b) {
  return a + b;
}

const x = add(1, 2);
`);

const cacheWithoutX = script.createCachedData();

script.runInThisContext();

const cacheWithX = script.createCachedData();
```

#### `script.runInContext(contextifiedObject[, options])`[#](http://nodejs.cn/api-v12/vm.html#scriptrunincontextcontextifiedobject-options)

[中英对照](http://nodejs.cn/api-v12/vm/script_runincontext_contextifiedobject_options.html)

-   `contextifiedObject` [<Object>](http://url.nodejs.cn/jzn6Ao) `vm.createContext()` 方法返回的[上下文隔离化的](http://nodejs.cn/api-v12/vm.html#vm_what_does_it_mean_to_contextify_an_object)对象。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `displayErrors` [<boolean>](http://url.nodejs.cn/jFbvuT) 当为 `true` 时，如果编译 `code` 时出现 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)，则导致错误的代码行会附加到堆栈跟踪中。 **默认值:** `true`。
        
    -   `timeout` [<integer>](http://url.nodejs.cn/SXbo1v) 指定终止执行前执行 `code` 的毫秒数。 如果执行终止，则将抛出 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)。 此值必须是严格的正整数。
        
    -   `breakOnSigint` [<boolean>](http://url.nodejs.cn/jFbvuT)
        
        如果执行终止，则将抛出 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)。 **默认值:** `false`。
        
-   返回: [<any>](http://url.nodejs.cn/6sTGdS) 脚本中执行的最后一条语句的结果。

在给定的 `contextifiedObject` 中运行 `vm.Script` 对象包含的编译代码并返回结果。 运行代码无权访问本地作用域。

下面的示例编译代码，增加一个全局变量，设置另一个全局变量的值，然后多次执行代码。 全局变量包含在 `context` 对象中。

```
const vm = require('vm');

const context = {
  animal: 'cat',
  count: 2
};

const script = new vm.Script('count += 1; name = "kitty";');

vm.createContext(context);
for (let i = 0; i < 10; ++i) {
  script.runInContext(context);
}

console.log(context);
// 打印: { animal: 'cat', count: 12, name: 'kitty' }
```

使用 `timeout` 或 `breakOnSigint` 选项将导致新的事件循环和相应的线程被启动，其性能开销非零。

#### `script.runInNewContext([contextObject[, options]])`[#](http://nodejs.cn/api-v12/vm.html#scriptruninnewcontextcontextobject-options)

[中英对照](http://nodejs.cn/api-v12/vm/script_runinnewcontext_contextobject_options.html)

-   `contextObject` [<Object>](http://url.nodejs.cn/jzn6Ao) 将被[上下文隔离化的](http://nodejs.cn/api-v12/vm.html#vm_what_does_it_mean_to_contextify_an_object)对象。 如果为 `undefined`，则将创建新的对象。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `displayErrors` [<boolean>](http://url.nodejs.cn/jFbvuT) 当为 `true` 时，如果编译 `code` 时出现 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)，则导致错误的代码行会附加到堆栈跟踪中。 **默认值:** `true`。
        
    -   `timeout` [<integer>](http://url.nodejs.cn/SXbo1v) 指定终止执行前执行 `code` 的毫秒数。 如果执行终止，则将抛出 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)。 此值必须是严格的正整数。
        
    -   `breakOnSigint` [<boolean>](http://url.nodejs.cn/jFbvuT)
        
        如果执行终止，则将抛出 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)。 **默认值:** `false`。
        
    -   `contextName` [<string>](http://url.nodejs.cn/9Tw2bK) 新创建的上下文的可读名称。 **默认值:** `'VM Context i'`, 其中 `i` 是创建的上下文的升序数字索引。
        
    -   `contextOrigin` [<string>](http://url.nodejs.cn/9Tw2bK) 对应于新创建的用于显示目的的上下文的[来源](http://url.nodejs.cn/SYyZxA)。 来源的格式应该像 URL，但只有协议、主机和端口（如果需要），就像 [`URL`](http://nodejs.cn/api-v12/url.html#url_class_url) 对象的 [`url.origin`](http://nodejs.cn/api-v12/url.html#url_url_origin) 属性的值。 最值得注意的是，该字符串应省略尾部斜杠，因为它表示路径。 **默认值:** `''`。
        
    -   `contextCodeGeneration` [<Object>](http://url.nodejs.cn/jzn6Ao)
        
        -   `strings` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果设置为 false，则任何对 `eval` 或函数构造函数（`Function`、`GeneratorFunction` 等）的调用都将抛出 `EvalError`。 **默认值:** `true`。
        -   `wasm` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果设置为 false，则任何编译 WebAssembly 模块的尝试都将抛出 `WebAssembly.CompileError`。 **默认值:** `true`。
-   返回: [<any>](http://url.nodejs.cn/6sTGdS) 脚本中执行的最后一条语句的结果。

首先对给定的 `contextObject` 进行上下文隔离化，在创建的上下文中运行 `vm.Script` 对象包含的编译代码，并返回结果。 运行代码无权访问本地作用域。

以下示例编译设置全局变量的代码，然后在不同的上下文中多次执行代码。 全局变量设置并包含在每个单独的 `context` 中。

```
const vm = require('vm');

const script = new vm.Script('globalVar = "set"');

const contexts = [{}, {}, {}];
contexts.forEach((context) => {
  script.runInNewContext(context);
});

console.log(contexts);
// 打印: [{ globalVar: 'set' }, { globalVar: 'set' }, { globalVar: 'set' }]
```

#### `script.runInThisContext([options])`[#](http://nodejs.cn/api-v12/vm.html#scriptruninthiscontextoptions)

[中英对照](http://nodejs.cn/api-v12/vm/script_runinthiscontext_options.html)

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `displayErrors` [<boolean>](http://url.nodejs.cn/jFbvuT) 当为 `true` 时，如果编译 `code` 时出现 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)，则导致错误的代码行会附加到堆栈跟踪中。 **默认值:** `true`。
        
    -   `timeout` [<integer>](http://url.nodejs.cn/SXbo1v) 指定终止执行前执行 `code` 的毫秒数。 如果执行终止，则将抛出 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)。 此值必须是严格的正整数。
        
    -   `breakOnSigint` [<boolean>](http://url.nodejs.cn/jFbvuT)
        
        如果执行终止，则将抛出 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)。 **默认值:** `false`。
        
-   返回: [<any>](http://url.nodejs.cn/6sTGdS) 脚本中执行的最后一条语句的结果。

在当前 `global` 对象的上下文中运行 `vm.Script` 包含的编译代码。 运行代码无权访问本地作用域，但_确实_有访问当前 `global` 对象的权限。

下面的示例编译了增加 `global` 变量的代码，然后多次执行该代码：

```
const vm = require('vm');

global.globalVar = 0;

const script = new vm.Script('globalVar += 1', { filename: 'myfile.vm' });

for (let i = 0; i < 1000; ++i) {
  script.runInThisContext();
}

console.log(globalVar);

// 1000
```

### `vm.Module` 类[#](http://nodejs.cn/api-v12/vm.html#class-vmmodule)

[中英对照](http://nodejs.cn/api-v12/vm/class_vm_module.html)

新增于: v12.16.0

`vm.Module` 类为在 VM 上下文中使用 ECMAScript 模块提供了低层接口。 它是 `vm.Script` 类的对应物，它密切反映了 ECMAScript 规范中定义的[模块记录](http://url.nodejs.cn/V6bsLN)。

但是，与 `vm.Script` 不同，每个 `vm.Module` 对象都从它的创建开始绑定到上下文。 与 `vm.Script` 对象的同步性质相比，对 `vm.Module` 对象的操作本质上是异步的。 'async' 函数的使用有助于操作 `vm.Module` 对象。

使用 `vm.Module` 对象需要三个不同的步骤：创建/解析、链接、以及评估。 以下示例说明了这三个步骤

此实现位于比 [ECMAScript 模块加载器](http://nodejs.cn/api-v12/esm.html#esm_modules_ecmascript_modules)更低的级别。 虽然计划提供支持，但也无法与加载器交互。

```
const vm = require('vm');

const contextifiedObject = vm.createContext({ secret: 42 });

(async () => {
  // 步骤 1
  //
  // Create a Module by constructing a new `vm.SourceTextModule` object. This
  // parses the provided source text, throwing a `SyntaxError` if anything goes
  // wrong. By default, a Module is created in the top context. But here, we
  // specify `contextifiedObject` as the context this Module belongs to.
  //
  // Here, we attempt to obtain the default export from the module "foo", and
  // put it into local binding "secret".

  const bar = new vm.SourceTextModule(`
    import s from 'foo';
    s;
  `, { context: contextifiedObject });

  // 步骤 2
  //
  // "Link" 此模块的导入依赖项。
  //
  // 提供的链接回调（“链接器”）接受两个参数：the
  // parent module (`bar` in this case) and the string that is the specifier of
  // the imported module. The callback is expected to return a Module that
  // corresponds to the provided specifier, with certain requirements documented
  // in `module.link()`.
  //
  // If linking has not started for the returned Module, the same linker
  // callback will be called on the returned Module.
  //
  // Even top-level Modules without dependencies must be explicitly linked. The
  // callback provided would never be called, however.
  //
  // link() 方法返回 Promise，
  // 当链接器返回的所有 Promise 都解决时，则该 Promise 将被解决。
  //
  // Note: This is a contrived example in that the linker function creates a new
  // "foo" module every time it is called. In a full-fledged module system, a
  // cache would probably be used to avoid duplicated modules.

  async function linker(specifier, referencingModule) {
    if (specifier === 'foo') {
      return new vm.SourceTextModule(`
        // The "secret" variable refers to the global variable we added to
        // "contextifiedObject" when creating the context.
        export default secret;
      `, { context: referencingModule.context });

      // Using `contextifiedObject` instead of `referencingModule.context`
      // here would work as well.
    }
    throw new Error(`Unable to resolve dependency: ${specifier}`);
  }
  await bar.link(linker);

  // 步骤 3
  //
  // Evaluate the Module. The evaluate() method returns a Promise with a single
  // property "result" that contains the result of the very last statement
  // executed in the Module. In the case of `bar`, it is `s;`, which refers to
  // the default export of the `foo` module, the `secret` we set in the
  // beginning to 42.

  const { result } = await bar.evaluate();

  console.log(result);
  // 打印 42。
})();
```

#### `module.dependencySpecifiers`[#](http://nodejs.cn/api-v12/vm.html#moduledependencyspecifiers)

[中英对照](http://nodejs.cn/api-v12/vm/module_dependencyspecifiers.html)

-   [<string\[\]>](http://url.nodejs.cn/9Tw2bK)

该模块所有依赖项的说明符。 返回的数组被冻结，不允许对其进行任何更改。

对应于 ECMAScript 规范中[循环模块记录](http://url.nodejs.cn/pe2Fus)的 `[[RequestedModules]]` 字段。

#### `module.error`[#](http://nodejs.cn/api-v12/vm.html#moduleerror)

[中英对照](http://nodejs.cn/api-v12/vm/module_error.html)

-   [<any>](http://url.nodejs.cn/6sTGdS)

如果 `module.status` 为 `'errored'`，则该属性包含模块在求值过程中抛出的异常。 如果状态是别的，访问这个属性会导致抛出异常。

值 `undefined` 不能用于由于可能与 `throw undefined;` 有歧义而没有抛出异常的情况。

对应于 ECMAScript 规范中[循环模块记录](http://url.nodejs.cn/pe2Fus)的 `[[EvaluationError]]` 字段。

#### `module.evaluate([options])`[#](http://nodejs.cn/api-v12/vm.html#moduleevaluateoptions)

[中英对照](http://nodejs.cn/api-v12/vm/module_evaluate_options.html)

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `timeout` [<integer>](http://url.nodejs.cn/SXbo1v) 指定终止执行前要评估的毫秒数。 如果执行中断，则会抛出[`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)。 此值必须是严格的正整数。
        
    -   `breakOnSigint` [<boolean>](http://url.nodejs.cn/jFbvuT)
        
        如果执行中断，则会抛出[`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)。 **默认值:** `false`。
        
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

评估模块。

对应 ECMAScript 规范中[循环模块记录](http://url.nodejs.cn/pe2Fus)的 [Evaluate() 具体方法](http://url.nodejs.cn/J4YRhE)字段。

#### `module.link(linker)`[#](http://nodejs.cn/api-v12/vm.html#modulelinklinker)

[中英对照](http://nodejs.cn/api-v12/vm/module_link_linker.html)

-   `linker` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `specifier` [<string>](http://url.nodejs.cn/9Tw2bK)
        
        ```
        import foo from 'foo';
        //              ^^^^^ 模块说明符
        ```
        
    -   `referencingModule` [<vm.Module>](http://nodejs.cn/api/vm.html#class-vmmodule) `Module` 对象 `link()` 被调用。
        
    -   返回: [<vm.Module>](http://nodejs.cn/api/vm.html#class-vmmodule) | [<Promise>](http://url.nodejs.cn/ri1kj8)
        
-   返回: [<Promise>](http://url.nodejs.cn/ri1kj8)

链接模块依赖项。 此方法必须在求值前调用，并且每个模块只能调用一次。

该函数应返回 `Module` 对象或最终解析为 `Module` 对象的 `Promise`。 返回的 `Module` 必须满足以下两个不变量：

-   它必须与父 `Module` 属于相同的上下文。
-   它的 `status` 不能是 `'errored'`。

如果返回的 `Module` 的 `status` 是 `'unlinked'`，则将在返回的 `Module` 上递归调用此方法，并使用相同提供的 `linker` 函数。

`link()` 返回 `Promise`，当所有链接实例都解析为有效的 `Module` 时，它将被解析，或者如果链接器函数抛出异常或返回无效的 `Module`，则被拒绝。

链接器函数大致对应于 ECMAScript 规范中实现定义的 [HostResolveImportedModule](http://url.nodejs.cn/DjcMRi) 抽象操作，有几个关键区别：

-   当 [HostResolveImportedModule](http://url.nodejs.cn/DjcMRi) 是同步的时，允许链接器函数是异步的。

在模块链接期间使用的实际 [HostResolveImportedModule](http://url.nodejs.cn/DjcMRi) 实现是一种返回链接期间链接的模块的实现。 因为那时所有模块都已经完全链接了，[HostResolveImportedModule](http://url.nodejs.cn/DjcMRi) 实现是完全同步的每个规范。

对应 ECMAScript 规范中[循环模块记录](http://url.nodejs.cn/pe2Fus)的 [Link() 具体方法](http://url.nodejs.cn/NSenof)字段。

#### `module.namespace`[#](http://nodejs.cn/api-v12/vm.html#modulenamespace)

[中英对照](http://nodejs.cn/api-v12/vm/module_namespace.html)

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

模块的命名空间对象。 这仅在链接 (`module.link()`) 完成后可用。

对应于 ECMAScript 规范中的 [GetModuleNamespace](http://url.nodejs.cn/8AR3t2) 抽象操作。

#### `module.status`[#](http://nodejs.cn/api-v12/vm.html#modulestatus)

[中英对照](http://nodejs.cn/api-v12/vm/module_status.html)

-   [<string>](http://url.nodejs.cn/9Tw2bK)

模块的当前状态。 将是以下之一：

-   `'unlinked'`: `module.link()` 还没有被调用。
    
-   `'linking'`: `module.link()` 已被调用，但链接器函数返回的 Promise 尚未全部解决。
    
-   `'linked'`: 模块已成功链接，其所有依赖都已链接，但尚未调用 `module.evaluate()`。
    
-   `'evaluating'`: 该模块正在通过自身或父模块上的 `module.evaluate()` 进行评估。
    
-   `'evaluated'`: 模块已成功评估。
    
-   `'errored'`: 模块已被评估，但抛出异常。
    

除了 `'errored'`，此状态字符串对应于规范的[循环模块记录](http://url.nodejs.cn/pe2Fus)的 `[[Status]]` 字段。 `'errored'` 对应于规范中的 `'evaluated'`，但 `[[EvaluationError]]` 设置为不是 `undefined` 的值。

#### `module.identifier`[#](http://nodejs.cn/api-v12/vm.html#moduleidentifier)

[中英对照](http://nodejs.cn/api-v12/vm/module_identifier.html)

-   [<string>](http://url.nodejs.cn/9Tw2bK)

当前模块的标识符，在构造函数中设置。

### `vm.SourceTextModule` 类[#](http://nodejs.cn/api-v12/vm.html#class-vmsourcetextmodule)

[中英对照](http://nodejs.cn/api-v12/vm/class_vm_sourcetextmodule.html)

新增于: v9.6.0

-   继承自: [<vm.Module>](http://nodejs.cn/api/vm.html#class-vmmodule)

`vm.SourceTextModule` 类提供了 ECMAScript 规范中定义的[源文本模块记录](http://url.nodejs.cn/gCBZGk)。

#### `new vm.SourceTextModule(code[, options])`[#](http://nodejs.cn/api-v12/vm.html#new-vmsourcetextmodulecode-options)

[中英对照](http://nodejs.cn/api-v12/vm/new_vm_sourcetextmodule_code_options.html)

-   `code` [<string>](http://url.nodejs.cn/9Tw2bK) 要解析的 JavaScript 模块代码
-   `options`
    -   `identifier` [<string>](http://url.nodejs.cn/9Tw2bK) 用于堆栈跟踪的字符串。 **默认值:** `'vm:module(i)'` 其中 `i` 是上下文特定的升序索引。
    -   `cachedData` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) 为所提供的源提供可选的 `Buffer` 或 `TypedArray` 或 `DataView`，其中包含 V8 的代码缓存数据。 `code` 必须与创建此 `cachedData` 的模块相同。
    -   `context` [<Object>](http://url.nodejs.cn/jzn6Ao) `vm.createContext()` 方法返回的[上下文隔离化的](http://nodejs.cn/api-v12/vm.html#vm_what_does_it_mean_to_contextify_an_object)对象，用于编译和评估此 `Module`。
    -   `lineOffset` [<integer>](http://url.nodejs.cn/SXbo1v) 指定在此 `Module` 产生的堆栈跟踪中显示的行号偏移量。 **默认值:** `0`。
    -   `columnOffset` [<integer>](http://url.nodejs.cn/SXbo1v) **默认值:** `0`。
    -   `initializeImportMeta` [<Function>](http://url.nodejs.cn/ceTQa6) 在评估此 `Module` 期间调用以初始化 `import.meta`。
        -   `meta` [<import.meta>](http://nodejs.cn/api/esm.html#importmeta)
        -   `module` [<vm.SourceTextModule>](http://nodejs.cn/api/vm.html#class-vmsourcetextmodule)
    -   `importModuleDynamically` [<Function>](http://url.nodejs.cn/ceTQa6) 在调用 `import()` 时在评估此模块期间调用。 如果未指定此选项，则调用 `import()` 将使用 [`ERR_VM_DYNAMIC_IMPORT_CALLBACK_MISSING`](http://nodejs.cn/api-v12/errors.html#ERR_VM_DYNAMIC_IMPORT_CALLBACK_MISSING) 拒绝。
        -   `specifier` [<string>](http://url.nodejs.cn/9Tw2bK) 传给 `import()` 的说明符
        -   `module` [<vm.Module>](http://nodejs.cn/api/vm.html#class-vmmodule)
        -   返回: [<Module Namespace Object>](http://url.nodejs.cn/uwQPrn) | [<vm.Module>](http://nodejs.cn/api/vm.html#class-vmmodule) 建议返回 `vm.Module` 以利用错误跟踪，并避免包含 `then` 函数导出的命名空间出现问题。

创建新的 `SourceTextModule` 实例。

分配给作为对象的 `import.meta` 对象的属性可能允许模块访问指定 `context` 之外的信息。 使用 `vm.runInContext()` 在特定上下文中创建对象。

```
const vm = require('vm');

const contextifiedObject = vm.createContext({ secret: 42 });

(async () => {
  const module = new vm.SourceTextModule(
    'Object.getPrototypeOf(import.meta.prop).secret = secret;',
    {
      initializeImportMeta(meta) {
        // 注意：这个对象是在顶层上下文中创建的。因此，
        // Object.getPrototypeOf(import.meta.prop) 指向
        // 顶层上下文中的 Object.prototype，
        // 而不是在上下文对象中。
        meta.prop = {};
      }
    });
  // 由于模块没有依赖关系，链接器函数永远不会被调用。
  await module.link(() => {});
  await module.evaluate();

  // 现在，Object.prototype.secret 将等于 42。
  //
  // 要解决这个问题，则将上面的
  //     meta.prop = {};
  // 替换为
  //     meta.prop = vm.runInContext('{}', contextifiedObject);
})();
```

#### `sourceTextModule.createCachedData()`[#](http://nodejs.cn/api-v12/vm.html#sourcetextmodulecreatecacheddata)

[中英对照](http://nodejs.cn/api-v12/vm/sourcetextmodule_createcacheddata.html)

新增于: v12.17.0

-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

在评估模块之前，可以多次调用此方法。

```
// 创建初始模块
const module = new vm.SourceTextModule('const a = 1;');

// 从这个模块创建缓存数据
const cachedData = module.createCachedData();

// 使用缓存数据创建新的模块。代码必须相同。
const module2 = new vm.SourceTextModule('const a = 1;', { cachedData });
```

### `vm.SyntheticModule` 类[#](http://nodejs.cn/api-v12/vm.html#class-vmsyntheticmodule)

[中英对照](http://nodejs.cn/api-v12/vm/class_vm_syntheticmodule.html)

新增于: v12.16.0

-   继承自: [<vm.Module>](http://nodejs.cn/api/vm.html#class-vmmodule)

`vm.SyntheticModule` 类提供了 WebIDL 规范中定义的[合成模块记录](http://url.nodejs.cn/bCp8jt)。 合成模块的目的是提供通用的接口，用于将非 JavaScript 源暴露给 ECMAScript 模块图。

```
const vm = require('vm');

const source = '{ "a": 1 }';
const module = new vm.SyntheticModule(['default'], function() {
  const obj = JSON.parse(source);
  this.setExport('default', obj);
});

// 在链接中使用 `module`...
```

#### `new vm.SyntheticModule(exportNames, evaluateCallback[, options])`[#](http://nodejs.cn/api-v12/vm.html#new-vmsyntheticmoduleexportnames-evaluatecallback-options)

[中英对照](http://nodejs.cn/api-v12/vm/new_vm_syntheticmodule_exportnames_evaluatecallback_options.html)

新增于: v12.16.0

-   `exportNames` [<string\[\]>](http://url.nodejs.cn/9Tw2bK) 将从模块导出的名称数组。
-   `evaluateCallback` [<Function>](http://url.nodejs.cn/ceTQa6) 在评估模块时调用。
-   `options`
    -   `identifier` [<string>](http://url.nodejs.cn/9Tw2bK) 用于堆栈跟踪的字符串。 **默认值:** `'vm:module(i)'` 其中 `i` 是上下文特定的升序索引。
    -   `context` [<Object>](http://url.nodejs.cn/jzn6Ao) `vm.createContext()` 方法返回的[上下文隔离化的](http://nodejs.cn/api-v12/vm.html#vm_what_does_it_mean_to_contextify_an_object)对象，用于编译和评估此 `Module`。

创建新的 `SyntheticModule` 实例。

分配给此实例导出的对象可能允许模块的导入者访问指定 `context` 之外的信息。 使用 `vm.runInContext()` 在特定上下文中创建对象。

#### `syntheticModule.setExport(name, value)`[#](http://nodejs.cn/api-v12/vm.html#syntheticmodulesetexportname-value)

[中英对照](http://nodejs.cn/api-v12/vm/syntheticmodule_setexport_name_value.html)

新增于: v12.16.0

-   `name` [<string>](http://url.nodejs.cn/9Tw2bK) 要设置的导出名称。
-   `value` [<any>](http://url.nodejs.cn/6sTGdS) 将导出设置为的值。

此方法用于模块链接后设置导出的值。 如果在链接模块之前调用，则会抛出 [`ERR_VM_MODULE_STATUS`](http://nodejs.cn/api-v12/errors.html#ERR_VM_MODULE_STATUS) 错误。

```
const vm = require('vm');

(async () => {
  const m = new vm.SyntheticModule(['x'], () => {
    m.setExport('x', 1);
  });

  await m.link(() => {});
  await m.evaluate();

  assert.strictEqual(m.namespace.x, 1);
})();
```

### `vm.compileFunction(code[, params[, options]])`[#](http://nodejs.cn/api-v12/vm.html#vmcompilefunctioncode-params-options)

[中英对照](http://nodejs.cn/api-v12/vm/vm_compilefunction_code_params_options.html)

新增于: v10.10.0

-   `code` [<string>](http://url.nodejs.cn/9Tw2bK) 要编译的函数体。
-   `params` [<string\[\]>](http://url.nodejs.cn/9Tw2bK) 包含函数所有参数的字符串数组。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `filename` [<string>](http://url.nodejs.cn/9Tw2bK) 指定此脚本生成的堆栈跟踪中使用的文件名。 **默认值:** `''`。
    -   `lineOffset` [<number>](http://url.nodejs.cn/SXbo1v) 指定在此脚本生成的堆栈跟踪中显示的行号偏移量。 **默认值:** `0`。
    -   `columnOffset` [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `0`。
    -   `cachedData` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) 为所提供的源提供可选的 `Buffer` 或 `TypedArray` 或 `DataView`，其中包含 V8 的代码缓存数据。
    -   `produceCachedData` [<boolean>](http://url.nodejs.cn/jFbvuT) 指定是否产生新的缓存数据。 **默认值:** `false`。
    -   `parsingContext` [<Object>](http://url.nodejs.cn/jzn6Ao) 应在其中编译所述函数的[上下文隔离化的](http://nodejs.cn/api-v12/vm.html#vm_what_does_it_mean_to_contextify_an_object)对象。
    -   `contextExtensions` [<Object\[\]>](http://url.nodejs.cn/jzn6Ao) 包含要在编译时应用的上下文扩展集合（包含当前作用域的对象）的数组。 **默认值:** `[]`。
-   返回: [<Function>](http://url.nodejs.cn/ceTQa6)

将给定的代码编译到提供的上下文中（如果没有提供上下文，则使用当前上下文），并返回它包装在具有给定 `params` 的函数中。

### `vm.createContext([contextObject[, options]])`[#](http://nodejs.cn/api-v12/vm.html#vmcreatecontextcontextobject-options)

[中英对照](http://nodejs.cn/api-v12/vm/vm_createcontext_contextobject_options.html)

-   `contextObject` [<Object>](http://url.nodejs.cn/jzn6Ao)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `name` [<string>](http://url.nodejs.cn/9Tw2bK) 新创建的上下文的可读名称。 **默认值:** `'VM Context i'`, 其中 `i` 是创建的上下文的升序数字索引。
    -   `origin` [<string>](http://url.nodejs.cn/9Tw2bK) 对应于新创建的用于显示目的的上下文的[来源](http://url.nodejs.cn/SYyZxA)。 来源的格式应该像 URL，但只有协议、主机和端口（如果需要），就像 [`URL`](http://nodejs.cn/api-v12/url.html#url_class_url) 对象的 [`url.origin`](http://nodejs.cn/api-v12/url.html#url_url_origin) 属性的值。 最值得注意的是，该字符串应省略尾部斜杠，因为它表示路径。 **默认值:** `''`。
    -   `codeGeneration` [<Object>](http://url.nodejs.cn/jzn6Ao)
        -   `strings` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果设置为 false，则任何对 `eval` 或函数构造函数（`Function`、`GeneratorFunction` 等）的调用都将抛出 `EvalError`。 **默认值:** `true`。
        -   `wasm` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果设置为 false，则任何编译 WebAssembly 模块的尝试都将抛出 `WebAssembly.CompileError`。 **默认值:** `true`。
-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao) 上下文隔离化的对象。

如果给定 `contextObject`，`vm.createContext()` 方法将[准备那个对象](http://nodejs.cn/api-v12/vm.html#vm_what_does_it_mean_to_contextify_an_object)，以便它可以用于调用 [`vm.runInContext()`](http://nodejs.cn/api-v12/vm.html#vm_vm_runincontext_code_contextifiedobject_options) 或 [`script.runInContext()`](http://nodejs.cn/api-v12/vm.html#vm_script_runincontext_contextifiedobject_options)。 在此类脚本中，`contextObject` 将是全局对象，保留其所有现有属性，但也具有任何标准[全局对象](http://url.nodejs.cn/hKgpea)具有的内置对象和函数。 在 vm 模块运行的脚本之外，全局变量将保持不变。

```
const vm = require('vm');

global.globalVar = 3;

const context = { globalVar: 1 };
vm.createContext(context);

vm.runInContext('globalVar *= 2;', context);

console.log(context);
// 打印: { globalVar: 2 }

console.log(global.globalVar);
// 打印: 3
```

如果省略 `contextObject`（或显式地作为 `undefined` 传入），则将返回新的空的[上下文隔离化的](http://nodejs.cn/api-v12/vm.html#vm_what_does_it_mean_to_contextify_an_object)对象。

`vm.createContext()` 方法主要用于创建可用于运行多个脚本的单个上下文。 例如，如果模拟网络浏览器，则该方法可用于创建表示窗口全局对象的单个上下文，然后在该上下文中一起运行所有 `<script>` 标签。

提供的上下文的 `name` 和 `origin` 通过检查器 API 可见。

### `vm.isContext(object)`[#](http://nodejs.cn/api-v12/vm.html#vmiscontextobject)

[中英对照](http://nodejs.cn/api-v12/vm/vm_iscontext_object.html)

新增于: v0.11.7

-   `object` [<Object>](http://url.nodejs.cn/jzn6Ao)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果给定的 `oject` 对象已使用 [`vm.createContext()`](http://nodejs.cn/api-v12/vm.html#vm_vm_createcontext_contextobject_options) [上下文隔离化](http://nodejs.cn/api-v12/vm.html#vm_what_does_it_mean_to_contextify_an_object)，则返回 `true`。

### `vm.runInContext(code, contextifiedObject[, options])`[#](http://nodejs.cn/api-v12/vm.html#vmrunincontextcode-contextifiedobject-options)

[中英对照](http://nodejs.cn/api-v12/vm/vm_runincontext_code_contextifiedobject_options.html)

-   `code` [<string>](http://url.nodejs.cn/9Tw2bK) 要编译和运行的 JavaScript 代码。
-   `contextifiedObject` [<Object>](http://url.nodejs.cn/jzn6Ao) 编译和运行 `code` 时将用作 `global` 的[上下文隔离化的](http://nodejs.cn/api-v12/vm.html#vm_what_does_it_mean_to_contextify_an_object)对象。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `filename` [<string>](http://url.nodejs.cn/9Tw2bK) 指定此脚本生成的堆栈跟踪中使用的文件名。 **默认值:** `'evalmachine.<anonymous>'`。
        
    -   `lineOffset` [<number>](http://url.nodejs.cn/SXbo1v) 指定在此脚本生成的堆栈跟踪中显示的行号偏移量。 **默认值:** `0`。
        
    -   `columnOffset` [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `0`。
        
    -   `displayErrors` [<boolean>](http://url.nodejs.cn/jFbvuT) 当为 `true` 时，如果编译 `code` 时出现 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)，则导致错误的代码行会附加到堆栈跟踪中。 **默认值:** `true`。
        
    -   `timeout` [<integer>](http://url.nodejs.cn/SXbo1v) 指定终止执行前执行 `code` 的毫秒数。 如果执行终止，则将抛出 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)。 此值必须是严格的正整数。
        
    -   `breakOnSigint` [<boolean>](http://url.nodejs.cn/jFbvuT)
        
        如果执行终止，则将抛出 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)。 **默认值:** `false`。
        
    -   `cachedData` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) 为所提供的源提供可选的 `Buffer` 或 `TypedArray` 或 `DataView`，其中包含 V8 的代码缓存数据。 当提供时，`cachedDataRejected` 值将设置为 `true` 或 `false`，具体取决于 V8 对数据的接受程度。
        
    -   `produceCachedData` [<boolean>](http://url.nodejs.cn/jFbvuT) 当 `true` 且没有 `cachedData` 存在时，则 V8 将尝试为 `code` 生成代码缓存数据。 当成功后，会生成带有 V8 代码缓存数据的 `Buffer` 并存储在返回的 `vm.Script` 实例的 `cachedData` 属性中。 `cachedDataProduced` 值将设置为 `true` 或 `false`，这取决于代码缓存数据是否成功生成。 此选项**已弃用**，支持 `script.createCachedData()`。 **默认值:** `false`。
        
    -   `importModuleDynamically` [<Function>](http://url.nodejs.cn/ceTQa6) 在调用 `import()` 时在评估此模块期间调用。 如果未指定此选项，则调用 `import()` 将使用 [`ERR_VM_DYNAMIC_IMPORT_CALLBACK_MISSING`](http://nodejs.cn/api-v12/errors.html#ERR_VM_DYNAMIC_IMPORT_CALLBACK_MISSING) 拒绝。 此选项是实验模块 API 的一部分，不应被视为稳定的。
        
        -   `specifier` [<string>](http://url.nodejs.cn/9Tw2bK) 传给 `import()` 的说明符
        -   `module` [<vm.Module>](http://nodejs.cn/api/vm.html#class-vmmodule)
        -   返回: [<Module Namespace Object>](http://url.nodejs.cn/uwQPrn) | [<vm.Module>](http://nodejs.cn/api/vm.html#class-vmmodule) 建议返回 `vm.Module` 以利用错误跟踪，并避免包含 `then` 函数导出的命名空间出现问题。
-   返回: [<any>](http://url.nodejs.cn/6sTGdS) 脚本中执行的最后一条语句的结果。

`vm.runInContext()` 方法编译 `code`，在 `contextifiedObject` 的上下文中运行它，然后返回结果。 运行代码无权访问本地作用域。 `contextifiedObject` 对象_必须_之前已经使用 [`vm.createContext()`](http://nodejs.cn/api-v12/vm.html#vm_vm_createcontext_contextobject_options) 方法[上下文隔离化](http://nodejs.cn/api-v12/vm.html#vm_what_does_it_mean_to_contextify_an_object)。

如果 `options` 是字符串，则指定文件名。

以下示例使用单个[上下文隔离化的](http://nodejs.cn/api-v12/vm.html#vm_what_does_it_mean_to_contextify_an_object)对象编译并执行不同的脚本：

```
const vm = require('vm');

const contextObject = { globalVar: 1 };
vm.createContext(contextObject);

for (let i = 0; i < 10; ++i) {
  vm.runInContext('globalVar *= 2;', contextObject);
}
console.log(contextObject);
// 打印: { globalVar: 1024 }
```

### `vm.runInNewContext(code[, contextObject[, options]])`[#](http://nodejs.cn/api-v12/vm.html#vmruninnewcontextcode-contextobject-options)

[中英对照](http://nodejs.cn/api-v12/vm/vm_runinnewcontext_code_contextobject_options.html)

-   `code` [<string>](http://url.nodejs.cn/9Tw2bK) 要编译和运行的 JavaScript 代码。
-   `contextObject` [<Object>](http://url.nodejs.cn/jzn6Ao) 将被[上下文隔离化的](http://nodejs.cn/api-v12/vm.html#vm_what_does_it_mean_to_contextify_an_object)对象。 如果为 `undefined`，则将创建新的对象。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `filename` [<string>](http://url.nodejs.cn/9Tw2bK) 指定此脚本生成的堆栈跟踪中使用的文件名。 **默认值:** `'evalmachine.<anonymous>'`。
        
    -   `lineOffset` [<number>](http://url.nodejs.cn/SXbo1v) 指定在此脚本生成的堆栈跟踪中显示的行号偏移量。 **默认值:** `0`。
        
    -   `columnOffset` [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `0`。
        
    -   `displayErrors` [<boolean>](http://url.nodejs.cn/jFbvuT) 当为 `true` 时，如果编译 `code` 时出现 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)，则导致错误的代码行会附加到堆栈跟踪中。 **默认值:** `true`。
        
    -   `timeout` [<integer>](http://url.nodejs.cn/SXbo1v) 指定终止执行前执行 `code` 的毫秒数。 如果执行终止，则将抛出 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)。 此值必须是严格的正整数。
        
    -   `breakOnSigint` [<boolean>](http://url.nodejs.cn/jFbvuT)
        
        如果执行终止，则将抛出 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)。 **默认值:** `false`。
        
    -   `contextName` [<string>](http://url.nodejs.cn/9Tw2bK) 新创建的上下文的可读名称。 **默认值:** `'VM Context i'`, 其中 `i` 是创建的上下文的升序数字索引。
        
    -   `contextOrigin` [<string>](http://url.nodejs.cn/9Tw2bK) 对应于新创建的用于显示目的的上下文的[来源](http://url.nodejs.cn/SYyZxA)。 来源的格式应该像 URL，但只有协议、主机和端口（如果需要），就像 [`URL`](http://nodejs.cn/api-v12/url.html#url_class_url) 对象的 [`url.origin`](http://nodejs.cn/api-v12/url.html#url_url_origin) 属性的值。 最值得注意的是，该字符串应省略尾部斜杠，因为它表示路径。 **默认值:** `''`。
        
    -   `contextCodeGeneration` [<Object>](http://url.nodejs.cn/jzn6Ao)
        
        -   `strings` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果设置为 false，则任何对 `eval` 或函数构造函数（`Function`、`GeneratorFunction` 等）的调用都将抛出 `EvalError`。 **默认值:** `true`。
        -   `wasm` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果设置为 false，则任何编译 WebAssembly 模块的尝试都将抛出 `WebAssembly.CompileError`。 **默认值:** `true`。
    -   `cachedData` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) 为所提供的源提供可选的 `Buffer` 或 `TypedArray` 或 `DataView`，其中包含 V8 的代码缓存数据。 当提供时，`cachedDataRejected` 值将设置为 `true` 或 `false`，具体取决于 V8 对数据的接受程度。
        
    -   `produceCachedData` [<boolean>](http://url.nodejs.cn/jFbvuT) 当 `true` 且没有 `cachedData` 存在时，则 V8 将尝试为 `code` 生成代码缓存数据。 当成功后，会生成带有 V8 代码缓存数据的 `Buffer` 并存储在返回的 `vm.Script` 实例的 `cachedData` 属性中。 `cachedDataProduced` 值将设置为 `true` 或 `false`，这取决于代码缓存数据是否成功生成。 此选项**已弃用**，支持 `script.createCachedData()`。 **默认值:** `false`。
        
    -   `importModuleDynamically` [<Function>](http://url.nodejs.cn/ceTQa6) 在调用 `import()` 时在评估此模块期间调用。 如果未指定此选项，则调用 `import()` 将使用 [`ERR_VM_DYNAMIC_IMPORT_CALLBACK_MISSING`](http://nodejs.cn/api-v12/errors.html#ERR_VM_DYNAMIC_IMPORT_CALLBACK_MISSING) 拒绝。 此选项是实验模块 API 的一部分，不应被视为稳定的。
        
        -   `specifier` [<string>](http://url.nodejs.cn/9Tw2bK) 传给 `import()` 的说明符
        -   `module` [<vm.Module>](http://nodejs.cn/api/vm.html#class-vmmodule)
        -   返回: [<Module Namespace Object>](http://url.nodejs.cn/uwQPrn) | [<vm.Module>](http://nodejs.cn/api/vm.html#class-vmmodule) 建议返回 `vm.Module` 以利用错误跟踪，并避免包含 `then` 函数导出的命名空间出现问题。
-   返回: [<any>](http://url.nodejs.cn/6sTGdS) 脚本中执行的最后一条语句的结果。

`vm.runInNewContext()` 首先将给定的 `contextObject` 上下文化（如果作为 `undefined` 传入，则创建新的 `contextObject`），编译 `code`，在创建的上下文中运行它，然后返回结果。 运行代码无权访问本地作用域。

如果 `options` 是字符串，则指定文件名。

以下示例编译并执行增加全局变量并设置新变量的代码。 这些全局变量包含在 `contextObject` 中。

```
const vm = require('vm');

const contextObject = {
  animal: 'cat',
  count: 2
};

vm.runInNewContext('count += 1; name = "kitty"', contextObject);
console.log(contextObject);
// 打印: { animal: 'cat', count: 3, name: 'kitty' }
```

### `vm.runInThisContext(code[, options])`[#](http://nodejs.cn/api-v12/vm.html#vmruninthiscontextcode-options)

[中英对照](http://nodejs.cn/api-v12/vm/vm_runinthiscontext_code_options.html)

-   `code` [<string>](http://url.nodejs.cn/9Tw2bK) 要编译和运行的 JavaScript 代码。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `filename` [<string>](http://url.nodejs.cn/9Tw2bK) 指定此脚本生成的堆栈跟踪中使用的文件名。 **默认值:** `'evalmachine.<anonymous>'`。
        
    -   `lineOffset` [<number>](http://url.nodejs.cn/SXbo1v) 指定在此脚本生成的堆栈跟踪中显示的行号偏移量。 **默认值:** `0`。
        
    -   `columnOffset` [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `0`。
        
    -   `displayErrors` [<boolean>](http://url.nodejs.cn/jFbvuT) 当为 `true` 时，如果编译 `code` 时出现 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)，则导致错误的代码行会附加到堆栈跟踪中。 **默认值:** `true`。
        
    -   `timeout` [<integer>](http://url.nodejs.cn/SXbo1v) 指定终止执行前执行 `code` 的毫秒数。 如果执行终止，则将抛出 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)。 此值必须是严格的正整数。
        
    -   `breakOnSigint` [<boolean>](http://url.nodejs.cn/jFbvuT)
        
        如果执行终止，则将抛出 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)。 **默认值:** `false`。
        
    -   `cachedData` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) 为所提供的源提供可选的 `Buffer` 或 `TypedArray` 或 `DataView`，其中包含 V8 的代码缓存数据。 当提供时，`cachedDataRejected` 值将设置为 `true` 或 `false`，具体取决于 V8 对数据的接受程度。
        
    -   `produceCachedData` [<boolean>](http://url.nodejs.cn/jFbvuT) 当 `true` 且没有 `cachedData` 存在时，则 V8 将尝试为 `code` 生成代码缓存数据。 当成功后，会生成带有 V8 代码缓存数据的 `Buffer` 并存储在返回的 `vm.Script` 实例的 `cachedData` 属性中。 `cachedDataProduced` 值将设置为 `true` 或 `false`，这取决于代码缓存数据是否成功生成。 此选项**已弃用**，支持 `script.createCachedData()`。 **默认值:** `false`。
        
    -   `importModuleDynamically` [<Function>](http://url.nodejs.cn/ceTQa6) 在调用 `import()` 时在评估此模块期间调用。 如果未指定此选项，则调用 `import()` 将使用 [`ERR_VM_DYNAMIC_IMPORT_CALLBACK_MISSING`](http://nodejs.cn/api-v12/errors.html#ERR_VM_DYNAMIC_IMPORT_CALLBACK_MISSING) 拒绝。 此选项是实验模块 API 的一部分，不应被视为稳定的。
        
        -   `specifier` [<string>](http://url.nodejs.cn/9Tw2bK) 传给 `import()` 的说明符
        -   `module` [<vm.Module>](http://nodejs.cn/api/vm.html#class-vmmodule)
        -   返回: [<Module Namespace Object>](http://url.nodejs.cn/uwQPrn) | [<vm.Module>](http://nodejs.cn/api/vm.html#class-vmmodule) 建议返回 `vm.Module` 以利用错误跟踪，并避免包含 `then` 函数导出的命名空间出现问题。
-   返回: [<any>](http://url.nodejs.cn/6sTGdS) 脚本中执行的最后一条语句的结果。

`vm.runInThisContext()` 编译 `code`，在当前 `global` 的上下文中运行它并返回结果。 运行代码无权访问局部作用域，但可以访问当前 `global` 对象。

如果 `options` 是字符串，则指定文件名。

以下示例说明使用 `vm.runInThisContext()` 和 JavaScript [`eval()`](http://url.nodejs.cn/qHvCuM) 函数来运行相同的代码：

```
const vm = require('vm');
let localVar = 'initial value';

const vmResult = vm.runInThisContext('localVar = "vm";');
console.log(`vmResult: '${vmResult}', localVar: '${localVar}'`);
// 打印: vmResult: 'vm', localVar: 'initial value'

const evalResult = eval('localVar = "eval";');
console.log(`evalResult: '${evalResult}', localVar: '${localVar}'`);
// 打印: evalResult: 'eval', localVar: 'eval'
```

因为 `vm.runInThisContext()` 无权访问本地作用域，所以 `localVar` 不变。 相比之下，[`eval()`](http://url.nodejs.cn/qHvCuM) _确实_有权访问本地作用域，因此值 `localVar` 已更改。 这样 `vm.runInThisContext()` 很像 [间接 `eval()` 调用](http://url.nodejs.cn/RBapQS)，例如 `(0,eval)('code')`。

### 示例：在 VM 中运行 HTTP Server[#](http://nodejs.cn/api-v12/vm.html#example-running-an-http-server-within-a-vm)

[中英对照](http://nodejs.cn/api-v12/vm/example_running_an_http_server_within_a_vm.html)

当使用 [`script.runInThisContext()`](http://nodejs.cn/api-v12/vm.html#vm_script_runinthiscontext_options) 或 [`vm.runInThisContext()`](http://nodejs.cn/api-v12/vm.html#vm_vm_runinthiscontext_code_options) 时，代码在当前 V8 全局上下文中执行。 传给此 VM 上下文的代码将有自己的隔离作用域。

为了使用 `http` 模块运行简单的 web 服务器，传给上下文的代码必须要么自己调用 `require('http')`，要么有对传给它的 `http` 模块的引用。 例如：

```
'use strict';
const vm = require('vm');

const code = `
((require) => {
  const http = require('http');

  http.createServer((request, response) => {
    response.writeHead(200, { 'Content-Type': 'text/plain' });
    response.end('Hello World\\n');
  }).listen(8124);

  console.log('Server running at http://127.0.0.1:8124/');
})`;

vm.runInThisContext(code)(require);
```

上述案例中的 `require()` 与其传入的上下文共享状态。 当执行不受信任的代码时，这可能会带来风险，例如以不需要的方式更改上下文中的对象。

### 上下文隔离化一个对象意味着什么？[#](http://nodejs.cn/api-v12/vm.html#what-does-it-mean-to-contextify-an-object)

[中英对照](http://nodejs.cn/api-v12/vm/what_does_it_mean_to_contextify_an_object.html)

在 Node.js 中执行的所有 JavaScript 都在 "上下文" 的作用域内运行。 根据 [V8 嵌入器指南](http://url.nodejs.cn/SBcUmh)：

> 在 V8 中，上下文是一个执行环境，它允许单独的、不相关的 JavaScript 应用程序在 V8 的单个实例中运行。 必须明确指定要在其中运行任何 JavaScript 代码的上下文。

当方法 `vm.createContext()` 被调用时，`contextObject` 参数（或者新创建的对象，如果 `contextObject` 是 `undefined`）在内部与 V8 上下文的新实例相关联。 这个 V8 上下文使用 `vm` 模块的方法提供了 `code` 运行，它可以在隔离的全局环境中运行。 创建 V8 上下文并将其与 `contextObject` 相关联的过程就是本文档所指的“上下文隔离化”对象。

### Timeout limitations when using `process.nextTick()`, promises, and `queueMicrotask()`[#](http://nodejs.cn/api-v12/vm.html#timeout-limitations-when-using-processnexttick-promises-and-queuemicrotask)

[中英对照](http://nodejs.cn/api-v12/vm/timeout_limitations_when_using_process_nexttick_promises_and_queuemicrotask.html)

例如，以下代码由 `vm.runInNewContext()` 执行，超时时间为 5 毫秒，它安排了一个无限循环在 promise 解决后运行。 计划的循环永远不会被超时中断：

```
const vm = require('vm');

function loop() {
  while (1) console.log(Date.now());
}

vm.runInNewContext(
  'Promise.resolve().then(loop);',
  { loop, console },
  { timeout: 5 }
);
```
