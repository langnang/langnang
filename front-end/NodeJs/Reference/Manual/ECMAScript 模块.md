---
created: 2022-07-29T13:12:53 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/esm.html
author: 
---

# ECMAScript 模块 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/esm/modules_ecmascript_modules.html)

### 介绍[#](http://nodejs.cn/api-v12/esm.html#introduction)

[中英对照](http://nodejs.cn/api-v12/esm/introduction.html)

ECMAScript 模块是来打包 JavaScript 代码以供重用的[官方标准格式](http://url.nodejs.cn/JQY1wd)。 模块使用各种 [`import`](http://url.nodejs.cn/otfx5w) 和 [`export`](http://url.nodejs.cn/JNCjeW) 语句定义。

以下是 ES 模块导出函数的示例：

```
// addTwo.mjs
function addTwo(num) {
  return num + 2;
}

export { addTwo };
```

以下是 ES 模块从 `addTwo.mjs` 导入函数的示例：

```
// app.mjs
import { addTwo } from './addTwo.mjs';

// 打印: 6
console.log(addTwo(4));
```

Node.js 完全支持当前指定的 ECMAScript 模块，并且提供它们与其原始模块格式 [CommonJS](http://nodejs.cn/api-v12/modules.html) 之间的互操作性。

### 启用[#](http://nodejs.cn/api-v12/esm.html#enabling)

[中英对照](http://nodejs.cn/api-v12/esm/enabling.html)

Node.js 默认将 JavaScript 代码视为 CommonJS 模块。 作者可以通过 `.mjs` 文件扩展名、`package.json` [`"type"`](http://nodejs.cn/api-v12/packages.html#packages_type) 字段、或 `--input-type` 标志告诉 Node.js 将 JavaScript 代码视为 ECMAScript 模块。

### 包[#](http://nodejs.cn/api-v12/esm.html#packages)

This section was moved to [Modules: Packages](http://nodejs.cn/api-v12/packages.html).

### import 说明符[#](http://nodejs.cn/api-v12/esm.html#import-specifiers)

#### 术语[#](http://nodejs.cn/api-v12/esm.html#terminology)

[中英对照](http://nodejs.cn/api-v12/esm/terminology.html)

`import` 语句的说明符是 `from` 关键字之后的字符串，例如 `import { sep } from 'path'` 中的 `'path'`。 说明符也用于 `export from` 语句，并作为 `import()` 表达式的参数。

-   相对说明符，如 `'./startup.js'` 或 `'../config.mjs'`。 它们指的是相对于导入文件位置的路径。
    
-   绝对说明符，如 `'file:///opt/nodejs/config.js'`。 它们直接且明确地引用完整的路径。
    

##### node: 导入[#](http://nodejs.cn/api-v12/esm.html#node-imports)

[中英对照](http://nodejs.cn/api-v12/esm/node_imports.html)

新增于: v12.20.0

此 URL 协议允许有效的绝对的 URL 字符串引用内置模块。

```
import fs from 'node:fs/promises';
```

##### data: 导入[#](http://nodejs.cn/api-v12/esm.html#data-imports)

[中英对照](http://nodejs.cn/api-v12/esm/data_imports.html)

新增于: v12.10.0

[`data:` URL](http://url.nodejs.cn/3Lb3vH) 支持使用以下 MIME 类型导入：

-   `text/javascript` 用于 ES 模块
-   `application/json` 用于 JSON
-   `application/wasm` 用于 Wasm

`data:` URL 只为内置模块解析[裸说明符](http://nodejs.cn/api-v12/esm.html#esm_terminology)和[绝对说明符](http://nodejs.cn/api-v12/esm.html#esm_terminology)。 解析[相对说明符](http://nodejs.cn/api-v12/esm.html#esm_terminology)不起作用，因为 `data:` 不是[特殊协议](http://url.nodejs.cn/fbSryY)。 例如，尝试从 `data:text/javascript,import "./foo";` 加载 `./foo` 无法解析，因为 `data:` URL 没有相对解析的概念。 正在使用的 `data:` URL 示例是：

```
import 'data:text/javascript,console.log("hello!");';
import _ from 'data:application/json,"world!"';
```

### `import.meta`[#](http://nodejs.cn/api-v12/esm.html#importmeta)

[中英对照](http://nodejs.cn/api-v12/esm/import_meta.html)

-   [<Object>](http://url.nodejs.cn/jzn6Ao)
    
-   `url` [<string>](http://url.nodejs.cn/9Tw2bK) 模块的绝对的 `file:` URL。
    

### ES 模块和 CommonJS 之间的差异[#](http://nodejs.cn/api-v12/esm.html#differences-between-es-modules-and-commonjs)

#### 强制的文件扩展名[#](http://nodejs.cn/api-v12/esm.html#mandatory-file-extensions)

[中英对照](http://nodejs.cn/api-v12/esm/mandatory_file_extensions.html)

还必须完全指定目录索引（例如 `'./startup/index.js'`）。

此行为与 `import` 在浏览器环境中的行为方式相匹配，假设服务器是典型配置的。

#### 没有 NODE\_PATH[#](http://nodejs.cn/api-v12/esm.html#no-node_path)

[中英对照](http://nodejs.cn/api-v12/esm/no_node_path.html)

`NODE_PATH` 不是解析 `import` 说明符的一部分。 如果需要这种行为，则使用符号链接。

#### No `require`, `exports`, `module.exports`, `__filename`, `__dirname`[#](http://nodejs.cn/api-v12/esm.html#no-require-exports-moduleexports-__filename-__dirname)

[中英对照](http://nodejs.cn/api-v12/esm/no_require_exports_module_exports_filename_dirname.html)

这些 CommonJS 变量在 ES 模块中不可用。

```
import { fileURLToPath } from 'url';
import { dirname } from 'path';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);
```

#### 没有 require.resolve[#](http://nodejs.cn/api-v12/esm.html#no-requireresolve)

[中英对照](http://nodejs.cn/api-v12/esm/no_require_resolve.html)

```
(async () => {
  const dependencyAsset = await import.meta.resolve('component-lib/asset.css');
})();
```

`import.meta.resolve` 还接受第二个参数，它是从中解析的父模块：

```
(async () => {
  // 
  await import.meta.resolve('./dep', import.meta.url);
})();
```

#### 没有 require.extensions[#](http://nodejs.cn/api-v12/esm.html#no-requireextensions)

[中英对照](http://nodejs.cn/api-v12/esm/no_require_extensions.html)

`require.extensions` 没有被 `import` 使用。 期望加载器钩子在未来可以提供这个工作流。

#### 没有 require.cache[#](http://nodejs.cn/api-v12/esm.html#no-requirecache)

[中英对照](http://nodejs.cn/api-v12/esm/no_require_cache.html)

`require.cache` 没有被 `import` 使用。

#### URL-based paths[#](http://nodejs.cn/api-v12/esm.html#url-based-paths)

[中英对照](http://nodejs.cn/api-v12/esm/url_based_paths.html)

这意味着包含 `#` 和 `?` 等特殊字符的文件需要转义。

如果用于解析模块的 `import` 说明符具有不同的查询或片段，则会多次加载模块。

```
import './foo.mjs?query=1'; // 加载具有 "?query=1" 查询的 ./foo.mjs
import './foo.mjs?query=2'; // 加载具有 "?query=2" 查询的 ./foo.mjs
```

### 与 CommonJS 的互操作性[#](http://nodejs.cn/api-v12/esm.html#interoperability-with-commonjs)

#### `require`[#](http://nodejs.cn/api-v12/esm.html#require)

`require` always treats the files it references as CommonJS. This applies whether `require` is used the traditional way within a CommonJS environment, or in an ES module environment using [`module.createRequire()`](http://nodejs.cn/api-v12/module.html#module_module_createrequire_filename).

To include an ES module into CommonJS, use [`import()`](http://nodejs.cn/api-v12/esm.html#esm_import_expressions).

#### import 声明[#](http://nodejs.cn/api-v12/esm.html#import-statements)

[中英对照](http://nodejs.cn/api-v12/esm/import_statements.html)

`import` 语句可以引用 ES 模块或 CommonJS 模块。

当导入 [CommonJS 模块](http://nodejs.cn/api-v12/esm.html#esm_commonjs_namespaces) 时，提供 `module.exports` 对象作为默认导出。 命名导出可能可用，由静态分析提供，以方便更好的生态系统兼容性。

```
import { sin, cos } from 'geometry/trigonometry-functions.mjs';
```

#### import() 表达式[#](http://nodejs.cn/api-v12/esm.html#import-expressions)

[中英对照](http://nodejs.cn/api-v12/esm/import_expressions.html)

[动态的 `import()`](http://url.nodejs.cn/4WGpC7) 在 CommonJS 和 ES 模块中都受支持。

### CommonJS 命名空间[#](http://nodejs.cn/api-v12/esm.html#commonjs-namespaces)

[中英对照](http://nodejs.cn/api-v12/esm/commonjs_namespaces.html)

CommonJS 模块由可以是任何类型的 `module.exports` 对象组成。

当导入 CommonJS 模块时，可以使用 ES 模块默认导入或其对应的语法糖可靠地导入：

```
import { default as cjs } from 'cjs';

// 下面的导入语句是上面的导入语句中
// `{ default as cjsSugar }` 的 "语法糖"（等价但更甜）：
import cjsSugar from 'cjs';

console.log(cjs);
console.log(cjs === cjsSugar);
// 打印:
//   <module.exports>
//   true
```

CommonJS 模块的 ECMAScript 模块命名空间表示始终是使用 `default` 导出键指向 CommonJS `module.exports` 值的命名空间。

当使用 `import * as m from 'cjs'` 或动态导入时，可以直接观察到此模块命名空间外来对象：

```
import * as m from 'cjs';
console.log(m);
console.log(m === await import('cjs'));
// 打印:
//   [Module] { default: <module.exports> }
//   true
```

为了更好地兼容 JS 生态系统中的现有用法，Node.js 还尝试确定每个导入的 CommonJS 模块的 CommonJS 命名导出，以使用静态分析过程将它们作为单独的 ES 模块导出提供。

例如，考虑编写的 CommonJS 模块：

```
// cjs.cjs
exports.name = 'exported';
```

前面的模块支持 ES 模块中的命名导入：

```
import { name } from './cjs.cjs';
console.log(name);
// 打印: 'exported'

import cjs from './cjs.cjs';
console.log(cjs);
// 打印: { name: 'exported' }

import * as m from './cjs.cjs';
console.log(m);
// 打印: [Module] { default: { name: 'exported' }, name: 'exported' }
```

从上一个记录模块命名空间外来对象的示例中可以看出，`name` 导出是从 `module.exports` 对象复制出来的，并在导入模块时直接设置在 ES 模块命名空间上。

未检测到这些命名导出的实时绑定更新或添加到 `module.exports` 的新导出。

命名导出的检测基于通用语法模式，但并不总是正确地检测命名导出。 在这些情况下，使用上述默认导入形式可能是更好的选择。

命名导出检测涵盖了许多常见的导出模式、再导出模式、以及构建工具和转译器输出。 参阅 [cjs-module-lexer](http://url.nodejs.cn/ecpd1v) 以了解实现的确切语义。

### 内置模块[#](http://nodejs.cn/api-v12/esm.html#builtin-modules)

[中英对照](http://nodejs.cn/api-v12/esm/builtin_modules.html)

[核心模块](http://nodejs.cn/api-v12/modules.html#modules_core_modules)提供了其公共 API 的命名导出。 还提供了默认导出，其是 CommonJS 导出的值。 默认导出可用于修改命名导出等。 内置模块的命名导出仅通过调用 [`module.syncBuiltinESMExports()`](http://nodejs.cn/api-v12/module.html#module_module_syncbuiltinesmexports) 进行更新。

```
import EventEmitter from 'events';
const e = new EventEmitter();
```

```
import { readFile } from 'fs';
readFile('./foo.txt', (err, source) => {
  if (err) {
    console.error(err);
  } else {
    console.log(source);
  }
});
```

```
import fs, { readFileSync } from 'fs';
import { syncBuiltinESMExports } from 'module';

fs.readFileSync = () => Buffer.from('Hello, ESM');
syncBuiltinESMExports();

fs.readFileSync === readFileSync;
```

### CommonJS, JSON, and native modules[#](http://nodejs.cn/api-v12/esm.html#commonjs-json-and-native-modules)

CommonJS, JSON, and native modules can be used with [`module.createRequire()`](http://nodejs.cn/api-v12/module.html#module_module_createrequire_filename).

```
// cjs.cjs
module.exports = 'cjs';

// esm.mjs
import { createRequire } from 'module';

const require = createRequire(import.meta.url);

const cjs = require('./cjs.cjs');
cjs === 'cjs'; // true
```

### Experimental JSON modules[#](http://nodejs.cn/api-v12/esm.html#experimental-json-modules)

[中英对照](http://nodejs.cn/api-v12/esm/experimental_json_modules.html)

目前导入 JSON 模块仅支持 `commonjs` 模式，并且使用 CJS 加载器加载。 [WHATWG JSON 模块规范](http://url.nodejs.cn/xZrkEh)仍在标准化中，并且通过在运行 Node.js 时包含额外的标志 `--experimental-json-modules` 进行实验性地支持。

当包含 `--experimental-json-modules` 标志时，`commonjs` 和 `module` 模式都使用新的实验性 JSON 加载器。 导入的 JSON 只暴露 `default`。 不支持命名导出。 在 CommonJS 缓存中创建缓存条目，以避免重复。 如果 JSON 模块已经从同一路径导入，则在 CommonJS 中返回相同的对象。

假设 `index.mjs` 具有

```
import packageConfig from './package.json';
```

模块需要 `--experimental-json-modules` 标志才有效。

```
node index.mjs # 失败
node --experimental-json-modules index.mjs # 有效
```

### Experimental Wasm modules[#](http://nodejs.cn/api-v12/esm.html#experimental-wasm-modules)

[中英对照](http://nodejs.cn/api-v12/esm/experimental_wasm_modules.html)

在 `--experimental-wasm-modules` 标志下支持导入 Web Assembly 模块，允许将任何 `.wasm` 文件作为普通模块导入，同时还支持它们的模块导入。

此集成符合[用于 Web Assembly 的 ES 模块集成提案](http://url.nodejs.cn/3w7yUG)。

例如，`index.mjs` 包含：

```
import * as M from './module.wasm';
console.log(M);
```

在以下条件下执行：

```
node --experimental-wasm-modules index.mjs
```

将为 `module.wasm` 的实例化提供导出接口。

### Experimental loaders[#](http://nodejs.cn/api-v12/esm.html#experimental-loaders)

[中英对照](http://nodejs.cn/api-v12/esm/experimental_loaders.html)

**注意：此 API 目前正在重新设计，并将继续更改。**

要自定义默认的模块解析，则可以选择通过 Node.js 的 `--experimental-loader ./loader-name.mjs` 参数提供加载器钩子。

当使用钩子时，只适用于 ES 模块加载，而不适用于任何加载的 CommonJS 模块。

#### 钩子[#](http://nodejs.cn/api-v12/esm.html#hooks)

##### `resolve(specifier, context, defaultResolve)`[#](http://nodejs.cn/api-v12/esm.html#resolvespecifier-context-defaultresolve)

[中英对照](http://nodejs.cn/api-v12/esm/resolve_specifier_context_defaultresolve.html)

> 注意：加载器 API 正在重新设计。 这个钩子可能会消失，或者它的签名可能会改变。 不要依赖下面描述的 API。

-   `specifier` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `context` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `conditions` [<string\[\]>](http://url.nodejs.cn/9Tw2bK)
    -   `parentURL` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `defaultResolve` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `url` [<string>](http://url.nodejs.cn/9Tw2bK)

`resolve` 钩子返回给定模块说明符和父 URL 的解析文件 URL。 模块说明符是 `import` 语句或 `import()` 表达式中的字符串，父 URL 是导入此模块的 URL，如果这是应用程序的主要入口点，则为 `undefined`

`context` 上的 `conditions` 属性是适用于此解析请求的[条件导出](http://nodejs.cn/api-v12/packages.html#packages_conditional_exports)的条件数组。 它们可用于在别处查找条件映射或在调用默认解析逻辑时修改列表。

当前的[包导出条件](http://nodejs.cn/api-v12/packages.html#packages_conditional_exports)始终在传入钩子的 `context.conditions` 数组中。 为了在调用 `defaultResolve` 时保证默认的 Node.js 模块说明符解析行为，传给它的 `context.conditions` 数组必须包含最初传到 `resolve` 钩子的 `context.conditions` 数组的所有元素。

```
/**
 * @param {string} specifier
 * @param {{
 *   conditions: !Array<string>,
 *   parentURL: !(string | undefined),
 * }} context
 * @param {Function} defaultResolve
 * @returns {Promise<{ url: string }>}
 */
export async function resolve(specifier, context, defaultResolve) {
  const { parentURL = null } = context;
  if (Math.random() > 0.5) { // 一些条件。
    // 对于部分或全部说明符，做一些自定义逻辑来解决。
    // 总是返回 {url: <string>} 形式的对象。
    return {
      url: parentURL ?
        new URL(specifier, parentURL).href :
        new URL(specifier).href,
    };
  }
  if (Math.random() < 0.5) { // 另一个条件。
    // 当调用 `defaultResolve` 时，可以修改参数。
    // 在这种情况下，它为匹配条件导出添加了另一个值。
    return defaultResolve(specifier, {
      ...context,
      conditions: [...context.conditions, 'another-condition'],
    });
  }
  // 对于所有其他说明符，请遵循 Node.js。
  return defaultResolve(specifier, context, defaultResolve);
}
```

##### `getFormat(url, context, defaultGetFormat)`[#](http://nodejs.cn/api-v12/esm.html#getformaturl-context-defaultgetformat)

[中英对照](http://nodejs.cn/api-v12/esm/getformat_url_context_defaultgetformat.html)

> 注意：加载器 API 正在重新设计。 这个钩子可能会消失，或者它的签名可能会改变。 不要依赖下面描述的 API。

-   `url` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `context` [<Object>](http://url.nodejs.cn/jzn6Ao)
-   `defaultGetFormat` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `format` [<string>](http://url.nodejs.cn/9Tw2bK)

`getFormat` 钩子提供了一种方式来定义确定网址应如何解释的自定义方法。 返回的 `format` 也会影响解析时模块的可接受的源值形式。 这可以是以下之一：

| `format` | 描述 | `getSource` 或 `transformSource` 返回的 `source` 的可接受类型 |
| --- | --- | --- |
| `'builtin'` | 加载 Node.js 内置模块 | 不适用 |
| `'dynamic'` | Use a [dynamic instantiate hook](http://nodejs.cn/api-v12/esm.html#esm_code_dynamicinstantiate_code_hook) | 不适用 |
| `'commonjs'` | 加载 Node.js CommonJS 模块 | 不适用 |
| `'json'` | 加载 JSON 文件 | { [`string`](http://url.nodejs.cn/NmKbqJ), [`ArrayBuffer`](http://url.nodejs.cn/mUbfvF), [`TypedArray`](http://url.nodejs.cn/oh3CkV) } |
| `'module'` | 加载 ES 模块 | { [`string`](http://url.nodejs.cn/NmKbqJ), [`ArrayBuffer`](http://url.nodejs.cn/mUbfvF), [`TypedArray`](http://url.nodejs.cn/oh3CkV) } |
| `'wasm'` | 加载 WebAssembly 模块 | { [`ArrayBuffer`](http://url.nodejs.cn/mUbfvF), [`TypedArray`](http://url.nodejs.cn/oh3CkV) } |

注意：这些类型都对应于 ECMAScript 中定义的类。

-   特定的 [`ArrayBuffer`](http://url.nodejs.cn/mUbfvF) 对象是 [`SharedArrayBuffer`](http://url.nodejs.cn/6J6LBy)。
-   特定的 [`TypedArray`](http://url.nodejs.cn/oh3CkV) 对象是 [`Uint8Array`](http://url.nodejs.cn/ZbDkpm)。

注意：如果基于文本的格式（即 `'json'`、`'module'`）的源值不是字符串，则使用 [`util.TextDecoder`](http://url.nodejs.cn/GF1K8i) 将其转换为字符串。

```
/**
 * @param {string} url
 * @param {Object} context (currently empty)
 * @param {Function} defaultGetFormat
 * @returns {Promise<{ format: string }>}
 */
export async function getFormat(url, context, defaultGetFormat) {
  if (Math.random() > 0.5) { // 一些条件。
    // 对于部分或所有 URL，执行一些自定义逻辑来确定格式。
    // 始终返回 {format: <string>} 形式的对象，
    // 其中格式是上表中的字符串之一。
    return {
      format: 'module',
    };
  }
  // 所有其他 URL 都遵循 Node.js。
  return defaultGetFormat(url, context, defaultGetFormat);
}
```

##### `getSource(url, context, defaultGetSource)`[#](http://nodejs.cn/api-v12/esm.html#getsourceurl-context-defaultgetsource)

[中英对照](http://nodejs.cn/api-v12/esm/getsource_url_context_defaultgetsource.html)

> 注意：加载器 API 正在重新设计。 这个钩子可能会消失，或者它的签名可能会改变。 不要依赖下面描述的 API。

-   `url` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `context` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `format` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `defaultGetSource` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `source` [<string>](http://url.nodejs.cn/9Tw2bK) | [<SharedArrayBuffer>](http://url.nodejs.cn/6J6LBy) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm)

`getSource` 钩子提供了一种方法来定义用于检索 ES 模块说明符的源代码的自定义方法。 这将允许加载器潜在地避免从磁盘读取文件。

```
/**
 * @param {string} url
 * @param {{ format: string }} context
 * @param {Function} defaultGetSource
 * @returns {Promise<{ source: !(string | SharedArrayBuffer | Uint8Array) }>}
 */
export async function getSource(url, context, defaultGetSource) {
  const { format } = context;
  if (Math.random() > 0.5) { // 一些条件。
    // 对于部分或所有 URL，执行一些自定义逻辑来检索源。
    // 总是返回 {source: <string|buffer>} 形式的对象。
    return {
      source: '...',
    };
  }
  // 所有其他 URL 都遵循 Node.js。
  return defaultGetSource(url, context, defaultGetSource);
}
```

##### `transformSource(source, context, defaultTransformSource)`[#](http://nodejs.cn/api-v12/esm.html#transformsourcesource-context-defaulttransformsource)

[中英对照](http://nodejs.cn/api-v12/esm/transformsource_source_context_defaulttransformsource.html)

```
NODE_OPTIONS='--experimental-loader ./custom-loader.mjs' node x.js
```

> 注意：加载器 API 正在重新设计。 这个钩子可能会消失，或者它的签名可能会改变。 不要依赖下面描述的 API。

-   `source` [<string>](http://url.nodejs.cn/9Tw2bK) | [<SharedArrayBuffer>](http://url.nodejs.cn/6J6LBy) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm)
-   `context` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `format` [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `url` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `source` [<string>](http://url.nodejs.cn/9Tw2bK) | [<SharedArrayBuffer>](http://url.nodejs.cn/6J6LBy) | [<Uint8Array>](http://url.nodejs.cn/ZbDkpm)

`transformSource` 钩子提供了一种在加载源字符串之后但在 Node.js 对其进行任何操作之前修改加载的 ES 模块文件的源代码的方法。

如果此钩子用于将未知的 Node.js 文件类型转换为可执行的 JavaScript，则还需要解析钩子来注册任何未知的 Node.js 文件扩展名。 请参阅下面的[转译加载器示例](http://nodejs.cn/api-v12/esm.html#esm_transpiler_loader)。

```
/**
 * @param {!(string | SharedArrayBuffer | Uint8Array)} source
 * @param {{
 *   format: string,
 *   url: string,
 * }} context
 * @param {Function} defaultTransformSource
 * @returns {Promise<{ source: !(string | SharedArrayBuffer | Uint8Array) }>}
 */
export async function transformSource(source, context, defaultTransformSource) {
  const { url, format } = context;
  if (Math.random() > 0.5) { // 一些条件。
    // 对于部分或全部 URL，做一些修改源的自定义逻辑。
    // 总是返回 {source: <string|buffer>} 形式的对象。
    return {
      source: '...',
    };
  }
  // 对于所有其他来源，请遵循 Node.js。
  return defaultTransformSource(source, context, defaultTransformSource);
}
```

##### `getGlobalPreloadCode()`[#](http://nodejs.cn/api-v12/esm.html#getglobalpreloadcode)

[中英对照](http://nodejs.cn/api-v12/esm/getglobalpreloadcode.html)

> 注意：加载器 API 正在重新设计。 这个钩子可能会消失，或者它的签名可能会改变。 不要依赖下面描述的 API。

-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

有时可能需要在应用程序运行所在的同一全局范围内运行一些代码。 此钩子允许返回在启动时作为宽松模式脚本运行的字符串。

类似于 CommonJS 封装器的工作方式，代码在隐式函数范围内运行。 唯一的参数是类似 `require` 的函数，可用于加载内置函数，如 "fs"：`getBuiltin(request: string)`。

如果代码需要更高级的 `require` 特性，则必须使用 `module.createRequire()` 构建自己的 `require`。

```
/**
 * @returns {string} 在应用程序启动之前运行的代码
 */
export function getGlobalPreloadCode() {
  return `\
globalThis.someInjectedProperty = 42;
console.log('I just set some globals!');

const { createRequire } = getBuiltin('module');

const require = createRequire(process.cwd() + '/<preload>');
// [...]
`;
}
```

##### `dynamicInstantiate` hook[#](http://nodejs.cn/api-v12/esm.html#codedynamicinstantiatecode-hook)

[中英对照](http://nodejs.cn/api-v12/esm/code_dynamicinstantiate_code_hook.html)

> 注意：加载器 API 正在重新设计。 这个钩子可能会消失，或者它的签名可能会改变。 不要依赖下面描述的 API。

```
/**
 * @param {string} url
 * @returns {object} response
 * @returns {array} response.exports
 * @returns {function} response.execute
 */
export async function dynamicInstantiate(url) {
  return {
    exports: ['customExportName'],
    execute: (exports) => {
      // 
      exports.customExportName.set('value');
    }
  };
}
```

#### 示例[#](http://nodejs.cn/api-v12/esm.html#examples)

[中英对照](http://nodejs.cn/api-v12/esm/examples.html)

各种加载器钩子可以一起使用来完成对 Node.js 代码加载和评估行为的广泛定制。

##### HTTPS 加载器[#](http://nodejs.cn/api-v12/esm.html#https-loader)

[中英对照](http://nodejs.cn/api-v12/esm/https_loader.html)

在当前的 Node.js 中，不支持以 `https://` 开头的说明符。 下面的加载器注册钩子以启用对此类说明符的基本支持。 虽然这似乎是对 Node.js 核心功能的重大改进，但实际使用这个加载器有很大的缺点：性能比从磁盘加载文件慢得多，没有缓存，也没有安全性。

```
// https-loader.mjs
import { get } from 'https';

export function resolve(specifier, context, defaultResolve) {
  const { parentURL = null } = context;

  // 通常，Node.js 会在以 'https://' 开头的说明符上出错，
  // 因此此钩子会拦截它们并将它们转换为绝对 URL，
  // 以便传给下面的后面的钩子。
  if (specifier.startsWith('https://')) {
    return {
      url: specifier
    };
  } else if (parentURL && parentURL.startsWith('https://')) {
    return {
      url: new URL(specifier, parentURL).href
    };
  }

  // 让 Node.js 处理所有其他说明符。
  return defaultResolve(specifier, context, defaultResolve);
}

export function getFormat(url, context, defaultGetFormat) {
  // 此加载器假定所有网络提供的 JavaScript 都是 ES 模块代码。
  if (url.startsWith('https://')) {
    return {
      format: 'module'
    };
  }

  // 让 Node.js 处理所有其他 URL。
  return defaultGetFormat(url, context, defaultGetFormat);
}

export function getSource(url, context, defaultGetSource) {
  // 要通过网络加载 JavaScript，
  // 则需要获取并返回它。
  if (url.startsWith('https://')) {
    return new Promise((resolve, reject) => {
      get(url, (res) => {
        let data = '';
        res.on('data', (chunk) => data += chunk);
        res.on('end', () => resolve({ source: data }));
      }).on('error', (err) => reject(err));
    });
  }

  // 让 Node.js 处理所有其他 URL。
  return defaultGetSource(url, context, defaultGetSource);
}
```

```
// main.mjs
import { VERSION } from 'https://coffeescript.org/browser-compiler-modern/coffeescript.js';

console.log(VERSION);
```

使用前面的加载器，运行 `node --experimental-loader ./https-loader.mjs ./main.mjs` 会在 `main.mjs` 中的 URL 处按照模块打印当前版本的 CoffeeScript。

##### 转译器加载器[#](http://nodejs.cn/api-v12/esm.html#transpiler-loader)

[中英对照](http://nodejs.cn/api-v12/esm/transpiler_loader.html)

可以使用 [`transformSource` 钩子](http://nodejs.cn/api-v12/esm.html#esm_transformsource_source_context_defaulttransformsource)将 Node.js 无法理解的格式的源转换为 JavaScript。 但是，在调用该钩子之前，其他钩子需要告诉 Node.js 不要在未知文件类型上抛出错误；并告诉 Node.js 如何加载这种新文件类型。

这比在运行 Node.js 之前转译源文件的性能要低；转译加载器应该只用于开发和测试目的。

```
// coffeescript-loader.mjs
import { URL, pathToFileURL } from 'url';
import CoffeeScript from 'coffeescript';

const baseURL = pathToFileURL(`${process.cwd()}/`).href;

// CoffeeScript 文件以 .coffee、.litcoffee 或 .coffee.md 结尾。
const extensionsRegex = /\.coffee$|\.litcoffee$|\.coffee\.md$/;

export function resolve(specifier, context, defaultResolve) {
  const { parentURL = baseURL } = context;

  // Node.js 通常在未知文件扩展名上出错，
  // 因此返回以 CoffeeScript 文件扩展名结尾的说明符的 URL。
  if (extensionsRegex.test(specifier)) {
    return {
      url: new URL(specifier, parentURL).href
    };
  }

  // 让 Node.js 处理所有其他说明符。
  return defaultResolve(specifier, context, defaultResolve);
}

export function getFormat(url, context, defaultGetFormat) {
  // 现在修补了解决以让 CoffeeScript URL 通过，
  // 需要告诉 Node.js 这样的 URL 应该被解释为什么格式。
  // 为了这个加载器的目的，所有 CoffeeScript URL 都是 ES 模块。
  if (extensionsRegex.test(url)) {
    return {
      format: 'module'
    };
  }

  // 让 Node.js 处理所有其他 URL。
  return defaultGetFormat(url, context, defaultGetFormat);
}

export function transformSource(source, context, defaultTransformSource) {
  const { url, format } = context;

  if (extensionsRegex.test(url)) {
    return {
      source: CoffeeScript.compile(source, { bare: true })
    };
  }

  // 让 Node.js 处理所有其他来源。
  return defaultTransformSource(source, context, defaultTransformSource);
}
```

```
# main.coffee
import { scream } from './scream.coffee'
console.log scream 'hello, world'

import { version } from 'process'
console.log "Brought to you by Node.js version #{version}"
```

```
# scream.coffee
export scream = (str) -> str.toUpperCase()
```

使用前面的加载器，运行 `node --experimental-loader ./coffeescript-loader.mjs main.coffee` 会导致 `main.coffee` 在其源代码从磁盘加载之后但在 Node.js 执行之前转换为 JavaScript；对于通过任何加载文件的 `import` 语句引用的任何 `.coffee`、`.litcoffee` 或 `.coffee.md` 文件，依此类推。

### 解析算法[#](http://nodejs.cn/api-v12/esm.html#resolution-algorithm)

#### 特性[#](http://nodejs.cn/api-v12/esm.html#features)

[中英对照](http://nodejs.cn/api-v12/esm/features.html)

解析器具有以下属性：

-   ES 模块使用的基于 FileURL 的解析
-   支持内置模块加载
-   相对和绝对的网址解析
-   没有默认的扩展名
-   没有主文件夹
-   通过 node\_modules 进行裸说明符包解析查找

#### 解析器算法[#](http://nodejs.cn/api-v12/esm.html#resolver-algorithm)

[中英对照](http://nodejs.cn/api-v12/esm/resolver_algorithm.html)

加载 ES 模块说明符的算法通过下面的 **ESM\_RESOLVE** 方法给出。 它返回相对于 parentURL 的模块说明符的解析 URL。

确定解析 URL 的模块格式的算法由 **ESM\_FORMAT** 提供，它返回任何文件的唯一模块格式。 "module" 格式为 ECMAScript 模块返回，而 "commonjs" 格式用于指示通过旧版 CommonJS 加载器加载。 其他格式，如 "addon" 可以在未来的更新中扩展。

在以下算法中，除非另有说明，否则所有子程序错误都将作为这些顶层程序的错误传播。

defaultConditions 是条件环境名称数组，`["node", "import"]`。

解析器可能会抛出以下错误：

-   无效的模块说明符：模块说明符是无效的 URL、包名称、或包子路径说明符。
-   无效的包配置：package.json 配置无效或包含无效配置。
-   无效的包目标：包导出或导入为无效类型或字符串目标的包定义了目标模块。
-   未导出包路径：包导出未定义或允许给定模块的包中的目标子路径。
-   未定义包导入：包导入未定义说明符。
-   未找到模块：请求的包或模块不存在。

#### 解析器算法规范[#](http://nodejs.cn/api-v12/esm.html#resolver-algorithm-specification)

**ESM\_RESOLVE**(_specifier_, _parentURL_)

> 1.  Let _resolved_ be **undefined**.
> 2.  If _specifier_ is a valid URL, then
>     1.  Set _resolved_ to the result of parsing and reserializing _specifier_ as a URL.
> 3.  Otherwise, if _specifier_ starts with _"/"_, _"./"_ or _"../"_, then
>     1.  Set _resolved_ to the URL resolution of _specifier_ relative to _parentURL_.
> 4.  Otherwise, if _specifier_ starts with _"#"_, then
>     1.  Set _resolved_ to the destructured value of the result of **PACKAGE\_IMPORTS\_RESOLVE**(_specifier_, _parentURL_, _defaultConditions_).
> 5.  Otherwise,
>     1.  Note: _specifier_ is now a bare specifier.
>     2.  Set _resolved_ the result of **PACKAGE\_RESOLVE**(_specifier_, _parentURL_).
> 6.  If _resolved_ contains any percent encodings of _"/"_ or _"\\"_ (_"%2f"_ and _"%5C"_ respectively), then
>     1.  Throw an _Invalid Module Specifier_ error.
> 7.  If the file at _resolved_ is a directory, then
>     1.  Throw an _Unsupported Directory Import_ error.
> 8.  If the file at _resolved_ does not exist, then
>     1.  Throw a _Module Not Found_ error.
> 9.  Set _resolved_ to the real path of _resolved_.
> 10.  Let _format_ be the result of **ESM\_FORMAT**(_resolved_).
> 11.  Load _resolved_ as module format, _format_.
> 12.  Return _resolved_.

**PACKAGE\_RESOLVE**(_packageSpecifier_, _parentURL_)

> 1.  Let _packageName_ be **undefined**.
> 2.  If _packageSpecifier_ is an empty string, then
>     1.  Throw an _Invalid Module Specifier_ error.
> 3.  If _packageSpecifier_ does not start with _"@"_, then
>     1.  Set _packageName_ to the substring of _packageSpecifier_ until the first _"/"_ separator or the end of the string.
> 4.  Otherwise,
>     1.  If _packageSpecifier_ does not contain a _"/"_ separator, then
>         1.  Throw an _Invalid Module Specifier_ error.
>     2.  Set _packageName_ to the substring of _packageSpecifier_ until the second _"/"_ separator or the end of the string.
> 5.  If _packageName_ starts with _"."_ or contains _"\\"_ or _"%"_, then
>     1.  Throw an _Invalid Module Specifier_ error.
> 6.  Let _packageSubpath_ be _"."_ concatenated with the substring of _packageSpecifier_ from the position at the length of _packageName_.
> 7.  Let _selfUrl_ be the result of **PACKAGE\_SELF\_RESOLVE**(_packageName_, _packageSubpath_, _parentURL_).
> 8.  If _selfUrl_ is not **undefined**, return _selfUrl_.
> 9.  If _packageSubpath_ is _"."_ and _packageName_ is a Node.js builtin module, then
>     1.  Return the string _"node:"_ concatenated with _packageSpecifier_.
> 10.  While _parentURL_ is not the file system root,
>     1.  Let _packageURL_ be the URL resolution of _"node\_modules/"_ concatenated with _packageSpecifier_, relative to _parentURL_.
>     2.  Set _parentURL_ to the parent folder URL of _parentURL_.
>     3.  If the folder at _packageURL_ does not exist, then
>         1.  Set _parentURL_ to the parent URL path of _parentURL_.
>         2.  Continue the next loop iteration.
>     4.  Let _pjson_ be the result of **READ\_PACKAGE\_JSON**(_packageURL_).
>     5.  If _pjson_ is not **null** and _pjson_._exports_ is not **null** or **undefined**, then
>         1.  Let _exports_ be _pjson.exports_.
>         2.  Return the _resolved_ destructured value of the result of **PACKAGE\_EXPORTS\_RESOLVE**(_packageURL_, _packageSubpath_, _pjson.exports_, _defaultConditions_).
>     6.  Otherwise, if _packageSubpath_ is equal to _"."_, then
>         1.  Return the result applying the legacy **LOAD\_AS\_DIRECTORY** CommonJS resolver to _packageURL_, throwing a _Module Not Found_ error for no resolution.
>     7.  Otherwise,
>         1.  Return the URL resolution of _packageSubpath_ in _packageURL_.
> 11.  Throw a _Module Not Found_ error.

**PACKAGE\_SELF\_RESOLVE**(_packageName_, _packageSubpath_, _parentURL_)

> 1.  Let _packageURL_ be the result of **READ\_PACKAGE\_SCOPE**(_parentURL_).
> 2.  If _packageURL_ is **null**, then
>     1.  Return **undefined**.
> 3.  Let _pjson_ be the result of **READ\_PACKAGE\_JSON**(_packageURL_).
> 4.  If _pjson_ is **null** or if _pjson_._exports_ is **null** or **undefined**, then
>     1.  Return **undefined**.
> 5.  If _pjson.name_ is equal to _packageName_, then
>     1.  Return the _resolved_ destructured value of the result of **PACKAGE\_EXPORTS\_RESOLVE**(_packageURL_, _subpath_, _pjson.exports_, _defaultConditions_).
> 6.  Otherwise, return **undefined**.

**PACKAGE\_EXPORTS\_RESOLVE**(_packageURL_, _subpath_, _exports_, _conditions_)

> 1.  If _exports_ is an Object with both a key starting with _"."_ and a key not starting with _"."_, throw an _Invalid Package Configuration_ error.
> 2.  If _subpath_ is equal to _"."_, then
>     1.  Let _mainExport_ be **undefined**.
>     2.  If _exports_ is a String or Array, or an Object containing no keys starting with _"."_, then
>         1.  Set _mainExport_ to _exports_.
>     3.  Otherwise if _exports_ is an Object containing a _"."_ property, then
>         1.  Set _mainExport_ to _exports_\[_"."_\].
>     4.  If _mainExport_ is not **undefined**, then
>         1.  Let _resolved_ be the result of **PACKAGE\_TARGET\_RESOLVE**( _packageURL_, _mainExport_, _""_, **false**, **false**, _conditions_).
>         2.  If _resolved_ is not **null** or **undefined**, then
>             1.  Return _resolved_.
> 3.  Otherwise, if _exports_ is an Object and all keys of _exports_ start with _"."_, then
>     1.  Let _matchKey_ be the string _"./"_ concatenated with _subpath_.
>     2.  Let _resolvedMatch_ be result of **PACKAGE\_IMPORTS\_EXPORTS\_RESOLVE**( _matchKey_, _exports_, _packageURL_, **false**, _conditions_).
>     3.  If _resolvedMatch_._resolve_ is not **null** or **undefined**, then
>         1.  Return _resolvedMatch_.
> 4.  Throw a _Package Path Not Exported_ error.

**PACKAGE\_IMPORTS\_RESOLVE**(_specifier_, _parentURL_, _conditions_)

> 1.  Assert: _specifier_ begins with _"#"_.
> 2.  If _specifier_ is exactly equal to _"#"_ or starts with _"#/"_, then
>     1.  Throw an _Invalid Module Specifier_ error.
> 3.  Let _packageURL_ be the result of **READ\_PACKAGE\_SCOPE**(_parentURL_).
> 4.  If _packageURL_ is not **null**, then
>     1.  Let _pjson_ be the result of **READ\_PACKAGE\_JSON**(_packageURL_).
>     2.  If _pjson.imports_ is a non-null Object, then
>         1.  Let _resolvedMatch_ be the result of **PACKAGE\_IMPORTS\_EXPORTS\_RESOLVE**(_specifier_, _pjson.imports_, _packageURL_, **true**, _conditions_).
>         2.  If _resolvedMatch_._resolve_ is not **null** or **undefined**, then
>             1.  Return _resolvedMatch_.
> 5.  Throw a _Package Import Not Defined_ error.

**PACKAGE\_IMPORTS\_EXPORTS\_RESOLVE**(_matchKey_, _matchObj_, _packageURL_, _isImports_, _conditions_)

> 1.  If _matchKey_ is a key of _matchObj_, and does not end in _"\*"_, then
>     1.  Let _target_ be the value of _matchObj_\[_matchKey_\].
>     2.  Let _resolved_ be the result of **PACKAGE\_TARGET\_RESOLVE**( _packageURL_, _target_, _""_, **false**, _isImports_, _conditions_).
>     3.  Return the object _{ resolved, exact: **true** }_.
> 2.  Let _expansionKeys_ be the list of keys of _matchObj_ ending in _"/"_ or _"\*"_, sorted by length descending.
> 3.  For each key _expansionKey_ in _expansionKeys_, do
>     1.  If _expansionKey_ ends in _"\*"_ and _matchKey_ starts with but is not equal to the substring of _expansionKey_ excluding the last _"\*"_ character, then
>         1.  Let _target_ be the value of _matchObj_\[_expansionKey_\].
>         2.  Let _subpath_ be the substring of _matchKey_ starting at the index of the length of _expansionKey_ minus one.
>         3.  Let _resolved_ be the result of **PACKAGE\_TARGET\_RESOLVE**( _packageURL_, _target_, _subpath_, **true**, _isImports_, _conditions_).
>         4.  Return the object _{ resolved, exact: **true** }_.
>     2.  If _matchKey_ starts with _expansionKey_, then
>         1.  Let _target_ be the value of _matchObj_\[_expansionKey_\].
>         2.  Let _subpath_ be the substring of _matchKey_ starting at the index of the length of _expansionKey_.
>         3.  Let _resolved_ be the result of **PACKAGE\_TARGET\_RESOLVE**( _packageURL_, _target_, _subpath_, **false**, _isImports_, _conditions_).
>         4.  Return the object _{ resolved, exact: **false** }_.
> 4.  Return the object _{ resolved: **null**, exact: **true** }_.

**PACKAGE\_TARGET\_RESOLVE**(_packageURL_, _target_, _subpath_, _pattern_, _internal_, _conditions_)

> 1.  If _target_ is a String, then
>     1.  If _pattern_ is **false**, _subpath_ has non-zero length and _target_ does not end with _"/"_, throw an _Invalid Module Specifier_ error.
>     2.  If _target_ does not start with _"./"_, then
>         1.  If _internal_ is **true** and _target_ does not start with _"../"_ or _"/"_ and is not a valid URL, then
>             1.  If _pattern_ is **true**, then
>                 1.  Return **PACKAGE\_RESOLVE**(_target_ with every instance of _"\*"_ replaced by _subpath_, _packageURL_ + _"/"_)\_.
>             2.  Return **PACKAGE\_RESOLVE**(_target_ + _subpath_, _packageURL_ + _"/"_)\_.
>         2.  Otherwise, throw an _Invalid Package Target_ error.
>     3.  If _target_ split on _"/"_ or _"\\"_ contains any _"."_, _".."_ or _"node\_modules"_ segments after the first segment, throw an _Invalid Package Target_ error.
>     4.  Let _resolvedTarget_ be the URL resolution of the concatenation of _packageURL_ and _target_.
>     5.  Assert: _resolvedTarget_ is contained in _packageURL_.
>     6.  If _subpath_ split on _"/"_ or _"\\"_ contains any _"."_, _".."_ or _"node\_modules"_ segments, throw an _Invalid Module Specifier_ error.
>     7.  If _pattern_ is **true**, then
>         1.  Return the URL resolution of _resolvedTarget_ with every instance of _"\*"_ replaced with _subpath_.
>     8.  Otherwise,
>         1.  Return the URL resolution of the concatenation of _subpath_ and _resolvedTarget_.
> 2.  Otherwise, if _target_ is a non-null Object, then
>     1.  If _exports_ contains any index property keys, as defined in ECMA-262 [6.1.7 Array Index](http://url.nodejs.cn/HGLN85), throw an _Invalid Package Configuration_ error.
>     2.  For each property _p_ of _target_, in object insertion order as,
>         1.  If _p_ equals _"default"_ or _conditions_ contains an entry for _p_, then
>             1.  Let _targetValue_ be the value of the _p_ property in _target_.
>             2.  Let _resolved_ be the result of **PACKAGE\_TARGET\_RESOLVE**( _packageURL_, _targetValue_, _subpath_, _pattern_, _internal_, _conditions_).
>             3.  If _resolved_ is equal to **undefined**, continue the loop.
>             4.  Return _resolved_.
>     3.  Return **undefined**.
> 3.  Otherwise, if _target_ is an Array, then
>     1.  If \_target.length is zero, return **null**.
>     2.  For each item _targetValue_ in _target_, do
>         1.  Let _resolved_ be the result of **PACKAGE\_TARGET\_RESOLVE**( _packageURL_, _targetValue_, _subpath_, _pattern_, _internal_, _conditions_), continuing the loop on any _Invalid Package Target_ error.
>         2.  If _resolved_ is **undefined**, continue the loop.
>         3.  Return _resolved_.
>     3.  Return or throw the last fallback resolution **null** return or error.
> 4.  Otherwise, if _target_ is _null_, return **null**.
> 5.  Otherwise throw an _Invalid Package Target_ error.

**ESM\_FORMAT**(_url_)

> 1.  Assert: _url_ corresponds to an existing file.
> 2.  Let _pjson_ be the result of **READ\_PACKAGE\_SCOPE**(_url_).
> 3.  If _url_ ends in _".mjs"_, then
>     1.  Return _"module"_.
> 4.  If _url_ ends in _".cjs"_, then
>     1.  Return _"commonjs"_.
> 5.  If _pjson?.type_ exists and is _"module"_, then
>     1.  If _url_ ends in _".js"_, then
>         1.  Return _"module"_.
>     2.  Throw an _Unsupported File Extension_ error.
> 6.  Otherwise,
>     1.  Throw an _Unsupported File Extension_ error.

**READ\_PACKAGE\_SCOPE**(_url_)

> 1.  Let _scopeURL_ be _url_.
> 2.  While _scopeURL_ is not the file system root,
>     1.  Set _scopeURL_ to the parent URL of _scopeURL_.
>     2.  If _scopeURL_ ends in a _"node\_modules"_ path segment, return **null**.
>     3.  Let _pjson_ be the result of **READ\_PACKAGE\_JSON**(_scopeURL_).
>     4.  If _pjson_ is not **null**, then
>         1.  Return _pjson_.
> 3.  Return **null**.

**READ\_PACKAGE\_JSON**(_packageURL_)

> 1.  Let _pjsonURL_ be the resolution of _"package.json"_ within _packageURL_.
> 2.  If the file at _pjsonURL_ does not exist, then
>     1.  Return **null**.
> 3.  If the file at _packageURL_ does not parse as valid JSON, then
>     1.  Throw an _Invalid Package Configuration_ error.
> 4.  Return the parsed JSON source of the file at _pjsonURL_.

#### 自定义的 ESM 说明符解析算法[#](http://nodejs.cn/api-v12/esm.html#customizing-esm-specifier-resolution-algorithm)

[中英对照](http://nodejs.cn/api-v12/esm/customizing_esm_specifier_resolution_algorithm.html)

当前的说明符解析不支持 CommonJS 加载器的所有默认行为。 行为差异之一是文件扩展名的自动解析以及导入具有索引文件的目录的能力。

`--experimental-specifier-resolution=[mode]` 标志可用于自定义扩展解析算法。 默认模式是 `explicit`，这需要向加载器提供模块的完整路径。 要启用自动扩展解析并从包含索引文件的目录导入，则使用 `node` 模式。

```
$ node index.mjs
success!
$ node index # 失败！
Error: Cannot find module
$ node --experimental-specifier-resolution=node index
success!
```
