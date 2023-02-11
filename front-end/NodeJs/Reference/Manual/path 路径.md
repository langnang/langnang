---
created: 2022-07-29T13:12:54 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/path.html
author: 
---

# path 路径 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/path/path.html)

**源代码:** [lib/path.js](https://github.com/nodejs/node/blob/v12.22.12/lib/path.js)

`path` 模块提供了用于处理文件和目录的路径的实用工具。 可以使用以下方式访问它：

```
const path = require('path');
```

### Windows 与 POSIX 的对比[#](http://nodejs.cn/api-v12/path.html#windows-vs-posix)

[中英对照](http://nodejs.cn/api-v12/path/windows_vs_posix.html)

`path` 模块的默认操作因运行 Node.js 应用程序的操作系统而异。 具体来说，当在 Windows 操作系统上运行时，`path` 模块将假定正在使用 Windows 风格的路径。

因此，在 POSIX 和 Windows 上使用 `path.basename()` 可能会产生不同的结果：

在 POSIX 上：

```
path.basename('C:\\temp\\myfile.html');
// 返回: 'C:\\temp\\myfile.html'
```

在 Windows 上：

```
path.basename('C:\\temp\\myfile.html');
// 返回: 'myfile.html'
```

当使用 Windows 文件路径时，若要在任何操作系统上获得一致的结果，则使用 [`path.win32`](http://nodejs.cn/api-v12/path.html#path_path_win32)：

在 POSIX 和 Windows 上：

```
path.win32.basename('C:\\temp\\myfile.html');
// 返回: 'myfile.html'
```

当使用 POSIX 文件路径时，若要在任何操作系统上获得一致的结果，则使用 [`path.posix`](http://nodejs.cn/api-v12/path.html#path_path_posix)：

在 POSIX 和 Windows 上：

```
path.posix.basename('/tmp/myfile.html');
// 返回: 'myfile.html'
```

在 Windows 上，Node.js 遵循独立驱动器工作目录的概念。 当使用不带反斜杠的驱动器路径时，可以观察到此行为。 例如，`path.resolve('C:\\')` 可能返回与 `path.resolve('C:')` 不同的结果。 有关详细信息，请参阅[此 MSDN 页面](http://url.nodejs.cn/qMc4eE)。

### `path.basename(path[, ext])`[#](http://nodejs.cn/api-v12/path.html#pathbasenamepath-ext)

[中英对照](http://nodejs.cn/api-v12/path/path_basename_path_ext.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `ext` [<string>](http://url.nodejs.cn/9Tw2bK) 可选的文件扩展名
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

`path.basename()` 方法返回 `path` 的最后一部分，类似于 Unix `basename` 命令。 尾随的目录分隔符被忽略，见 [`path.sep`](http://nodejs.cn/api-v12/path.html#path_path_sep)。

```
path.basename('/foo/bar/baz/asdf/quux.html');
// 返回: 'quux.html'

path.basename('/foo/bar/baz/asdf/quux.html', '.html');
// 返回: 'quux'
```

尽管 Windows 通常以不区分大小写的方式处理文件名（包括文件扩展名），但此函数不会。 例如，`C:\\foo.html` 和 `C:\\foo.HTML` 指的是同一个文件，但 `basename` 将扩展名视为区分大小写的字符串：

```
path.win32.basename('C:\\foo.html', '.html');
// 返回: 'foo'

path.win32.basename('C:\\foo.HTML', '.html');
// 返回: 'foo.HTML'
```

如果 `path` 不是字符串，或者如果给定 `ext` 并且不是字符串，则抛出 [`TypeError`](http://nodejs.cn/api-v12/errors.html#errors_class_typeerror)。

### `path.delimiter`[#](http://nodejs.cn/api-v12/path.html#pathdelimiter)

[中英对照](http://nodejs.cn/api-v12/path/path_delimiter.html)

新增于: v0.9.3

-   [<string>](http://url.nodejs.cn/9Tw2bK)

提供特定于平台的路径定界符：

-   `;` 用于 Windows
-   `:` 用于 POSIX

例如，在 POSIX 上：

```
console.log(process.env.PATH);
// 打印: '/usr/bin:/bin:/usr/sbin:/sbin:/usr/local/bin'

process.env.PATH.split(path.delimiter);
// 返回: ['/usr/bin', '/bin', '/usr/sbin', '/sbin', '/usr/local/bin']
```

在 Windows 上：

```
console.log(process.env.PATH);
// 打印: 'C:\Windows\system32;C:\Windows;C:\Program Files\node\'

process.env.PATH.split(path.delimiter);
// 返回: ['C:\\Windows\\system32', 'C:\\Windows', 'C:\\Program Files\\node\\']
```

### `path.dirname(path)`[#](http://nodejs.cn/api-v12/path.html#pathdirnamepath)

[中英对照](http://nodejs.cn/api-v12/path/path_dirname_path.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

`path.dirname()` 方法返回 `path` 的目录名，类似于 Unix `dirname` 命令。 尾随的目录分隔符被忽略，见 [`path.sep`](http://nodejs.cn/api-v12/path.html#path_path_sep)。

```
path.dirname('/foo/bar/baz/asdf/quux');
// 返回: '/foo/bar/baz/asdf'
```

如果 `path` 不是字符串，则抛出 [`TypeError`](http://nodejs.cn/api-v12/errors.html#errors_class_typeerror)。

### `path.extname(path)`[#](http://nodejs.cn/api-v12/path.html#pathextnamepath)

[中英对照](http://nodejs.cn/api-v12/path/path_extname_path.html)

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

`path.extname()` 方法返回 `path` 的扩展名，即 `path` 的最后一部分中从最后一次出现的 `.`（句点）字符到字符串的结尾。 如果 `path` 的最后一部分中没有 `.`，或者除了 `path` 的基本名称（参见 `path.basename()`）的第一个字符之外没有 `.` 个字符，则返回空字符串。

```
path.extname('index.html');
// 返回: '.html'

path.extname('index.coffee.md');
// 返回: '.md'

path.extname('index.');
// 返回: '.'

path.extname('index');
// 返回: ''

path.extname('.index');
// 返回: ''

path.extname('.index.md');
// 返回: '.md'
```

如果 `path` 不是字符串，则抛出 [`TypeError`](http://nodejs.cn/api-v12/errors.html#errors_class_typeerror)。

### `path.format(pathObject)`[#](http://nodejs.cn/api-v12/path.html#pathformatpathobject)

[中英对照](http://nodejs.cn/api-v12/path/path_format_pathobject.html)

新增于: v0.11.15

-   `pathObject` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `dir` [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `root` [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `base` [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `name` [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `ext` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

`path.format()` 方法从对象返回路径字符串。 这与 [`path.parse()`](http://nodejs.cn/api-v12/path.html#path_path_parse_path) 相反。

当向 `pathObject` 提供属性时，存在一个属性优先于另一个属性的组合：

-   如果提供 `pathObject.dir`，则忽略 `pathObject.root`
-   如果 `pathObject.base` 存在，则忽略 `pathObject.ext` 和 `pathObject.name`

例如，在 POSIX 上：

```
// 如果提供 `dir`、`root` 和 `base`，
// 则将返回 `${dir}${path.sep}${base}`。
// `root` 将被忽略。
path.format({
  root: '/ignored',
  dir: '/home/user/dir',
  base: 'file.txt'
});
// 返回: '/home/user/dir/file.txt'

// 如果未指定 `dir`，则将使用 `root`。
// 如果仅提供 `root` 或 `dir` 等于 `root`，则将不包括平台分隔符。
// `ext` 将被忽略。
path.format({
  root: '/',
  base: 'file.txt',
  ext: 'ignored'
});
// 返回: '/file.txt'

// 如果未指定 `base`，则将使用 `name` + `ext`。
path.format({
  root: '/',
  name: 'file',
  ext: '.txt'
});
// 返回: '/file.txt'
```

在 Windows 上：

```
path.format({
  dir: 'C:\\path\\dir',
  base: 'file.txt'
});
// 返回: 'C:\\path\\dir\\file.txt'
```

### `path.isAbsolute(path)`[#](http://nodejs.cn/api-v12/path.html#pathisabsolutepath)

[中英对照](http://nodejs.cn/api-v12/path/path_isabsolute_path.html)

新增于: v0.11.2

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

`path.isAbsolute()` 方法确定 `path` 是否为绝对路径。

如果给定的 `path` 是零长度字符串，则将返回 `false`。

例如，在 POSIX 上：

```
path.isAbsolute('/foo/bar'); // true
path.isAbsolute('/baz/..');  // true
path.isAbsolute('qux/');     // false
path.isAbsolute('.');        // false
```

在 Windows 上：

```
path.isAbsolute('//server');    // true
path.isAbsolute('\\\\server');  // true
path.isAbsolute('C:/foo/..');   // true
path.isAbsolute('C:\\foo\\..'); // true
path.isAbsolute('bar\\baz');    // false
path.isAbsolute('bar/baz');     // false
path.isAbsolute('.');           // false
```

如果 `path` 不是字符串，则抛出 [`TypeError`](http://nodejs.cn/api-v12/errors.html#errors_class_typeerror)。

### `path.join([...paths])`[#](http://nodejs.cn/api-v12/path.html#pathjoinpaths)

[中英对照](http://nodejs.cn/api-v12/path/path_join_paths.html)

新增于: v0.1.16

-   `...paths` [<string>](http://url.nodejs.cn/9Tw2bK) 路径片段的序列
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

`path.join()` 方法使用特定于平台的分隔符作为定界符将所有给定的 `path` 片段连接在一起，然后规范化生成的路径。

零长度的 `path` 片段被忽略。 如果连接的路径字符串是零长度字符串，则将返回 `'.'`，表示当前工作目录。

```
path.join('/foo', 'bar', 'baz/asdf', 'quux', '..');
// 返回: '/foo/bar/baz/asdf'

path.join('foo', {}, 'bar');
// 抛出 'TypeError: Path must be a string. Received {}'
```

如果任何路径片段不是字符串，则抛出 [`TypeError`](http://nodejs.cn/api-v12/errors.html#errors_class_typeerror)。

### `path.normalize(path)`[#](http://nodejs.cn/api-v12/path.html#pathnormalizepath)

[中英对照](http://nodejs.cn/api-v12/path/path_normalize_path.html)

新增于: v0.1.23

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

`path.normalize()` 方法规范化给定的 `path`，解析 `'..'` 和 `'.'` 片段。

当找到多个连续的路径片段分隔符（例如 POSIX 上的 `/` 和 Windows 上的 `\` 或 `/`）时，则它们将被平台特定路径片段分隔符（POSIX 上的 `/` 和 Windows 上的 `\`）的单个实例替换。 保留尾随的分隔符。

如果 `path` 是零长度字符串，则返回 `'.'`，表示当前工作目录。

例如，在 POSIX 上：

```
path.normalize('/foo/bar//baz/asdf/quux/..');
// 返回: '/foo/bar/baz/asdf'
```

在 Windows 上：

```
path.normalize('C:\\temp\\\\foo\\bar\\..\\');
// 返回: 'C:\\temp\\foo\\'
```

由于 Windows 识别多个路径分隔符，两个分隔符都将被 Windows 首选分隔符 (`\`) 的实例替换：

```
path.win32.normalize('C:////temp\\\\/\\/\\/foo/bar');
// 返回: 'C:\\temp\\foo\\bar'
```

如果 `path` 不是字符串，则抛出 [`TypeError`](http://nodejs.cn/api-v12/errors.html#errors_class_typeerror)。

### `path.parse(path)`[#](http://nodejs.cn/api-v12/path.html#pathparsepath)

[中英对照](http://nodejs.cn/api-v12/path/path_parse_path.html)

新增于: v0.11.15

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)

`path.parse()` 方法返回一个对象，其属性表示 `path` 的重要元素。 尾随的目录分隔符被忽略，见 [`path.sep`](http://nodejs.cn/api-v12/path.html#path_path_sep)。

返回的对象将具有以下属性：

-   `dir` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `root` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `base` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `name` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `ext` [<string>](http://url.nodejs.cn/9Tw2bK)

例如，在 POSIX 上：

```
path.parse('/home/user/dir/file.txt');
// 返回:
// { root: '/',
//   dir: '/home/user/dir',
//   base: 'file.txt',
//   ext: '.txt',
//   name: 'file' }
```

```
┌─────────────────────┬────────────┐
│          dir        │    base    │
├──────┬              ├──────┬─────┤
│ root │              │ name │ ext │
"  /    home/user/dir / file  .txt "
└──────┴──────────────┴──────┴─────┘
("" 行中的所有空格都应被忽略。它们纯粹是为了格式化。)
```

在 Windows 上：

```
path.parse('C:\\path\\dir\\file.txt');
// 返回:
// { root: 'C:\\',
//   dir: 'C:\\path\\dir',
//   base: 'file.txt',
//   ext: '.txt',
//   name: 'file' }
```

```
┌─────────────────────┬────────────┐
│          dir        │    base    │
├──────┬              ├──────┬─────┤
│ root │              │ name │ ext │
" C:\      path\dir   \ file  .txt "
└──────┴──────────────┴──────┴─────┘
("" 行中的所有空格都应被忽略。它们纯粹是为了格式化。)
```

如果 `path` 不是字符串，则抛出 [`TypeError`](http://nodejs.cn/api-v12/errors.html#errors_class_typeerror)。

### `path.posix`[#](http://nodejs.cn/api-v12/path.html#pathposix)

[中英对照](http://nodejs.cn/api-v12/path/path_posix.html)

新增于: v0.11.15

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

`path.posix` 属性提供对 `path` 方法的 POSIX 特定实现的访问。

### `path.relative(from, to)`[#](http://nodejs.cn/api-v12/path.html#pathrelativefrom-to)

[中英对照](http://nodejs.cn/api-v12/path/path_relative_from_to.html)

-   `from` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `to` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

`path.relative()` 方法根据当前工作目录返回从 `from` 到 `to` 的相对路径。 如果 `from` 和 `to` 都解析为相同的路径（在分别调用 `path.resolve()` 之后），则返回零长度字符串。

如果零长度字符串作为 `from` 或 `to` 传入，则将使用当前工作目录而不是零长度字符串。

例如，在 POSIX 上：

```
path.relative('/data/orandea/test/aaa', '/data/orandea/impl/bbb');
// 返回: '../../impl/bbb'
```

在 Windows 上：

```
path.relative('C:\\orandea\\test\\aaa', 'C:\\orandea\\impl\\bbb');
// 返回: '..\\..\\impl\\bbb'
```

如果 `from` 或 `to` 不是字符串，则抛出 [`TypeError`](http://nodejs.cn/api-v12/errors.html#errors_class_typeerror)。

### `path.resolve([...paths])`[#](http://nodejs.cn/api-v12/path.html#pathresolvepaths)

[中英对照](http://nodejs.cn/api-v12/path/path_resolve_paths.html)

新增于: v0.3.4

-   `...paths` [<string>](http://url.nodejs.cn/9Tw2bK) 路径或路径片段的序列
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

`path.resolve()` 方法将路径或路径片段的序列解析为绝对路径。

给定的路径序列从右到左处理，每个后续的 `path` 会被追加到前面，直到构建绝对路径。 例如，给定路径片段的序列：`/foo`、`/bar`、`baz`，调用 `path.resolve('/foo', '/bar', 'baz')` 将返回 `/bar/baz`，因为 `'baz'` 不是绝对路径，而 `'/bar' + '/' + 'baz'` 是。

如果在处理完所有给定的 `path` 片段之后，还没有生成绝对路径，则使用当前工作目录。

生成的路径被规范化，并删除尾部斜杠（除非路径解析为根目录）。

零长度的 `path` 片段被忽略。

如果没有传入 `path` 片段，则 `path.resolve()` 将返回当前工作目录的绝对路径。

```
path.resolve('/foo/bar', './baz');
// 返回: '/foo/bar/baz'

path.resolve('/foo/bar', '/tmp/file/');
// 返回: '/tmp/file'

path.resolve('wwwroot', 'static_files/png/', '../gif/image.gif');
// 如果当前工作目录是 /home/myself/node，
// 则返回 '/home/myself/node/wwwroot/static_files/gif/image.gif'
```

如果任何参数不是字符串，则抛出 [`TypeError`](http://nodejs.cn/api-v12/errors.html#errors_class_typeerror)。

### `path.sep`[#](http://nodejs.cn/api-v12/path.html#pathsep)

[中英对照](http://nodejs.cn/api-v12/path/path_sep.html)

新增于: v0.7.9

-   [<string>](http://url.nodejs.cn/9Tw2bK)

提供特定于平台的路径片段分隔符：

-   Windows 上是 `\`
-   POSIX 上是 `/`

例如，在 POSIX 上：

```
'foo/bar/baz'.split(path.sep);
// 返回: ['foo', 'bar', 'baz']
```

在 Windows 上：

```
'foo\\bar\\baz'.split(path.sep);
// 返回: ['foo', 'bar', 'baz']
```

在 Windows 上，正斜杠 (`/`) 和反斜杠 (`\`) 都被接受作为路径片段分隔符；但是，`path` 方法只添加反斜杠 (`\`)。

### `path.toNamespacedPath(path)`[#](http://nodejs.cn/api-v12/path.html#pathtonamespacedpathpath)

[中英对照](http://nodejs.cn/api-v12/path/path_tonamespacedpath_path.html)

新增于: v9.0.0

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK)
-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

仅在 Windows 系统上，返回给定 `path` 的等效[命名空间前缀路径](http://url.nodejs.cn/cVsGGE)。 如果 `path` 不是字符串，则 `path` 将不加修改地返回。

此方法仅在 Windows 系统上有意义。 在 POSIX 系统上，该方法是不可操作的，并且始终返回 `path` 而不进行修改。

### `path.win32`[#](http://nodejs.cn/api-v12/path.html#pathwin32)

[中英对照](http://nodejs.cn/api-v12/path/path_win32.html)

新增于: v0.11.15

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

`path.win32` 属性提供对 `path` 方法的 Windows 特定实现的访问。
