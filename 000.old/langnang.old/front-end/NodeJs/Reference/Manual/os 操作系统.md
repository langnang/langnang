---
created: 2022-07-29T13:12:52 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/os.html
author: 
---

# os 操作系统 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/os/os.html)

**源代码:** [lib/os.js](https://github.com/nodejs/node/blob/v12.22.12/lib/os.js)

`os` 模块提供了与操作系统相关的实用方法和属性。 可以使用以下方式访问它：

```
const os = require('os');
```

### `os.EOL`[#](http://nodejs.cn/api-v12/os.html#oseol)

[中英对照](http://nodejs.cn/api-v12/os/os_eol.html)

新增于: v0.7.8

-   [<string>](http://url.nodejs.cn/9Tw2bK)

操作系统特定的行尾标记。

-   POSIX 上是 `\n`
-   Windows 上是 `\r\n`

### `os.arch()`[#](http://nodejs.cn/api-v12/os.html#osarch)

[中英对照](http://nodejs.cn/api-v12/os/os_arch.html)

新增于: v0.5.0

-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

返回为其编译 Node.js 二进制文件的操作系统 CPU 架构。 可能的值为 `'arm'`、`'arm64'`、`'ia32'`、`'mips'`、`'mipsel'`、`'ppc'`、`'ppc64'`、`'s390'`、`'s390x'`、`'x32'` 和 `'x64'`。

返回值相当于 [`process.arch`](http://nodejs.cn/api-v12/process.html#process_process_arch)。

### `os.constants`[#](http://nodejs.cn/api-v12/os.html#osconstants)

[中英对照](http://nodejs.cn/api-v12/os/os_constants.html)

新增于: v6.3.0

-   [<Object>](http://url.nodejs.cn/jzn6Ao)

包含用于错误码、进程信号等的常用操作系统特定常量。 定义的特定常量在[操作系统常量](http://nodejs.cn/api-v12/os.html#os_os_constants_1)中描述。

### `os.cpus()`[#](http://nodejs.cn/api-v12/os.html#oscpus)

[中英对照](http://nodejs.cn/api-v12/os/os_cpus.html)

新增于: v0.3.3

-   返回: [<Object\[\]>](http://url.nodejs.cn/jzn6Ao)

返回包含有关每个逻辑 CPU 内核的信息的对象数组。

每个对象上包含的属性包括：

-   `model` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `speed` [<number>](http://url.nodejs.cn/SXbo1v) （以兆赫为单位）
-   `times` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `user` [<number>](http://url.nodejs.cn/SXbo1v) CPU 在用户模式下花费的毫秒数。
    -   `nice` [<number>](http://url.nodejs.cn/SXbo1v) CPU 在良好模式下花费的毫秒数。
    -   `sys` [<number>](http://url.nodejs.cn/SXbo1v) CPU 在系统模式下花费的毫秒数。
    -   `idle` [<number>](http://url.nodejs.cn/SXbo1v) CPU 在空闲模式下花费的毫秒数。
    -   `irq` [<number>](http://url.nodejs.cn/SXbo1v) CPU 在中断请求模式下花费的毫秒数。

```
[
  {
    model: 'Intel(R) Core(TM) i7 CPU         860  @ 2.80GHz',
    speed: 2926,
    times: {
      user: 252020,
      nice: 0,
      sys: 30340,
      idle: 1070356870,
      irq: 0
    }
  },
  {
    model: 'Intel(R) Core(TM) i7 CPU         860  @ 2.80GHz',
    speed: 2926,
    times: {
      user: 306960,
      nice: 0,
      sys: 26980,
      idle: 1071569080,
      irq: 0
    }
  },
  {
    model: 'Intel(R) Core(TM) i7 CPU         860  @ 2.80GHz',
    speed: 2926,
    times: {
      user: 248450,
      nice: 0,
      sys: 21750,
      idle: 1070919370,
      irq: 0
    }
  },
  {
    model: 'Intel(R) Core(TM) i7 CPU         860  @ 2.80GHz',
    speed: 2926,
    times: {
      user: 256880,
      nice: 0,
      sys: 19430,
      idle: 1070905480,
      irq: 20
    }
  }
]
```

`nice` 值仅适用于 POSIX。 在 Windows 上，所有处理器的 `nice` 值始终为 0。

### `os.endianness()`[#](http://nodejs.cn/api-v12/os.html#osendianness)

[中英对照](http://nodejs.cn/api-v12/os/os_endianness.html)

新增于: v0.9.4

-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

返回标识为其编译 Node.js 二进制文件的 CPU 的字节序的字符串。

可能的值是大端序的 `'BE'` 和小端序的 `'LE'`。

### `os.freemem()`[#](http://nodejs.cn/api-v12/os.html#osfreemem)

[中英对照](http://nodejs.cn/api-v12/os/os_freemem.html)

新增于: v0.3.3

-   返回: [<integer>](http://url.nodejs.cn/SXbo1v)

以整数形式返回空闲的系统内存量（以字节为单位）。

### `os.getPriority([pid])`[#](http://nodejs.cn/api-v12/os.html#osgetprioritypid)

[中英对照](http://nodejs.cn/api-v12/os/os_getpriority_pid.html)

新增于: v10.10.0

-   `pid` [<integer>](http://url.nodejs.cn/SXbo1v) 要为其检索调度优先级的进程 ID。 **Default** `0`。
-   返回: [<integer>](http://url.nodejs.cn/SXbo1v)

返回由 `pid` 指定的进程的调度优先级。 如果未提供 `pid` 或为 `0`，则返回当前进程的优先级。

### `os.homedir()`[#](http://nodejs.cn/api-v12/os.html#oshomedir)

[中英对照](http://nodejs.cn/api-v12/os/os_homedir.html)

新增于: v2.3.0

-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

返回当前用户的主目录的字符串路径。

在 POSIX 上，它使用 `$HOME` 环境变量（如果已定义）。 否则，它使用[有效的 UID](http://url.nodejs.cn/qnvwQK) 来查找用户的主目录。

在 Windows 上，它使用 `USERPROFILE` 环境变量（如果已定义）。 否则，它使用当前用户的配置文件目录的路径。

### `os.hostname()`[#](http://nodejs.cn/api-v12/os.html#oshostname)

[中英对照](http://nodejs.cn/api-v12/os/os_hostname.html)

新增于: v0.3.3

-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

以字符串形式返回操作系统的主机名。

### `os.loadavg()`[#](http://nodejs.cn/api-v12/os.html#osloadavg)

[中英对照](http://nodejs.cn/api-v12/os/os_loadavg.html)

新增于: v0.3.3

-   返回: [<number\[\]>](http://url.nodejs.cn/SXbo1v)

返回包含 1、5 和 15 分钟平均负载的数组。

平均负载是操作系统计算的系统活动量度，并表示为小数。

平均负载是 Unix 特有的概念。 在 Windows 上，返回值始终为 `[0, 0, 0]`。

### `os.networkInterfaces()`[#](http://nodejs.cn/api-v12/os.html#osnetworkinterfaces)

[中英对照](http://nodejs.cn/api-v12/os/os_networkinterfaces.html)

新增于: v0.6.0

-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)

返回包含已分配网络地址的网络接口的对象。

返回对象上的每个键都标识一个网络接口。 关联的值是每个对象描述一个分配的网络地址的对象数组。

分配的网络地址对象上可用的属性包括：

-   `address` [<string>](http://url.nodejs.cn/9Tw2bK) 分配的 IPv4 或 IPv6 地址
-   `netmask` [<string>](http://url.nodejs.cn/9Tw2bK) IPv4 或 IPv6 网络掩码
-   `family` [<string>](http://url.nodejs.cn/9Tw2bK) `IPv4` 或 `IPv6`
-   `mac` [<string>](http://url.nodejs.cn/9Tw2bK) 网络接口的 MAC 地址
-   `internal` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果网络接口是不能远程访问的环回或类似接口，则为 `true`；否则为 `false`
-   `scopeid` [<number>](http://url.nodejs.cn/SXbo1v) 数字的 IPv6 范围 ID（仅在 `family` 为 `IPv6` 时指定）
-   `cidr` [<string>](http://url.nodejs.cn/9Tw2bK) 使用 CIDR 表示法的路由前缀分配的 IPv4 或 IPv6 地址。 如果 `netmask` 无效，则此属性设置为 `null`。

```
{
  lo: [
    {
      address: '127.0.0.1',
      netmask: '255.0.0.0',
      family: 'IPv4',
      mac: '00:00:00:00:00:00',
      internal: true,
      cidr: '127.0.0.1/8'
    },
    {
      address: '::1',
      netmask: 'ffff:ffff:ffff:ffff:ffff:ffff:ffff:ffff',
      family: 'IPv6',
      mac: '00:00:00:00:00:00',
      scopeid: 0,
      internal: true,
      cidr: '::1/128'
    }
  ],
  eth0: [
    {
      address: '192.168.1.108',
      netmask: '255.255.255.0',
      family: 'IPv4',
      mac: '01:02:03:0a:0b:0c',
      internal: false,
      cidr: '192.168.1.108/24'
    },
    {
      address: 'fe80::a00:27ff:fe4e:66a1',
      netmask: 'ffff:ffff:ffff:ffff::',
      family: 'IPv6',
      mac: '01:02:03:0a:0b:0c',
      scopeid: 1,
      internal: false,
      cidr: 'fe80::a00:27ff:fe4e:66a1/64'
    }
  ]
}
```

### `os.platform()`[#](http://nodejs.cn/api-v12/os.html#osplatform)

[中英对照](http://nodejs.cn/api-v12/os/os_platform.html)

新增于: v0.5.0

-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

返回标识操作系统平台的字符串。 该值在编译时设置。 可能的值为 `'aix'`、`'darwin'`、`'freebsd'`、`'linux'`、`'openbsd'`、`'sunos'` 和 `'win32'`。

返回值相当于 [`process.platform`](http://nodejs.cn/api-v12/process.html#process_process_platform)。

如果 Node.js 是在安卓操作系统上构建的，则也可能返回值 `'android'`。 [安卓支持是实验的](http://url.nodejs.cn/4Wkt3D)。

### `os.release()`[#](http://nodejs.cn/api-v12/os.html#osrelease)

[中英对照](http://nodejs.cn/api-v12/os/os_release.html)

新增于: v0.3.3

-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

以字符串形式返回操作系统。

在 POSIX 系统上，操作系统版本是通过调用 [`uname(3)`](http://url.nodejs.cn/JL5KHm) 来确定的。 在 Windows 上，使用 `GetVersionExW()`。 有关更多信息，请参阅 [https://en.wikipedia.org/wiki/Uname#Examples](https://en.wikipedia.org/wiki/Uname#Examples)。

### `os.setPriority([pid, ]priority)`[#](http://nodejs.cn/api-v12/os.html#ossetprioritypid-priority)

[中英对照](http://nodejs.cn/api-v12/os/os_setpriority_pid_priority.html)

新增于: v10.10.0

-   `pid` [<integer>](http://url.nodejs.cn/SXbo1v) 要为其设置调度优先级的进程 ID。 **Default** `0`。
-   `priority` [<integer>](http://url.nodejs.cn/SXbo1v) 分配给进程的调度优先级。

尝试为 `pid` 指定的进程设置调度优先级。 如果未提供 `pid` 或为 `0`，则使用当前进程的进程 ID。

`priority` 输入必须是 `-20`（高优先级）和 `19`（低优先级）之间的整数。 由于 Unix 优先级和 Windows 优先级之间的差异，`priority` 映射到 `os.constants.priority` 中的六个优先级常量之一。 当检索进程优先级时，此范围映射可能会导致返回值在 Windows 上略有不同。 为避免混淆，请将 `priority` 设置为优先级常量之一。

在 Windows 上，将优先级设置为 `PRIORITY_HIGHEST` 需要提升用户权限。 否则设置的优先级将被静默地降低到 `PRIORITY_HIGH`。

### `os.tmpdir()`[#](http://nodejs.cn/api-v12/os.html#ostmpdir)

[中英对照](http://nodejs.cn/api-v12/os/os_tmpdir.html)

-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

以字符串形式返回操作系统默认的临时文件的目录。

### `os.totalmem()`[#](http://nodejs.cn/api-v12/os.html#ostotalmem)

[中英对照](http://nodejs.cn/api-v12/os/os_totalmem.html)

新增于: v0.3.3

-   返回: [<integer>](http://url.nodejs.cn/SXbo1v)

以整数形式返回系统内存总量（以字节为单位）。

### `os.type()`[#](http://nodejs.cn/api-v12/os.html#ostype)

[中英对照](http://nodejs.cn/api-v12/os/os_type.html)

新增于: v0.3.3

-   返回: [<string>](http://url.nodejs.cn/9Tw2bK)

返回 [`uname(3)`](http://url.nodejs.cn/JL5KHm) 返回的操作系统名称。 例如，它在 Linux 上返回 `'Linux'`，在 macOS 上返回 `'Darwin'`，在 Windows 上返回 `'Windows_NT'`。

有关在各种操作系统上运行 [`uname(3)`](http://url.nodejs.cn/JL5KHm) 的输出的其他信息，请参阅 [https://en.wikipedia.org/wiki/Uname#Examples](https://en.wikipedia.org/wiki/Uname#Examples)。

### `os.uptime()`[#](http://nodejs.cn/api-v12/os.html#osuptime)

[中英对照](http://nodejs.cn/api-v12/os/os_uptime.html)

-   返回: [<integer>](http://url.nodejs.cn/SXbo1v)

以秒为单位返回系统正常运行时间。

### `os.userInfo([options])`[#](http://nodejs.cn/api-v12/os.html#osuserinfooptions)

[中英对照](http://nodejs.cn/api-v12/os/os_userinfo_options.html)

新增于: v6.0.0

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `encoding` [<string>](http://url.nodejs.cn/9Tw2bK) 用于解释结果字符串的字符编码。 如果 `encoding` 设置为 `'buffer'`，则 `username`、`shell` 和 `homedir` 的值将是 `Buffer` 实例。 **默认值:** `'utf8'`。
-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)

返回有关当前有效用户的信息。 在 POSIX 平台上，这通常是密码文件的子集。 返回的对象包括 `username`、`uid`、`gid`、`shell` 和 `homedir`。 在 Windows 上，`uid` 和 `gid` 字段是 `-1`，而 `shell` 是 `null`。

`os.userInfo()` 返回的 `homedir` 的值由操作系统提供。 这与 `os.homedir()` 的结果不同，后者在回退到操作系统响应之前查询主目录的环境变量。

如果用户没有 `username` 或 `homedir`，则抛出 [`SystemError`](http://nodejs.cn/api-v12/errors.html#errors_class_systemerror)。

### `os.version()`[#](http://nodejs.cn/api-v12/os.html#osversion)

[中英对照](http://nodejs.cn/api-v12/os/os_version.html)

新增于: v12.17.0

-   返回 [<string>](http://url.nodejs.cn/9Tw2bK)

返回标识内核版本的字符串。

在 POSIX 系统上，操作系统版本是通过调用 [`uname(3)`](http://url.nodejs.cn/JL5KHm) 来确定的。 在 Windows 上，使用 `RtlGetVersion()`，如果不可用，则将使用 `GetVersionExW()`。 有关更多信息，请参阅 [https://en.wikipedia.org/wiki/Uname#Examples](https://en.wikipedia.org/wiki/Uname#Examples)。

### 操作系统常量[#](http://nodejs.cn/api-v12/os.html#os-constants)

[中英对照](http://nodejs.cn/api-v12/os/os_constants_1.html)

以下常量由 `os.constants` 导出。

并非所有常量都适用于每个操作系统。

#### 信号常量[#](http://nodejs.cn/api-v12/os.html#signal-constants)

[中英对照](http://nodejs.cn/api-v12/os/signal_constants.html)

以下信号常量由 `os.constants.signals` 导出。

| 常量 | 描述 |
| --- | --- |
| `SIGHUP` | 发送以指示控制终端何时关闭或父进程退出。 |
| `SIGINT` |  |
| `SIGQUIT` | 发送以指示用户何时希望终止进程并执行核心转储。 |
| `SIGILL` | 发送给进程以通知其已尝试执行非法、格式错误、未知、或特权指令。 |
| `SIGTRAP` | 发生异常时发送给进程。 |
| `SIGABRT` | 发送给进程以请求其中止。 |
| `SIGIOT` | `SIGABRT` 的同义词 |
| `SIGBUS` | 发送给进程以通知其已导致总线错误。 |
| `SIGFPE` | 发送给进程以通知其执行了非法的算术运算。 |
| `SIGKILL` | 发送给进程以立即终止其。 |
| `SIGUSR1` `SIGUSR2` | 发送给进程以识别用户定义的条件。 |
| `SIGSEGV` | 发送给进程以通知分段错误。 |
| `SIGPIPE` | 当进程尝试写入断开的管道时发送给进程。 |
| `SIGALRM` | 当系统定时器结束时发送给进程。 |
| `SIGTERM` | 发送给进程以请求终止。 |
| `SIGCHLD` | 当子进程终止时发送给进程。 |
| `SIGSTKFLT` | 发送给进程以指示协处理器上的堆栈错误。 |
| `SIGCONT` | 发送以指示操作系统继续暂停的进程。 |
| `SIGSTOP` | 发送以指示操作系统停止进程。 |
| `SIGTSTP` | 发送给进程以请求停止。 |
| `SIGBREAK` | 发送以指示用户何时希望中断进程。 |
| `SIGTTIN` | 在后台从终端读取时发送给进程。 |
| `SIGTTOU` | 在后台写入终端时发送给进程。 |
| `SIGURG` | 当套接字有紧急数据要读取时发送给进程。 |
| `SIGXCPU` | 当进程超过其 CPU 使用限制时发送给进程。 |
| `SIGXFSZ` | 当文件增长超过允许的最大值时发送给进程。 |
| `SIGVTALRM` | 当虚拟定时器已过时时发送给进程。 |
| `SIGPROF` | 当系统定时器已过时发送给进程。 |
| `SIGWINCH` | 当控制终端改变其大小时发送给进程。 |
| `SIGIO` | 当 I/O 可用时发送给进程。 |
| `SIGPOLL` | `SIGIO` 的同义词 |
| `SIGLOST` | 当文件锁丢失时发送给进程。 |
| `SIGPWR` | 发送给进程以通知电源故障。 |
| `SIGINFO` | `SIGPWR` 的同义词 |
| `SIGSYS` | 发送给进程以通知错误的参数。 |
| `SIGUNUSED` | `SIGSYS` 的同义词 |

#### 错误常量[#](http://nodejs.cn/api-v12/os.html#error-constants)

[中英对照](http://nodejs.cn/api-v12/os/error_constants.html)

以下错误常量由 `os.constants.errno` 导出。

##### POSIX 错误常量[#](http://nodejs.cn/api-v12/os.html#posix-error-constants)

[中英对照](http://nodejs.cn/api-v12/os/posix_error_constants.html)

| 常量 | 描述 |
| --- | --- |
| `E2BIG` | 表示参数列表比预期长。 |
| `EACCES` | 表示操作没有足够的权限。 |
| `EADDRINUSE` | 表示该网络地址已被使用。 |
| `EADDRNOTAVAIL` | 表示该网络地址当前不可用。 |
| `EAFNOSUPPORT` | 表示不支持网络地址族。 |
| `EAGAIN` | 表示没有可用数据，稍后再试操作。 |
| `EALREADY` | 指示套接字已经有正在进行的挂起连接。 |
| `EBADF` | 表示文件描述符无效。 |
| `EBADMSG` | 表示无效的数据消息。 |
| `EBUSY` | 表示设备或资源繁忙。 |
| `ECANCELED` | 表示操作被取消。 |
| `ECHILD` | 表示没有子进程。 |
| `ECONNABORTED` | 表示网络连接已中止。 |
| `ECONNREFUSED` | 表示网络连接已被拒绝。 |
| `ECONNRESET` | 表示网络连接已重置。 |
| `EDEADLK` | 表示避免了资源死锁。 |
| `EDESTADDRREQ` | 表示需要目标地址。 |
| `EDOM` | 表示参数超出了函数的域。 |
| `EDQUOT` | 表示已超出磁盘配额。 |
| `EEXIST` | 表示文件已经存在。 |
| `EFAULT` | 指示无效的指针地址。 |
| `EFBIG` | 表示文件过大。 |
| `EHOSTUNREACH` | 表示主机不可达。 |
| `EIDRM` | 表示该标识符已被删除。 |
| `EILSEQ` | 指示非法字节序列。 |
| `EINPROGRESS` | 表示操作已经在进行中。 |
| `EINTR` | 表示函数调用被中断。 |
| `EINVAL` | 表示提供了无效的参数。 |
| `EIO` | 表示未指定的 I/O 错误。 |
| `EISCONN` | 表示套接字已连接。 |
| `EISDIR` | 表示路径是目录。 |
| `ELOOP` | 表示路径中的符号链接级别过多。 |
| `EMFILE` | 表示打开的文件太多。 |
| `EMLINK` | 表示文件的硬链接过多。 |
| `EMSGSIZE` | 表示提供的消息太长。 |
| `EMULTIHOP` | 表示已尝试多跳。 |
| `ENAMETOOLONG` | 表示文件名太长。 |
| `ENETDOWN` | 表示网络已关闭。 |
| `ENETRESET` | 表示连接已被网络中止。 |
| `ENETUNREACH` | 表示网络不可达。 |
| `ENFILE` | 表示系统中打开的文件过多。 |
| `ENOBUFS` | 表示没有可用的缓冲区空间。 |
| `ENODATA` | 表示流头读取队列上没有可用的消息。 |
| `ENODEV` | 表示没有这样的设备。 |
| `ENOENT` | 表示没有这样的文件或目录。 |
| `ENOEXEC` | 表示 exec 格式错误。 |
| `ENOLCK` | 表示没有可用的锁。 |
| `ENOLINK` | 表示链接已被切断。 |
| `ENOMEM` | 表示空间不足。 |
| `ENOMSG` | 表示没有所需类型的消息。 |
| `ENOPROTOOPT` | 表示给定的协议不可用。 |
| `ENOSPC` | 表示设备上没有可用空间。 |
| `ENOSR` | 表示没有可用的流资源。 |
| `ENOSTR` | 表示给定的资源不是流。 |
| `ENOSYS` | 表示功能尚未实现。 |
| `ENOTCONN` | 表示套接字未连接。 |
| `ENOTDIR` | 表示路径不是目录。 |
| `ENOTEMPTY` | 表示目录不为空。 |
| `ENOTSOCK` | 表示给定的条目不是套接字。 |
| `ENOTSUP` | 表示不支持给定的操作。 |
| `ENOTTY` | 表示不适当的 I/O 控制操作。 |
| `ENXIO` | 表示没有这样的设备或地址。 |
| `EOPNOTSUPP` | 表示套接字不支持某个操作。 尽管 `ENOTSUP` 和 `EOPNOTSUPP` 在 Linux 上具有相同的值，但根据 POSIX.1，这些错误值应该是不同的。 |
| `EOVERFLOW` | 表示值太大而无法存储在给定的数据类型中。 |
| `EPERM` | 表示不允许该操作。 |
| `EPIPE` | 表示管道破损。 |
| `EPROTO` | 表示协议错误。 |
| `EPROTONOSUPPORT` | 表示不支持协议。 |
| `EPROTOTYPE` | 标识套接字的错误协议类型。 |
| `ERANGE` | 表示结果过大。 |
| `EROFS` | 表示文件系统是只读的。 |
| `ESPIPE` | 指示无效的查找操作。 |
| `ESRCH` | 表示没有这样的进程。 |
| `ESTALE` | 表示文件句柄已过时。 |
| `ETIME` | 表示过期的定时器。 |
| `ETIMEDOUT` | 表示连接超时。 |
| `ETXTBSY` | 表示文本文件繁忙。 |
| `EWOULDBLOCK` | 表示操作会阻塞。 |
| `EXDEV` | 表示链接不正确。 |

##### Windows 特有的错误常量[#](http://nodejs.cn/api-v12/os.html#windows-specific-error-constants)

[中英对照](http://nodejs.cn/api-v12/os/windows_specific_error_constants.html)

以下错误码特定于 Windows 操作系统。

| 常量 | 描述 |
| --- | --- |
| `WSAEINTR` | 表示中断的函数调用。 |
| `WSAEBADF` | 表示无效的文件句柄。 |
| `WSAEACCES` | 表示权限不足，无法完成操作。 |
| `WSAEFAULT` | 指示无效的指针地址。 |
| `WSAEINVAL` | 表示传入了无效参数。 |
| `WSAEMFILE` | 表示打开的文件太多。 |
| `WSAEWOULDBLOCK` | 表示资源暂时不可用。 |
| `WSAEINPROGRESS` | 指示当前正在进行的操作。 |
| `WSAEALREADY` | 表示操作已经在进行中。 |
| `WSAENOTSOCK` | 表示该资源不是套接字。 |
| `WSAEDESTADDRREQ` | 表示需要目标地址。 |
| `WSAEMSGSIZE` | 表示消息大小太长。 |
| `WSAEPROTOTYPE` | 指示套接字的错误协议类型。 |
| `WSAENOPROTOOPT` | 表示错误的协议选项。 |
| `WSAEPROTONOSUPPORT` | 表示不支持该协议。 |
| `WSAESOCKTNOSUPPORT` | 表示不支持该套接字类型。 |
| `WSAEOPNOTSUPP` | 表示不支持该操作。 |
| `WSAEPFNOSUPPORT` | 表示不支持该协议族。 |
| `WSAEAFNOSUPPORT` | 表示不支持该地址族。 |
| `WSAEADDRINUSE` | 表示该网络地址已被使用。 |
| `WSAEADDRNOTAVAIL` | 表示网络地址不可用。 |
| `WSAENETDOWN` | 表示网络已关闭。 |
| `WSAENETUNREACH` | 表示网络不可达。 |
| `WSAENETRESET` | 表示网络连接已重置。 |
| `WSAECONNABORTED` | 表示连接已中止。 |
| `WSAECONNRESET` | 表示连接已被对端重置。 |
| `WSAENOBUFS` | 表示没有可用的缓冲区空间。 |
| `WSAEISCONN` | 表示套接字已经连接。 |
| `WSAENOTCONN` | 表示套接字未连接。 |
| `WSAESHUTDOWN` | 表示套接字关闭后无法发送数据。 |
| `WSAETOOMANYREFS` | 表示引用过多。 |
| `WSAETIMEDOUT` | 表示连接超时。 |
| `WSAECONNREFUSED` | 表示连接已被拒绝。 |
| `WSAELOOP` | 表示无法翻译名称。 |
| `WSAENAMETOOLONG` | 表示名称太长。 |
| `WSAEHOSTDOWN` | 表示网络主机已关闭。 |
| `WSAEHOSTUNREACH` | 表示没有到网络主机的路由。 |
| `WSAENOTEMPTY` | 表示目录不为空。 |
| `WSAEPROCLIM` | 表示进程过多。 |
| `WSAEUSERS` | 表示已超出用户配额。 |
| `WSAEDQUOT` | 表示已超出磁盘配额。 |
| `WSAESTALE` | 表示陈旧的文件句柄引用。 |
| `WSAEREMOTE` | 表示该条目是远程的。 |
| `WSASYSNOTREADY` | 表示网络子系统没有准备好。 |
| `WSAVERNOTSUPPORTED` | 表示 `winsock.dll` 版本超出范围。 |
| `WSANOTINITIALISED` | 表示尚未成功执行 WSAStartup。 |
| `WSAEDISCON` | 表示正在进行正常关闭。 |
| `WSAENOMORE` | 表示没有更多的结果。 |
| `WSAECANCELLED` | 表示操作已被取消。 |
| `WSAEINVALIDPROCTABLE` | 表示过程调用表无效。 |
| `WSAEINVALIDPROVIDER` | 表示无效的服务提供者。 |
| `WSAEPROVIDERFAILEDINIT` | 表示服务提供者初始化失败。 |
| `WSASYSCALLFAILURE` | 表示系统调用失败。 |
| `WSASERVICE_NOT_FOUND` | 表示未找到服务。 |
| `WSATYPE_NOT_FOUND` | 表示未找到类类型。 |
| `WSA_E_NO_MORE` | 表示没有更多的结果。 |
| `WSA_E_CANCELLED` | 表示调用已取消。 |
| `WSAEREFUSED` | 表示数据库查询被拒绝。 |

#### dlopen 常量[#](http://nodejs.cn/api-v12/os.html#dlopen-constants)

[中英对照](http://nodejs.cn/api-v12/os/dlopen_constants.html)

如果在操作系统上可用，则在 `os.constants.dlopen` 中导出以下常量。 有关详细信息，请参阅 [`dlopen(3)`](http://url.nodejs.cn/K8AVEi)。

| 常量 | 描述 |
| --- | --- |
| `RTLD_LAZY` | 执行延迟绑定。 Node.js 默认设置这个标志。 |
| `RTLD_NOW` | 在 dlopen(3) 返回之前解析库中所有未定义的符号。 |
| `RTLD_GLOBAL` | 库定义的符号将可用于随后加载的库的符号解析。 |
| `RTLD_LOCAL` | `RTLDGLOBAL` 的反义。 如果未指定任何标志，则这是默认行为。 |
| `RTLD_DEEPBIND` | 使自包含库优先使用自己的符号而不是来自先前加载的库的符号。 |

#### 优先级常量[#](http://nodejs.cn/api-v12/os.html#priority-constants)

[中英对照](http://nodejs.cn/api-v12/os/priority_constants.html)

新增于: v10.10.0

以下进程调度常量由 `os.constants.priority` 导出。

| 常量 | 描述 |
| --- | --- |
| `PRIORITY_LOW` | 最低的进程调度优先级。 这对应于 Windows 上的 `IDLEPRIORITYCLASS`，以及所有其他平台上的 `19` 的值。 |
| `PRIORITY_BELOW_NORMAL` | 进程调度优先级高于 `PRIORITYLOW` 和低于 `PRIORITYNORMAL`。 这对应于 Windows 上的 `BELOWNORMALPRIORITYCLASS`，以及所有其他平台上的 `10` 的值。 |
| `PRIORITY_NORMAL` | 默认的进程调度优先级。 这对应于 Windows 上的 `NORMALPRIORITYCLASS`，以及所有其他平台上的 `0` 的值。 |
| `PRIORITY_ABOVE_NORMAL` | 进程调度优先级高于 `PRIORITYNORMAL` 和低于 `PRIORITYHIGH`。 这对应于 Windows 上的 `ABOVENORMALPRIORITYCLASS`，以及所有其他平台上的 `-7` 的值。 |
| `PRIORITY_HIGH` | 进程调度优先级高于 `PRIORITYABOVENORMAL` 和低于 `PRIORITYHIGHEST`。 这对应于 Windows 上的 `HIGHPRIORITYCLASS`，以及所有其他平台上的 `-14` 的值。 |
| `PRIORITY_HIGHEST` | 最高的进程调度优先级。 这对应于 Windows 上的 `REALTIMEPRIORITYCLASS`，以及所有其他平台上的 `-20` 的值。 |

#### libuv 常量[#](http://nodejs.cn/api-v12/os.html#libuv-constants)

[中英对照](http://nodejs.cn/api-v12/os/libuv_constants.html)

| 常量 | 描述 |
| --- | --- |
| `UV_UDP_REUSEADDR` |  |
