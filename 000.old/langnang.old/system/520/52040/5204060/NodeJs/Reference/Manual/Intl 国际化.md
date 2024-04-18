---
created: 2022-07-29T13:12:53 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/intl.html
author: 
---

# Intl 国际化 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/intl/internationalization_support.html)

Node.js 有很多特性可以让编写国际化程序变得更容易。 它们之中有一些是：

-   [ECMAScript 语言规范](http://url.nodejs.cn/7fw6aN)中的区域设置敏感或 Unicode 感知函数：
    -   [`String.prototype.normalize()`](http://url.nodejs.cn/wzacDq)
    -   [`String.prototype.toLowerCase()`](http://url.nodejs.cn/m2c5Kr)
    -   [`String.prototype.toUpperCase()`](http://url.nodejs.cn/yrHHHo)
-   [ECMAScript 国际化 API 规范](http://url.nodejs.cn/JJbHHP)（又名 ECMA-402）中描述的所有功能：
    -   [`Intl`](http://url.nodejs.cn/RiCnzn) 对象
    -   像 [`String.prototype.localeCompare()`](http://url.nodejs.cn/ix2EPt) 和 [`Date.prototype.toLocaleString()`](http://url.nodejs.cn/MB7uur) 这样的区域敏感方法
-   [WHATWG 网址解析器](http://nodejs.cn/api-v12/url.html#url_the_whatwg_url_api)的[国际化域名](http://url.nodejs.cn/T3J9ze)（IDN）支持
-   [`require('buffer').transcode()`](http://nodejs.cn/api-v12/buffer.html#buffer_buffer_transcode_source_fromenc_toenc)
-   更准确的[交互式解释器](http://nodejs.cn/api-v12/repl.html#repl_repl)行编辑
-   [`require('util').TextDecoder`](http://nodejs.cn/api-v12/util.html#util_class_util_textdecoder)
-   [`RegExp` Unicode 属性转义](http://url.nodejs.cn/aRrfSH)

### 构建 Node.js 的选项[#](http://nodejs.cn/api-v12/intl.html#options-for-building-nodejs)

[中英对照](http://nodejs.cn/api-v12/intl/options_for_building_node_js.html)

为了控制在 Node.js 中如何使用 ICU，在编译期间提供了四个 `configure` 选项。 [BUILDING.md](http://url.nodejs.cn/moEzTX) 中记录了有关如何编译 Node.js 的其他详细信息。

-   `--with-intl=none`/`--without-intl`
-   `--with-intl=system-icu`
-   `--with-intl=small-icu`（默认）
-   `--with-intl=full-icu`

每个 `configure` 选项的可用 Node.js 和 JavaScript 特性概述：

|  | `none` | `system-icu` | `small-icu` | `full-icu` |
| --- | --- | --- | --- | --- |
| [`String.prototype.normalize()`](http://url.nodejs.cn/wzacDq) | 无（函数无操作） | 完整 | 完整 | 完整 |
| `String.prototype.to*Case()` | 完整 | 完整 | 完整 | 完整 |
| [`Intl`](http://url.nodejs.cn/RiCnzn) | 无（对象不存在） | 部分/完整（取决于操作系统） | 部分（仅英文） | 完整 |
| [`String.prototype.localeCompare()`](http://url.nodejs.cn/ix2EPt) | 部分（不识别区域设置） | 完整 | 完整 | 完整 |
| `String.prototype.toLocale*Case()` | 部分（不识别区域设置） | 完整 | 完整 | 完整 |
| [`Number.prototype.toLocaleString()`](http://url.nodejs.cn/Hvk1sa) | 部分（不识别区域设置） | 部分/完整（取决于操作系统） | 部分（仅英文） | 完整 |
| `Date.prototype.toLocale*String()` | 部分（不识别区域设置） | 部分/完整（取决于操作系统） | 部分（仅英文） | 完整 |
| [WHATWG URL Parser](http://nodejs.cn/api-v12/url.html#url_the_whatwg_url_api) | 部分（不支持 IDN） | 完整 | 完整 | 完整 |
| [`require('buffer').transcode()`](http://nodejs.cn/api-v12/buffer.html#buffer_buffer_transcode_source_fromenc_toenc) | 无（函数不存在） | 完整 | 完整 | 完整 |
| [REPL](http://nodejs.cn/api-v12/repl.html#repl_repl) | 部分（不准确的行编辑） | 完整 | 完整 | 完整 |
| [`require('util').TextDecoder`](http://nodejs.cn/api-v12/util.html#util_class_util_textdecoder) | 部分（基本的编码支持） | 部分/完整（取决于操作系统） | 部分（仅限 Unicode） | 完整 |
| [`RegExp` Unicode Property Escapes](http://url.nodejs.cn/aRrfSH) | 无（无效的 `RegExp` 错误） | 完整 | 完整 | 完整 |

"(not locale-aware)" 表示该函数执行其操作就像函数的非 `Locale` 版本一样，如果存在的话。 比如在 `none` 模式下，`Date.prototype.toLocaleString()` 的操作和 `Date.prototype.toString()` 是一样的。

#### 禁用全部国际化特性（none）[#](http://nodejs.cn/api-v12/intl.html#disable-all-internationalization-features-none)

If this option is chosen, most internationalization features mentioned above will be **unavailable** in the resulting `node` binary.

#### 使用预装的 ICU 构建（system-icu）[#](http://nodejs.cn/api-v12/intl.html#build-with-a-pre-installed-icu-system-icu)

[中英对照](http://nodejs.cn/api-v12/intl/build_with_a_pre_installed_icu_system_icu.html)

Node.js 可以链接到系统上已安装的 ICU。 事实上，大多数 Linux 发行版已经安装了 ICU，这个选项可以复用操作系统中其他组件使用的相同数据集。

`system-icu` 完全支持仅需要 ICU 库本身的功能，例如 [`String.prototype.normalize()`](http://url.nodejs.cn/wzacDq) 和 [WHATWG 网址解析器](http://nodejs.cn/api-v12/url.html#url_the_whatwg_url_api)。 另外需要 ICU 语言环境数据的特性，例如 [`Intl.DateTimeFormat`](http://url.nodejs.cn/LA7NEx) 可能完全或部分支持，具体取决于系统上安装的 ICU 数据的完整性。

#### 嵌入 ICU 数据的有界集（small-icu）[#](http://nodejs.cn/api-v12/intl.html#embed-a-limited-set-of-icu-data-small-icu)

[中英对照](http://nodejs.cn/api-v12/intl/embed_a_limited_set_of_icu_data_small_icu.html)

此选项静态地生成针对 ICU 库的二进制链接，并在 `node` 可执行文件中包含 ICU 数据的子集（通常只有英文区域设置）。

`small-icu` 完全支持仅需要 ICU 库本身的功能，例如 [`String.prototype.normalize()`](http://url.nodejs.cn/wzacDq) 和 [WHATWG 网址解析器](http://nodejs.cn/api-v12/url.html#url_the_whatwg_url_api)。 另外需要 ICU 语言环境数据的特性，比如 [`Intl.DateTimeFormat`](http://url.nodejs.cn/LA7NEx)，一般只适用于英文语言环境：

```
const january = new Date(9e8);
const english = new Intl.DateTimeFormat('en', { month: 'long' });
const spanish = new Intl.DateTimeFormat('es', { month: 'long' });

console.log(english.format(january));
// 打印 "January"
console.log(spanish.format(january));
// 在 small-icu 上打印 "M01"
// 应该打印 "enero"
```

官方的二进制文件也是以这种模式构建的。

##### 在运行时提供 ICU 数据[#](http://nodejs.cn/api-v12/intl.html#providing-icu-data-at-runtime)

[中英对照](http://nodejs.cn/api-v12/intl/providing_icu_data_at_runtime.html)

如果使用 `small-icu` 选项，则仍然可以在运行时提供额外的语言环境数据，以便 JS 方法适用于所有 ICU 语言环境。 假设数据文件存储在 `/some/directory`，它可以通过以下任一方式提供给 ICU：

-   [`NODE_ICU_DATA`](http://nodejs.cn/api-v12/cli.html#cli_node_icu_data_file) 环境变量：
    
    ```
    env NODE_ICU_DATA=/some/directory node
    ```
    
-   [`--icu-data-dir`](http://nodejs.cn/api-v12/cli.html#cli_icu_data_dir_file) 命令行参数：
    
    ```
    node --icu-data-dir=/some/directory
    ```
    

（如果两者都指定，则 `--icu-data-dir` 命令行参数优先。）

ICU 能够自动查找和加载多种数据格式，但数据必须适合 ICU 版本，并且文件命名正确。 数据文件最常见的名称是 `icudt6X[bl].dat`，其中 `6X` 表示预期的 ICU 版本，而 `b` 或 `l` 表示系统的字节序。 查看 ICU 用户指南中的 ["ICU 数据"](http://url.nodejs.cn/yL59BN)文章以了解其他支持的格式以及有关 ICU 数据的更多详细信息。

[full-icu](http://url.nodejs.cn/yymGdw) npm 模块通过检测运行中的 `node` 可执行文件的 ICU 版本并下载相应的数据文件，可以大大简化 ICU 数据安装。 通过 `npm i full-icu` 安装模块后，数据文件将在 `./node_modules/full-icu` 可用。 然后可以将此路径传给 `NODE_ICU_DATA` 或 `--icu-data-dir`，如上所示以启用完整的 `Intl` 支持。

#### 嵌入整个 ICU（full-icu）[#](http://nodejs.cn/api-v12/intl.html#embed-the-entire-icu-full-icu)

[中英对照](http://nodejs.cn/api-v12/intl/embed_the_entire_icu_full_icu.html)

此选项使生成的二进制链接与 ICU 静态地关联并包含全套 ICU 数据。 以这种方式创建的二进制文件没有进一步的外部依赖项并支持所有语言环境，但可能相当大。

### 检测国际化支持[#](http://nodejs.cn/api-v12/intl.html#detecting-internationalization-support)

[中英对照](http://nodejs.cn/api-v12/intl/detecting_internationalization_support.html)

要验证是否启用了 ICU（`system-icu`、`small-icu` 或 `full-icu`），只需检查 `Intl` 是否存在就足够了：

```
const hasICU = typeof Intl === 'object';
```

或者，检查 `process.versions.icu`，一个仅在启用 ICU 时定义的属性，也可以工作：

```
const hasICU = typeof process.versions.icu === 'string';
```

要检查对非英语语言环境（即 `full-icu` 或 `system-icu`）的支持，[`Intl.DateTimeFormat`](http://url.nodejs.cn/LA7NEx) 可能是一个很好的区分因素：

```
const hasFullICU = (() => {
  try {
    const january = new Date(9e8);
    const spanish = new Intl.DateTimeFormat('es', { month: 'long' });
    return spanish.format(january) === 'enero';
  } catch (err) {
    return false;
  }
})();
```

有关 `Intl` 支持的更详细的测试，以下资源可能会有所帮助：

-   [btest402](http://url.nodejs.cn/bCQnPY): 一般用于检查是否正确地构建了支持 `Intl` 的 Node.js。
-   [Test262](http://url.nodejs.cn/B4L2Pp): ECMAScript 的官方一致性测试套件包括一个专门针对 ECMA-402 的部分。
