---
created: 2022-07-29T13:12:52 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/dns.html
author: 
---

# dns 域名服务器 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/dns/dns.html)

**源代码:** [lib/dns.js](https://github.com/nodejs/node/blob/v12.22.12/lib/dns.js)

`dns` 模块启用了名称解析。 例如，使用它来查找主机名的 IP 地址。

尽管以[域名系统](http://url.nodejs.cn/pQKTKQ)命名，但它并不总是使用域名系统协议进行查找。 [`dns.lookup()`](http://nodejs.cn/api-v12/dns.html#dns_dns_lookup_hostname_options_callback) 使用操作系统工具来执行名称解析。 它可能不需要执行任何网络通信。 要像同一系统上的其他应用程序那样执行名称解析，则使用 [`dns.lookup()`](http://nodejs.cn/api-v12/dns.html#dns_dns_lookup_hostname_options_callback)。

```
const dns = require('dns');

dns.lookup('example.org', (err, address, family) => {
  console.log('address: %j family: IPv%s', address, family);
});
// address: "93.184.216.34" family: IPv4
```

`dns` 模块中的所有其他函数都连接到实际的域名系统服务器以执行名称解析。 它们将始终使用网络来执行域名系统查询。 这些函数不使用 [`dns.lookup()`](http://nodejs.cn/api-v12/dns.html#dns_dns_lookup_hostname_options_callback) 使用的同一组配置文件（例如 `/etc/hosts`）。 使用这些函数始终执行域名系统查询，绕过其他名称解析工具。

```
const dns = require('dns');

dns.resolve4('archive.org', (err, addresses) => {
  if (err) throw err;

  console.log(`addresses: ${JSON.stringify(addresses)}`);

  addresses.forEach((a) => {
    dns.reverse(a, (err, hostnames) => {
      if (err) {
        throw err;
      }
      console.log(`reverse for ${a}: ${JSON.stringify(hostnames)}`);
    });
  });
});
```

有关更多信息，请参阅[实现的注意事项章节](http://nodejs.cn/api-v12/dns.html#dns_implementation_considerations)。

### `dns.Resolver` 类[#](http://nodejs.cn/api-v12/dns.html#class-dnsresolver)

[中英对照](http://nodejs.cn/api-v12/dns/class_dns_resolver.html)

新增于: v8.3.0

域名系统请求的独立解析器。

创建新的解析器使用默认的服务器设置。 使用 [`resolver.setServers()`](http://nodejs.cn/api-v12/dns.html#dns_dns_setservers_servers) 设置用于解析器的服务器不会影响其他解析器：

```
const { Resolver } = require('dns');
const resolver = new Resolver();
resolver.setServers(['4.4.4.4']);

// 此请求将使用 4.4.4.4 的服务器，与全局设置无关。
resolver.resolve4('example.org', (err, addresses) => {
  // ...
});
```

可以使用 `dns` 模块中的以下方法：

-   [`resolver.getServers()`](http://nodejs.cn/api-v12/dns.html#dns_dns_getservers)
-   [`resolver.resolve()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolve_hostname_rrtype_callback)
-   [`resolver.resolve4()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolve4_hostname_options_callback)
-   [`resolver.resolve6()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolve6_hostname_options_callback)
-   [`resolver.resolveAny()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolveany_hostname_callback)
-   [`resolver.resolveCname()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolvecname_hostname_callback)
-   [`resolver.resolveMx()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolvemx_hostname_callback)
-   [`resolver.resolveNaptr()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolvenaptr_hostname_callback)
-   [`resolver.resolveNs()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolvens_hostname_callback)
-   [`resolver.resolvePtr()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolveptr_hostname_callback)
-   [`resolver.resolveSoa()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolvesoa_hostname_callback)
-   [`resolver.resolveSrv()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolvesrv_hostname_callback)
-   [`resolver.resolveTxt()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolvetxt_hostname_callback)
-   [`resolver.reverse()`](http://nodejs.cn/api-v12/dns.html#dns_dns_reverse_ip_callback)
-   [`resolver.setServers()`](http://nodejs.cn/api-v12/dns.html#dns_dns_setservers_servers)

#### `Resolver([options])`[#](http://nodejs.cn/api-v12/dns.html#resolveroptions)

[中英对照](http://nodejs.cn/api-v12/dns/resolver_options.html)

创建新的解析器。

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `timeout` [<integer>](http://url.nodejs.cn/SXbo1v) 查询超时（以毫秒为单位），或 `-1` 使用默认超时。

#### `resolver.cancel()`[#](http://nodejs.cn/api-v12/dns.html#resolvercancel)

[中英对照](http://nodejs.cn/api-v12/dns/resolver_cancel.html)

新增于: v8.3.0

取消此解析器进行的所有未完成的域名系统查询。 相应的回调将被调用，错误码为 `ECANCELLED`。

### `dns.getServers()`[#](http://nodejs.cn/api-v12/dns.html#dnsgetservers)

[中英对照](http://nodejs.cn/api-v12/dns/dns_getservers.html)

新增于: v0.11.3

-   返回: [<string\[\]>](http://url.nodejs.cn/9Tw2bK)

返回 IP 地址字符串的数组，根据 [RFC 5952](http://url.nodejs.cn/jzbgfM) 格式化，当前配置为用于 DNS 解析。 如果使用自定义端口，则字符串将包含端口部分。

```
[
  '4.4.4.4',
  '2001:4860:4860::8888',
  '4.4.4.4:1053',
  '[2001:4860:4860::8888]:1053'
]
```

### `dns.lookup(hostname[, options], callback)`[#](http://nodejs.cn/api-v12/dns.html#dnslookuphostname-options-callback)

[中英对照](http://nodejs.cn/api-v12/dns/dns_lookup_hostname_options_callback.html)

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<integer>](http://url.nodejs.cn/SXbo1v) | [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `family` [<integer>](http://url.nodejs.cn/SXbo1v) 记录族。 必须是 `4`、`6` 或 `0`。 值 `0` 表示同时返回 IPv4 和 IPv6 地址。 **默认值:** `0`。
    -   `hints` [<number>](http://url.nodejs.cn/SXbo1v) 一个或多个[受支持的 `getaddrinfo` 标志](http://nodejs.cn/api-v12/dns.html#dns_supported_getaddrinfo_flags)。 多个标志可以通过按位 `OR` 其值来传入。
    -   `all` [<boolean>](http://url.nodejs.cn/jFbvuT) 当为 `true` 时，回调返回数组中所有已解析的地址。 否则，返回单个地址。 **默认值:** `false`。
    -   `verbatim` [<boolean>](http://url.nodejs.cn/jFbvuT) 当为 `true` 时，回调按照 DNS 解析器返回的顺序接收 IPv4 和 IPv6 地址。 当为 `false` 时，IPv4 地址位于 IPv6 地址之前。 **默认值:** 当前为 `false`（地址已重新排序），但预计在不久的将来会发生变化。 新代码应使用 `{ verbatim: true }`。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `address` [<string>](http://url.nodejs.cn/9Tw2bK) IPv4 或 IPv6 地址的字符串表示形式。
    -   `family` [<integer>](http://url.nodejs.cn/SXbo1v) `4` 或 `6`，表示 `address` 族，如果地址不是 IPv4 或 IPv6 地址，则表示为 `0`。 `0` 可能是操作系统使用的名称解析服务中存在错误的指示符。

将主机名（例如 `'nodejs.org'`）解析为第一个找到的 A (IPv4) 或 AAAA (IPv6) 记录。 所有 `option` 属性都是可选的。 如果 `options` 是整数，则它必须是 `4` 或 `6` – 如果未提供 `options`，则如果找到，则返回 IPv4 和 IPv6 地址。

将 `all` 选项设置为 `true`，`callback` 的参数更改为 `(err, addresses)`，`addresses` 是具有属性 `address` 和 `family` 的对象数组。

出错时，`err` 是 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 对象，其中 `err.code` 是错误码。 记住，`err.code` 将设置为 `'ENOTFOUND'`，不仅当主机名不存在时，而且当查找以其他方式失败时，例如没有可用的文件描述符。

`dns.lookup()` 不一定与域名系统协议有任何关系。 该实现使用了一个操作系统工具，可以将名称与地址相关联，反之亦然。 这种实现会对任何 Node.js 程序的行为产生微妙但重要的影响。 在使用 `dns.lookup()` 之前，请花一些时间查阅[实现的注意事项章节](http://nodejs.cn/api-v12/dns.html#dns_implementation_considerations)。

用法示例：

```
const dns = require('dns');
const options = {
  family: 6,
  hints: dns.ADDRCONFIG | dns.V4MAPPED,
};
dns.lookup('example.com', options, (err, address, family) =>
  console.log('address: %j family: IPv%s', address, family));
// address: "2606:2800:220:1:248:1893:25c8:1946" family: IPv6

// 当 options.all 为真时，结果将是数组。
options.all = true;
dns.lookup('example.com', options, (err, addresses) =>
  console.log('addresses: %j', addresses));
// addresses: [{"address":"2606:2800:220:1:248:1893:25c8:1946","family":6}]
```

如果此方法作为其 [`util.promisify()`](http://nodejs.cn/api-v12/util.html#util_util_promisify_original) 版本被调用，并且 `all` 未设置为 `true`，则它为具有 `address` 和 `family` 属性的 `Object` 返回 `Promise`。

#### 支持的 getaddrinfo[#](http://nodejs.cn/api-v12/dns.html#supported-getaddrinfo-flags)

[中英对照](http://nodejs.cn/api-v12/dns/supported_getaddrinfo_flags.html)

以下标志可以作为提示传给 [`dns.lookup()`](http://nodejs.cn/api-v12/dns.html#dns_dns_lookup_hostname_options_callback)。

-   `dns.ADDRCONFIG`: 将返回的地址类型限制为系统上配置的非环回地址类型。 例如，仅当当前系统至少配置了一个 IPv4 地址时，才会返回 IPv4 地址。
-   `dns.V4MAPPED`: 如果指定了 IPv6 族，但未找到 IPv6 地址，则返回 IPv4 映射的 IPv6 地址。 某些操作系统（例如 FreeBSD 10.1）不支持它。
-   `dns.ALL`: 如果指定了 `dns.V4MAPPED`，则返回解析的 IPv6 地址以及 IPv4 映射的 IPv6 地址。

### `dns.lookupService(address, port, callback)`[#](http://nodejs.cn/api-v12/dns.html#dnslookupserviceaddress-port-callback)

[中英对照](http://nodejs.cn/api-v12/dns/dns_lookupservice_address_port_callback.html)

新增于: v0.11.14

-   `address` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `port` [<number>](http://url.nodejs.cn/SXbo1v)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK) 例如 `example.com`
    -   `service` [<string>](http://url.nodejs.cn/9Tw2bK) 例如 `http`

使用操作系统的底层 `getnameinfo` 实现将给定的 `address` 和 `port` 解析为主机名和服务。

如果 `address` 不是有效的 IP 地址，则会抛出 `TypeError`。 `port` 将被强制为数字。 如果不是合法的端口，则会抛出 `TypeError`。

出错时，`err` 是 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 对象，其中 `err.code` 是错误码。

```
const dns = require('dns');
dns.lookupService('127.0.0.1', 22, (err, hostname, service) => {
  console.log(hostname, service);
  // 打印: localhost ssh
});
```

如果此方法作为其 [`util.promisify()`](http://nodejs.cn/api-v12/util.html#util_util_promisify_original) 版本被调用，则其将为具有 `hostname` 和 `service` 属性的 `Object` 返回 `Promise`。

### `dns.resolve(hostname[, rrtype], callback)`[#](http://nodejs.cn/api-v12/dns.html#dnsresolvehostname-rrtype-callback)

[中英对照](http://nodejs.cn/api-v12/dns/dns_resolve_hostname_rrtype_callback.html)

新增于: v0.1.27

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK) 要解析的主机名。
-   `rrtype` [<string>](http://url.nodejs.cn/9Tw2bK) 资源记录类型。 **默认值:** `'A'`。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `records` [<string\[\]>](http://url.nodejs.cn/9Tw2bK) | [<Object\[\]>](http://url.nodejs.cn/jzn6Ao) | [<Object>](http://url.nodejs.cn/jzn6Ao)

使用域名系统协议将主机名（例如 `'nodejs.org'`）解析为资源记录数组。 `callback` 函数有参数 `(err, records)`。 当成功时，`records` 将是资源记录数组。 个别结果的类型和结构因 `rrtype` 而异：

| `rrtype` | `records` 包含 | 结果的类型 | 快捷方法 |
| --- | --- | --- | --- |
| `'A'` | IPv4 地址（默认） | [<string>](http://url.nodejs.cn/9Tw2bK) | [`dns.resolve4()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolve4_hostname_options_callback) |
| `'AAAA'` | IPv6 地址 | [<string>](http://url.nodejs.cn/9Tw2bK) | [`dns.resolve6()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolve6_hostname_options_callback) |
| `'ANY'` | 任何记录 | [<Object>](http://url.nodejs.cn/jzn6Ao) | [`dns.resolveAny()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolveany_hostname_callback) |
| `'CNAME'` | 规范名称记录 | [<string>](http://url.nodejs.cn/9Tw2bK) | [`dns.resolveCname()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolvecname_hostname_callback) |
| `'MX'` | 邮件交换记录 | [<Object>](http://url.nodejs.cn/jzn6Ao) | [`dns.resolveMx()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolvemx_hostname_callback) |
| `'NAPTR'` | 名称授权指针记录 | [<Object>](http://url.nodejs.cn/jzn6Ao) | [`dns.resolveNaptr()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolvenaptr_hostname_callback) |
| `'NS'` | 名称服务器记录 | [<string>](http://url.nodejs.cn/9Tw2bK) | [`dns.resolveNs()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolvens_hostname_callback) |
| `'PTR'` | 指针记录 | [<string>](http://url.nodejs.cn/9Tw2bK) | [`dns.resolvePtr()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolveptr_hostname_callback) |
| `'SOA'` | 起始规范记录 | [<Object>](http://url.nodejs.cn/jzn6Ao) | [`dns.resolveSoa()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolvesoa_hostname_callback) |
| `'SRV'` | 服务记录 | [<Object>](http://url.nodejs.cn/jzn6Ao) | [`dns.resolveSrv()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolvesrv_hostname_callback) |
| `'TXT'` | 文本记录 | [<string\[\]>](http://url.nodejs.cn/9Tw2bK) | [`dns.resolveTxt()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolvetxt_hostname_callback) |

出错时，`err` 是 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 对象，其中 `err.code` 是 [DNS 错误码](http://nodejs.cn/api-v12/dns.html#dns_error_codes)之一。

### `dns.resolve4(hostname[, options], callback)`[#](http://nodejs.cn/api-v12/dns.html#dnsresolve4hostname-options-callback)

[中英对照](http://nodejs.cn/api-v12/dns/dns_resolve4_hostname_options_callback.html)

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK) 要解析的主机名。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `ttl` [<boolean>](http://url.nodejs.cn/jFbvuT) 检索每条记录的生存时间值 (TTL)。 当为 `true` 时，回调接收 `{ address: '1.2.3.4', ttl: 60 }` 对象数组而不是字符串数组，TTL 以秒表示。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `addresses` [<string\[\]>](http://url.nodejs.cn/9Tw2bK) | [<Object\[\]>](http://url.nodejs.cn/jzn6Ao)

使用域名系统协议为 `hostname` 解析 IPv4 地址（`A` 记录）。 传给 `callback` 函数的 `addresses` 参数将包含 IPv4 地址的数组（例如 `['74.125.79.104', '74.125.79.105', '74.125.79.106']`）。

### `dns.resolve6(hostname[, options], callback)`[#](http://nodejs.cn/api-v12/dns.html#dnsresolve6hostname-options-callback)

[中英对照](http://nodejs.cn/api-v12/dns/dns_resolve6_hostname_options_callback.html)

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK) 要解析的主机名。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `ttl` [<boolean>](http://url.nodejs.cn/jFbvuT) 检索每条记录的生存时间值 (TTL)。 当为 `true` 时，回调接收 `{ address: '0:1:2:3:4:5:6:7', ttl: 60 }` 对象数组而不是字符串数组，TTL 以秒表示。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `addresses` [<string\[\]>](http://url.nodejs.cn/9Tw2bK) | [<Object\[\]>](http://url.nodejs.cn/jzn6Ao)

使用域名系统协议为 `hostname` 解析 IPv6 地址（`AAAA` 记录）。 传给 `callback` 函数的 `addresses` 参数将包含 IPv6 地址数组。

### `dns.resolveAny(hostname, callback)`[#](http://nodejs.cn/api-v12/dns.html#dnsresolveanyhostname-callback)

[中英对照](http://nodejs.cn/api-v12/dns/dns_resolveany_hostname_callback.html)

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `ret` [<Object\[\]>](http://url.nodejs.cn/jzn6Ao)

使用域名系统协议解析所有记录（也称为 `ANY` 或 `*` 查询）。 传给 `callback` 函数的 `ret` 参数将是包含各种类型记录的数组。 每个对象都有表示当前记录的类型的属性 `type`。 并且根据 `type`，对象上将出现其他属性：

| 类型 | 属性 |
| --- | --- |
| `'A'` | `address`/`ttl` |
| `'AAAA'` | `address`/`ttl` |
| `'CNAME'` | `value` |
| `'MX'` | 指向 [`dns.resolveMx()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolvemx_hostname_callback) |
| `'NAPTR'` | 指向 [`dns.resolveNaptr()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolvenaptr_hostname_callback) |
| `'NS'` | `value` |
| `'PTR'` | `value` |
| `'SOA'` | 指向 [`dns.resolveSoa()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolvesoa_hostname_callback) |
| `'SRV'` | 指向 [`dns.resolveSrv()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolvesrv_hostname_callback) |
| `'TXT'` | 此类型的记录包含名为 `entries` 的数组属性，它指向 [`dns.resolveTxt()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolvetxt_hostname_callback)，例如 `{ entries: ['...'], type: 'TXT' }` |

这是传给回调的 `ret` 对象的示例：

```
[ { type: 'A', address: '127.0.0.1', ttl: 299 },
  { type: 'CNAME', value: 'example.com' },
  { type: 'MX', exchange: 'alt4.aspmx.l.example.com', priority: 50 },
  { type: 'NS', value: 'ns1.example.com' },
  { type: 'TXT', entries: [ 'v=spf1 include:_spf.example.com ~all' ] },
  { type: 'SOA',
    nsname: 'ns1.example.com',
    hostmaster: 'admin.example.com',
    serial: 156696742,
    refresh: 900,
    retry: 900,
    expire: 1800,
    minttl: 60 } ]
```

域名系统服务器运营商可以选择不响应 `ANY` 查询。 调用单个方法（如 [`dns.resolve4()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolve4_hostname_options_callback)、[`dns.resolveMx()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolvemx_hostname_callback) 等）可能会更好。 有关更多详细信息，请参阅 [RFC 8482](http://url.nodejs.cn/RFFP6n)。

### `dns.resolveCname(hostname, callback)`[#](http://nodejs.cn/api-v12/dns.html#dnsresolvecnamehostname-callback)

[中英对照](http://nodejs.cn/api-v12/dns/dns_resolvecname_hostname_callback.html)

新增于: v0.3.2

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `addresses` [<string\[\]>](http://url.nodejs.cn/9Tw2bK)

使用域名系统协议为 `hostname` 解析 `CNAME` 记录。 传给 `callback` 函数的 `addresses` 参数将包含可用于 `hostname`（例如 `['bar.example.com']`）的规范名称记录的数组。

### `dns.resolveMx(hostname, callback)`[#](http://nodejs.cn/api-v12/dns.html#dnsresolvemxhostname-callback)

[中英对照](http://nodejs.cn/api-v12/dns/dns_resolvemx_hostname_callback.html)

新增于: v0.1.27

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `addresses` [<Object\[\]>](http://url.nodejs.cn/jzn6Ao)

使用域名系统协议解析 `hostname` 的邮件交换记录（`MX` 记录）。 传给 `callback` 函数的 `addresses` 参数将包含其中包含 `priority` 和 `exchange` 属性（例如 `[{priority: 10, exchange: 'mx.example.com'}, ...]`）的对象数组。

### `dns.resolveNaptr(hostname, callback)`[#](http://nodejs.cn/api-v12/dns.html#dnsresolvenaptrhostname-callback)

[中英对照](http://nodejs.cn/api-v12/dns/dns_resolvenaptr_hostname_callback.html)

新增于: v0.9.12

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `addresses` [<Object\[\]>](http://url.nodejs.cn/jzn6Ao)

使用域名系统协议为 `hostname` 解析基于正则表达式的记录（`NAPTR` 记录）。 传给 `callback` 函数的 `addresses` 参数将包含具有以下属性的对象数组：

-   `flags`
-   `service`
-   `regexp`
-   `replacement`
-   `order`
-   `preference`

```
{
  flags: 's',
  service: 'SIP+D2U',
  regexp: '',
  replacement: '_sip._udp.example.com',
  order: 30,
  preference: 100
}
```

### `dns.resolveNs(hostname, callback)`[#](http://nodejs.cn/api-v12/dns.html#dnsresolvenshostname-callback)

[中英对照](http://nodejs.cn/api-v12/dns/dns_resolvens_hostname_callback.html)

新增于: v0.1.90

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `addresses` [<string\[\]>](http://url.nodejs.cn/9Tw2bK)

使用域名系统协议为 `hostname` 解析名称服务器记录（`NS` 记录）。 传给 `callback` 函数的 `addresses` 参数将包含可用于 `hostname`（例如 `['ns1.example.com', 'ns2.example.com']`）的名称服务器记录数组。

### `dns.resolvePtr(hostname, callback)`[#](http://nodejs.cn/api-v12/dns.html#dnsresolveptrhostname-callback)

[中英对照](http://nodejs.cn/api-v12/dns/dns_resolveptr_hostname_callback.html)

新增于: v6.0.0

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `addresses` [<string\[\]>](http://url.nodejs.cn/9Tw2bK)

使用域名系统协议解析 `hostname` 的指针记录（`PTR` 记录）。 传给 `callback` 函数的 `addresses` 参数将是包含回复记录的字符串数组。

### `dns.resolveSoa(hostname, callback)`[#](http://nodejs.cn/api-v12/dns.html#dnsresolvesoahostname-callback)

[中英对照](http://nodejs.cn/api-v12/dns/dns_resolvesoa_hostname_callback.html)

新增于: v0.11.10

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `address` [<Object>](http://url.nodejs.cn/jzn6Ao)

使用域名系统协议来解析 `hostname` 的起始规范记录（`SOA` 记录）。 传给 `callback` 函数的 `address` 参数将是具有以下属性的对象：

-   `nsname`
-   `hostmaster`
-   `serial`
-   `refresh`
-   `retry`
-   `expire`
-   `minttl`

```
{
  nsname: 'ns.example.com',
  hostmaster: 'root.example.com',
  serial: 2013101809,
  refresh: 10000,
  retry: 2400,
  expire: 604800,
  minttl: 3600
}
```

### `dns.resolveSrv(hostname, callback)`[#](http://nodejs.cn/api-v12/dns.html#dnsresolvesrvhostname-callback)

[中英对照](http://nodejs.cn/api-v12/dns/dns_resolvesrv_hostname_callback.html)

新增于: v0.1.27

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `addresses` [<Object\[\]>](http://url.nodejs.cn/jzn6Ao)

使用域名系统协议解析 `hostname` 的服务记录（`SRV` 记录）。 传给 `callback` 函数的 `addresses` 参数将是具有以下属性的对象数组：

-   `priority`
-   `weight`
-   `port`
-   `name`

```
{
  priority: 10,
  weight: 5,
  port: 21223,
  name: 'service.example.com'
}
```

### `dns.resolveTxt(hostname, callback)`[#](http://nodejs.cn/api-v12/dns.html#dnsresolvetxthostname-callback)

[中英对照](http://nodejs.cn/api-v12/dns/dns_resolvetxt_hostname_callback.html)

新增于: v0.1.27

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    

使用域名系统协议为 `hostname` 解析文本查询（`TXT` 记录）。 传给 `callback` 函数的 `records` 参数是可用于 `hostname`（例如 `[ ['v=spf1 ip4:0.0.0.0 ', '~all' ] ]`）的文本记录的二维数组。 每个子数组包含一条记录的 TXT 块。 根据用例，这些可以连接在一起或单独处理。

### `dns.reverse(ip, callback)`[#](http://nodejs.cn/api-v12/dns.html#dnsreverseip-callback)

[中英对照](http://nodejs.cn/api-v12/dns/dns_reverse_ip_callback.html)

新增于: v0.1.16

-   `ip` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `hostnames` [<string\[\]>](http://url.nodejs.cn/9Tw2bK)

执行反向域名系统查询，将 IPv4 或 IPv6 地址解析为主机名数组。

当出错时，`err` 是 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 对象，其中 `err.code` 是 [DNS 错误码](http://nodejs.cn/api-v12/dns.html#dns_error_codes)之一。

### `dns.setServers(servers)`[#](http://nodejs.cn/api-v12/dns.html#dnssetserversservers)

[中英对照](http://nodejs.cn/api-v12/dns/dns_setservers_servers.html)

新增于: v0.11.3

-   `servers` [<string\[\]>](http://url.nodejs.cn/9Tw2bK) [RFC 5952](http://url.nodejs.cn/jzbgfM) 格式的地址数组

设置执行 DNS 解析时要使用的服务器的 IP 地址和端口。 `servers` 参数是 [RFC 5952](http://url.nodejs.cn/jzbgfM) 格式的地址数组。 如果端口是 IANA 默认 DNS 端口 (53)，则可以省略。

```
dns.setServers([
  '4.4.4.4',
  '[2001:4860:4860::8888]',
  '4.4.4.4:1053',
  '[2001:4860:4860::8888]:1053'
]);
```

如果提供的地址无效，则会抛出错误。

在进行域名系统查询时不得调用 `dns.setServers()` 方法。

[`dns.setServers()`](http://nodejs.cn/api-v12/dns.html#dns_dns_setservers_servers) 方法仅影响 [`dns.resolve()`](http://nodejs.cn/api-v12/dns.html#dns_dns_resolve_hostname_rrtype_callback)、`dns.resolve*()` 和 [`dns.reverse()`](http://nodejs.cn/api-v12/dns.html#dns_dns_reverse_ip_callback)（特别是不影响 [`dns.lookup()`](http://nodejs.cn/api-v12/dns.html#dns_dns_lookup_hostname_options_callback)）。

此方法的工作方式与 [resolve.conf](http://url.nodejs.cn/azKRAV) 非常相似。 也就是说，如果尝试使用提供的第一个服务器进行解析导致 `NOTFOUND` 错误，则 `resolve()` 方法将不会尝试使用提供的后续服务器进行解析。 仅当较早的域名系统服务器超时或导致其他错误时，才会使用后备域名系统服务器。

### Promise 形式的 API[#](http://nodejs.cn/api-v12/dns.html#dns-promises-api)

[中英对照](http://nodejs.cn/api-v12/dns/dns_promises_api.html)

`dns.promises` API 提供了一组替代的异步 DNS 方法，这些方法返回 `Promise` 对象而不是使用回调。 API 可通过 `require('dns').promises` 访问。

#### `dnsPromises.Resolver` 类[#](http://nodejs.cn/api-v12/dns.html#class-dnspromisesresolver)

[中英对照](http://nodejs.cn/api-v12/dns/class_dnspromises_resolver.html)

新增于: v10.6.0

域名系统请求的独立解析器。

创建新的解析器使用默认的服务器设置。 使用 [`resolver.setServers()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_setservers_servers) 设置用于解析器的服务器不会影响其他解析器：

```
const { Resolver } = require('dns').promises;
const resolver = new Resolver();
resolver.setServers(['4.4.4.4']);

// 此请求将使用 4.4.4.4 的服务器，与全局设置无关。
resolver.resolve4('example.org').then((addresses) => {
  // ...
});

// 或者，可以使用 async-await 风格编写相同的代码。
(async function() {
  const addresses = await resolver.resolve4('example.org');
})();
```

来自 `dnsPromises` API 的以下方法可用：

-   [`resolver.getServers()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_getservers)
-   [`resolver.resolve()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolve_hostname_rrtype)
-   [`resolver.resolve4()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolve4_hostname_options)
-   [`resolver.resolve6()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolve6_hostname_options)
-   [`resolver.resolveAny()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolveany_hostname)
-   [`resolver.resolveCname()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolvecname_hostname)
-   [`resolver.resolveMx()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolvemx_hostname)
-   [`resolver.resolveNaptr()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolvenaptr_hostname)
-   [`resolver.resolveNs()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolvens_hostname)
-   [`resolver.resolvePtr()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolveptr_hostname)
-   [`resolver.resolveSoa()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolvesoa_hostname)
-   [`resolver.resolveSrv()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolvesrv_hostname)
-   [`resolver.resolveTxt()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolvetxt_hostname)
-   [`resolver.reverse()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_reverse_ip)
-   [`resolver.setServers()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_setservers_servers)

#### `dnsPromises.getServers()`[#](http://nodejs.cn/api-v12/dns.html#dnspromisesgetservers)

[中英对照](http://nodejs.cn/api-v12/dns/dnspromises_getservers.html)

新增于: v10.6.0

-   返回: [<string\[\]>](http://url.nodejs.cn/9Tw2bK)

返回 IP 地址字符串的数组，根据 [RFC 5952](http://url.nodejs.cn/jzbgfM) 格式化，当前配置为用于 DNS 解析。 如果使用自定义端口，则字符串将包含端口部分。

```
[
  '4.4.4.4',
  '2001:4860:4860::8888',
  '4.4.4.4:1053',
  '[2001:4860:4860::8888]:1053'
]
```

#### `dnsPromises.lookup(hostname[, options])`[#](http://nodejs.cn/api-v12/dns.html#dnspromiseslookuphostname-options)

[中英对照](http://nodejs.cn/api-v12/dns/dnspromises_lookup_hostname_options.html)

新增于: v10.6.0

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `options` [<integer>](http://url.nodejs.cn/SXbo1v) | [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `family` [<integer>](http://url.nodejs.cn/SXbo1v) 记录族。 必须是 `4`、`6` 或 `0`。 值 `0` 表示同时返回 IPv4 和 IPv6 地址。 **默认值:** `0`。
    -   `hints` [<number>](http://url.nodejs.cn/SXbo1v) 一个或多个[受支持的 `getaddrinfo` 标志](http://nodejs.cn/api-v12/dns.html#dns_supported_getaddrinfo_flags)。 多个标志可以通过按位 `OR` 其值来传入。
    -   `all` [<boolean>](http://url.nodejs.cn/jFbvuT) 当为 `true` 时，`Promise` 使用数组中的所有地址进行解决。 否则，返回单个地址。 **默认值:** `false`。
    -   `verbatim` [<boolean>](http://url.nodejs.cn/jFbvuT) 当为 `true` 时，`Promise` 使用按照 DNS 解析器返回的顺序使用 IPv4 和 IPv6 地址进行解决。 当为 `false` 时，IPv4 地址位于 IPv6 地址之前。 **默认值:** 当前为 `false`（地址已重新排序），但预计在不久的将来会发生变化。 新代码应使用 `{ verbatim: true }`。

将主机名（例如 `'nodejs.org'`）解析为第一个找到的 A (IPv4) 或 AAAA (IPv6) 记录。 所有 `option` 属性都是可选的。 如果 `options` 是整数，则它必须是 `4` 或 `6` – 如果未提供 `options`，则如果找到，则返回 IPv4 和 IPv6 地址。

将 `all` 选项设置为 `true`，则 `Promise` 使用 `addresses` 是具有属性 `address` 和 `family` 的对象数组进行解决。

当出错时，`Promise` 使用 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 对象拒绝，其中 `err.code` 是错误码。 记住，`err.code` 将设置为 `'ENOTFOUND'`，不仅当主机名不存在时，而且当查找以其他方式失败时，例如没有可用的文件描述符。

[`dnsPromises.lookup()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_lookup_hostname_options) 不一定与域名系统协议有任何关系。 该实现使用了一个操作系统工具，可以将名称与地址相关联，反之亦然。 这种实现会对任何 Node.js 程序的行为产生微妙但重要的影响。 在使用 `dnsPromises.lookup()` 之前，请花一些时间查阅[实现的注意事项章节](http://nodejs.cn/api-v12/dns.html#dns_implementation_considerations)。

用法示例：

```
const dns = require('dns');
const dnsPromises = dns.promises;
const options = {
  family: 6,
  hints: dns.ADDRCONFIG | dns.V4MAPPED,
};

dnsPromises.lookup('example.com', options).then((result) => {
  console.log('address: %j family: IPv%s', result.address, result.family);
  // address: "2606:2800:220:1:248:1893:25c8:1946" family: IPv6
});

// 当 options.all 为真时，结果将是数组。
options.all = true;
dnsPromises.lookup('example.com', options).then((result) => {
  console.log('addresses: %j', result);
  // addresses: [{"address":"2606:2800:220:1:248:1893:25c8:1946","family":6}]
});
```

#### `dnsPromises.lookupService(address, port)`[#](http://nodejs.cn/api-v12/dns.html#dnspromiseslookupserviceaddress-port)

[中英对照](http://nodejs.cn/api-v12/dns/dnspromises_lookupservice_address_port.html)

新增于: v10.6.0

-   `address` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `port` [<number>](http://url.nodejs.cn/SXbo1v)

使用操作系统的底层 `getnameinfo` 实现将给定的 `address` 和 `port` 解析为主机名和服务。

如果 `address` 不是有效的 IP 地址，则会抛出 `TypeError`。 `port` 将被强制为数字。 如果不是合法的端口，则会抛出 `TypeError`。

当出错时，`Promise` 使用 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 对象拒绝，其中 `err.code` 是错误码。

```
const dnsPromises = require('dns').promises;
dnsPromises.lookupService('127.0.0.1', 22).then((result) => {
  console.log(result.hostname, result.service);
  // 打印: localhost ssh
});
```

#### `dnsPromises.resolve(hostname[, rrtype])`[#](http://nodejs.cn/api-v12/dns.html#dnspromisesresolvehostname-rrtype)

[中英对照](http://nodejs.cn/api-v12/dns/dnspromises_resolve_hostname_rrtype.html)

新增于: v10.6.0

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK) 要解析的主机名。
-   `rrtype` [<string>](http://url.nodejs.cn/9Tw2bK) 资源记录类型。 **默认值:** `'A'`。

使用域名系统协议将主机名（例如 `'nodejs.org'`）解析为资源记录数组。 当成功时，`Promise` 使用资源记录数组解决。 个别结果的类型和结构因 `rrtype` 而异：

| `rrtype` | `records` 包含 | 结果的类型 | 快捷方法 |
| --- | --- | --- | --- |
| `'A'` | IPv4 地址（默认） | [<string>](http://url.nodejs.cn/9Tw2bK) | [`dnsPromises.resolve4()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolve4_hostname_options) |
| `'AAAA'` | IPv6 地址 | [<string>](http://url.nodejs.cn/9Tw2bK) | [`dnsPromises.resolve6()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolve6_hostname_options) |
| `'ANY'` | 任何记录 | [<Object>](http://url.nodejs.cn/jzn6Ao) | [`dnsPromises.resolveAny()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolveany_hostname) |
| `'CNAME'` | 规范名称记录 | [<string>](http://url.nodejs.cn/9Tw2bK) | [`dnsPromises.resolveCname()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolvecname_hostname) |
| `'MX'` | 邮件交换记录 | [<Object>](http://url.nodejs.cn/jzn6Ao) | [`dnsPromises.resolveMx()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolvemx_hostname) |
| `'NAPTR'` | 名称授权指针记录 | [<Object>](http://url.nodejs.cn/jzn6Ao) | [`dnsPromises.resolveNaptr()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolvenaptr_hostname) |
| `'NS'` | 名称服务器记录 | [<string>](http://url.nodejs.cn/9Tw2bK) | [`dnsPromises.resolveNs()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolvens_hostname) |
| `'PTR'` | 指针记录 | [<string>](http://url.nodejs.cn/9Tw2bK) | [`dnsPromises.resolvePtr()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolveptr_hostname) |
| `'SOA'` | 起始规范记录 | [<Object>](http://url.nodejs.cn/jzn6Ao) | [`dnsPromises.resolveSoa()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolvesoa_hostname) |
| `'SRV'` | 服务记录 | [<Object>](http://url.nodejs.cn/jzn6Ao) | [`dnsPromises.resolveSrv()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolvesrv_hostname) |
| `'TXT'` | 文本记录 | [<string\[\]>](http://url.nodejs.cn/9Tw2bK) | [`dnsPromises.resolveTxt()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolvetxt_hostname) |

当出错时，`Promise` 使用 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 对象拒绝，其中 `err.code` 是 [DNS 错误码](http://nodejs.cn/api-v12/dns.html#dns_error_codes) 之一。

#### `dnsPromises.resolve4(hostname[, options])`[#](http://nodejs.cn/api-v12/dns.html#dnspromisesresolve4hostname-options)

[中英对照](http://nodejs.cn/api-v12/dns/dnspromises_resolve4_hostname_options.html)

新增于: v10.6.0

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK) 要解析的主机名。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `ttl` [<boolean>](http://url.nodejs.cn/jFbvuT) 检索每条记录的生存时间值 (TTL)。 当为 `true` 时，`Promise` 使用 `{ address: '1.2.3.4', ttl: 60 }` 对象数组而不是字符串数组进行解决，TTL 以秒表示。

使用域名系统协议为 `hostname` 解析 IPv4 地址（`A` 记录）。 当成功时，`Promise` 使用 IPv4 地址数值（例如 `['74.125.79.104', '74.125.79.105', '74.125.79.106']`）解决。

#### `dnsPromises.resolve6(hostname[, options])`[#](http://nodejs.cn/api-v12/dns.html#dnspromisesresolve6hostname-options)

[中英对照](http://nodejs.cn/api-v12/dns/dnspromises_resolve6_hostname_options.html)

新增于: v10.6.0

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK) 要解析的主机名。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `ttl` [<boolean>](http://url.nodejs.cn/jFbvuT) 检索每条记录的生存时间值 (TTL)。 当为 `true` 时，`Promise` 使用 `{ address: '0:1:2:3:4:5:6:7', ttl: 60 }` 对象数组而不是字符串数组进行解决，TTL 以秒表示。

使用域名系统协议为 `hostname` 解析 IPv6 地址（`AAAA` 记录）。 当成功时，`Promise` 使用 IPv6 地址数组解决。

#### `dnsPromises.resolveAny(hostname)`[#](http://nodejs.cn/api-v12/dns.html#dnspromisesresolveanyhostname)

[中英对照](http://nodejs.cn/api-v12/dns/dnspromises_resolveany_hostname.html)

新增于: v10.6.0

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK)

使用域名系统协议解析所有记录（也称为 `ANY` 或 `*` 查询）。 当成功时，`Promise` 使用包含各种类型记录的数组进行解决。 每个对象都有表示当前记录的类型的属性 `type`。 并且根据 `type`，对象上将出现其他属性：

| 类型 | 属性 |
| --- | --- |
| `'A'` | `address`/`ttl` |
| `'AAAA'` | `address`/`ttl` |
| `'CNAME'` | `value` |
| `'MX'` | 指向 [`dnsPromises.resolveMx()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolvemx_hostname) |
| `'NAPTR'` | 指向 [`dnsPromises.resolveNaptr()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolvenaptr_hostname) |
| `'NS'` | `value` |
| `'PTR'` | `value` |
| `'SOA'` | 指向 [`dnsPromises.resolveSoa()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolvesoa_hostname) |
| `'SRV'` | 指向 [`dnsPromises.resolveSrv()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolvesrv_hostname) |
| `'TXT'` | 此类型的记录包含名为 `entries` 的数组属性，它指向 [`dnsPromises.resolveTxt()`](http://nodejs.cn/api-v12/dns.html#dns_dnspromises_resolvetxt_hostname)，例如 `{ entries: ['...'], type: 'TXT' }` |

以下是结果对象的示例：

```
[ { type: 'A', address: '127.0.0.1', ttl: 299 },
  { type: 'CNAME', value: 'example.com' },
  { type: 'MX', exchange: 'alt4.aspmx.l.example.com', priority: 50 },
  { type: 'NS', value: 'ns1.example.com' },
  { type: 'TXT', entries: [ 'v=spf1 include:_spf.example.com ~all' ] },
  { type: 'SOA',
    nsname: 'ns1.example.com',
    hostmaster: 'admin.example.com',
    serial: 156696742,
    refresh: 900,
    retry: 900,
    expire: 1800,
    minttl: 60 } ]
```

#### `dnsPromises.resolveCname(hostname)`[#](http://nodejs.cn/api-v12/dns.html#dnspromisesresolvecnamehostname)

[中英对照](http://nodejs.cn/api-v12/dns/dnspromises_resolvecname_hostname.html)

新增于: v10.6.0

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK)

使用域名系统协议为 `hostname` 解析 `CNAME` 记录。 当成功时，`Promise` 使用 `hostname` 可用的规范名称记录数组（例如 `['bar.example.com']`）进行解决。

#### `dnsPromises.resolveMx(hostname)`[#](http://nodejs.cn/api-v12/dns.html#dnspromisesresolvemxhostname)

[中英对照](http://nodejs.cn/api-v12/dns/dnspromises_resolvemx_hostname.html)

新增于: v10.6.0

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK)

使用域名系统协议解析 `hostname` 的邮件交换记录（`MX` 记录）。 当成功时，`Promise` 使用包含 `priority` 和 `exchange` 属性（例如 `[{priority: 10, exchange: 'mx.example.com'}, ...]`）的对象数组进行解决。

#### `dnsPromises.resolveNaptr(hostname)`[#](http://nodejs.cn/api-v12/dns.html#dnspromisesresolvenaptrhostname)

[中英对照](http://nodejs.cn/api-v12/dns/dnspromises_resolvenaptr_hostname.html)

新增于: v10.6.0

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK)

使用域名系统协议为 `hostname` 解析基于正则表达式的记录（`NAPTR` 记录）。 当成功时，`Promise` 使用具有以下属性的对象数组进行解决：

-   `flags`
-   `service`
-   `regexp`
-   `replacement`
-   `order`
-   `preference`

```
{
  flags: 's',
  service: 'SIP+D2U',
  regexp: '',
  replacement: '_sip._udp.example.com',
  order: 30,
  preference: 100
}
```

#### `dnsPromises.resolveNs(hostname)`[#](http://nodejs.cn/api-v12/dns.html#dnspromisesresolvenshostname)

[中英对照](http://nodejs.cn/api-v12/dns/dnspromises_resolvens_hostname.html)

新增于: v10.6.0

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK)

使用域名系统协议为 `hostname` 解析名称服务器记录（`NS` 记录）。 当成功时，`Promise` 使用可用于 `hostname` 的名称服务器记录数组（例如 `['ns1.example.com', 'ns2.example.com']`）进行解决。

#### `dnsPromises.resolvePtr(hostname)`[#](http://nodejs.cn/api-v12/dns.html#dnspromisesresolveptrhostname)

[中英对照](http://nodejs.cn/api-v12/dns/dnspromises_resolveptr_hostname.html)

新增于: v10.6.0

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK)

使用域名系统协议解析 `hostname` 的指针记录（`PTR` 记录）。 当成功时，`Promise` 使用包含回复记录的字符串数组进行解决。

#### `dnsPromises.resolveSoa(hostname)`[#](http://nodejs.cn/api-v12/dns.html#dnspromisesresolvesoahostname)

[中英对照](http://nodejs.cn/api-v12/dns/dnspromises_resolvesoa_hostname.html)

新增于: v10.6.0

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK)

使用域名系统协议来解析 `hostname` 的起始规范记录（`SOA` 记录）。 当成功时，`Promise` 使用具有以下属性的对象进行解决：

-   `nsname`
-   `hostmaster`
-   `serial`
-   `refresh`
-   `retry`
-   `expire`
-   `minttl`

```
{
  nsname: 'ns.example.com',
  hostmaster: 'root.example.com',
  serial: 2013101809,
  refresh: 10000,
  retry: 2400,
  expire: 604800,
  minttl: 3600
}
```

#### `dnsPromises.resolveSrv(hostname)`[#](http://nodejs.cn/api-v12/dns.html#dnspromisesresolvesrvhostname)

[中英对照](http://nodejs.cn/api-v12/dns/dnspromises_resolvesrv_hostname.html)

新增于: v10.6.0

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK)

使用域名系统协议解析 `hostname` 的服务记录（`SRV` 记录）。 当成功时，`Promise` 使用具有以下属性的对象数组进行解决：

-   `priority`
-   `weight`
-   `port`
-   `name`

```
{
  priority: 10,
  weight: 5,
  port: 21223,
  name: 'service.example.com'
}
```

#### `dnsPromises.resolveTxt(hostname)`[#](http://nodejs.cn/api-v12/dns.html#dnspromisesresolvetxthostname)

[中英对照](http://nodejs.cn/api-v12/dns/dnspromises_resolvetxt_hostname.html)

新增于: v10.6.0

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK)

使用域名系统协议为 `hostname` 解析文本查询（`TXT` 记录）。 当成功时，`Promise` 使用可用于 `hostname`（例如 `[ ['v=spf1 ip4:0.0.0.0 ', '~all' ] ]`）的文本记录的二维数组进行解决。 每个子数组包含一条记录的 TXT 块。 根据用例，这些可以连接在一起或单独处理。

#### `dnsPromises.reverse(ip)`[#](http://nodejs.cn/api-v12/dns.html#dnspromisesreverseip)

[中英对照](http://nodejs.cn/api-v12/dns/dnspromises_reverse_ip.html)

新增于: v10.6.0

-   `ip` [<string>](http://url.nodejs.cn/9Tw2bK)

执行反向域名系统查询，将 IPv4 或 IPv6 地址解析为主机名数组。

当出错时，`Promise` 使用 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 对象拒绝，其中 `err.code` 是 [DNS 错误码](http://nodejs.cn/api-v12/dns.html#dns_error_codes) 之一。

#### `dnsPromises.setServers(servers)`[#](http://nodejs.cn/api-v12/dns.html#dnspromisessetserversservers)

[中英对照](http://nodejs.cn/api-v12/dns/dnspromises_setservers_servers.html)

新增于: v10.6.0

-   `servers` [<string\[\]>](http://url.nodejs.cn/9Tw2bK) [RFC 5952](http://url.nodejs.cn/jzbgfM) 格式的地址数组

设置执行 DNS 解析时要使用的服务器的 IP 地址和端口。 `servers` 参数是 [RFC 5952](http://url.nodejs.cn/jzbgfM) 格式的地址数组。 如果端口是 IANA 默认 DNS 端口 (53)，则可以省略。

```
dnsPromises.setServers([
  '4.4.4.4',
  '[2001:4860:4860::8888]',
  '4.4.4.4:1053',
  '[2001:4860:4860::8888]:1053'
]);
```

如果提供的地址无效，则会抛出错误。

在进行域名系统查询时不得调用 `dnsPromises.setServers()` 方法。

此方法的工作方式与 [resolve.conf](http://url.nodejs.cn/azKRAV) 非常相似。 也就是说，如果尝试使用提供的第一个服务器进行解析导致 `NOTFOUND` 错误，则 `resolve()` 方法将不会尝试使用提供的后续服务器进行解析。 仅当较早的域名系统服务器超时或导致其他错误时，才会使用后备域名系统服务器。

### 错误码[#](http://nodejs.cn/api-v12/dns.html#error-codes)

[中英对照](http://nodejs.cn/api-v12/dns/error_codes.html)

每个域名系统查询都可以返回以下错误代码之一：

-   `dns.NODATA`: 域名系统服务器返回没有数据的答案。
-   `dns.FORMERR`: 域名系统服务器声称查询格式错误。
-   `dns.SERVFAIL`: 域名系统服务器返回一般故障。
-   `dns.NOTFOUND`: 未找到域名。
-   `dns.NOTIMP`: 域名系统服务器未执行请求的操作。
-   `dns.REFUSED`: 域名系统服务器拒绝查询。
-   `dns.BADQUERY`: 域名系统查询格式错误。
-   `dns.BADNAME`: 主机名格式错误。
-   `dns.BADFAMILY`: 不支持的地址族。
-   `dns.BADRESP`: DNS 回复格式错误。
-   `dns.CONNREFUSED`: 无法联系域名系统服务器。
-   `dns.TIMEOUT`: 联系域名系统服务器时超时。
-   `dns.EOF`: 文件结束。
-   `dns.FILE`: 读取文件时出错。
-   `dns.NOMEM`: 内存不足。
-   `dns.DESTRUCTION`: 渠道正在被销毁。
-   `dns.BADSTR`: 格式错误的字符串。
-   `dns.BADFLAGS`: 指定了非法标志。
-   `dns.NONAME`: 给定的主机名不是数字。
-   `dns.BADHINTS`: 指定了非法提示标志。
-   `dns.NOTINITIALIZED`: c-ares 库初始化尚未执行。
-   `dns.LOADIPHLPAPI`: 加载 `iphlpapi.dll` 时出错。
-   `dns.ADDRGETNETWORKPARAMS`: 找不到 `GetNetworkParams` 函数。
-   `dns.CANCELLED`: 域名系统查询已取消。

### 实现的注意事项[#](http://nodejs.cn/api-v12/dns.html#implementation-considerations)

[中英对照](http://nodejs.cn/api-v12/dns/implementation_considerations.html)

尽管 [`dns.lookup()`](http://nodejs.cn/api-v12/dns.html#dns_dns_lookup_hostname_options_callback) 和各种 `dns.resolve*()/dns.reverse()` 函数具有将网络名称与网络地址相关联的相同目标（反之亦然），但它们的行为却大不相同。 这些差异可能会对 Node.js 程序的行为产生微妙但重要的影响。

#### `dns.lookup()`[#](http://nodejs.cn/api-v12/dns.html#dnslookup)

[中英对照](http://nodejs.cn/api-v12/dns/dns_lookup.html)

在幕后，[`dns.lookup()`](http://nodejs.cn/api-v12/dns.html#dns_dns_lookup_hostname_options_callback) 使用与大多数其他程序相同的操作系统设施。 例如，[`dns.lookup()`](http://nodejs.cn/api-v12/dns.html#dns_dns_lookup_hostname_options_callback) 几乎总是以与 `ping` 命令相同的方式解析给定名称。 在大多数类似 POSIX 的操作系统上，可以通过更改 [`nsswitch.conf(5)`](http://url.nodejs.cn/ZSVJkK) 和/或 [`resolv.conf(5)`](http://url.nodejs.cn/H73V97) 中的设置来修改 [`dns.lookup()`](http://nodejs.cn/api-v12/dns.html#dns_dns_lookup_hostname_options_callback) 函数的行为，但更改这些文件将更改在同一操作系统上运行的所有其他程序的行为。

尽管对 `dns.lookup()` 的调用从 JavaScript 的角度来看是异步的，但它被实现为对运行在 libuv 线程池上的 [`getaddrinfo(3)`](http://url.nodejs.cn/wNCF2x) 的同步调用。 这可能会对某些应用程序产生令人惊讶的负面性能影响，有关更多信息，请参阅 [`UV_THREADPOOL_SIZE`](http://nodejs.cn/api-v12/cli.html#cli_uv_threadpool_size_size) 文档。

各种网络 API 将在内部调用 `dns.lookup()` 来解析主机名。 如果这是一个问题，则考虑使用 `dns.resolve()` 并使用地址而不是主机名将主机名解析为地址。 此外，某些网络 API（例如 [`socket.connect()`](http://nodejs.cn/api-v12/net.html#net_socket_connect_options_connectlistener) 和 [`dgram.createSocket()`](http://nodejs.cn/api-v12/dgram.html#dgram_dgram_createsocket_options_callback)）允许替换默认解析器 `dns.lookup()`。

#### dns.resolve()、dns.resolve\*() 与 dns.reverse()[#](http://nodejs.cn/api-v12/dns.html#dnsresolve-dnsresolve-and-dnsreverse)

[中英对照](http://nodejs.cn/api-v12/dns/dns_resolve_dns_resolve_and_dns_reverse.html)

这些函数的实现与 [`dns.lookup()`](http://nodejs.cn/api-v12/dns.html#dns_dns_lookup_hostname_options_callback) 完全不同。 它们不使用 [`getaddrinfo(3)`](http://url.nodejs.cn/wNCF2x)，其总是在网络上执行域名系统查询。 这种网络通信总是异步完成的，不使用 libuv 的线程池。

因此，这些函数不会对发生在 libuv 线程池上的其他处理产生与 [`dns.lookup()`](http://nodejs.cn/api-v12/dns.html#dns_dns_lookup_hostname_options_callback) 相同的负面影响。

它们使用的配置文件集与 [`dns.lookup()`](http://nodejs.cn/api-v12/dns.html#dns_dns_lookup_hostname_options_callback) 使用的配置文件集不同。 例如，它们不使用 `/etc/hosts` 的配置。
