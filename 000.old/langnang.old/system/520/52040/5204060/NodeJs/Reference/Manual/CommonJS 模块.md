---
created: 2022-07-29T13:12:52 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/modules.html
author: 
---

# CommonJS 模块 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/modules/modules_commonjs_modules.html)

在 Node.js 模块系统中，每个文件都被视为独立的模块。 例如，假设一个名为 `foo.js` 的文件：

```
const circle = require('./circle.js');
console.log(`The area of a circle of radius 4 is ${circle.area(4)}`);
```

在第一行，`foo.js` 加载了与 `foo.js` 位于同一目录中的模块 `circle.js`。

以下是 `circle.js` 的内容：

```
const { PI } = Math;

exports.area = (r) => PI * r ** 2;

exports.circumference = (r) => 2 * PI * r;
```

模块 `circle.js` 已导出函数 `area()` 和 `circumference()`。 通过在特殊的 `exports` 对象上指定额外的属性，将函数和对象添加到模块的根部。

模块的本地变量将是私有的，因为模块被 Node.js 封装在函数中（参见[模块封装器](http://nodejs.cn/api-v12/modules.html#modules_the_module_wrapper)）。 在此示例中，变量 `PI` 是 `circle.js` 私有的。

可以为 `module.exports` 属性分配新的值（例如函数或对象）。

下面，`bar.js` 使用了导出 Square 类的 `square` 模块：

```
const Square = require('./square.js');
const mySquare = new Square(2);
console.log(`The area of mySquare is ${mySquare.area()}`);
```

`square` 模块在 `square.js` 中定义：

```
// 赋值给 exports 不会修改模块，必须使用 module.exports
module.exports = class Square {
  constructor(width) {
    this.width = width;
  }

  area() {
    return this.width ** 2;
  }
};
```

模块系统在 `require('module')` 模块中实现。

### 访问主模块[#](http://nodejs.cn/api-v12/modules.html#accessing-the-main-module)

[中英对照](http://nodejs.cn/api-v12/modules/accessing_the_main_module.html)

当文件直接从 Node.js 运行时，则 `require.main` 被设置为其 `module`。 这意味着可以通过测试 `require.main === module` 来确定文件是否被直接运行。

对于文件 `foo.js`，如果通过 `node foo.js` 运行，则为 `true`，如果通过 `require('./foo')` 运行，则为 `false`。

因为 `module` 提供了 `filename` 属性（通常相当于 `__filename`），通过查看 `require.main.filename` 就可以得到当前应用的入口点。

### Addenda: Package manager tips[#](http://nodejs.cn/api-v12/modules.html#addenda-package-manager-tips)

[中英对照](http://nodejs.cn/api-v12/modules/addenda_package_manager_tips.html)

Node.js `require()` 函数的语义被设计为足够通用以支持合理的目录结构。 诸如 `dpkg`、`rpm` 和 `npm` 之类的包管理器程序有望发现无需修改即可从 Node.js 模块构建本机包。

下面给出了一个可行的建议目录结构：

假设想让位于 `/usr/lib/node/<some-package>/<some-version>` 的文件夹保存特定版本包的内容。

包可以相互依赖。 为了安装包 `foo`，可能需要安装包 `bar` 的特定版本。 `bar` 包本身可能存在依赖关系，在某些情况下，这些甚至可能发生冲突或形成循环依赖关系。

因为 Node.js 查找它加载的任何模块的 `realpath`（即，它解析符号链接）然后[在 `node_modules` 文件夹中查找它们的依赖项](http://nodejs.cn/api-v12/modules.html#modules_loading_from_node_modules_folders)，所以这种情况可以通过以下架构解决：

-   `/usr/lib/node/foo/1.2.3/`: `foo` 包的内容，版本 1.2.3。
-   `/usr/lib/node/bar/4.3.2/`: `foo` 依赖的 `bar` 包的内容。
-   `/usr/lib/node/foo/1.2.3/node_modules/bar`: `/usr/lib/node/bar/4.3.2/` 的符号链接。
-   `/usr/lib/node/bar/4.3.2/node_modules/*`: `bar` 依赖的包的符号链接。

因此，即使遇到循环，或者如果存在依赖冲突，每个模块都将能够获得它可以使用的依赖版本。

当 `foo` 包中的代码执行 `require('bar')` 时，它将获得符号链接到 `/usr/lib/node/foo/1.2.3/node_modules/bar` 的版本。 然后，当 `bar` 包中的代码调用 `require('quux')` 时，它将获得符号链接到 `/usr/lib/node/bar/4.3.2/node_modules/quux` 的版本。

此外，为了使模块查找过程更加优化，与其将包直接放在 `/usr/lib/node` 中，还可以将它们放在 `/usr/lib/node_modules/<name>/<version>` 中。 这样 Node.js 就不会费心寻找 `/usr/node_modules` 或 `/node_modules` 中缺失的依赖项了。

为了使模块可用于 Node.js 交互式解释器，将 `/usr/lib/node_modules` 文件夹添加到 `$NODE_PATH` 环境变量可能会很有用。 由于使用 `node_modules` 文件夹的模块查找都是相对的，并且基于调用 `require()` 的文件的真实路径，因此包本身可以位于任何位置。

### Addenda: The `.mjs` extension[#](http://nodejs.cn/api-v12/modules.html#addenda-the-mjs-extension)

[中英对照](http://nodejs.cn/api-v12/modules/addenda_the_mjs_extension.html)

无法使用 `require()` 扩展名为 `.mjs` 的文件。 尝试这样做会抛出[错误](http://nodejs.cn/api-v12/errors.html#errors_err_require_esm)。 `.mjs` 扩展名是为无法通过 `require()` 加载的 [ECMAScript 模块](http://nodejs.cn/api-v12/esm.html)保留的。 有关更多详细信息，请参阅 [ECMAScript 模块](http://nodejs.cn/api-v12/esm.html)。

### 总结[#](http://nodejs.cn/api-v12/modules.html#all-together)

[中英对照](http://nodejs.cn/api-v12/modules/all_together.html)

要获取调用 `require()` 时将加载的确切文件名，则使用 `require.resolve()` 函数。

综上所述，这里是 `require()` 的伪代码高级算法：

````
require(X) from module at path Y
1. 
   
   
2. 
   
3. 
   
   
   
4. 
   
5. 
6. 
7. 

LOAD_AS_FILE(X)
1. 
   
2. 
   
3. 
   
4. 
   

LOAD_INDEX(X)
1. 
   
2. 
   
3. 
   

LOAD_AS_DIRECTORY(X)
1. 
   
   
   
   
   
   
   
2. LOAD_INDEX(X)

LOAD_NODE_MODULES(X, START)
1. 
2. 
   
   
   

NODE_MODULES_PATHS(START)
1. 
2. 
3. 
4. 
   
   
   
   
   
5. 

LOAD_PACKAGE_IMPORTS(X, DIR)
1. 
2. 
3. 
4. 
5. 

LOAD_PACKAGE_EXPORTS(X, DIR)
1. 
2. 
3. 
4. 
5. 
6. RESOLVE_ESM_MATCH(MATCH)

LOAD_PACKAGE_SELF(X, DIR)
1. 
2. 
3. 
4. 
5. 
6. RESOLVE_ESM_MATCH(MATCH)

RESOLVE_ESM_MATCH(MATCH)
1. 
2. 
3. 
   
   
4. 
   
   
5. 


## Caching


<!--type=misc-->

模块在第一次加载后被缓存。
这意味着（类似其他缓存）每次调用 `require('foo')` 都会返回完全相同的对象（如果解析为相同的文件）。

如果 `require.cache` 没有被修改，则多次调用 `require('foo')` 不会导致模块代码被多次执行。
这是重要的特征。
有了它，可以返回“部分完成”的对象，从而允许加载传递依赖项，即使它们会导致循环。

要让模块多次执行代码，则导出函数，然后调用该函数。


### Module caching caveats


<!--type=misc-->

模块根据其解析的文件名进行缓存。
由于模块可能会根据调用模块的位置（从 `node_modules` 文件夹加载）解析为不同的文件名，因此如果 `require('foo')` 解析为不同的文件，则不能保证 `require('foo')` 将始终返回完全相同的对象。

此外，在不区分大小写的文件系统或操作系统上，不同的解析文件名可以指向同一个文件，但缓存仍会将它们视为不同的模块，并将多次重新加载文件。
例如，`require('./foo')` 和 `require('./FOO')` 返回两个不同的对象，而不管 `./foo` 和 `./FOO` 是否是同一个文件。


## Core modules


<!--type=misc-->

Node.js 有些模块编译成二进制文件。
这些模块在本文档的其他地方有更详细的描述。

核心模块在 Node.js 源代码中定义，位于 `lib/` 文件夹中。

如果将核心模块的标识符传给 `require()`，则始终优先加载核心模块。
例如，`require('http')` 将始终返回内置的 HTTP 模块，即使存在该名称的文件。


## Cycles


<!--type=misc-->

当有循环 `require()` 调用时，模块在返回时可能尚未完成执行。

考虑这种情况：

`a.js`:

```js
console.log('a starting');
exports.done = false;
const b = require('./b.js');
console.log('in a, b.done = %j', b.done);
exports.done = true;
console.log('a done');
````

`b.js`:

```
console.log('b starting');
exports.done = false;
const a = require('./a.js');
console.log('in b, a.done = %j', a.done);
exports.done = true;
console.log('b done');
```

`main.js`:

```
console.log('main starting');
const a = require('./a.js');
const b = require('./b.js');
console.log('in main, a.done = %j, b.done = %j', a.done, b.done);
```

当 `main.js` 加载 `a.js` 时，`a.js` 依次加载 `b.js`。 此时，`b.js` 尝试加载 `a.js`。 为了防止无限循环，将 `a.js` 导出对象的未完成副本返回给 `b.js` 模块。 然后 `b.js` 完成加载，并将其 `exports` 对象提供给 `a.js` 模块。

到 `main.js` 加载这两个模块时，它们都已完成。 因此，该程序的输出将是：

```
$ node main.js
main starting
a starting
b starting
in b, a.done = false
b done
in a, b.done = true
a done
in main, a.done = true, b.done = true
```

需要仔细规划以允许循环模块依赖项在应用程序中正常工作。

### 文件模块[#](http://nodejs.cn/api-v12/modules.html#file-modules)

[中英对照](http://nodejs.cn/api-v12/modules/file_modules.html)

如果找不到确切的文件名，Node.js 将尝试加载所需的文件名，并添加扩展名：`.js`、`.json`，最后是 `.node`。

`.js` 文件被解释为 JavaScript 文本文件，而 `.json` 文件被解析为 JSON 文本文件。 `.node` 文件被解释为加载了 `process.dlopen()` 的编译插件模块。

以 `'/'` 为前缀的必需模块是文件的绝对路径。 例如，`require('/home/marco/foo.js')` 将在 `/home/marco/foo.js` 加载文件。

以 `'./'` 为前缀的必需模块与调用 `require()` 的文件相关。 也就是说，`circle.js` 必须和 `foo.js` 在同一个目录下，`require('./circle')` 才能找到它。

如果没有前导 `'/'`、`'./'` 或 `'../'` 来指示文件，则该模块必须是核心模块或从 `node_modules` 文件夹加载。

如果给定的路径不存在，则 `require()` 将抛出 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error)，其 `code` 属性设置为 `'MODULE_NOT_FOUND'`。

### 目录作为模块[#](http://nodejs.cn/api-v12/modules.html#folders-as-modules)

[中英对照](http://nodejs.cn/api-v12/modules/folders_as_modules.html)

将程序和库组织到自包含目录中，然后为这些目录提供单个入口点是很方便的。 可以通过三种方式将文件夹作为参数传给 `require()`。

首先是在文件夹的根目录创建 [`package.json`](http://nodejs.cn/api-v12/packages.html#packages_node_js_package_json_field_definitions) 文件，指定 `main` 模块。 一个示例 [`package.json`](http://nodejs.cn/api-v12/packages.html#packages_node_js_package_json_field_definitions) 文件可能如下所示：

```
{ "name" : "some-library",
  "main" : "./lib/some-library.js" }
```

如果这是在 `./some-library` 的文件夹中，则 `require('./some-library')` 将尝试加载 `./some-library/lib/some-library.js`。

这就是 Node.js 中对 `package.json` 文件的认识程度。

如果目录中不存在 [`package.json`](http://nodejs.cn/api-v12/packages.html#packages_node_js_package_json_field_definitions) 文件，或者 [`"main"`](http://nodejs.cn/api-v12/packages.html#packages_main) 条目丢失或无法解析，则 Node.js 将尝试从该目录中加载 `index.js` 或 `index.node` 文件。 例如，如果前面的示例中没有 [`package.json`](http://nodejs.cn/api-v12/packages.html#packages_node_js_package_json_field_definitions) 文件，则 `require('./some-library')` 将尝试加载：

-   `./some-library/index.js`
-   `./some-library/index.node`

如果这些尝试失败，Node.js 将报告整个模块丢失，并显示默认错误：

```
Error: Cannot find module 'some-library'
```

### 从 node\_modules 目录加载[#](http://nodejs.cn/api-v12/modules.html#loading-from-node_modules-folders)

[中英对照](http://nodejs.cn/api-v12/modules/loading_from_node_modules_folders.html)

如果传给 `require()` 的模块标识符不是[核心](http://nodejs.cn/api-v12/modules.html#modules_core_modules)模块，并且不以 `'/'`、`'../'` 或 `'./'` 开头，则 Node.js 从当前模块的父目录开始，并添加 `/node_modules`，并尝试从该位置加载模块。 Node.js 不会将 `node_modules` 附加到已经以 `node_modules` 结尾的路径。

如果在那里找不到它，则它移动到父目录，依此类推，直到到达文件系统的根目录。

例如，如果 `'/home/ry/projects/foo.js'` 处的文件调用 `require('bar.js')`，则 Node.js 将按以下顺序查找以下位置：

-   `/home/ry/projects/node_modules/bar.js`
-   `/home/ry/node_modules/bar.js`
-   `/home/node_modules/bar.js`
-   `/node_modules/bar.js`

这允许程序本地化它们的依赖项，这样它们就不会发生冲突。

通过在模块名称后包含路径后缀，可以要求与模块一起分发的特定文件或子模块。 例如，`require('example-module/path/to/file')` 将相对于 `example-module` 所在的位置解析 `path/to/file`。 后缀路径遵循相同的模块解析语义。

### 从全局目录加载[#](http://nodejs.cn/api-v12/modules.html#loading-from-the-global-folders)

[中英对照](http://nodejs.cn/api-v12/modules/loading_from_the_global_folders.html)

如果 `NODE_PATH` 环境变量设置为以冒号分隔的绝对路径列表，则 Node.js 将在这些路径中搜索模块（如果它们在其他地方找不到）。

在 Windows 上，`NODE_PATH` 由分号 (`;`) 而不是冒号分隔。

在定义当前的[模块解析](http://nodejs.cn/api-v12/modules.html#modules_all_together)算法之前，`NODE_PATH` 最初是为了支持从不同路径加载模块而创建的。

`NODE_PATH` 仍然受支持，但现在 Node.js 生态系统已经确定了用于定位依赖模块的约定，因此不太必要。 有时，当不知道必须设置 `NODE_PATH` 时，依赖 `NODE_PATH` 的部署会表现出意外的行为。 有时，模块的依赖项会发生变化，导致在搜索 `NODE_PATH` 时加载不同的版本（甚至不同的模块）。

此外，Node.js 将在以下 GLOBAL\_FOLDERS 列表中搜索：

-   1: `$HOME/.node_modules`
-   2: `$HOME/.node_libraries`
-   3: `$PREFIX/lib/node`

其中 `$HOME` 是用户的主目录，`$PREFIX` 是 Node.js 配置的 `node_prefix`。

这些主要是出于历史原因。

强烈建议将依赖项放在本地 `node_modules` 文件夹中。 这些将加载得更快，更可靠。

### 模块封装器[#](http://nodejs.cn/api-v12/modules.html#the-module-wrapper)

[中英对照](http://nodejs.cn/api-v12/modules/the_module_wrapper.html)

在执行模块代码之前，Node.js 将使用如下所示的函数封装器对其进行封装：

```
(function(exports, require, module, __filename, __dirname) {
// 模块代码实际存在于此处
});
```

通过这样做，Node.js 实现了以下几点：

-   它将顶层变量（用 `var`、`const` 或 `let` 定义）保持在模块而不是全局对象的范围内。
-   它有助于提供一些实际特定于模块的全局变量，例如：
    -   `module` 和 `exports` 对象，实现者可以用来从模块中导出值。
    -   便利变量 `__filename` 和 `__dirname`，包含模块的绝对文件名和目录路径。

### 模块作用域[#](http://nodejs.cn/api-v12/modules.html#the-module-scope)

#### `__dirname`[#](http://nodejs.cn/api-v12/modules.html#__dirname)

[中英对照](http://nodejs.cn/api-v12/modules/dirname.html)

新增于: v0.1.27

-   [<string>](http://url.nodejs.cn/9Tw2bK)

当前模块的目录名。 这与 [`__filename`](http://nodejs.cn/api-v12/modules.html#modules_filename) 的 [`path.dirname()`](http://nodejs.cn/api-v12/path.html#path_path_dirname_path) 相同。

示例：从 `/Users/mjr` 运行 `node example.js`

```
console.log(__dirname);
// 打印: /Users/mjr
console.log(path.dirname(__filename));
// 打印: /Users/mjr
```

#### `__filename`[#](http://nodejs.cn/api-v12/modules.html#__filename)

[中英对照](http://nodejs.cn/api-v12/modules/filename.html)

新增于: v0.0.1

-   [<string>](http://url.nodejs.cn/9Tw2bK)

当前模块的文件名。 这是当前模块文件的已解析符号链接的绝对路径。

对于主程序，这不一定与命令行中使用的文件名相同。

当前模块的目录名见 [`__dirname`](http://nodejs.cn/api-v12/modules.html#modules_dirname)。

示例：

从 `/Users/mjr` 运行 `node example.js`

```
console.log(__filename);
// 打印: /Users/mjr/example.js
console.log(__dirname);
// 打印: /Users/mjr
```

给定两个模块：`a` 和 `b`，其中 `b` 是 `a` 的依赖项，且目录结构为：

-   `/Users/mjr/app/a.js`
-   `/Users/mjr/app/node_modules/b/b.js`

在 `b.js` 中对 `__filename` 的引用将返回 `/Users/mjr/app/node_modules/b/b.js`，而在 `a.js` 中对 `__filename` 的引用将返回 `/Users/mjr/app/a.js`。

#### `exports`[#](http://nodejs.cn/api-v12/modules.html#exports)

[中英对照](http://nodejs.cn/api-v12/modules/exports.html)

新增于: v0.1.12

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

对 `module.exports` 的引用，其输入更短。 有关何时使用 `exports` 和何时使用 `module.exports` 的详细信息，请参阅有关[导出的快捷方式](http://nodejs.cn/api-v12/modules.html#modules_exports_shortcut)的章节。

#### `module`[#](http://nodejs.cn/api-v12/modules.html#module)

[中英对照](http://nodejs.cn/api-v12/modules/module.html)

新增于: v0.1.16

-   [<module>](http://nodejs.cn/api/modules.html#the-module-object)

对当前模块的引用，请参阅有关 [`module` 对象](http://nodejs.cn/api-v12/modules.html#modules_the_module_object)的部分。 特别是，`module.exports` 用于定义模块通过 `require()` 导出和提供的内容。

#### `require(id)`[#](http://nodejs.cn/api-v12/modules.html#requireid)

[中英对照](http://nodejs.cn/api-v12/modules/require_id.html)

新增于: v0.1.13

-   `id` [<string>](http://url.nodejs.cn/9Tw2bK) 模块名称或路径
-   返回: [<any>](http://url.nodejs.cn/6sTGdS) 导出的模块内容

用于导入模块、`JSON` 和本地文件。 模块可以从 `node_modules` 导入。 可以使用相对路径（例如 `./`、`./foo`、`./bar/baz`、`../foo`）导入本地模块和 JSON 文件，该路径将根据 [`__dirname`](http://nodejs.cn/api-v12/modules.html#modules_dirname)（如果有定义）命名的目录或当前工作目录进行解析。 POSIX 风格的相对路径以独立于操作系统的方式解析，这意味着上面的示例将在 Windows 上以与在 Unix 系统上相同的方式工作。

```
// 使用相对于 `__dirname` 或当前工作目录的路径导入本地模块。
//（在 Windows 上，这将解析为 .\path\myLocalModule。）
const myLocalModule = require('./path/myLocalModule');

// 导入 JSON 文件：
const jsonData = require('./path/filename.json');

// 从 node_modules 或 Node.js 内置模块导入模块：
const crypto = require('crypto');
```

##### `require.cache`[#](http://nodejs.cn/api-v12/modules.html#requirecache)

[中英对照](http://nodejs.cn/api-v12/modules/require_cache.html)

新增于: v0.3.0

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

模块在需要时缓存在此对象中。 通过从此对象中删除键值，下一次 `require` 将重新加载模块。 这不适用于[原生插件](http://nodejs.cn/api-v12/addons.html)，因为重新加载会导致错误。

添加或替换条目也是可能的。

小心使用！

##### `require.extensions`[#](http://nodejs.cn/api-v12/modules.html#requireextensions)

[中英对照](http://nodejs.cn/api-v12/modules/require_extensions.html)

新增于: v0.3.0弃用于: v0.10.6

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

指导 `require` 如何处理某些文件扩展名。

将扩展名为 `.sjs` 的文件处理为 `.js`：

```
require.extensions['.sjs'] = require.extensions['.js'];
```

**已弃用。** 过去，此列表用于通过按需编译将非 JavaScript 模块加载到 Node.js 中。 但是，在实践中，有很多更好的方法可以做到这一点，例如通过其他一些 Node.js 程序加载模块，或者提前将它们编译为 JavaScript。

避免使用 `require.extensions`。 使用可能会导致细微的错误，并且每个注册的扩展程序解决扩展程序的速度都会变慢。

##### `require.main`[#](http://nodejs.cn/api-v12/modules.html#requiremain)

[中英对照](http://nodejs.cn/api-v12/modules/require_main.html)

新增于: v0.1.17

-   [<module>](http://nodejs.cn/api/modules.html#the-module-object)

`Module` 对象表示 Node.js 进程启动时加载的入口脚本。 请参阅[“访问主模块”](http://nodejs.cn/api-v12/modules.html#modules_accessing_the_main_module)。

在 `entry.js` 脚本中：

```
console.log(require.main);
```

```
node entry.js
```

```
Module {
  id: '.',
  path: '/absolute/path/to',
  exports: {},
  parent: null,
  filename: '/absolute/path/to/entry.js',
  loaded: false,
  children: [],
  paths:
   [ '/absolute/path/to/node_modules',
     '/absolute/path/node_modules',
     '/absolute/node_modules',
     '/node_modules' ] }
```

##### `require.resolve(request[, options])`[#](http://nodejs.cn/api-v12/modules.html#requireresolverequest-options)

[中英对照](http://nodejs.cn/api-v12/modules/require_resolve_request_options.html)

-   `request` [<string>](http://url.nodejs.cn/9Tw2bK) 要解析的模块路径。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `paths` [<string\[\]>](http://url.nodejs.cn/9Tw2bK) 从中解析模块位置的路径。 如果存在，则使用这些路径而不是默认的解析路径，除了 [GLOBAL\_FOLDERS](http://nodejs.cn/api-v12/modules.html#modules_loading_from_the_global_folders)（例如 `$HOME/.node_modules`，其总是被包含在内）。 这些路径中的每一个都用作模块解析算法的起点，这意味着从此位置检查 `node_modules` 层级。
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

使用内部的 `require()` 工具查找模块的位置，但不加载模块，只返回解析的文件名。

如果找不到模块，则会抛出 `MODULE_NOT_FOUND` 错误。

###### `require.resolve.paths(request)`[#](http://nodejs.cn/api-v12/modules.html#requireresolvepathsrequest)

[中英对照](http://nodejs.cn/api-v12/modules/require_resolve_paths_request.html)

新增于: v8.9.0

-   `request` [<string>](http://url.nodejs.cn/9Tw2bK) 正在检索其查找路径的模块路径。
-   返回: [<string\[\]>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC)

如果 `request` 字符串引用核心模块，例如 `http` 或 `fs`，则返回包含在解析 `request` 或 `null` 期间搜索的路径的数组。

### module 对象[#](http://nodejs.cn/api-v12/modules.html#the-module-object)

[中英对照](http://nodejs.cn/api-v12/modules/the_module_object.html)

新增于: v0.1.16

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

在每个模块中，`module` 自由变量是对代表当前模块的对象的引用。 为方便起见，`module.exports` 也可通过 `exports` 模块全局访问。 `module` 实际上不是全局的，而是每个模块本地的。

#### `module.children`[#](http://nodejs.cn/api-v12/modules.html#modulechildren)

[中英对照](http://nodejs.cn/api-v12/modules/module_children.html)

新增于: v0.1.16

-   [<module\[\]>](http://nodejs.cn/api/modules.html#the-module-object)

这个模块首次需要的对象。

#### `module.exports`[#](http://nodejs.cn/api-v12/modules.html#moduleexports)

[中英对照](http://nodejs.cn/api-v12/modules/module_exports.html)

新增于: v0.1.16

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

`module.exports` 对象由 `Module` 系统创建。 有时这是不可接受的；许多人希望他们的模块成为某个类的实例。 为此，则将所需的导出对象赋值给 `module.exports`。 将所需的对象赋值给 `exports` 只会重新绑定本地的 `exports` 变量，这可能不是想要的。

例如，假设正在制作一个名为 `a.js` 的模块：

```
const EventEmitter = require('events');

module.exports = new EventEmitter();

// 做一些工作，一段时间后从模块本身触发 'ready' 事件。
setTimeout(() => {
  module.exports.emit('ready');
}, 1000);
```

然后在另一个文件中可以这样做：

```
const a = require('./a');
a.on('ready', () => {
  console.log('module "a" is ready');
});
```

赋值给 `module.exports` 必须立即完成。 不能在任何回调中完成。 以下不起作用：

`x.js`:

```
setTimeout(() => {
  module.exports = { a: 'hello' };
}, 0);
```

`y.js`:

```
const x = require('./x');
console.log(x.a);
```

##### 导出的快捷方式[#](http://nodejs.cn/api-v12/modules.html#exports-shortcut)

[中英对照](http://nodejs.cn/api-v12/modules/exports_shortcut.html)

新增于: v0.1.16

`exports` 变量在模块的文件级作用域内可用，并在评估模块之前被分配 `module.exports` 的值。

它允许一个快捷方式，以便 `module.exports.f = ...` 可以更简洁地写成 `exports.f = ...`。 但是，请注意，与任何变量一样，如果将新值分配给 `exports`，则它就不再绑定到 `module.exports`：

```
module.exports.hello = true; // 从模块的 require 中导出
exports = { hello: false };  // 未导出，仅在模块中可用
```

当 `module.exports` 属性被新对象完全替换时，通常也会重新分配 `exports`：

```
module.exports = exports = function Constructor() {
  // ... 等等。
};
```

为了阐明该行为，想象一下 `require()` 的这个假设实现，它与 `require()` 的实际实现非常相似：

```
function require(/* ... */) {
  const module = { exports: {} };
  ((module, exports) => {
    // 模块代码在这里。 在本例中，定义一个函数。
    function someFunc() {}
    exports = someFunc;
    // 此时，exports 不再是 module.exports 的快捷方式，
    // 并且此模块仍然会导出空的默认对象。
    module.exports = someFunc;
    // 此时，该模块现在将导出 someFunc，
    // 而不是默认对象。
  })(module, module.exports);
  return module.exports;
}
```

#### `module.filename`[#](http://nodejs.cn/api-v12/modules.html#modulefilename)

[中英对照](http://nodejs.cn/api-v12/modules/module_filename.html)

新增于: v0.1.16

-   [<string>](http://url.nodejs.cn/9Tw2bK)

模块的完全解析文件名。

#### `module.id`[#](http://nodejs.cn/api-v12/modules.html#moduleid)

[中英对照](http://nodejs.cn/api-v12/modules/module_id.html)

新增于: v0.1.16

-   [<string>](http://url.nodejs.cn/9Tw2bK)

模块的标识符。 通常这是完全解析的文件名。

#### `module.loaded`[#](http://nodejs.cn/api-v12/modules.html#moduleloaded)

[中英对照](http://nodejs.cn/api-v12/modules/module_loaded.html)

新增于: v0.1.16

-   [<boolean>](http://url.nodejs.cn/jFbvuT)

模块是否已完成加载，或正在加载。

#### `module.parent`[#](http://nodejs.cn/api-v12/modules.html#moduleparent)

[中英对照](http://nodejs.cn/api-v12/modules/module_parent.html)

新增于: v0.1.16弃用于: v12.19.0, v14.6.0

-   [<module>](http://nodejs.cn/api/modules.html#the-module-object) | [<null>](http://url.nodejs.cn/334hvC) | [<undefined>](http://url.nodejs.cn/8ym6ow)

首先需要这个模块的模块，如果当前模块是当前进程的入口点，则为 `null`，如果模块是由不是 CommonJS 模块的东西（例如：REPL 或 `import`）加载的，则为 `undefined`。

#### `module.path`[#](http://nodejs.cn/api-v12/modules.html#modulepath)

[中英对照](http://nodejs.cn/api-v12/modules/module_path.html)

新增于: v11.14.0

-   [<string>](http://url.nodejs.cn/9Tw2bK)

模块的目录名称。 这通常与 [`module.id`](http://nodejs.cn/api-v12/modules.html#modules_module_id) 的 [`path.dirname()`](http://nodejs.cn/api-v12/path.html#path_path_dirname_path) 相同。

#### `module.paths`[#](http://nodejs.cn/api-v12/modules.html#modulepaths)

[中英对照](http://nodejs.cn/api-v12/modules/module_paths.html)

新增于: v0.4.0

-   [<string\[\]>](http://url.nodejs.cn/9Tw2bK)

模块的搜索路径。

#### `module.require(id)`[#](http://nodejs.cn/api-v12/modules.html#modulerequireid)

[中英对照](http://nodejs.cn/api-v12/modules/module_require_id.html)

新增于: v0.5.1

-   `id` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<any>](http://url.nodejs.cn/6sTGdS) 导出的模块内容

`module.require()` 方法提供了一种加载模块的方法，就像从原始模块调用 `require()` 一样。

为此，必须获得对 `module` 对象的引用。 由于 `require()` 返回 `module.exports`，而 `module` 通常仅在特定模块的代码中可用，因此必须明确导出才能使用。

### Module 对象[#](http://nodejs.cn/api-v12/modules.html#the-module-object_1)

This section was moved to [Modules: `module` core module](http://nodejs.cn/api-v12/module.html#module_the_module_object).

-   [`module.builtinModules`](http://nodejs.cn/api-v12/module.html#module_module_builtinmodules)
-   [`module.createRequire(filename)`](http://nodejs.cn/api-v12/module.html#module_module_createrequire_filename)
-   [`module.createRequireFromPath(filename)`](http://nodejs.cn/api-v12/module.html#module_module_createrequirefrompath_filename)
-   [`module.syncBuiltinESMExports()`](http://nodejs.cn/api-v12/module.html#module_module_syncbuiltinesmexports)

### Source Map V3 的支持[#](http://nodejs.cn/api-v12/modules.html#source-map-v3-support)

[中英对照](http://nodejs.cn/api-v12/modules/source_map_v3_support.html)

-   [类：`module.SourceMap`](http://nodejs.cn/api-v12/module.html#module_class_module_sourcemap)
    -   [`new SourceMap(payload)`](http://nodejs.cn/api-v12/module.html#module_new_sourcemap_payload)
    -   [`sourceMap.payload`](http://nodejs.cn/api-v12/module.html#module_sourcemap_payload)
    -   [`sourceMap.findEntry(lineNumber, columnNumber)`](http://nodejs.cn/api-v12/module.html#module_sourcemap_findentry_linenumber_columnnumber)
