---
created: 2022-07-29T13:12:55 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/module.html
author: 
---

# module 模块 | Node.js API 文档

> ## Excerpt
> 中英对照

---
### Module 对象[#](http://nodejs.cn/api-v12/module.html#the-module-object)

[中英对照](http://nodejs.cn/api-v12/module/the_module_object.html)

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

当与 `Module` 的实例交互时提供通用的实用方法，[`module`](http://nodejs.cn/api-v12/modules.html#modules_the_module_object) 变量常见于 [CommonJS](http://nodejs.cn/api-v12/modules.html) 模块中。 通过 `import 'module'` 或 `require('module')` 访问。

#### `module.builtinModules`[#](http://nodejs.cn/api-v12/module.html#modulebuiltinmodules)

[中英对照](http://nodejs.cn/api-v12/module/module_builtinmodules.html)

新增于: v9.3.0, v8.10.0, v6.13.0

-   [<string\[\]>](http://url.nodejs.cn/9Tw2bK)

Node.js 提供的所有模块的名称列表。 可用于验证模块是否由第三方维护。

此上下文中的 `module` 与[模块封装器](http://nodejs.cn/api-v12/modules_cjs.html#modules_cjs_the_module_wrapper)提供的对象不同。 要访问它，需要 `Module` 模块：

```
// module.mjs
// 在 ECMAScript 模块中
import { builtinModules as builtin } from 'module';
```

```
// module.cjs
// 在 CommonJS 模块中
const builtin = require('module').builtinModules;
```

#### `module.createRequire(filename)`[#](http://nodejs.cn/api-v12/module.html#modulecreaterequirefilename)

[中英对照](http://nodejs.cn/api-v12/module/module_createrequire_filename.html)

新增于: v12.2.0

-   `filename` [<string>](http://url.nodejs.cn/9Tw2bK) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) 用于构造 require 函数的文件名。 必须是文件网址对象、文件网址字符串、或绝对路径字符串。
-   返回: [<require>](http://nodejs.cn/api/modules.html#requireid) require 函数

```
import { createRequire } from 'module';
const require = createRequire(import.meta.url);

// sibling-module.js 是 CommonJS 模块。
const siblingModule = require('./sibling-module');
```

#### `module.createRequireFromPath(filename)`[#](http://nodejs.cn/api-v12/module.html#modulecreaterequirefrompathfilename)

[中英对照](http://nodejs.cn/api-v12/module/module_createrequirefrompath_filename.html)

新增于: v10.12.0弃用于: v12.2.0

-   `filename` [<string>](http://url.nodejs.cn/9Tw2bK) 用于构造相对 require 函数的文件名。
-   返回: [<require>](http://nodejs.cn/api/modules.html#requireid) require 函数

```
const { createRequireFromPath } = require('module');
const requireUtil = createRequireFromPath('../src/utils/');

// 需要 `../src/utils/some-tool`
requireUtil('./some-tool');
```

#### `module.syncBuiltinESMExports()`[#](http://nodejs.cn/api-v12/module.html#modulesyncbuiltinesmexports)

[中英对照](http://nodejs.cn/api-v12/module/module_syncbuiltinesmexports.html)

新增于: v12.12.0

`module.syncBuiltinESMExports()` 方法更新内置的 [ES 模块](http://nodejs.cn/api-v12/esm.html)的所有实时绑定，以匹配 [CommonJS](http://nodejs.cn/api-v12/modules.html) 导出的属性。 它不会在 [ES 模块](http://nodejs.cn/api-v12/esm.html)中添加或删除导出的名称。

```
const fs = require('fs');
const { syncBuiltinESMExports } = require('module');

fs.readFile = null;

delete fs.readFileSync;

fs.newAPI = function newAPI() {
  // ...
};

syncBuiltinESMExports();

import('fs').then((esmFS) => {
  assert.strictEqual(esmFS.readFile, null);
  assert.strictEqual('readFileSync' in fs, true);
  assert.strictEqual(esmFS.newAPI, undefined);
});
```

### Source Map V3 的支持[#](http://nodejs.cn/api-v12/module.html#source-map-v3-support)

[中英对照](http://nodejs.cn/api-v12/module/source_map_v3_support.html)

新增于: v13.7.0, v12.17.0

与源映射缓存交互的助手。 当启用源映射解析并且在模块的页脚中找到[源映射包含指令](http://url.nodejs.cn/N2PLzU)时，则会填充此缓存。

要启用源映射解析，则 Node.js 必须使用标志 [`--enable-source-maps`](http://nodejs.cn/api-v12/cli.html#cli_enable_source_maps) 运行、或者通过设置 [`NODE_V8_COVERAGE=dir`](http://nodejs.cn/api-v12/cli.html#cli_node_v8_coverage_dir) 启用代码覆盖率。

```
// module.mjs
// 在 ECMAScript 模块中
import { findSourceMap, SourceMap } from 'module';
```

```
// module.cjs
// 在 CommonJS 模块中
const { findSourceMap, SourceMap } = require('module');
```

#### `module.findSourceMap(path[, error])`[#](http://nodejs.cn/api-v12/module.html#modulefindsourcemappath-error)

[中英对照](http://nodejs.cn/api-v12/module/module_findsourcemap_path_error.html)

新增于: v13.7.0, v12.17.0

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `error` [<Error>](http://url.nodejs.cn/qZ873x)
-   返回: [<module.SourceMap>](http://nodejs.cn/api/module.html#class-modulesourcemap)

`path` 是文件的解析路径，应为其获取相应的源映射。

#### `module.SourceMap` 类[#](http://nodejs.cn/api-v12/module.html#class-modulesourcemap)

新增于: v13.7.0, v12.17.0

##### `new SourceMap(payload)`[#](http://nodejs.cn/api-v12/module.html#new-sourcemappayload)

[中英对照](http://nodejs.cn/api-v12/module/new_sourcemap_payload.html)

-   `payload` [<Object>](http://url.nodejs.cn/jzn6Ao)

创建新的 `sourceMap` 实例。

`payload` 是键匹配 [Source map v3 格式](http://url.nodejs.cn/dP4AvC)的对象：

-   `file`: [<string>](http://url.nodejs.cn/9Tw2bK)
-   `version`: [<number>](http://url.nodejs.cn/SXbo1v)
-   `sources`: [<string\[\]>](http://url.nodejs.cn/9Tw2bK)
-   `sourcesContent`: [<string\[\]>](http://url.nodejs.cn/9Tw2bK)
-   `names`: [<string\[\]>](http://url.nodejs.cn/9Tw2bK)
-   `mappings`: [<string>](http://url.nodejs.cn/9Tw2bK)
-   `sourceRoot`: [<string>](http://url.nodejs.cn/9Tw2bK)

##### `sourceMap.payload`[#](http://nodejs.cn/api-v12/module.html#sourcemappayload)

[中英对照](http://nodejs.cn/api-v12/module/sourcemap_payload.html)

-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)

用于构造 [`SourceMap`](http://nodejs.cn/api-v12/module.html#module_class_module_sourcemap) 实例的有效负载的获取器。

##### `sourceMap.findEntry(lineNumber, columnNumber)`[#](http://nodejs.cn/api-v12/module.html#sourcemapfindentrylinenumber-columnnumber)

[中英对照](http://nodejs.cn/api-v12/module/sourcemap_findentry_linenumber_columnnumber.html)

-   `lineNumber` [<number>](http://url.nodejs.cn/SXbo1v)
-   `columnNumber` [<number>](http://url.nodejs.cn/SXbo1v)
-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)

给定生成的源文件中的行号和列号，返回表示原始文件中位置的对象。 返回的对象包含以下键：

-   generatedLine: [<number>](http://url.nodejs.cn/SXbo1v)
-   generatedColumn: [<number>](http://url.nodejs.cn/SXbo1v)
-   originalSource: [<string>](http://url.nodejs.cn/9Tw2bK)
-   originalLine: [<number>](http://url.nodejs.cn/SXbo1v)
-   originalColumn: [<number>](http://url.nodejs.cn/SXbo1v)
