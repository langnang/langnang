---
created: 2022-07-29T13:12:55 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/policy.html
author: 
---

# policy 安全策略 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/policy/policies.html)

Node.js 包含了对创建加载代码的策略的实验性支持。

策略是一个安全特性，旨在保证 Node.js 能够加载哪些代码。 策略的使用假定策略文件的安全实践，例如确保 Node.js 应用程序不能使用文件权限覆盖策略文件。

一个典型的设置是将策略文件创建为与运行 Node.js 的用户 ID 不同的用户 ID，并向运行 Node.js 的用户 ID 授予读取权限。

### 启用[#](http://nodejs.cn/api-v12/policy.html#enabling)

[中英对照](http://nodejs.cn/api-v12/policy/enabling.html)

`--experimental-policy` 标志可用于在加载模块时启用策略特性。

一旦设置好，则所有模块都必须符合传给标志的策略清单文件：

```
node --experimental-policy=policy.json app.js
```

策略清单将用于对 Node.js 加载的代码实施约束。

为了减少对磁盘上策略文件的篡改，可以通过 `--policy-integrity` 提供策略文件本身的完整性。 这允许运行 `node` 并断言策略文件内容，即使文件在磁盘上被更改。

```
node --experimental-policy=policy.json --policy-integrity="sha384-SggXRQHwCG8g+DktYYzxkXRIkTiEYWBHqev0xnpCxYlqMBufKZHAHQM3/boDaI/0" app.js
```

### 特性[#](http://nodejs.cn/api-v12/policy.html#features)

#### 错误的行为[#](http://nodejs.cn/api-v12/policy.html#error-behavior)

[中英对照](http://nodejs.cn/api-v12/policy/error_behavior.html)

当策略检查失败时，Node.js 默认会抛出错误。 通过在策略清单中定义 “onerror” 字段，可以将错误行为更改为几种可能性之一。 以下值可用于更改行为：

-   `"exit"`: 将立即退出进程。 不允许运行任何清理代码。
-   `"log"`: 将在发生故障的地方记录错误。
-   `"throw"`: 将在失败的地方抛出 JS 错误。 这是默认值。

```
{
  "onerror": "log",
  "resources": {
    "./app/checked.js": {
      "integrity": "sha384-SggXRQHwCG8g+DktYYzxkXRIkTiEYWBHqev0xnpCxYlqMBufKZHAHQM3/boDaI/0"
    }
  }
}
```

#### 完整性检查[#](http://nodejs.cn/api-v12/policy.html#integrity-checks)

[中英对照](http://nodejs.cn/api-v12/policy/integrity_checks.html)

策略文件必须使用与绝对 URL 关联的浏览器[完整性属性](http://url.nodejs.cn/JDfR74)兼容的子资源完整性字符串的完整性检查。

如果资源与清单中列出的完整性不匹配，则会抛出错误。

允许加载文件 `checked.js` 的示例策略文件：

```
{
  "resources": {
    "./app/checked.js": {
      "integrity": "sha384-SggXRQHwCG8g+DktYYzxkXRIkTiEYWBHqev0xnpCxYlqMBufKZHAHQM3/boDaI/0"
    }
  }
}
```

策略清单中列出的每个资源都可以采用以下格式之一来确定其位置：

当加载资源时，整个 URL 必须匹配，包括搜索参数和哈希片段。 尝试加载 `./a.js` 时不会使用 `./a.js?b`，反之亦然。

要生成完整性字符串，则可以使用 `printf "sha384-$(cat checked.js | openssl dgst -sha384 -binary | base64)"` 等脚本。

完整性可以指定为布尔值 `true`，以接受任何对本地开发有用的资源主体。 不建议在生产中这样做，因为它会允许资源的意外更改被认为是有效的。

#### 依赖项重定向[#](http://nodejs.cn/api-v12/policy.html#dependency-redirection)

[中英对照](http://nodejs.cn/api-v12/policy/dependency_redirection.html)

应用程序可能需要发布模块的补丁版本或阻止模块允许所有模块访问所有其他模块。 可以通过拦截加载希望被替换的模块的尝试来使用重定向。

```
{
  "builtins": [],
  "resources": {
    "./app/checked.js": {
      "dependencies": {
        "fs": true,
        "os": "./app/node_modules/alt-os"
      }
    }
  }
}
```

可以指定依赖项映射的布尔值 `true` 以允许模块加载任何说明符而无需重定向。 这对本地开发很有用，并且在生产中可能有一些有效的用途，但只有在审核模块以确保其行为有效后才应谨慎使用。

##### 示例：修补依赖项[#](http://nodejs.cn/api-v12/policy.html#example-patched-dependency)

[中英对照](http://nodejs.cn/api-v12/policy/example_patched_dependency.html)

重定向的依赖可以提供适合应用程序的衰减或修改功能。 例如，通过封装原始记录有关函数持续时间的计时数据：

```
const original = require('fn');
module.exports = function fn(...args) {
  console.time();
  try {
    return new.target ?
      Reflect.construct(original, args) :
      Reflect.apply(original, this, args);
  } finally {
    console.timeEnd();
  }
};
```
