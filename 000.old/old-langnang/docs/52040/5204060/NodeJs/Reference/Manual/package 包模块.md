---
created: 2022-07-29T13:12:54 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/packages.html
author: 
---

# package 包模块 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/packages/modules_packages.html)

### 介绍[#](http://nodejs.cn/api-v12/packages.html#introduction)

[中英对照](http://nodejs.cn/api-v12/packages/introduction.html)

包是由 `package.json` 文件描述的文件夹树。 包由包含 `package.json` 文件的文件夹和所有子文件夹组成，直到包含另一个 `package.json` 文件的下一个文件夹或名为 `node_modules` 的文件夹。

此页面为编写 `package.json` 文件的包作者提供指导，以及 Node.js 定义的 [`package.json`](http://nodejs.cn/api-v12/packages.html#packages_node_js_package_json_field_definitions) 字段的参考。

### 确定模块系统[#](http://nodejs.cn/api-v12/packages.html#determining-module-system)

[中英对照](http://nodejs.cn/api-v12/packages/determining_module_system.html)

当作为初始输入传给 `node` 时，或当 ES 模块代码中的 `import` 语句引用时，Node.js 会将以下视为[ES 模块](http://nodejs.cn/api-v12/esm.html)：

-   以 `.mjs` 结尾的文件。
    
-   当最近的父 `package.json` 文件包含值为 `"module"` 的顶层 [`"type"`](http://nodejs.cn/api-v12/packages.html#packages_type) 字段时，以 `.js` 结尾的文件。
    
-   字符串作为参数传入 `--eval`，或通过 `STDIN` 管道传输到 `node`，带有标志 `--input-type=module`。
    

Node.js 会将所有其他形式的输入视为 [CommonJS](http://nodejs.cn/api-v12/modules.html)，例如 `.js` 文件，其中最近的父 `package.json` 文件不包含顶层 `"type"` 字段，或者没有标志 `--input-type` 的字符串输入。 此行为是为了保持向后兼容性。 但是，现在 Node.js 同时支持 CommonJS 和 ES 模块，最好尽可能明确。 当作为初始输入传给 `node` 或被 ES 模块代码中的 `import` 语句引用时，Node.js 会将以下视为 CommonJS：

-   以 `.cjs` 结尾的文件。
    
-   当最近的父 `package.json` 文件包含值为 `"commonjs"` 的顶层字段 [`"type"`](http://nodejs.cn/api-v12/packages.html#packages_type) 时，以 `.js` 结尾的文件。
    
-   字符串作为参数传入 `--eval` 或 `--print`，或通过 `STDIN` 管道传输到 `node`，带有标志 `--input-type=commonjs`。
    

包作者应该包括 [`"type"`](http://nodejs.cn/api-v12/packages.html#packages_type) 字段，即使在所有源都是 CommonJS 的包中也是如此。 如果 Node.js 的默认类型发生变化，显式说明包的 `type` 将使包面向未来，它还将使构建工具和加载器更容易确定应如何解释包中的文件。

#### package.json 和文件扩展名[#](http://nodejs.cn/api-v12/packages.html#packagejson-and-file-extensions)

[中英对照](http://nodejs.cn/api-v12/packages/package_json_and_file_extensions.html)

在包中，[`package.json`](http://nodejs.cn/api-v12/packages.html#packages_node_js_package_json_field_definitions) [`"type"`](http://nodejs.cn/api-v12/packages.html#packages_type) 字段定义了 Node.js 应该如何解释 `.js` 文件。 如果 `package.json` 文件没有 `"type"` 字段，则 `.js` 文件将被视为 [CommonJS](http://nodejs.cn/api-v12/modules.html)。

`"module"` 的 `package.json` `"type"` 值告诉 Node.js 将该包中的 `.js` 文件解释为使用 [ES 模块](http://nodejs.cn/api-v12/esm.html)语法。

`"type"` 字段不仅适用于初始入口点 (`node my-app.js`)，还适用于 `import` 语句和 `import()` 表达式引用的文件。

```
// my-app.js 被当做 ES 模块，
// 因为在同一个文件夹中有 package.json 文件与 "type": "module"。

import './startup/init.js';
// 作为 ES 模块加载，因为 ./startup 不包含 package.json 文件，
// 因此从上一层继承了 "type" 值。

import 'commonjs-package';
// 作为 CommonJS 加载，因为 ./node_modules/commonjs-package/package.json 
// 缺少 "type" 字段或包含 "type": "commonjs"。

import './node_modules/commonjs-package/index.js';
// 作为 CommonJS 加载，因为 ./node_modules/commonjs-package/package.json 
// 缺少 "type" 字段或包含 "type": "commonjs"。
```

以 `.mjs` 结尾的文件总是作为 [ES 模块](http://nodejs.cn/api-v12/esm.html)加载，而不管最近的父级 `package.json`。

以 `.cjs` 结尾的文件总是作为 [CommonJS](http://nodejs.cn/api-v12/modules.html) 加载，而不管最近的父级 `package.json`。

```
import './legacy-file.cjs';
// 作为 CommonJS 加载，因为 .cjs 总是作为 CommonJS 加载。

import 'commonjs-package/src/index.mjs';
// 作为 ES 模块加载，因为 .mjs 总是作为 ES 模块加载。
```

`.mjs` 和 `.cjs` 扩展可用于在同一个包中混合类型：

-   在 `"type": "module"` 包中，Node.js 可以通过使用 `.cjs` 扩展名命名它来指示将特定文件解释为 [CommonJS](http://nodejs.cn/api-v12/modules.html)（因为 `.js` 和 `.mjs` 文件都被视为 `"module"` 包中的 ES 模块）
    
-   在 `"type": "commonjs"` 包中，Node.js 可以被指示将特定文件解释为 [ES 模块](http://nodejs.cn/api-v12/esm.html)，方法是使用 `.mjs` 扩展名命名它（因为 `.js` 和 `.cjs` 文件都被视为 `"commonjs"` 包中的 CommonJS）。
    

#### \--input-type 标志[#](http://nodejs.cn/api-v12/packages.html#--input-type-flag)

[中英对照](http://nodejs.cn/api-v12/packages/input_type_flag.html)

作为参数传给 `--eval`（或 `-e`），或通过 `STDIN` 管道传输到 `node` 的字符串，在设置 `--input-type=module` 标志时被视为 [ES 模块](http://nodejs.cn/api-v12/esm.html)。

```
node --input-type=module --eval "import { sep } from 'path'; console.log(sep);"

echo "import { sep } from 'path'; console.log(sep);" | node --input-type=module
```

为了完整起见，还有 `--input-type=commonjs`，用于显式地将字符串输入作为 CommonJS 运行。 如果未指定 `--input-type`，这是默认行为。

### 包的入口[#](http://nodejs.cn/api-v12/packages.html#package-entry-points)

[中英对照](http://nodejs.cn/api-v12/packages/package_entry_points.html)

在包的 `package.json` 文件中，有两个字段可以定义包的入口点：[`"main"`](http://nodejs.cn/api-v12/packages.html#packages_main) 和 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports)。 所有版本的 Node.js 都支持 [`"main"`](http://nodejs.cn/api-v12/packages.html#packages_main) 字段，但它的功能有限：它只定义了包的主要入口点。

[`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 字段提供了 [`"main"`](http://nodejs.cn/api-v12/packages.html#packages_main) 的替代方案，其中可以定义包主入口点，同时封装包，**防止除 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 中定义的入口点之外的任何其他入口点**。 这种封装允许模块作者为他们的包定义一个公共接口。

如果同时定义了 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 和 [`"main"`](http://nodejs.cn/api-v12/packages.html#packages_main)，则 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 字段优先于 [`"main"`](http://nodejs.cn/api-v12/packages.html#packages_main)。 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 不特定于 ES 模块或 CommonJS；如果 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 存在，则 [`"main"`](http://nodejs.cn/api-v12/packages.html#packages_main) 将被覆盖。 因此 [`"main"`](http://nodejs.cn/api-v12/packages.html#packages_main) 不能用作 CommonJS 的后备，但它可以用作不支持 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 字段的旧版 Node.js 的后备。

[条件导出](http://nodejs.cn/api-v12/packages.html#packages_conditional_exports)可以在 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 中用于为每个环境定义不同的包入口点，包括包是通过 `require` 还是通过 `import` 引用。 有关在单个包中同时支持 CommonJS 和 ES 模块的更多信息，请参阅[双 CommonJS/ES 模块包章节](http://nodejs.cn/api-v12/packages.html#packages_dual_commonjs_es_module_packages)。

**警告**：引入 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 字段可防止包的消费者使用任何未定义的入口点，包括 [`package.json`](http://nodejs.cn/api-v12/packages.html#packages_node_js_package_json_field_definitions)（例如 `require('your-package/package.json')`。 **这可能是一个突破性的变化。**

为了使 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 的引入不间断，请确保导出每个以前支持的入口点。 最好明确指定入口点，以便明确定义包的公共 API。 例如，以前导出 `main`、`lib`、`feature` 和 `package.json` 的项目可以使用以下 `package.exports`：

```
{
  "name": "my-mod",
  "exports": {
    ".": "./lib/index.js",
    "./lib": "./lib/index.js",
    "./lib/index": "./lib/index.js",
    "./lib/index.js": "./lib/index.js",
    "./feature": "./feature/index.js",
    "./feature/index.js": "./feature/index.js",
    "./package.json": "./package.json"
  }
}
```

或者，一个项目可以选择导出整个文件夹：

```
{
  "name": "my-mod",
  "exports": {
    ".": "./lib/index.js",
    "./lib": "./lib/index.js",
    "./lib/*": "./lib/*.js",
    "./feature": "./feature/index.js",
    "./feature/*": "./feature/*.js",
    "./package.json": "./package.json"
  }
}
```

作为最后的手段，可以通过为包 `"./*": "./*"` 的根创建导出来完全禁用包封装。 这会以禁用封装和潜在的工具优势为代价公开包中的每个文件。 由于 Node.js 中的 ES 模块加载器强制使用[完整说明符路径](http://url.nodejs.cn/W9TQvZ)，导出根而不是明确表示条目比前面的任何一个示例都没有表现力。 不仅封装丢失，模块消费者也无法 `import feature from 'my-mod/feature'`，因为他们需要提供完整路径 `import feature from 'my-mod/feature/index.js`。

#### 主入口的导出[#](http://nodejs.cn/api-v12/packages.html#main-entry-point-export)

[中英对照](http://nodejs.cn/api-v12/packages/main_entry_point_export.html)

要设置包的主入口点，建议在包的 [`package.json`](http://nodejs.cn/api-v12/packages.html#packages_node_js_package_json_field_definitions) 文件中同时定义 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 和 [`"main"`](http://nodejs.cn/api-v12/packages.html#packages_main)：

```
{
  "main": "./main.js",
  "exports": "./main.js"
}
```

当定义了 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 字段时，则包的所有子路径都被封装，不再提供给导入器。 例如，`require('pkg/subpath.js')` 抛出 [`ERR_PACKAGE_PATH_NOT_EXPORTED`](http://nodejs.cn/api-v12/errors.html#errors_err_package_path_not_exported) 错误。

这种导出的封装为工具的包接口以及处理包的语义版本升级提供了更可靠的保证。 这不是强封装，因为直接要求包的任何绝对子路径，例如 `require('/path/to/node_modules/pkg/subpath.js')` 仍然会加载 `subpath.js`。

#### 子路径的导出[#](http://nodejs.cn/api-v12/packages.html#subpath-exports)

[中英对照](http://nodejs.cn/api-v12/packages/subpath_exports.html)

当使用 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 字段时，可以通过将主入口点视为 `"."` 子路径来定义自定义子路径以及主入口点：

```
{
  "main": "./main.js",
  "exports": {
    ".": "./main.js",
    "./submodule": "./src/submodule.js"
  }
}
```

现在消费者只能导入 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 中定义的子路径：

```
import submodule from 'es-module-package/submodule';
// 加载 ./node_modules/es-module-package/src/submodule.js
```

而其他子路径会出错：

```
import submodule from 'es-module-package/private-module.js';
// 抛出 ERR_PACKAGE_PATH_NOT_EXPORTED
```

#### 子路径的导入[#](http://nodejs.cn/api-v12/packages.html#subpath-imports)

[中英对照](http://nodejs.cn/api-v12/packages/subpath_imports.html)

除了 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 字段，还可以定义内部包导入映射，这些映射仅适用于包本身内部的导入说明符。

导入字段中的条目必须始终以 `#` 开头，以确保它们与包说明符没有歧义。

例如，可以使用导入字段来获得内部模块条件导出的好处：

```
// package.json
{
  "imports": {
    "#dep": {
      "node": "dep-node-native",
      "default": "./dep-polyfill.js"
    }
  },
  "dependencies": {
    "dep-node-native": "^1.0.0"
  }
}
```

其中 `import '#dep'` 没有得到外部包 `dep-node-native` 的解析（依次包括其导出），而是获取了相对于其他环境中的包的本地文件 `./dep-polyfill.js`。

与 `"exports"` 字段不同，`"imports"` 字段允许映射到外部包。

导入字段的解析规则与导出字段类似。

#### 子路径的模式[#](http://nodejs.cn/api-v12/packages.html#subpath-patterns)

[中英对照](http://nodejs.cn/api-v12/packages/subpath_patterns.html)

对于具有少量导出或导入的包，我们建议显式地列出每个导出子路径条目。 但是对于具有大量子路径的包，这可能会导致 `package.json` 膨胀和维护问题。

对于这些用例，可以使用子路径导出模式：

```
// ./node_modules/es-module-package/package.json
{
  "exports": {
    "./features/*": "./src/features/*.js"
  },
  "imports": {
    "#internal/*": "./src/internal/*.js"
  }
}
```

然后，右侧 `*` 的所有实例都将替换为该值，包括它是否包含任何 `/` 分隔符。

```
import featureX from 'es-module-package/features/x';
// 加载 ./node_modules/es-module-package/src/features/x.js

import featureY from 'es-module-package/features/y/y';
// 加载 ./node_modules/es-module-package/src/features/y/y.js

import internalZ from '#internal/z';
// 加载 ./node_modules/es-module-package/src/internal/z.js
```

这是直接的静态替换，没有对文件扩展名进行任何特殊处理。 在前面的例子中，`pkg/features/x.json` 将在映射中解析为 `./src/features/x.json.js`。

导出的静态可枚举属性由导出模式维护，因为可以通过将右侧目标模式视为针对包内文件列表的 `**` glob 来确定包的各个导出。 因为导出目标中禁止 `node_modules` 路径，所以这个扩展只依赖包本身的文件。

#### 导出的语法糖[#](http://nodejs.cn/api-v12/packages.html#exports-sugar)

[中英对照](http://nodejs.cn/api-v12/packages/exports_sugar.html)

如果 `"."` 导出是唯一的导出，则 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 字段为这种情况提供了语法糖，即直接的 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 字段值。

如果 `"."` 导出有回退数组或字符串值，则可以直接将 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 字段设置为此值。

```
{
  "exports": {
    ".": "./main.js"
  }
}
```

可以写成：

```
{
  "exports": "./main.js"
}
```

#### 条件导出[#](http://nodejs.cn/api-v12/packages.html#conditional-exports)

[中英对照](http://nodejs.cn/api-v12/packages/conditional_exports.html)

条件导出提供了一种根据特定条件映射到不同路径的方法。 CommonJS 和 ES 模块导入都支持它们。

比如，包想要为 `require()` 和 `import` 提供不同的 ES 模块导出可以这样写：

```
// package.json
{
  "main": "./main-require.cjs",
  "exports": {
    "import": "./main-module.js",
    "require": "./main-require.cjs"
  },
  "type": "module"
}
```

-   `"import"` - 当包通过 `import` 或 `import()`，或者通过 ECMAScript 模块加载器的任何顶层导入或解析操作加载时匹配。 无论目标文件的模块格式如何，都适用。 _始终与 `"require"` 互斥。_
-   `"require"` - 当包通过 `require()` 加载时匹配。 引用的文件应该可以用 `require()` 加载，尽管无论目标文件的模块格式如何，条件都匹配。 预期的格式包括 CommonJS、JSON 和原生插件，但不包括 ES 模块，因为 `require()` 不支持它们。 _始终与 `"import"` 互斥。_
-   `"node"` - 匹配任何 Node.js 环境。 可以是 CommonJS 或 ES 模块文件。 _此条件应始终在 `"import"` 或 `"require"` 之后。_
-   `"default"` - 始终匹配的通用后备。 可以是 CommonJS 或 ES 模块文件。 _此条件应始终放在最后。_

在 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 对象中，键顺序很重要。 在条件匹配过程中，较早的条目具有更高的优先级并优先于较晚的条目。 _一般规则是条件应该按照对象顺序从最具体到最不具体_。

Node.js 以外的运行时或工具可以自行决定使用它们。

使用 `"import"` 和 `"require"` 条件会导致一些危害，在[双 CommonJS/ES 模块包章节](http://nodejs.cn/api-v12/packages.html#packages_dual_commonjs_es_module_packages)中有进一步的解释。

条件导出也可以扩展为导出子路径，例如：

```
{
  "main": "./main.js",
  "exports": {
    ".": "./main.js",
    "./feature": {
      "node": "./feature-node.js",
      "default": "./feature.js"
    }
  }
}
```

定义了一个包，其中 `require('pkg/feature')` 和 `import 'pkg/feature'` 可以在 Node.js 和其他 JS 环境之间提供不同的实现。

当使用环境分支时，总是尽可能包含 `"default"` 条件。 提供 `"default"` 条件可确保任何未知的 JS 环境都能够使用此通用实现，这有助于避免这些 JS 环境必须伪装成现有环境以支持具有条件导出的包。 出于这个原因，使用 `"node"` 和 `"default"` 条件分支通常比使用 `"node"` 和 `"browser"` 条件分支更可取。

#### 嵌套的条件[#](http://nodejs.cn/api-v12/packages.html#nested-conditions)

[中英对照](http://nodejs.cn/api-v12/packages/nested_conditions.html)

除了直接映射，Node.js 还支持嵌套条件对象。

例如，要定义一个包，它只有双模式入口点用于 Node.js 而不是浏览器：

```
{
  "main": "./main.js",
  "exports": {
    "node": {
      "import": "./feature-node.mjs",
      "require": "./feature-node.cjs"
    },
    "default": "./feature.mjs",
  }
}
```

条件继续按顺序与平面条件匹配。 如果嵌套条件没有任何映射，则将继续检查父条件的剩余条件。 通过这种方式，嵌套条件的行为类似于嵌套的 JavaScript `if` 语句。

#### 处理用户条件[#](http://nodejs.cn/api-v12/packages.html#resolving-user-conditions)

[中英对照](http://nodejs.cn/api-v12/packages/resolving_user_conditions.html)

运行 Node.js 时，可以使用 `--conditions` 标志添加自定义用户条件：

```
node --conditions=development main.js
```

可以使用重复标志设置任意数量的自定义条件。

#### 使用名称来引用包[#](http://nodejs.cn/api-v12/packages.html#self-referencing-a-package-using-its-name)

[中英对照](http://nodejs.cn/api-v12/packages/self_referencing_a_package_using_its_name.html)

在一个包中，在包的 `package.json` [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 字段中定义的值可以通过包的名称引用。 例如，假设 `package.json` 是：

```
// package.json
{
  "name": "a-package",
  "exports": {
    ".": "./main.mjs",
    "./foo": "./foo.js"
  }
}
```

然后该包中的任何模块都可以引用包本身中的导出：

```
// ./a-module.mjs
import { something } from 'a-package'; // 从 ./main.mjs 导入 "something"。
```

自引用仅在 `package.json` 具有 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 时可用，并且只允许导入 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports)（在 `package.json` 中）允许的内容。 所以下面的代码，给定前面的包，会产生运行时错误：

```
// ./another-module.mjs

// 从 ./m.mjs 导入 "another"。
// 失败，因为 "package.json" "exports" 字段 
// 不提供名为 "./m.mjs" 的导出。
import { another } from 'a-package/m.mjs';
```

在 ES 模块和 CommonJS 模块中使用 `require` 时也可以使用自引用。 例如，这段代码也可以工作：

```
// ./a-module.js
const { something } = require('a-package/foo'); // 从 ./foo.js 加载。
```

### 双 CommonJS/ES 模块包[#](http://nodejs.cn/api-v12/packages.html#dual-commonjses-module-packages)

[中英对照](http://nodejs.cn/api-v12/packages/dual_commonjs_es_module_packages.html)

在 Node.js 中引入对 ES 模块的支持之前，包作者的一种常见模式是在他们的包中包含 CommonJS 和 ES 模块 JavaScript 源代码，其中 `package.json` [`"main"`](http://nodejs.cn/api-v12/packages.html#packages_main) 指定了 CommonJS 入口点，而 `package.json` `"module"` 指定了 ES模块入口点。 这使 Node.js 能够运行 CommonJS 入口点，而构建工具（例如捆绑器）使用 ES 模块入口点，因为 Node.js 忽略（并且仍然忽略）顶层 `"module"` 字段。

Node.js 现在可以运行 ES 模块入口点，并且一个包可以同时包含 CommonJS 和 ES 模块入口点（通过单独的说明符，例如 `'pkg'` 和 `'pkg/es-module'`，或者通过[条件导出](http://nodejs.cn/api-v12/packages.html#packages_conditional_exports)在同一个说明符中）。 与 `"module"` 仅由打包程序使用的场景不同，或者在 Node.js 评估之前将 ES 模块文件动态转换为 CommonJS，ES 模块入口点引用的文件被评估为 ES 模块。

#### 双包的危害[#](http://nodejs.cn/api-v12/packages.html#dual-package-hazard)

[中英对照](http://nodejs.cn/api-v12/packages/dual_package_hazard.html)

当应用程序使用提供 CommonJS 和 ES 模块源的包时，如果包的两个版本都被加载，则存在某些错误的风险。 此潜力来自于 `const pkgInstance = require('pkg')` 创建的 `pkgInstance` 与 `import pkgInstance from 'pkg'` 创建的 `pkgInstance`（或像 `'pkg/module'` 这样的替代主路径）不同的事实。 这是“双包风险”，同一包的两个版本可以在同一个运行时环境中加载。 虽然应用程序或包不太可能有意直接加载两个版本，但应用程序加载一个版本而应用程序的依赖项加载另一个版本是很常见的。 这种危险可能发生，因为 Node.js 支持混合 CommonJS 和 ES 模块，并可能导致意外行为。

如果包主导出是一个构造函数，两个版本创建的实例的 `instanceof` 比较返回 `false`，如果导出是一个对象，添加到一个的属性（如 `pkgInstance.foo = 3`）在另一个上不存在。 这与 `import` 和 `require` 语句分别在全 CommonJS 或全 ES 模块环境中的工作方式不同，因此令用户感到惊讶。 它也不同于用户在通过 [Babel](http://url.nodejs.cn/u3q1WH) 或 [`esm`](http://url.nodejs.cn/6t74fP) 等工具使用转译时所熟悉的行为。

#### 在避免或最小化危害的同时编写双包[#](http://nodejs.cn/api-v12/packages.html#writing-dual-packages-while-avoiding-or-minimizing-hazards)

[中英对照](http://nodejs.cn/api-v12/packages/writing_dual_packages_while_avoiding_or_minimizing_hazards.html)

首先，当一个包同时包含 CommonJS 和 ES 模块源并且这两个源都通过单独的主入口点或导出路径提供以在 Node.js 中使用时，就会发生上一节中描述的危险。 一个包可能被写成任何版本的 Node.js 只接收 CommonJS 源，并且包可能包含的任何单独的 ES 模块源仅用于其他环境，例如浏览器。 这样的包可以被任何版本的 Node.js 使用，因为 `import` 可以引用 CommonJS 文件；但它不会提供使用 ES 模块语法的任何优点。

一个包也可能会在[重大更改](http://url.nodejs.cn/ePJAtd)版本碰撞中从 CommonJS 切换到 ES 模块语法。 这有一个缺点，即最新版本的包只能在支持 ES 模块的 Node.js 版本中使用。

每种模式都有权衡，但有两种广泛的方法可以满足以下条件：

1.  该软件包可通过 `require` 和 `import` 使用。
2.  该包在当前 Node.js 和不支持 ES 模块的旧版本 Node.js 中都可用。
3.  包主入口点，例如 `'pkg'` 可以被 `require` 用来解析 CommonJS 文件，也可以被 `import` 用来解析 ES 模块文件。 （对于导出的路径也是如此，例如 `'pkg/feature'`。）
4.  该包提供命名导出，例如 `import { name } from 'pkg'` 而不是 `import pkg from 'pkg'; pkg.name`。
5.  该包可能在其他 ES 模块环境中可用，例如浏览器。
6.  避免或最小化上一节中描述的危害。

##### 方法1：使用 ES 模块封装器[#](http://nodejs.cn/api-v12/packages.html#approach-1-use-an-es-module-wrapper)

[中英对照](http://nodejs.cn/api-v12/packages/approach_1_use_an_es_module_wrapper.html)

在 CommonJS 中编写包或将 ES 模块源代码转换为 CommonJS，并创建定义命名导出的 ES 模块封装文件。 使用[条件导出](http://nodejs.cn/api-v12/packages.html#packages_conditional_exports), `import` 使用 ES 模块封装器，`require` 使用 CommonJS 入口点。

```
// ./node_modules/pkg/package.json
{
  "type": "module",
  "main": "./index.cjs",
  "exports": {
    "import": "./wrapper.mjs",
    "require": "./index.cjs"
  }
}
```

前面的示例使用显式扩展 `.mjs` 和 `.cjs`。 如果你的文件使用 `.js` 扩展名，`"type": "module"` 会导致这些文件被视为 ES 模块，就像 `"type": "commonjs"` 会导致它们被视为 CommonJS。

```
// ./node_modules/pkg/index.cjs
exports.name = 'value';
```

```
// ./node_modules/pkg/wrapper.mjs
import cjsModule from './index.cjs';
export const name = cjsModule.name;
```

在这个例子中，`import { name } from 'pkg'` 中的 `name` 与 `const { name } = require('pkg')` 中的 `name` 是相同的单例。 因此，当比较两个 `name` 时，`===` 返回 `true`，避免了发散说明符的危险。

如果模块不是简单的命名导出列表，而是包含独特的函数或对象导出，如 `module.exports = function () { ... }`，或者如果需要封装器支持 `import pkg from 'pkg'` 模式，则封装器将被编写为可选地导出默认值以及任何命名的导出：

```
import cjsModule from './index.cjs';
export const name = cjsModule.name;
export default cjsModule;
```

此方法适用于以下任何用例：

-   该包目前是用 CommonJS 编写的，作者不希望将其重构为 ES 模块语法，而是希望为 ES 模块使用者提供命名导出。
-   该包还有其他依赖它的包，最终用户可能会同时安装这个包和那些其他包。 比如 `utilities` 包直接在应用中使用，`utilities-plus` 包给 `utilities` 增加了一些功能。 因为封装器会导出底层的 CommonJS 文件，所以 `utilities-plus` 是用 CommonJS 还是 ES 模块语法编写的并不重要；它会以任何一种方式工作。
-   包存储内部状态，包作者宁愿不重构包以隔离其状态管理。 请参阅下一章节。

此方法的变体不需要消费者有条件导出，可以添加一个导出，例如 `"./module"`，指向包的全 ES 模块语法版本。 这可以通过 `import 'pkg/module'` 由确定 CommonJS 版本不会在应用程序中的任何地方加载的用户使用，例如通过依赖项；或者如果 CommonJS 版本可以加载但不影响 ES 模块版本（例如, 因为包是无状态的）：

```
// ./node_modules/pkg/package.json
{
  "type": "module",
  "main": "./index.cjs",
  "exports": {
    ".": "./index.cjs",
    "./module": "./wrapper.mjs"
  }
}
```

##### 方法2：隔离状态[#](http://nodejs.cn/api-v12/packages.html#approach-2-isolate-state)

[中英对照](http://nodejs.cn/api-v12/packages/approach_2_isolate_state.html)

[`package.json`](http://nodejs.cn/api-v12/packages.html#packages_node_js_package_json_field_definitions) 文件可以直接定义单独的 CommonJS 和 ES 模块入口点：

```
// ./node_modules/pkg/package.json
{
  "type": "module",
  "main": "./index.cjs",
  "exports": {
    "import": "./index.mjs",
    "require": "./index.cjs"
  }
}
```

如果包的 CommonJS 和 ES 模块版本相同，则可以这样做，例如因为一个是另一个的转译输出；并且包的状态管理被仔细隔离（或包是无状态的）。

状态是一个问题的原因是因为包的 CommonJS 和 ES 模块版本都可能在应用程序中使用；例如，用户的应用程序代码可以 `import` ES 模块版本，而依赖项 `require` 是 CommonJS 版本。 如果发生这种情况，包的两个副本将被加载到内存中，因此将出现两个不同的状态。 这可能会导致难以解决的错误。

除了编写无状态的包（例如，如果 JavaScript 的 `Math` 是一个包，它将是无状态的，因为它的所有方法都是静态的），还有一些方法可以隔离状态，以便在潜在加载的 CommonJS 和 ES 模块之间共享包的实例：

1.  如果可能，在实例化对象中包含所有状态。 例如，JavaScript 的 `Date` 需要实例化以包含状态；如果它是包，则它会像这样使用：
    
    ```
    import Date from 'date';
    const someDate = new Date();
    // someDate 包含状态；Date 不包含
    ```
    
    `new` 关键字不是必需的；包的函数可以返回新的对象，或修改传入的对象，以保持包外部的状态。
    
2.  在包的 CommonJS 和 ES 模块版本之间共享的一个或多个 CommonJS 文件中隔离状态。 比如 CommonJS 和 ES 模块入口点分别是 `index.cjs` 和 `index.mjs`：
    
    ```
    // ./node_modules/pkg/index.cjs
    const state = require('./state.cjs');
    module.exports.state = state;
    ```
    
    ```
    // ./node_modules/pkg/index.mjs
    import state from './state.cjs';
    export {
      state
    };
    ```
    
    即使 `pkg` 在应用程序中通过 `require` 和 `import` 使用（例如，通过应用程序代码中的 `import` 和依赖项通过 `require`）`pkg` 的每个引用都将包含相同的状态；并且从任一模块系统修改该状态将适用二者皆是。
    

任何附加到包单例的插件都需要分别附加到 CommonJS 和 ES 模块单例。

此方法适用于以下任何用例：

-   该包目前是用 ES 模块语法编写的，包作者希望在支持此类语法的任何地方使用该版本。
-   包是无状态的，或者它的状态可以很容易地被隔离。
-   该包不太可能有其他依赖它的公共包，或者如果有，则该包是无状态的，或者具有不需要在依赖项之间或与整个应用程序共享的状态。

即使处于隔离状态，在 CommonJS 和 ES 模块版本之间仍然存在可能执行额外代码的成本。

与之前的方法一样，这种方法的变体不需要消费者有条件的导出，可以添加一个导出，例如 `"./module"`，指向包的全 ES 模块语法版本：

```
// ./node_modules/pkg/package.json
{
  "type": "module",
  "main": "./index.cjs",
  "exports": {
    ".": "./index.cjs",
    "./module": "./index.mjs"
  }
}
```

### Node.js package.json 字段定义[#](http://nodejs.cn/api-v12/packages.html#nodejs-packagejson-field-definitions)

[中英对照](http://nodejs.cn/api-v12/packages/node_js_package_json_field_definitions.html)

本节描述了 Node.js 运行时使用的字段。 其他工具（例如 [npm](https://docs.npmjs.com/creating-a-package-json-file)）使用 Node.js 忽略且未在此处记录的其他字段。

`package.json` 文件中的以下字段在 Node.js 中使用：

-   [`"name"`](http://nodejs.cn/api-v12/packages.html#packages_name) - 当包中使用命名导入时相关。 也被包管理器用作包的名称。
-   [`"type"`](http://nodejs.cn/api-v12/packages.html#packages_type) - 决定是否将 `.js` 文件加载为 CommonJS 或 ES 模块的包类型。
-   [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) - 包导出和条件导出。 当存在时，限制可以从包中加载哪些子模块。
-   [`"main"`](http://nodejs.cn/api-v12/packages.html#packages_main) - 加载包时的默认模块，如果没有指定导出，并且在引入导出之前的 Node.js 版本中。
-   [`"imports"`](http://nodejs.cn/api-v12/packages.html#packages_imports) - 包导入，供包本身内的模块使用。

#### `"name"`[#](http://nodejs.cn/api-v12/packages.html#name)

[中英对照](http://nodejs.cn/api-v12/packages/name.html)

-   类型: [<string>](http://url.nodejs.cn/9Tw2bK)

```
{
  "name": "package-name"
}
```

`"name"` 字段定义了包的名称。 发布到 _npm_ 仓库需要满足[特定要求](https://docs.npmjs.com/files/package.json#name)的名称。

除了 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 字段外，`"name"` 字段还可用于[自引用](http://nodejs.cn/api-v12/packages.html#packages_self_referencing_a_package_using_its_name)使用其名称的包。

#### `"type"`[#](http://nodejs.cn/api-v12/packages.html#type)

[中英对照](http://nodejs.cn/api-v12/packages/type.html)

-   类型: [<string>](http://url.nodejs.cn/9Tw2bK)

`"type"` 字段定义了 Node.js 用于所有 `.js` 文件的模块格式，这些 `.js` 文件将该 `package.json` 文件作为其最近的父文件。

当最近的父 `package.json` 文件包含值为 `"module"` 的顶级字段 `"type"` 时，以 `.js` 结尾的文件将作为 ES 模块加载。

最近的父 `package.json` 被定义为在当前文件夹中搜索时找到的第一个 `package.json`，该文件夹的父文件夹，依此类推，直到到达 node\_modules 文件夹或卷根。

```
// package.json
{
  "type": "module"
}
```

```
# 在与前面的 package.json 相同的文件夹中
node my-app.js # 作为 ES 模块运行
```

如果最近的父 `package.json` 缺少 `"type"` 字段，或包含 `"type": "commonjs"`，则 `.js` 文件将被视为 [CommonJS](http://nodejs.cn/api-v12/modules.html)。 如果到达卷根目录但未找到 `package.json`，则将 `.js` 文件视为 [CommonJS](http://nodejs.cn/api-v12/modules.html)。

如果最近的父 `package.json` 包含 `"type": "module"`，则 `.js` 文件的 `import` 语句被视为 ES 模块。

```
// my-app.js, 同上示例的一部分
import './startup.js'; // 由于 package.json 加载为 ES 模块
```

无论 `"type"` 字段的值如何，`.mjs` 文件始终被视为 ES 模块，而 `.cjs` 文件始终被视为 CommonJS。

#### `"exports"`[#](http://nodejs.cn/api-v12/packages.html#exports)

[中英对照](http://nodejs.cn/api-v12/packages/exports.html)

-   类型: [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<string\[\]>](http://url.nodejs.cn/9Tw2bK)

```
{
  "exports": "./index.js"
}
```

`"exports"` 字段允许定义包的[入口点](http://nodejs.cn/api-v12/packages.html#packages_package_entry_points)，当通过 `node_modules` 查找或[自引用](http://nodejs.cn/api-v12/packages.html#packages_self_referencing_a_package_using_its_name)加载到其自身的名称的名称导入时。 Node.js 12+ 支持它作为 [`"main"`](http://nodejs.cn/api-v12/packages.html#packages_main) 的替代方案，它可以支持定义[子路径导出](http://nodejs.cn/api-v12/packages.html#packages_subpath_exports)和[条件导出](http://nodejs.cn/api-v12/packages.html#packages_conditional_exports)，同时封装内部未导出的模块。

[条件导出](http://nodejs.cn/api-v12/packages.html#packages_conditional_exports)也可以在 `"exports"` 中用于为每个环境定义不同的包入口点，包括包是通过 `require` 还是通过 `import` 引用。

`"exports"` 中定义的所有路径必须是以 `./` 开头的相对文件 URL。

#### `"main"`[#](http://nodejs.cn/api-v12/packages.html#main)

[中英对照](http://nodejs.cn/api-v12/packages/main.html)

新增于: v0.4.0

-   类型: [<string>](http://url.nodejs.cn/9Tw2bK)

```
{
  "main": "./main.js"
}
```

```
require('./path/to/directory'); // 这解析为 ./path/to/directory/main.js。
```

当包具有 [`"exports"`](http://nodejs.cn/api-v12/packages.html#packages_exports) 字段时，则在按名称导入包时，这将优先于 `"main"` 字段。

#### `"imports"`[#](http://nodejs.cn/api-v12/packages.html#imports)

[中英对照](http://nodejs.cn/api-v12/packages/imports.html)

新增于: v12.19.0

-   类型: [<Object>](http://url.nodejs.cn/jzn6Ao)

```
// package.json
{
  "imports": {
    "#dep": {
      "node": "dep-node-native",
      "default": "./dep-polyfill.js"
    }
  },
  "dependencies": {
    "dep-node-native": "^1.0.0"
  }
}
```

导入字段中的条目必须是以 `#` 开头的字符串。

导入映射允许映射到外部包。

此字段为当前包定义了[子路径导入](http://nodejs.cn/api-v12/packages.html#packages_subpath_imports)。
