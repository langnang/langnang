---
created: 2022-07-29T13:12:54 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/tls.html
author: #
---

# tls 安全传输层 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/tls/tls_ssl.html)

**源代码:** [lib/tls.js](https://github.com/nodejs/node/blob/v12.22.12/lib/tls.js)

`tls` 模块提供了构建在 OpenSSL 之上的传输层安全 (TLS) 和安全套接字层 (SSL) 协议的实现。 该模块可以使用以下方式访问：

```
const tls = require('tls');
```

### TLS/SSL 概念[#](http://nodejs.cn/api-v12/tls.html#tlsssl-concepts)

[中英对照](http://nodejs.cn/api-v12/tls/tls_ssl_concepts.html)

TLS/SSL 是公钥/私钥基础结构 (PKI)。 对于最常见的情况，每个客户端和服务器都必须有_私钥_。

可以通过多种方式生成私钥。 以下示例说明了使用 OpenSSL 命令行界面生成 2048 位 RSA 私钥：

```
openssl genrsa -out ryans-key.pem 2048
```

使用 TLS/SSL，所有服务器（和一些客户端）都必须有_证书_。 证书是与私钥相对应的_公钥_，并且由证书颁发机构或私钥的所有者进行数字签名（此类证书称为“自签名”）。 获取证书的第一步是创建_证书签名请求_（CSR）文件。

OpenSSL 命令行界面可用于为私钥生成 CSR：

```
openssl req -new -sha256 -key ryans-key.pem -out ryans-csr.pem
```

一旦生成 CSR 文件，则它可以发送到证书颁发机构进行签名或用于生成自签名证书。

使用 OpenSSL 命令行界面创建自签名证书如以下示例所示：

```
openssl x509 -req -in ryans-csr.pem -signkey ryans-key.pem -out ryans-cert.pem
```

生成证书后，可用于生成 `.pfx` 或 `.p12` 文件：

```
openssl pkcs12 -export -in ryans-cert.pem -inkey ryans-key.pem \
      -certfile ca-cert.pem -out ryans.pfx
```

在哪里：

-   `in`: 是签名的证书
-   `inkey`: 是关联的私钥
-   `certfile`: 是将所有证书颁发机构 (CA) 证书串联到一个文件中，例如 `cat ca1-cert.pem ca2-cert.pem > ca-cert.pem`

#### 完美前向保密[#](http://nodejs.cn/api-v12/tls.html#perfect-forward-secrecy)

[中英对照](http://nodejs.cn/api-v12/tls/perfect_forward_secrecy.html)

术语 _[前向保密](http://url.nodejs.cn/wybzZg)_ 或 _完美前向保密_ 描述了密钥协议（即密钥交换）方法的一个特征。 也就是说，服务器和客户端密钥用于协商新的临时密钥，这些密钥专门用于且仅用于当前通信会话。 实际上，这意味着即使服务器的私钥被泄露，如果攻击者设法获得专门为会话生成的密钥对，通信也只能被窃听者解密。

完美前向保密是通过在每次 TLS/SSL 握手时随机生成密钥对的密钥对来实现的（与对所有会话使用相同的密钥相反）。 实现这种技术的方法被称为"临时"。

目前常用两种方法来实现完美前向保密（注意繁体缩写后的字符 "E"）：

-   [DHE](http://url.nodejs.cn/iDZV96): Diffie-Hellman 密钥协议的临时版本。
-   [ECDHE](http://url.nodejs.cn/p9zTGn): 椭圆曲线 Diffie-Hellman 密钥协议的临时版本。

临时方法可能有一些性能缺陷，因为密钥生成很昂贵。

要使用 `DHE` 和 `tls` 模块使用完美前向保密，需要生成 Diffie-Hellman 参数并使用 `dhparam` 选项指定它们到 [`tls.createSecureContext()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createsecurecontext_options)。 以下说明使用 OpenSSL 命令行界面生成此类参数：

```
openssl dhparam -outform PEM -out dhparam.pem 2048
```

如果使用 `ECDHE` 使用完美前向保密，则不需要 Diffie-Hellman 参数，将使用默认 ECDHE 曲线。 创建 TLS 服务器时可以使用 `ecdhCurve` 属性来指定要使用的受支持曲线的名称列表，有关详细信息，请参阅 [`tls.createServer()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createserver_options_secureconnectionlistener)。

完美前向保密在 TLSv1.2 之前是可选的，但它对于 TLSv1.3 不是可选的，因为所有 TLSv1.3 密码套件都使用 ECDHE。

#### ALPN 和 SNI[#](http://nodejs.cn/api-v12/tls.html#alpn-and-sni)

[中英对照](http://nodejs.cn/api-v12/tls/alpn_and_sni.html)

ALPN（应用层协议协商扩展）和 SNI（服务器名称指示）是 TLS 握手扩展：

-   ALPN: 允许将 TLS 服务器用于多种协议（HTTP，HTTP/2）
-   SNI: 允许将 TLS 服务器用于具有不同 SSL 证书的多个主机名。

#### 预共享的密钥[#](http://nodejs.cn/api-v12/tls.html#pre-shared-keys)

[中英对照](http://nodejs.cn/api-v12/tls/pre_shared_keys.html)

TLS-PSK 支持可作为普通基于证书的身份验证的替代方法。 它使用预共享密钥而不是证书来验证 TLS 连接，提供相互验证。 TLS-PSK 和公钥基础设施并不相互排斥。 客户端和服务器可以同时容纳两者，在正常的密码协商步骤中选择它们中的任何一个。

TLS-PSK 只是一个不错的选择，因为存在与每台连接机器安全共享密钥的方法，因此它不会取代大多数 TLS 使用的 PKI（公钥基础设施）。 OpenSSL 中的 TLS-PSK 实现近年来出现了许多安全漏洞，主要是因为它仅被少数应用程序使用。 在切换到 PSK 密码之前，请考虑所有替代解决方案。 在生成 PSK 时，使用 [RFC 4086](http://url.nodejs.cn/qw1PMn) 中讨论的足够熵至关重要。 从密码或其他低熵来源导出共享秘密是不安全的。

默认情况下禁用 PSK 密码，因此使用 TLS-PSK 需要使用 `ciphers` 选项明确指定密码套件。 可用密码列表可以通过 `openssl ciphers -v 'PSK'` 检索。 所有 TLS 1.3 密码都有资格使用 PSK，但目前仅支持使用 SHA256 摘要的密码，它们可以通过 `openssl ciphers -v -s -tls1_3 -psk` 检索。

根据 [RFC 4279](http://url.nodejs.cn/Gq5awY)，必须支持最长 128 个字节的 PSK 标识和最长 64 个字节的 PSK。 从 OpenSSL 1.1.0 开始，最大身份大小为 128 字节，最大 PSK 长度为 256 字节。

由于底层 OpenSSL API 的限制，当前的实现不支持异步 PSK 回调。

#### 客户端发起的重协商攻击缓解[#](http://nodejs.cn/api-v12/tls.html#client-initiated-renegotiation-attack-mitigation)

[中英对照](http://nodejs.cn/api-v12/tls/client_initiated_renegotiation_attack_mitigation.html)

TLS 协议允许客户端重新协商 TLS 会话的某些方面。 不幸的是，会话重新协商需要不成比例的服务器端资源，使其成为拒绝服务攻击的潜在载体。

为了降低风险，每十分钟重新协商的次数限制为 3 次。 当超过此阈值时，[`tls.TLSSocket`](http://nodejs.cn/api-v12/tls.html#tls_class_tls_tlssocket) 实例上会触发 `'error'` 事件。 限制是可配置的：

-   `tls.CLIENT_RENEG_LIMIT` [<number>](http://url.nodejs.cn/SXbo1v) 指定重新协商请求的数量。 **默认值:** `3`。
-   `tls.CLIENT_RENEG_WINDOW` [<number>](http://url.nodejs.cn/SXbo1v) 指定时间重新协商窗口（以秒为单位）。 **默认值:** `600` （10分钟）。

在没有充分了解影响和风险的情况下，不应修改默认的重新协商限制。

TLSv1.3 不支持重新协商。

#### 会话恢复[#](http://nodejs.cn/api-v12/tls.html#session-resumption)

[中英对照](http://nodejs.cn/api-v12/tls/session_resumption.html)

建立 TLS 会话可能相对较慢。 可以通过保存并稍后重用会话状态来加快进程。 有几种机制可以做到这一点，这里从最旧到最新（和首选）进行了讨论。

##### 会话标识符[#](http://nodejs.cn/api-v12/tls.html#session-identifiers)

[中英对照](http://nodejs.cn/api-v12/tls/session_identifiers.html)

服务器为新连接生成唯一的 ID 并将其发送给客户端。 客户端和服务器保存会话状态。 当重新连接时，客户端发送其保存的会话状态的 ID，如果服务器也有该 ID 的状态，它可以同意使用它。 否则，服务器将创建新的会话。 请参阅 [RFC 2246](http://url.nodejs.cn/uEXxgB) 了解更多信息，第 23 和 30 页。

当发出 HTTPS 请求时，大多数网络浏览器都支持使用会话标识符恢复。

对于 Node.js，客户端等待 [`'session'`](http://nodejs.cn/api-v12/tls.html#tls_event_session) 事件获取会话数据，并将数据提供给后续 [`tls.connect()`](http://nodejs.cn/api-v12/tls.html#tls_tls_connect_options_callback) 的 `session` 选项以重用会话。 服务器必须为 [`'newSession'`](http://nodejs.cn/api-v12/tls.html#tls_event_newsession) 和 [`'resumeSession'`](http://nodejs.cn/api-v12/tls.html#tls_event_resumesession) 事件实现句柄，以使用会话 ID 作为查找键来保存和恢复会话数据以重用会话。 要在负载均衡器或集群工作器之间重用会话，服务器必须在其会话处理程序中使用共享会话缓存（例如 Redis）。

##### 会话票证[#](http://nodejs.cn/api-v12/tls.html#session-tickets)

[中英对照](http://nodejs.cn/api-v12/tls/session_tickets.html)

服务器加密整个会话状态并将其作为"票证"发送给客户端。 当重新连接时，在初始连接时将状态发送到服务器。 这种机制避免了服务器端会话缓存的需要。 如果服务器不使用票证，出于任何原因（无法解密、太旧等），则它将创建新的会话并发送新的票证。 请参阅 [RFC 5077](http://url.nodejs.cn/ZpmZTP) 了解更多信息。

当发出 HTTPS 请求时，许多网络浏览器普遍支持使用会话票证恢复。

对于 Node.js，客户端使用相同的 API 来恢复会话标识符和恢复会话票证。 用于调试，如果 [`tls.TLSSocket.getTLSTicket()`](http://nodejs.cn/api-v12/tls.html#tls_tlssocket_gettlsticket) 返回值，则会话数据包含票证，否则包含客户端会话状态。

使用 TLSv1.3，请注意服务器可能会发送多个票证，从而导致多个 `'session'` 事件，请参阅 [`'session'`](http://nodejs.cn/api-v12/tls.html#tls_event_session) 了解更多信息。

单进程服务器不需要特定的实现来使用会话票证。 要在服务器重新启动或负载平衡器之间使用会话票证，服务器必须都具有相同的票证密钥。 内部有三个 16 字节的密钥，但 tls API 为方便起见将它们公开为单个 48 字节的缓冲区。

可以通过在一个服务器实例上调用 [`server.getTicketKeys()`](http://nodejs.cn/api-v12/tls.html#tls_server_getticketkeys) 来获取票证密钥然后分发它们，但是安全地生成 48 字节的安全随机数据并使用 [`tls.createServer()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createserver_options_secureconnectionlistener) 的 `ticketKeys` 选项设置它们更合理。 应该定期重新生成密钥，并且可以使用 [`server.setTicketKeys()`](http://nodejs.cn/api-v12/tls.html#tls_server_setticketkeys_keys) 重置服务器的密钥。

会话票证密钥是加密密钥，它们_**必须安全存储**_。 使用 TLS 1.2 及更低版本，如果它们被泄露，所有使用用它们加密的票证的会话都可以解密。 它们不应该存储在磁盘上，应该定期重新生成。

如果客户端宣传支持票证，则服务器将发送它们。 服务器可以通过在 `secureOptions` 中提供 `require('constants').SSL_OP_NO_TICKET` 来禁用票证。

会话标识符和会话票证都超时，导致服务器创建新会话。 超时时间可以用 [`tls.createServer()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createserver_options_secureconnectionlistener) 的 `sessionTimeout` 选项配置。

对于所有机制，当恢复失败时，服务器将创建新会话。 由于无法恢复会话不会导致 TLS/HTTPS 连接失败，所以很容易不会注意到 TLS 性能不必要的糟糕。 OpenSSL CLI 可用于验证服务器是否正在恢复会话。 使用 `-reconnect` 选项到 `openssl s_client`，例如：

```
$ openssl s_client -connect localhost:443 -reconnect
```

通过调试输出读取。 第一个连接应该说 "New"，例如：

```
New, TLSv1.2, Cipher is ECDHE-RSA-AES128-GCM-SHA256
```

后续连接应该说 "Reused"，例如：

```
Reused, TLSv1.2, Cipher is ECDHE-RSA-AES128-GCM-SHA256
```

### 修改默认的 TLS 加密组件[#](http://nodejs.cn/api-v12/tls.html#modifying-the-default-tls-cipher-suite)

[中英对照](http://nodejs.cn/api-v12/tls/modifying_the_default_tls_cipher_suite.html)

Node.js 是使用默认的启用和禁用 TLS 密码套件构建的。 这个默认密码列表可以在构建 Node.js 时配置，以允许发行版提供自己的默认列表。

以下命令可用于显示默认密码套件：

```
node -p crypto.constants.defaultCoreCipherList | tr ':' '\n'
TLS_AES_256_GCM_SHA384
TLS_CHACHA20_POLY1305_SHA256
TLS_AES_128_GCM_SHA256
ECDHE-RSA-AES128-GCM-SHA256
ECDHE-ECDSA-AES128-GCM-SHA256
ECDHE-RSA-AES256-GCM-SHA384
ECDHE-ECDSA-AES256-GCM-SHA384
DHE-RSA-AES128-GCM-SHA256
ECDHE-RSA-AES128-SHA256
DHE-RSA-AES128-SHA256
ECDHE-RSA-AES256-SHA384
DHE-RSA-AES256-SHA384
ECDHE-RSA-AES256-SHA256
DHE-RSA-AES256-SHA256
HIGH
!aNULL
!eNULL
!EXPORT
!DES
!RC4
!MD5
!PSK
!SRP
!CAMELLIA
```

例如，以下使 `ECDHE-RSA-AES128-GCM-SHA256:!RC4` 成为默认的 TLS 密码套件：

```
node --tls-cipher-list='ECDHE-RSA-AES128-GCM-SHA256:!RC4' server.js

export NODE_OPTIONS=--tls-cipher-list='ECDHE-RSA-AES128-GCM-SHA256:!RC4'
node server.js
```

也可以使用 [`tls.createSecureContext()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createsecurecontext_options) 中的 `ciphers` 选项在每个客户端或服务器的基础上替换默认值，该选项在 [`tls.createServer()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createserver_options_secureconnectionlistener)、[`tls.connect()`](http://nodejs.cn/api-v12/tls.html#tls_tls_connect_options_callback) 和创建新的 [`tls.TLSSocket`](http://nodejs.cn/api-v12/tls.html#tls_class_tls_tlssocket) 时也可用。

密码列表可以包含 TLSv1.3 密码套件名称、以 `'TLS_'` 开头的名称以及 TLSv1.2 及以下密码套件的规范的混合。 TLSv1.2 密码支持旧规范格式，有关详细信息，请参阅 OpenSSL [密码列表格式](http://url.nodejs.cn/XcPHdc)文档，但这些规范_不_适用于 TLSv1.3 密码。 TLSv1.3 套件只能通过在密码列表中包含其全名来启用。 例如，不能使用旧版 TLSv1.2 `'EECDH'` 或 `'!EECDH'` 规范启用或禁用它们。

尽管 TLSv1.3 和 TLSv1.2 密码套件的相对顺序不同，但 TLSv1.3 协议比 TLSv1.2 安全得多，如果握手表明它受支持，并且如果有的话，总是会被选择而不是 TLSv1.2 TLSv1.3 密码套件已启用。

Node.js 中包含的默认密码套件经过精心挑选，以反映当前的安全最佳实践和风险缓解。 更改默认密码套件会对应用程序的安全性产生重大影响。 只有在绝对必要时才应使用 `--tls-cipher-list` 开关和 `ciphers` 选项。

默认密码套件更喜欢 [Chrome 的‘现代密码学’设置](http://url.nodejs.cn/phZkVM)的 GCM 密码，并且还更喜欢 ECDHE 和 DHE 密码以实现完美的前向保密，同时提供一些向后兼容性。

鉴于[影响更大 AES 密钥大小的特定攻击](http://url.nodejs.cn/Ai7HeQ)，128 位 AES 优于 192 位和 256 位 AES。

依赖不安全且不推荐使用的 RC4 或基于 DES 的密码（如 Internet Explorer 6）的旧客户端无法使用默认配置完成握手过程。 如果必须支持这些客户端，则 [TLS 建议](http://url.nodejs.cn/PLgT7T)可能会提供兼容的密码套件。 有关格式的更多详细信息，请参阅 OpenSSL [密码列表格式](http://url.nodejs.cn/XcPHdc)文档。

只有 5 个 TLSv1.3 密码套件：

-   `'TLS_AES_256_GCM_SHA384'`
-   `'TLS_CHACHA20_POLY1305_SHA256'`
-   `'TLS_AES_128_GCM_SHA256'`
-   `'TLS_AES_128_CCM_SHA256'`
-   `'TLS_AES_128_CCM_8_SHA256'`

默认启用前 3 个。 TLSv1.3 支持最后 2 个基于 `CCM` 的套件，因为它们在受限系统上的性能可能更高，但默认情况下未启用它们，因为它们提供的安全性较低。

### `tls.CryptoStream` 类[#](http://nodejs.cn/api-v12/tls.html#class-tlscryptostream)

[中英对照](http://nodejs.cn/api-v12/tls/class_tls_cryptostream.html)

新增于: v0.3.4弃用于: v0.11.3

`tls.CryptoStream` 类表示加密数据流。 此类已弃用，不应再使用。

#### `cryptoStream.bytesWritten`[#](http://nodejs.cn/api-v12/tls.html#cryptostreambyteswritten)

[中英对照](http://nodejs.cn/api-v12/tls/cryptostream_byteswritten.html)

新增于: v0.3.4弃用于: v0.11.3

`cryptoStream.bytesWritten` 属性返回写入底层套接字的总字节数_包括_实现 TLS 协议所需的字节数。

### `tls.SecurePair` 类[#](http://nodejs.cn/api-v12/tls.html#class-tlssecurepair)

[中英对照](http://nodejs.cn/api-v12/tls/class_tls_securepair.html)

新增于: v0.3.2弃用于: v0.11.3

由 [`tls.createSecurePair()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createsecurepair_context_isserver_requestcert_rejectunauthorized_options) 返回。

#### `'secure'` 事件[#](http://nodejs.cn/api-v12/tls.html#event-secure)

[中英对照](http://nodejs.cn/api-v12/tls/event_secure.html)

新增于: v0.3.2弃用于: v0.11.3

一旦建立了安全连接，则 `SecurePair` 对象就会触发 `'secure'` 事件。

与检查服务器 [`'secureConnection'`](http://nodejs.cn/api-v12/tls.html#tls_event_secureconnection) 事件一样，应检查 `pair.cleartext.authorized` 以确认使用的证书是否已正确授权。

### `tls.Server` 类[#](http://nodejs.cn/api-v12/tls.html#class-tlsserver)

[中英对照](http://nodejs.cn/api-v12/tls/class_tls_server.html)

新增于: v0.3.2

-   继承自: [<net.Server>](http://nodejs.cn/api/net.html#class-netserver)

接受使用 TLS 或 SSL 的加密连接。

#### `'connection'` 事件[#](http://nodejs.cn/api-v12/tls.html#event-connection)

[中英对照](http://nodejs.cn/api-v12/tls/event_connection.html)

新增于: v0.3.2

-   `socket` [<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex)

此事件在建立新的 TCP 流时触发，在 TLS 握手开始之前。 `socket` 通常是 [`net.Socket`](http://nodejs.cn/api-v12/net.html#net_class_net_socket) 类型的对象。 通常用户不会想访问这个事件。

此事件也可以由用户显式地触发以将连接注入 TLS 服务器。 在这种情况下，任何 [`Duplex`](http://nodejs.cn/api-v12/stream.html#stream_class_stream_duplex) 流都可以通过。

#### `'keylog'` 事件[#](http://nodejs.cn/api-v12/tls.html#event-keylog)

[中英对照](http://nodejs.cn/api-v12/tls/event_keylog.html)

新增于: v12.3.0

-   `line` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) ASCII 文本行，采用 NSS `SSLKEYLOGFILE` 格式。
-   `tlsSocket` [<tls.TLSSocket>](http://nodejs.cn/api/tls.html#class-tlstlssocket) 生成它的 `tls.TLSSocket` 实例。

`keylog` 事件在生成或通过与此服务器的连接接收密钥材料时触发（通常在握手完成之前，但不一定）。 该密钥材料可以存储用于调试，因为它允许对捕获的 TLS 流量进行解密。 它可以为每个套接字多次触发。

一个典型的用例是将接收到的行附加到公共文本文件中，稍后软件（例如 Wireshark）使用它来解密流量：

```
const logFile = fs.createWriteStream('/tmp/ssl-keys.log', { flags: 'a' });
// ...
server.on('keylog', (line, tlsSocket) => {
  if (tlsSocket.remoteAddress !== '...')
    return; // 仅记录特定 IP 的密钥
  logFile.write(line);
});
```

#### `'newSession'` 事件[#](http://nodejs.cn/api-v12/tls.html#event-newsession)

[中英对照](http://nodejs.cn/api-v12/tls/event_newsession.html)

在创建新的 TLS 会话时触发 `'newSession'` 事件。 这可用于在外部存储中存储会话。 数据应该提供给 [`'resumeSession'`](http://nodejs.cn/api-v12/tls.html#tls_event_resumesession) 回调。

监听器回调在调用时传入三个参数：

-   `sessionId` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) TLS 会话标识符
-   `sessionData` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) TLS 会话数据
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 回调函数不带参数，必须调用这些参数才能通过安全连接发送或接收数据。

监听此事件只会对添加事件监听器后建立的连接有影响。

#### `'OCSPRequest'` 事件[#](http://nodejs.cn/api-v12/tls.html#event-ocsprequest)

[中英对照](http://nodejs.cn/api-v12/tls/event_ocsprequest.html)

新增于: v0.11.13

当客户端发送证书状态请求时会触发 `'OCSPRequest'` 事件。 监听器回调在调用时传入三个参数：

-   `certificate` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 服务器证书
-   `issuer` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 发行人证书
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 必须调用的回调函数来提供 OCSP 请求的结果。

可以解析服务器当前的证书，获取 OCSP URL 和证书 ID；获取 OCSP 响应后，再调用 `callback(null, resp)`，其中 `resp` 是包含 OCSP 响应的 `Buffer` 实例。 `certificate` 和 `issuer` 都是主证书和颁发者证书的 `Buffer` DER 表示。 这些可用于获取 OCSP 证书 ID 和 OCSP 端点 URL。

或者，可以调用 `callback(null, null)`，表示没有 OCSP 响应。

调用 `callback(err)` 将导致调用 `socket.destroy(err)`。

OCSP 请求的典型流程如下：

1.  客户端连接到服务器并发送 `'OCSPRequest'`（通过 ClientHello 中的状态信息扩展）。
2.  服务器收到请求并触发 `'OCSPRequest'` 事件，如果已注册则调用监听器。
3.  服务器从 `certificate` 或 `issuer` 中提取 OCSP URL，并向 CA 执行 [OCSP 请求](http://url.nodejs.cn/ughRFP)。
4.  服务器从 CA 接收 `'OCSPResponse'` 并通过 `callback` 参数将其发送回客户端
5.  客户端验证响应并销毁套接字或执行握手。

如果证书是自签名证书或颁发者不在根证书列表中，则 `issuer` 可以是 `null`。 （在建立 TLS 连接时可以通过 `ca` 选项提供颁发者。）

监听此事件只会对添加事件监听器后建立的连接有影响。

像 [asn1.js](http://url.nodejs.cn/2C7nRg) 这样的 npm 模块可用于解析证书。

#### `'resumeSession'` 事件[#](http://nodejs.cn/api-v12/tls.html#event-resumesession)

[中英对照](http://nodejs.cn/api-v12/tls/event_resumesession.html)

新增于: v0.9.2

当客户端请求恢复之前的 TLS 会话时，则会触发 `'resumeSession'` 事件。 监听器回调在调用时传入两个参数：

-   `sessionId` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) TLS 会话标识符
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 恢复前一个会话时要调用的回调函数：`callback([err[, sessionData]])`
    -   `err` [<Error>](http://url.nodejs.cn/qZ873x)
    -   `sessionData` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

事件监听器应该使用给定的 `sessionId` 在外部存储中为 [`'newSession'`](http://nodejs.cn/api-v12/tls.html#tls_event_newsession) 事件处理程序保存的 `sessionData` 执行查找。 如果找到，则调用 `callback(null, sessionData)` 恢复会话。 如果没有找到，则会话将无法恢复。 `callback()` 必须在没有 `sessionData` 的情况下被调用，以便握手可以继续并可以创建新的会话。 可以调用 `callback(err)` 来终止传入的连接并销毁套接字。

监听此事件只会对添加事件监听器后建立的连接有影响。

以下说明恢复 TLS 会话：

```
const tlsSessionStore = {};
server.on('newSession', (id, data, cb) => {
  tlsSessionStore[id.toString('hex')] = data;
  cb();
});
server.on('resumeSession', (id, cb) => {
  cb(null, tlsSessionStore[id.toString('hex')] || null);
});
```

#### `'secureConnection'` 事件[#](http://nodejs.cn/api-v12/tls.html#event-secureconnection)

[中英对照](http://nodejs.cn/api-v12/tls/event_secureconnection.html)

新增于: v0.3.2

`'secureConnection'` 事件在新连接的握手过程成功完成后触发。 监听器回调在调用时传入一个参数：

-   `tlsSocket` [<tls.TLSSocket>](http://nodejs.cn/api/tls.html#class-tlstlssocket) 已建立的 TLS 套接字。

`tlsSocket.authorized` 属性是一个 `boolean`，指示客户端是否已通过服务器提供的证书颁发机构之一进行验证。 如果 `tlsSocket.authorized` 为 `false`，则设置 `socket.authorizationError` 来描述授权失败的方式。 根据 TLS 服务器的设置，可能仍会接受未经授权的连接。

`tlsSocket.alpnProtocol` 属性是包含所选 ALPN 协议的字符串。 当 ALPN 没有选择协议时，则 `tlsSocket.alpnProtocol` 等于 `false`。

`tlsSocket.servername` 属性是包含通过 SNI 请求的服务器名称的字符串。

#### `'tlsClientError'` 事件[#](http://nodejs.cn/api-v12/tls.html#event-tlsclienterror)

[中英对照](http://nodejs.cn/api-v12/tls/event_tlsclienterror.html)

新增于: v6.0.0

在建立安全连接之前发生错误时会触发 `'tlsClientError'` 事件。 监听器回调在调用时传入两个参数：

-   `exception` [<Error>](http://url.nodejs.cn/qZ873x) 描述错误的 `Error` 对象
-   `tlsSocket` [<tls.TLSSocket>](http://nodejs.cn/api/tls.html#class-tlstlssocket) 错误源自的 `tls.TLSSocket` 实例。

#### `server.addContext(hostname, context)`[#](http://nodejs.cn/api-v12/tls.html#serveraddcontexthostname-context)

[中英对照](http://nodejs.cn/api-v12/tls/server_addcontext_hostname_context.html)

新增于: v0.5.3

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK) SNI 主机名或通配符（例如 `'*'`）
-   `context` [<Object>](http://url.nodejs.cn/jzn6Ao) 包含来自 [`tls.createSecureContext()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createsecurecontext_options) `options` 参数（例如 `key`、`cert`、`ca` 等）的任何可能属性的对象。

`server.addContext()` 方法添加了安全的上下文，如果客户端请求的 SNI 名称与提供的 `hostname`（或通配符）匹配，则将使用该上下文。

#### `server.address()`[#](http://nodejs.cn/api-v12/tls.html#serveraddress)

[中英对照](http://nodejs.cn/api-v12/tls/server_address.html)

新增于: v0.6.0

-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)

返回操作系统报告的绑定地址、地址族名称和服务器端口。 有关详细信息，请参阅 [`net.Server.address()`](http://nodejs.cn/api-v12/net.html#net_server_address)。

#### `server.close([callback])`[#](http://nodejs.cn/api-v12/tls.html#serverclosecallback)

[中英对照](http://nodejs.cn/api-v12/tls/server_close_callback.html)

新增于: v0.3.2

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 监听器回调，将被注册以监听服务器实例的 `'close'` 事件。
-   返回: [<tls.Server>](http://nodejs.cn/api/tls.html#class-tlsserver)

`server.close()` 方法阻止服务器接受新连接。

此函数异步地运行。 当服务器没有更多打开的连接时，则将触发 `'close'` 事件。

#### `server.connections`[#](http://nodejs.cn/api-v12/tls.html#serverconnections)

[中英对照](http://nodejs.cn/api-v12/tls/server_connections.html)

新增于: v0.3.2弃用于: v0.9.7

-   [<number>](http://url.nodejs.cn/SXbo1v)

返回服务器上当前的并发连接数。

#### `server.getTicketKeys()`[#](http://nodejs.cn/api-v12/tls.html#servergetticketkeys)

[中英对照](http://nodejs.cn/api-v12/tls/server_getticketkeys.html)

新增于: v3.0.0

-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 包含会话票证密钥的 48 字节缓冲区。

返回会话票证密钥。

请参阅[会话恢复](http://nodejs.cn/api-v12/tls.html#tls_session_resumption)了解更多信息。

#### `server.listen()`[#](http://nodejs.cn/api-v12/tls.html#serverlisten)

[中英对照](http://nodejs.cn/api-v12/tls/server_listen.html)

启动服务器监听加密连接。 此方法与 [`net.Server`](http://nodejs.cn/api-v12/net.html#net_class_net_server) 中的 [`server.listen()`](http://nodejs.cn/api-v12/net.html#net_server_listen) 相同。

#### `server.setSecureContext(options)`[#](http://nodejs.cn/api-v12/tls.html#serversetsecurecontextoptions)

[中英对照](http://nodejs.cn/api-v12/tls/server_setsecurecontext_options.html)

新增于: v11.0.0

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) 包含来自 [`tls.createSecureContext()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createsecurecontext_options) `options` 参数（例如 `key`、`cert`、`ca` 等）的任何可能属性的对象。

`server.setSecureContext()` 方法替换现有服务器的安全上下文。 与服务器的现有连接不会中断。

#### `server.setTicketKeys(keys)`[#](http://nodejs.cn/api-v12/tls.html#serversetticketkeyskeys)

[中英对照](http://nodejs.cn/api-v12/tls/server_setticketkeys_keys.html)

新增于: v3.0.0

-   `keys` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 包含会话票证密钥的 48 字节缓冲区。

设置会话票证密钥。

更改票证密钥仅对以后的服务器连接有效。 现有的或当前挂起的服务器连接将使用以前的键。

请参阅[会话恢复](http://nodejs.cn/api-v12/tls.html#tls_session_resumption)了解更多信息。

### `tls.TLSSocket` 类[#](http://nodejs.cn/api-v12/tls.html#class-tlstlssocket)

[中英对照](http://nodejs.cn/api-v12/tls/class_tls_tlssocket.html)

新增于: v0.11.4

-   继承自: [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket)

对写入的数据和所有必需的 TLS 协商进行透明加密。

`tls.TLSSocket` 的实例实现了双工[流](http://nodejs.cn/api-v12/stream.html#stream_stream)接口。

返回 TLS 连接元数据的方法（例如 [`tls.TLSSocket.getPeerCertificate()`](http://nodejs.cn/api-v12/tls.html#tls_tlssocket_getpeercertificate_detailed) 只会在连接打开时返回数据。

#### `new tls.TLSSocket(socket[, options])`[#](http://nodejs.cn/api-v12/tls.html#new-tlstlssocketsocket-options)

[中英对照](http://nodejs.cn/api-v12/tls/new_tls_tlssocket_socket_options.html)

-   `socket` [<net.Socket>](http://nodejs.cn/api/net.html#class-netsocket) | [<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex) 在服务器端，任何 `Duplex` 流。 在客户端，任何 [`net.Socket`](http://nodejs.cn/api-v12/net.html#net_class_net_socket) 实例（对于客户端的通用 `Duplex` 流支持，必须使用 [`tls.connect()`](http://nodejs.cn/api-v12/tls.html#tls_tls_connect_options_callback)）。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `enableTrace`: 参见 [`tls.createServer()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createserver_options_secureconnectionlistener)
    -   `isServer`: SSL/TLS 协议是不对称的，TLSSockets 必须知道它们是作为服务器还是客户端运行。 如果 `true` TLS 套接字将被实例化为服务器。 **默认值:** `false`。
    -   `server` [<net.Server>](http://nodejs.cn/api/net.html#class-netserver) [`net.Server`](http://nodejs.cn/api-v12/net.html#net_class_net_server) 实例。
    -   `requestCert`: 是否通过请求证书来验证远程对等体。 客户端总是请求服务器证书。 服务器（`isServer` 为真）可以将 `requestCert` 设置为真以请求客户端证书。
    -   `rejectUnauthorized`: 参见 [`tls.createServer()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createserver_options_secureconnectionlistener)
    -   `ALPNProtocols`: 参见 [`tls.createServer()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createserver_options_secureconnectionlistener)
    -   `SNICallback`: 参见 [`tls.createServer()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createserver_options_secureconnectionlistener)
    -   `session` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 包含 TLS 会话的 `Buffer` 实例。
    -   `requestOCSP` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 `true`, 则指定将 OCSP 状态请求扩展添加到客户端 hello 并在建立安全通信之前在套接字上触发 `'OCSPResponse'` 事件
    -   `secureContext`: 使用 [`tls.createSecureContext()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createsecurecontext_options) 创建的 TLS 上下文对象。 如果 `secureContext` 未提供，则将通过将整个 `options` 对象传给 `tls.createSecureContext()` 来创建。
    -   ...: 如果缺少 `secureContext` 选项，则使用 [`tls.createSecureContext()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createsecurecontext_options) 选项。 否则，它们将被忽略。

从现有的 TCP 套接字构造新的 `tls.TLSSocket` 对象。

#### `'keylog'` 事件[#](http://nodejs.cn/api-v12/tls.html#event-keylog_1)

[中英对照](http://nodejs.cn/api-v12/tls/event_keylog_1.html)

新增于: v12.3.0

-   `line` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) ASCII 文本行，采用 NSS `SSLKEYLOGFILE` 格式。

当套接字生成或接收密钥材料时，`keylog` 事件在 `tls.TLSSocket` 上触发。 该密钥材料可以存储用于调试，因为它允许对捕获的 TLS 流量进行解密。 它可能会在握手完成之前或之后多次触发。

一个典型的用例是将接收到的行附加到公共文本文件中，稍后软件（例如 Wireshark）使用它来解密流量：

```
const logFile = fs.createWriteStream('/tmp/ssl-keys.log', { flags: 'a' });
// ...
tlsSocket.on('keylog', (line) => logFile.write(line));
```

#### `'OCSPResponse'` 事件[#](http://nodejs.cn/api-v12/tls.html#event-ocspresponse)

[中英对照](http://nodejs.cn/api-v12/tls/event_ocspresponse.html)

新增于: v0.11.13

如果在创建 `tls.TLSSocket` 并收到 OCSP 响应时设置了 `requestOCSP` 选项，则会触发 `'OCSPResponse'` 事件。 监听器回调在调用时传入一个参数：

-   `response` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 服务器的 OCSP 响应

通常，`response` 是来自服务器 CA 的数字签名对象，其中包含有关服务器证书吊销状态的信息。

#### `'secureConnect'` 事件[#](http://nodejs.cn/api-v12/tls.html#event-secureconnect)

[中英对照](http://nodejs.cn/api-v12/tls/event_secureconnect.html)

新增于: v0.11.4

`'secureConnect'` 事件在新连接的握手过程成功完成后触发。 无论服务器的证书是否被授权，都会调用监听回调。 客户端有责任检查 `tlsSocket.authorized` 属性以确定服务器证书是否由指定的 CA 之一签名。 如果为 `tlsSocket.authorized === false`，则可以通过检查 `tlsSocket.authorizationError` 属性来发现错误。 如果使用了 ALPN，可以检查 `tlsSocket.alpnProtocol` 属性来确定协商的协议。

#### `'session'` 事件[#](http://nodejs.cn/api-v12/tls.html#event-session)

[中英对照](http://nodejs.cn/api-v12/tls/event_session.html)

新增于: v11.10.0

-   `session` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

当新会话或 TLS 票证可用时，则客户端 `tls.TLSSocket` 上会触发 `'session'` 事件。 这可能会也可能不会在握手完成之前发生，具体取决于协商的 TLS 协议版本。 该事件未在服务器上触发，或者未创建新会话，例如，当连接恢复时。 对于某些 TLS 协议版本，事件可能会多次发出，在这种情况下，所有会话都可以用于恢复。

在客户端，可以将 `session` 提供给 [`tls.connect()`](http://nodejs.cn/api-v12/tls.html#tls_tls_connect_options_callback) 的 `session` 选项来恢复连接。

请参阅[会话恢复](http://nodejs.cn/api-v12/tls.html#tls_session_resumption)了解更多信息。

对于 TLSv1.2 及以下版本，握手完成后可以调用 [`tls.TLSSocket.getSession()`](http://nodejs.cn/api-v12/tls.html#tls_tlssocket_getsession)。 对于 TLSv1.3，协议只允许基于票证的恢复，发送多张票证，直到握手完成后才发送票证。 所以需要等待 `'session'` 事件才能得到可恢复的会话。 应用程序应该使用 `'session'` 事件而不是 `getSession()` 来确保它们适用于所有 TLS 版本。 只希望获得或使用一个会话的应用程序应该只监听此事件一次：

```
tlsSocket.once('session', (session) => {
  // 会话可以立即或稍后使用。
  tls.connect({
    session: session,
    // 其他连接选项...
  });
});
```

#### `tlsSocket.address()`[#](http://nodejs.cn/api-v12/tls.html#tlssocketaddress)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_address.html)

新增于: v0.11.4

-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)

返回操作系统报告的底层套接字的绑定 `address`、地址 `family` 名称和 `port`：`{ port: 12346, family: 'IPv4', address: '127.0.0.1' }`。

#### `tlsSocket.authorizationError`

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_authorizationerror.html)

新增于: v0.11.4

返回未验证对等方证书的原因。 此属性仅在 `tlsSocket.authorized === false` 时设置。

#### `tlsSocket.authorized`[#](http://nodejs.cn/api-v12/tls.html#tlssocketauthorized)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_authorized.html)

新增于: v0.11.4

-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

如果对等证书由创建 `tls.TLSSocket` 实例时指定的 CA 之一签名，则返回 `true`，否则返回 `false`。

#### `tlsSocket.disableRenegotiation()`[#](http://nodejs.cn/api-v12/tls.html#tlssocketdisablerenegotiation)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_disablerenegotiation.html)

新增于: v8.4.0

禁用此 `TLSSocket` 实例的 TLS 重新协商。 一旦调用，则尝试重新协商将在 `TLSSocket` 上触发 `'error'` 事件。

#### `tlsSocket.enableTrace()`[#](http://nodejs.cn/api-v12/tls.html#tlssocketenabletrace)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_enabletrace.html)

新增于: v12.2.0

当启用后，TLS 数据包跟踪信息将写入 `stderr`。 这可用于调试 TLS 连接问题。

注意：输出的格式与 `openssl s_client -trace` 或 `openssl s_server -trace` 的输出相同。 虽然它是由 OpenSSL 的 `SSL_trace()` 函数生成的，但格式未记录，可以在不通知的情况下更改，不应依赖。

#### `tlsSocket.encrypted`[#](http://nodejs.cn/api-v12/tls.html#tlssocketencrypted)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_encrypted.html)

新增于: v0.11.4

总是返回 `true`。 这可用于将 TLS 套接字与常规 `net.Socket` 实例区分开来。

#### `tlsSocket.getCertificate()`[#](http://nodejs.cn/api-v12/tls.html#tlssocketgetcertificate)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_getcertificate.html)

新增于: v11.2.0

-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)

返回表示本地证书的对象。 返回的对象有一些与证书字段对应的属性。

有关证书结构的示例，请参见 [`tls.TLSSocket.getPeerCertificate()`](http://nodejs.cn/api-v12/tls.html#tls_tlssocket_getpeercertificate_detailed)。

如果没有本地证书，则将返回空对象。 如果套接字被销毁，则返回 `null`。

#### `tlsSocket.getCipher()`[#](http://nodejs.cn/api-v12/tls.html#tlssocketgetcipher)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_getcipher.html)

-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `name` [<string>](http://url.nodejs.cn/9Tw2bK) 密码套件的 OpenSSL 名称。
    -   `standardName` [<string>](http://url.nodejs.cn/9Tw2bK) 密码套件的 IETF 名称。
    -   `version` [<string>](http://url.nodejs.cn/9Tw2bK) 此密码套件支持的最低 TLS 协议版本。

返回包含协商密码套件信息的对象。

例如：

```
{
    "name": "AES128-SHA256",
    "standardName": "TLS_RSA_WITH_AES_128_CBC_SHA256",
    "version": "TLSv1.2"
}
```

请参阅 [SSL\_CIPHER\_get\_name](https://www.openssl.org/docs/man1.1.1/man3/SSL_CIPHER_get_name.html) 了解更多信息。

#### `tlsSocket.getEphemeralKeyInfo()`[#](http://nodejs.cn/api-v12/tls.html#tlssocketgetephemeralkeyinfo)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_getephemeralkeyinfo.html)

新增于: v5.0.0

-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao)

返回一个对象，表示客户端连接上[完美前向保密](http://nodejs.cn/api-v12/tls.html#tls_perfect_forward_secrecy)中临时密钥交换的参数的类型、名称和大小。 当密钥交换不是短暂的时，则它返回空对象。 因为这仅在客户端套接字上受支持；如果在服务器套接字上调用，则返回 `null`。 支持的类型是 `'DH'` 和 `'ECDH'`。 `name` 属性仅在类型为 `'ECDH'` 时可用。

例如：`{ type: 'ECDH', name: 'prime256v1', size: 256 }`。

#### `tlsSocket.getFinished()`[#](http://nodejs.cn/api-v12/tls.html#tlssocketgetfinished)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_getfinished.html)

新增于: v9.9.0

-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<undefined>](http://url.nodejs.cn/8ym6ow) 作为 SSL/TLS 握手的一部分已发送到套接字的最新 `Finished` 消息，如果尚未发送 `Finished` 消息，则为 `undefined`。

由于 `Finished` 消息是完整握手的消息摘要（对于 TLS 1.0 总共有 192 位，对于 SSL 3.0 则更多），当不需要或不需要 SSL/TLS 提供的身份验证时，它们可用于外部身份验证程序不够。

对应于 OpenSSL 中的 `SSL_get_finished` 例程，可用于实现 [RFC 5929](http://url.nodejs.cn/Koa3CP) 中的 `tls-unique` 通道绑定。

#### `tlsSocket.getPeerCertificate([detailed])`[#](http://nodejs.cn/api-v12/tls.html#tlssocketgetpeercertificatedetailed)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_getpeercertificate_detailed.html)

新增于: v0.11.4

-   `detailed` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 `true`，则包含完整的证书链，否则仅包含对等方的证书。
-   返回: [<Object>](http://url.nodejs.cn/jzn6Ao) 证书对象。

返回代表对等方证书的对象。 如果对端没有提供证书，则将返回空对象。 如果套接字被销毁，则返回 `null`。

如果请求完整的证书链，则每个证书都将包含一个 `issuerCertificate` 属性，其中包含代表其颁发者证书的对象。

##### 证书对象[#](http://nodejs.cn/api-v12/tls.html#certificate-object)

[中英对照](http://nodejs.cn/api-v12/tls/certificate_object.html)

证书对象具有与证书字段对应的属性。

-   `raw` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) DER 编码的 X.509 证书数据。
-   `subject` [<Object>](http://url.nodejs.cn/jzn6Ao) 证书主题，按照国家 (`C:`)、州或省 (`ST`)、地区 (`L`)、组织 (`O`)、组织单位 (`OU`) 和通用名称 (`CN`) 进行描述。 CommonName 通常是带有 TLS 证书的 DNS 名称。 示例：`{C: 'UK', ST: 'BC', L: 'Metro', O: 'Node Fans', OU: 'Docs', CN: 'example.com'}`。
-   `issuer` [<Object>](http://url.nodejs.cn/jzn6Ao) 证书颁发者，使用与 `subject` 相同的术语描述。
-   `valid_from` [<string>](http://url.nodejs.cn/9Tw2bK) 证书有效的开始日期时间。
-   `valid_to` [<string>](http://url.nodejs.cn/9Tw2bK) 证书有效的结束日期时间。
-   `serialNumber` [<string>](http://url.nodejs.cn/9Tw2bK) 证书序列号，以十六进制字符串表示。 示例：`'B9B0D332A1AA5635'`。
-   `fingerprint` [<string>](http://url.nodejs.cn/9Tw2bK) DER 编码证书的 SHA-1 摘要。 它作为 `:` 分隔的十六进制字符串返回。 示例：`'2A:7A:C2:DD:...'`。
-   `fingerprint256` [<string>](http://url.nodejs.cn/9Tw2bK) DER 编码证书的 SHA-256 摘要。 它作为 `:` 分隔的十六进制字符串返回。 示例：`'2A:7A:C2:DD:...'`。
-   `ext_key_usage` [<Array>](http://url.nodejs.cn/ZJSz23) （可选的）扩展的密钥用法，一组 OID。
-   `subjectaltname` [<string>](http://url.nodejs.cn/9Tw2bK) （可选的）包含主题的连接名称的字符串，`subject` 名称的替代。
-   `infoAccess` [<Array>](http://url.nodejs.cn/ZJSz23) （可选的）描述 AuthorityInfoAccess 的数组，与OCSP 一起使用。
-   `issuerCertificate` [<Object>](http://url.nodejs.cn/jzn6Ao) （可选的）颁发者证书对象。 对于自签名证书，这可能是一个循环引用。

证书可能包含有关公钥的信息，具体取决于密钥类型。

对于 RSA 密钥，可以定义以下属性：

-   `bits` [<number>](http://url.nodejs.cn/SXbo1v) RSA 位大小。 示例：`1024`。
-   `exponent` [<string>](http://url.nodejs.cn/9Tw2bK) RSA 指数，作为十六进制数字表示法的字符串。 示例：`'0x010001'`。
-   `modulus` [<string>](http://url.nodejs.cn/9Tw2bK) RSA 模数，作为十六进制字符串。 示例：`'B56CE45CB7...'`。
-   `pubkey` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 公钥。

对于 EC 密钥，可以定义以下属性：

-   `pubkey` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 公钥。
-   `bits` [<number>](http://url.nodejs.cn/SXbo1v) 密钥大小（以位为单位）。 示例：`256`。
-   `asn1Curve` [<string>](http://url.nodejs.cn/9Tw2bK) （可选的）椭圆曲线的 OID 的 ASN.1 名称。 知名曲线由 OID 标识。 虽然这很不寻常，但曲线可能是由其数学属性标识的，在这种情况下，它不会有 OID。 示例：`'prime256v1'`。
-   `nistCurve` [<string>](http://url.nodejs.cn/9Tw2bK) （可选的）椭圆曲线的 NIST 名称，如果有的话（并非所有知名曲线都由 NIST 指定名称）。 示例：`'P-256'`。

示例证书：

```
{ subject:
   { OU: [ 'Domain Control Validated', 'PositiveSSL Wildcard' ],
     CN: '*.nodejs.org' },
  issuer:
   { C: 'GB',
     ST: 'Greater Manchester',
     L: 'Salford',
     O: 'COMODO CA Limited',
     CN: 'COMODO RSA Domain Validation Secure Server CA' },
  subjectaltname: 'DNS:*.nodejs.org, DNS:nodejs.org',
  infoAccess:
   { 'CA Issuers - URI':
      [ 'http://crt.comodoca.com/COMODORSADomainValidationSecureServerCA.crt' ],
     'OCSP - URI': [ 'http://ocsp.comodoca.com' ] },
  modulus: 'B56CE45CB740B09A13F64AC543B712FF9EE8E4C284B542A1708A27E82A8D151CA178153E12E6DDA15BF70FFD96CB8A88618641BDFCCA03527E665B70D779C8A349A6F88FD4EF6557180BD4C98192872BCFE3AF56E863C09DDD8BC1EC58DF9D94F914F0369102B2870BECFA1348A0838C9C49BD1C20124B442477572347047506B1FCD658A80D0C44BCC16BC5C5496CFE6E4A8428EF654CD3D8972BF6E5BFAD59C93006830B5EB1056BBB38B53D1464FA6E02BFDF2FF66CD949486F0775EC43034EC2602AEFBF1703AD221DAA2A88353C3B6A688EFE8387811F645CEED7B3FE46E1F8B9F59FAD028F349B9BC14211D5830994D055EEA3D547911E07A0ADDEB8A82B9188E58720D95CD478EEC9AF1F17BE8141BE80906F1A339445A7EB5B285F68039B0F294598A7D1C0005FC22B5271B0752F58CCDEF8C8FD856FB7AE21C80B8A2CE983AE94046E53EDE4CB89F42502D31B5360771C01C80155918637490550E3F555E2EE75CC8C636DDE3633CFEDD62E91BF0F7688273694EEEBA20C2FC9F14A2A435517BC1D7373922463409AB603295CEB0BB53787A334C9CA3CA8B30005C5A62FC0715083462E00719A8FA3ED0A9828C3871360A73F8B04A4FC1E71302844E9BB9940B77E745C9D91F226D71AFCAD4B113AAF68D92B24DDB4A2136B55A1CD1ADF39605B63CB639038ED0F4C987689866743A68769CC55847E4A06D6E2E3F1',
  exponent: '0x10001',
  pubkey: <Buffer ... >,
  valid_from: 'Aug 14 00:00:00 2017 GMT',
  valid_to: 'Nov 20 23:59:59 2019 GMT',
  fingerprint: '01:02:59:D9:C3:D2:0D:08:F7:82:4E:44:A4:B4:53:C5:E2:3A:87:4D',
  fingerprint256: '69:AE:1A:6A:D4:3D:C6:C1:1B:EA:C6:23:DE:BA:2A:14:62:62:93:5C:7A:EA:06:41:9B:0B:BC:87:CE:48:4E:02',
  ext_key_usage: [ '1.3.6.1.5.5.7.3.1', '1.3.6.1.5.5.7.3.2' ],
  serialNumber: '66593D57F20CBC573E433381B5FEC280',
  raw: <Buffer ... > }
```

#### `tlsSocket.getPeerFinished()`[#](http://nodejs.cn/api-v12/tls.html#tlssocketgetpeerfinished)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_getpeerfinished.html)

新增于: v9.9.0

-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<undefined>](http://url.nodejs.cn/8ym6ow) 作为 SSL/TLS 握手的一部分，预期或实际已从套接字接收到的最新 `Finished` 消息，如果到目前为止还没有 `Finished` 消息，则为 `undefined`。

由于 `Finished` 消息是完整握手的消息摘要（对于 TLS 1.0 总共有 192 位，对于 SSL 3.0 则更多），当不需要或不需要 SSL/TLS 提供的身份验证时，它们可用于外部身份验证程序不够。

对应于 OpenSSL 中的 `SSL_get_peer_finished` 例程，可用于实现 [RFC 5929](http://url.nodejs.cn/Koa3CP) 中的 `tls-unique` 通道绑定。

#### `tlsSocket.getProtocol()`[#](http://nodejs.cn/api-v12/tls.html#tlssocketgetprotocol)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_getprotocol.html)

新增于: v5.7.0

-   返回: [<string>](http://url.nodejs.cn/9Tw2bK) | [<null>](http://url.nodejs.cn/334hvC)

返回包含当前连接的协商 SSL/TLS 协议版本的字符串。 对于尚未完成握手过程的已连接套接字，将返回值 `'unknown'`。 服务器套接字或断开的客户端套接字将返回值 `null`。

协议版本为：

-   `'SSLv3'`
-   `'TLSv1'`
-   `'TLSv1.1'`
-   `'TLSv1.2'`
-   `'TLSv1.3'`

有关详细信息，请参阅 OpenSSL [`SSL_get_version`](http://url.nodejs.cn/GqcYyf) 文档。

#### `tlsSocket.getSession()`[#](http://nodejs.cn/api-v12/tls.html#tlssocketgetsession)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_getsession.html)

新增于: v0.11.4

-   [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

如果没有协商会话，则返回 TLS 会话数据或 `undefined`。 在客户端，可以将数据提供给 [`tls.connect()`](http://nodejs.cn/api-v12/tls.html#tls_tls_connect_options_callback) 的 `session` 选项来恢复连接。 在服务器上，它可能对调试有用。

请参阅[会话恢复](http://nodejs.cn/api-v12/tls.html#tls_session_resumption)了解更多信息。

注意：`getSession()` 仅适用于 TLSv1.2 及以下版本。 对于 TLSv1.3，应用程序必须使用 [`'session'`](http://nodejs.cn/api-v12/tls.html#tls_event_session) 事件（它也适用于 TLSv1.2 及更低版本）。

#### `tlsSocket.getSharedSigalgs()`[#](http://nodejs.cn/api-v12/tls.html#tlssocketgetsharedsigalgs)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_getsharedsigalgs.html)

新增于: v12.11.0

-   返回: [<Array>](http://url.nodejs.cn/ZJSz23) 服务器和客户端之间共享的签名算法列表，按优先级降序排列。

请参阅 [SSL\_get\_shared\_sigalgs](https://www.openssl.org/docs/man1.1.1/man3/SSL_get_shared_sigalgs.html) 了解更多信息。

#### `tlsSocket.exportKeyingMaterial(length, label[, context])`[#](http://nodejs.cn/api-v12/tls.html#tlssocketexportkeyingmateriallength-label-context)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_exportkeyingmaterial_length_label_context.html)

新增于: v12.17.0

-   `length` [<number>](http://url.nodejs.cn/SXbo1v) 从密钥材料中检索的字节数
    
-   `label` [<string>](http://url.nodejs.cn/9Tw2bK) 特定于应用程序的标签，通常是来自 [IANA 出口商标签注册](https://www.iana.org/assignments/tls-parameters/tls-parameters.xhtml#exporter-labels) 的值。
    
-   `context` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 可选地提供上下文。
    
-   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 请求的密钥材料字节
    

密钥材料用于验证以防止网络协议中的不同类型的攻击，例如在 IEEE 802.1X 的规范中。

示例

```
const keyingMaterial = tlsSocket.exportKeyingMaterial(
  128,
  'client finished');

/**
 keyingMaterial 的返回值示例：
 <Buffer 76 26 af 99 c5 56 8e 42 09 91 ef 9f 93 cb ad 6c 7b 65 f8 53 f1 d8 d9
    12 5a 33 b8 b5 25 df 7b 37 9f e0 e2 4f b8 67 83 a3 2f cd 5d 41 42 4c 91
    74 ef 2c ... 78 more bytes>
*/
```

有关详细信息，请参阅 OpenSSL [`SSL_export_keying_material`](http://url.nodejs.cn/f2X32c) 文档。

#### `tlsSocket.getTLSTicket()`[#](http://nodejs.cn/api-v12/tls.html#tlssocketgettlsticket)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_gettlsticket.html)

新增于: v0.11.4

-   [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer)

对于客户端，如果可用，则返回 TLS 会话票证，或 `undefined`。 对于服务器，总是返回 `undefined`。

它可能对调试有用。

请参阅[会话恢复](http://nodejs.cn/api-v12/tls.html#tls_session_resumption)了解更多信息。

#### `tlsSocket.isSessionReused()`[#](http://nodejs.cn/api-v12/tls.html#tlssocketissessionreused)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_issessionreused.html)

新增于: v0.5.6

-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT) 如果会话被重用则为 `true`，否则为 `false`。

请参阅[会话恢复](http://nodejs.cn/api-v12/tls.html#tls_session_resumption)了解更多信息。

#### `tlsSocket.localAddress`[#](http://nodejs.cn/api-v12/tls.html#tlssocketlocaladdress)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_localaddress.html)

新增于: v0.11.4

-   [<string>](http://url.nodejs.cn/9Tw2bK)

返回本地 IP 地址的字符串表示形式。

#### `tlsSocket.localPort`[#](http://nodejs.cn/api-v12/tls.html#tlssocketlocalport)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_localport.html)

新增于: v0.11.4

-   [<number>](http://url.nodejs.cn/SXbo1v)

返回本地端口的数字表示。

#### `tlsSocket.remoteAddress`[#](http://nodejs.cn/api-v12/tls.html#tlssocketremoteaddress)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_remoteaddress.html)

新增于: v0.11.4

-   [<string>](http://url.nodejs.cn/9Tw2bK)

返回远程 IP 地址的字符串表示形式。 例如，`'74.125.127.100'` 或 `'2001:4860:a005::68'`。

#### `tlsSocket.remoteFamily`[#](http://nodejs.cn/api-v12/tls.html#tlssocketremotefamily)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_remotefamily.html)

新增于: v0.11.4

-   [<string>](http://url.nodejs.cn/9Tw2bK)

返回远程 IP 族的字符串表示形式。 `'IPv4'` 或 `'IPv6'`。

#### `tlsSocket.remotePort`[#](http://nodejs.cn/api-v12/tls.html#tlssocketremoteport)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_remoteport.html)

新增于: v0.11.4

-   [<number>](http://url.nodejs.cn/SXbo1v)

返回远程端口的数字表示。 例如，`443`。

#### `tlsSocket.renegotiate(options, callback)`[#](http://nodejs.cn/api-v12/tls.html#tlssocketrenegotiateoptions-callback)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_renegotiate_options_callback.html)

新增于: v0.11.8

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    
    -   `rejectUnauthorized` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果不是 `false`，则服务器证书将根据提供的 CA 列表进行验证。 如果验证失败，则会触发 `'error'` 事件；`err.code` 包含 OpenSSL 错误代码。 **默认值:** `true`。
    -   `requestCert`
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 如果 `renegotiate()` 返回 `true`，则回调将绑定到 `'secure'` 事件。 如果 `renegotiate()` 返回 `false`, 则 `callback` 将在下一个滴答中被调用并出错, 除非 `tlsSocket` 已被销毁, 在这种情况下根本不会调用 `callback`。
    
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT) 如果重新协商已启动则为 `true`，否则为 `false`。
    

`tlsSocket.renegotiate()` 方法启动 TLS 重新协商过程。 当完成后，`callback` 函数将传入一个参数，该参数是 `Error`（如果请求失败）或 `null`。

此方法可用于在建立安全连接后请求对等方的证书。

当作为服务器运行时，套接字将在 `handshakeTimeout` 超时后销毁并出现错误。

对于 TLSv1.3，无法发起重协商，协议不支持。

#### `tlsSocket.setMaxSendFragment(size)`[#](http://nodejs.cn/api-v12/tls.html#tlssocketsetmaxsendfragmentsize)

[中英对照](http://nodejs.cn/api-v12/tls/tlssocket_setmaxsendfragment_size.html)

新增于: v0.11.11

-   `size` [<number>](http://url.nodejs.cn/SXbo1v) 最大 TLS 片段大小。 最大值为 `16384`。 **默认值:** `16384`。
-   返回: [<boolean>](http://url.nodejs.cn/jFbvuT)

`tlsSocket.setMaxSendFragment()` 方法设置最大 TLS 片段大小。 如果设置限制成功，则返回 `true`；否则返回 `false`。

较小的片段大小减少了客户端的缓冲延迟：较大的片段由 TLS 层缓冲，直到接收到整个片段并验证其完整性；大片段可以跨越多次往返，并且由于数据包丢失或重新排序，它们的处理可能会延迟。 但是，较小的片段会增加额外的 TLS 成帧字节和 CPU 开销，这可能会降低整体服务器吞吐量。

### `tls.checkServerIdentity(hostname, cert)`[#](http://nodejs.cn/api-v12/tls.html#tlscheckserveridentityhostname-cert)

[中英对照](http://nodejs.cn/api-v12/tls/tls_checkserveridentity_hostname_cert.html)

-   `hostname` [<string>](http://url.nodejs.cn/9Tw2bK) 用于验证证书的主机名或 IP 地址。
-   `cert` [<Object>](http://url.nodejs.cn/jzn6Ao) [证书对象](http://nodejs.cn/api-v12/tls.html#tls_certificate_object)代表对等方的证书。
-   返回: [<Error>](http://url.nodejs.cn/qZ873x) | [<undefined>](http://url.nodejs.cn/8ym6ow)

验证证书 `cert` 颁发给 `hostname`。

返回 [<Error>](http://url.nodejs.cn/qZ873x) 对象，失败时用 `reason`、`host` 和 `cert` 填充它。 当成功时，返回 [<undefined>](http://url.nodejs.cn/8ym6ow)。

可以通过提供替代函数作为传给 `tls.connect()` 的 `options.checkServerIdentity` 选项的一部分来覆盖此函数。 覆盖函数当然可以调用 `tls.checkServerIdentity()`，以增加通过额外验证完成的检查。

此函数仅在证书通过所有其他检查时才会调用，例如由受信任的 CA (`options.ca`) 颁发。

如果存在匹配的 `uniformResourceIdentifier` 主题替代名称，则 Node.js 的早期版本会错误地接受给定 `hostname` 的证书（请参阅 [CVE-2021-44531](http://url.nodejs.cn/7HWWbS)）。 希望接受 `uniformResourceIdentifier` 主题替代名称的应用程序可以使用实现所需行为的自定义 `options.checkServerIdentity` 函数。

### `tls.connect(options[, callback])`[#](http://nodejs.cn/api-v12/tls.html#tlsconnectoptions-callback)

[中英对照](http://nodejs.cn/api-v12/tls/tls_connect_options_callback.html)

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `enableTrace`: 参见 [`tls.createServer()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createserver_options_secureconnectionlistener)
    -   `host` [<string>](http://url.nodejs.cn/9Tw2bK) 客户端应该连接到的主机。 **默认值:** `'localhost'`。
    -   `port` [<number>](http://url.nodejs.cn/SXbo1v) 客户端应该连接到的端口。
    -   `path` [<string>](http://url.nodejs.cn/9Tw2bK) 创建到路径的 Unix 套接字连接。 如果指定了此选项，则 `host` 和 `port` 将被忽略。
    -   `socket` [<stream.Duplex>](http://nodejs.cn/api/stream.html#class-streamduplex) 在给定的套接字上建立安全连接而不是创建新的套接字。 通常，这是 [`net.Socket`](http://nodejs.cn/api-v12/net.html#net_class_net_socket) 的实例，但允许任何 `Duplex` 流。 如果指定了此选项，则 `path`、`host` 和 `port` 将被忽略，除了证书验证。 通常，套接字在传给 `tls.connect()` 的时候就已经连接上了，但是可以稍后再连接。 `socket` 的连接/断开/销毁是用户的责任；调用 `tls.connect()` 不会导致调用 `net.connect()`。
    -   `allowHalfOpen` [<boolean>](http://url.nodejs.cn/jFbvuT) 详见 [`net.Socket`](http://nodejs.cn/api-v12/net.html#net_class_net_socket) 的 `allowHalfOpen` 选项。 **默认值:** `false`。
    -   `rejectUnauthorized` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果不是 `false`，则服务器证书将根据提供的 CA 列表进行验证。 如果验证失败，则会触发 `'error'` 事件；`err.code` 包含 OpenSSL 错误代码。 **默认值:** `true`。
    -   `pskCallback` [<Function>](http://url.nodejs.cn/ceTQa6)
        -   提示：从服务器发送的 [<string>](http://url.nodejs.cn/9Tw2bK) 可选消息，以帮助客户端决定在协商期间使用哪个身份。 如果使用 TLS 1.3，则始终为 `null`。
        -   返回: [<Object>](http://url.nodejs.cn/jzn6Ao) 以 `{ psk: <Buffer|TypedArray|DataView>, identity: <string> }` 或 `null` 形式停止协商过程。 `psk` 必须与所选密码的摘要兼容。 `identity` 必须使用 UTF-8 编码。 当协商 TLS-PSK（预共享密钥）时，此函数将使用服务器提供的可选标识 `hint` 或 `null` 调用，以防 TLS 1.3 中删除了 `hint`。 有必要为连接提供自定义 `tls.checkServerIdentity()`，因为默认情况下会尝试根据证书检查服务器的主机名/IP，但这不适用于 PSK，因为不会存在证书。 可以在 [RFC 4279](http://url.nodejs.cn/Gq5awY) 中找到更多信息。
    -   `ALPNProtocols`: [<string\[\]>](http://url.nodejs.cn/9Tw2bK) | [<Buffer\[\]>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray\[\]>](http://url.nodejs.cn/oh3CkV) | [<DataView\[\]>](http://url.nodejs.cn/yCdVkD) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) 字符串数组、`Buffer`、或 `TypedArray`、或 `DataView`、或包含支持的 ALPN 协议的单个 `Buffer` 或 `TypedArray` 或 `DataView`。 `Buffer` 的格式应该是 `[len][name][len][name]...`，例如 `'\x08http/1.1\x08http/1.0'`，其中 `len` 字节是下一个协议名称的长度。 传入数组通常要简单得多，例如 `['http/1.1', 'http/1.0']`。 列表中较早的协议比后面的有更高的优先级。
    -   `servername`: [<string>](http://url.nodejs.cn/9Tw2bK) SNI（服务器名称指示）TLS 扩展的服务器名称。 它是所连接主机的名称，必须是主机名，而不是 IP 地址。 它可以被多宿主服务器用来选择正确的证书呈现给客户端，参见 `SNICallback` 选项到 [`tls.createServer()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createserver_options_secureconnectionlistener)。
    -   `checkServerIdentity(servername, cert)` [<Function>](http://url.nodejs.cn/ceTQa6) 根据证书检查服务器的主机名（或显式设置时提供的 `servername`）时要使用的回调函数（而不是内置的 `tls.checkServerIdentity()` 函数）。 如果验证失败，则这应该返回 [<Error>](http://url.nodejs.cn/qZ873x)。 如果验证了 `servername` 和 `cert`，则该方法应该返回 `undefined`。
    -   `session` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) `Buffer` 实例，包含 TLS 会话。
    -   `minDHSize` [<number>](http://url.nodejs.cn/SXbo1v) 接受 TLS 连接的 DH 参数的最小大小（以位为单位）。 当服务器提供大小小于 `minDHSize` 的 DH 参数时，则 TLS 连接被销毁并抛出错误。 **默认值:** `1024`。
    -   `secureContext`: 使用 [`tls.createSecureContext()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createsecurecontext_options) 创建的 TLS 上下文对象。 如果 `secureContext` 未提供，则将通过将整个 `options` 对象传给 `tls.createSecureContext()` 来创建。
    -   ...: 如果缺少 `secureContext` 选项，则使用 [`tls.createSecureContext()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createsecurecontext_options) 选项，否则它们将被忽略。
    -   ...: 尚未列出的任何 [`socket.connect()`](http://nodejs.cn/api-v12/net.html#net_socket_connect_options_connectlistener) 选项。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<tls.TLSSocket>](http://nodejs.cn/api/tls.html#class-tlstlssocket)

`callback` 函数，如果指定，则将被添加为 [`'secureConnect'`](http://nodejs.cn/api-v12/tls.html#tls_event_secureconnect) 事件的监听器。

`tls.connect()` 返回 [`tls.TLSSocket`](http://nodejs.cn/api-v12/tls.html#tls_class_tls_tlssocket) 对象。

与 `https` API不同，`tls.connect()` 默认不启用 SNI（服务器名称指示）扩展，这可能会导致部分服务器返回错误证书或完全拒绝连接。 要启用 SNI，除了 `host` 之外，还要设置 `servername` 选项。

以下说明了来自 [`tls.createServer()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createserver_options_secureconnectionlistener) 的回显服务器示例的客户端：

```
// 假设回显服务器正在监听端口 8000。
const tls = require('tls');
const fs = require('fs');

const options = {
  // 仅当服务器需要客户端证书身份验证时才需要。
  key: fs.readFileSync('client-key.pem'),
  cert: fs.readFileSync('client-cert.pem'),

  // 仅当服务器使用自签名证书时才需要。
  ca: [ fs.readFileSync('server-cert.pem') ],

  // 仅当服务器的证书不适用于 "localhost" 时才需要。
  checkServerIdentity: () => { return null; },
};

const socket = tls.connect(8000, options, () => {
  console.log('client connected',
              socket.authorized ? 'authorized' : 'unauthorized');
  process.stdin.pipe(socket);
  process.stdin.resume();
});
socket.setEncoding('utf8');
socket.on('data', (data) => {
  console.log(data);
});
socket.on('end', () => {
  console.log('server ends connection');
});
```

### `tls.connect(path[, options][, callback])`[#](http://nodejs.cn/api-v12/tls.html#tlsconnectpath-options-callback)

[中英对照](http://nodejs.cn/api-v12/tls/tls_connect_path_options_callback.html)

新增于: v0.11.3

-   `path` [<string>](http://url.nodejs.cn/9Tw2bK) `options.path` 的默认值。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) 参见 [`tls.connect()`](http://nodejs.cn/api-v12/tls.html#tls_tls_connect_options_callback)。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 参见 [`tls.connect()`](http://nodejs.cn/api-v12/tls.html#tls_tls_connect_options_callback)。
-   返回: [<tls.TLSSocket>](http://nodejs.cn/api/tls.html#class-tlstlssocket)

与 [`tls.connect()`](http://nodejs.cn/api-v12/tls.html#tls_tls_connect_options_callback) 相同，除了 `path` 可以作为参数而不是选项提供。

路径选项，如果指定，将优先于路径参数。

### `tls.connect(port[, host][, options][, callback])`[#](http://nodejs.cn/api-v12/tls.html#tlsconnectport-host-options-callback)

[中英对照](http://nodejs.cn/api-v12/tls/tls_connect_port_host_options_callback.html)

新增于: v0.11.3

-   `port` [<number>](http://url.nodejs.cn/SXbo1v) `options.port` 的默认值。
-   `host` [<string>](http://url.nodejs.cn/9Tw2bK) `options.host` 的默认值。
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) 参见 [`tls.connect()`](http://nodejs.cn/api-v12/tls.html#tls_tls_connect_options_callback)。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6) 参见 [`tls.connect()`](http://nodejs.cn/api-v12/tls.html#tls_tls_connect_options_callback)。
-   返回: [<tls.TLSSocket>](http://nodejs.cn/api/tls.html#class-tlstlssocket)

与 [`tls.connect()`](http://nodejs.cn/api-v12/tls.html#tls_tls_connect_options_callback) 相同，除了 `port` 和 `host` 可以作为参数而不是选项提供。

端口或主机选项，如果指定，将优先于任何端口或主机参数。

### `tls.createSecureContext([options])`[#](http://nodejs.cn/api-v12/tls.html#tlscreatesecurecontextoptions)

[中英对照](http://nodejs.cn/api-v12/tls/tls_createsecurecontext_options.html)

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `ca` [<string>](http://url.nodejs.cn/9Tw2bK) | [<string\[\]>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Buffer\[\]>](http://nodejs.cn/api/buffer.html#class-buffer) 可选择覆盖受信任的 CA 证书。 默认是信任 Mozilla 策划的知名 CA。 当使用此选项明确指定 CA 时，Mozilla 的 CA 将被完全替换。 该值可以是字符串、或 `Buffer`、或 `Array` 的字符串和/或 `Buffer`。 任何字符串或 `Buffer` 都可以包含多个连接在一起的 PEM CA。 对等方的证书必须可链接到服务器信任的 CA 才能对连接进行身份验证。 当使用不可链接到知名 CA 的证书时，必须明确指定证书的 CA 为受信任的 CA，否则连接将无法通过身份验证。 如果对等方使用的证书不匹配或链接到默认 CA 之一，则使用 `ca` 选项提供对等方证书可以匹配或链接到的 CA 证书。 对于自签名证书，证书是自己的CA，必须提供。 对于 PEM 编码的证书，支持的类型是 "TRUSTED CERTIFICATE"、"X509 CERTIFICATE"、以及 "CERTIFICATE"。 另见 [`tls.rootCertificates`](http://nodejs.cn/api-v12/tls.html#tls_tls_rootcertificates)。
        
    -   `cert` [<string>](http://url.nodejs.cn/9Tw2bK) | [<string\[\]>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Buffer\[\]>](http://nodejs.cn/api/buffer.html#class-buffer) PEM 格式的证书链。 每个私钥应提供证书链。 每个证书链都应包含提供的私有 `key` 的 PEM 格式证书，然后是 PEM 格式的中间证书（如果有），按顺序排列，并且不包括根 CA（根 CA 必须是对等方预先知道的，参见 `ca`）。 在提供多个证书链时，它们不必与 `key` 中的私钥顺序相同。 如果不提供中间证书，则对端将无法验证证书，握手将失败。
        
    -   `sigalgs` [<string>](http://url.nodejs.cn/9Tw2bK) 支持的签名算法的冒号分隔列表。 该列表可以包含摘要算法（`SHA256`、`MD5` 等）、公钥算法（`RSA-PSS`、`ECDSA` 等）、两者的组合（例如 'RSA+SHA384'）或 TLS v1.3 方案名称（例如 `rsa_pss_pss_sha512`）。 请参阅 [OpenSSL 手册页](https://www.openssl.org/docs/man1.1.1/man3/SSL_CTX_set1_sigalgs_list.html) 了解更多信息。
        
    -   `ciphers` [<string>](http://url.nodejs.cn/9Tw2bK) 密码套件规范，替换默认值。 有关更多信息，请参阅[修改默认密码套件](http://nodejs.cn/api-v12/tls.html#tls_modifying_the_default_tls_cipher_suite)。 可以通过 [`tls.getCiphers()`](http://nodejs.cn/api-v12/tls.html#tls_tls_getciphers) 获得允许的密码。 密码名称必须大写，OpenSSL 才能接受它们。
        
    -   `clientCertEngine` [<string>](http://url.nodejs.cn/9Tw2bK) 可以提供客户端证书的 OpenSSL 引擎的名称。
        
    -   `crl` [<string>](http://url.nodejs.cn/9Tw2bK) | [<string\[\]>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Buffer\[\]>](http://nodejs.cn/api/buffer.html#class-buffer) PEM 格式的 CRL（证书吊销列表）。
        
    -   `dhparam` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) Diffie-Hellman 参数，[完美前向保密](http://nodejs.cn/api-v12/tls.html#tls_perfect_forward_secrecy)所需。 使用 `openssl dhparam` 创建参数。 密钥长度必须大于等于 1024 位，否则会报错。 虽然 1024 位是允许的，但为了更强的安全性，请使用 2048 位或更大的位。 如果省略或无效，参数将被静默丢弃，DHE 密码将不可用。
        
    -   `ecdhCurve` [<string>](http://url.nodejs.cn/9Tw2bK) 描述命名曲线或以冒号分隔的曲线 NID 或名称列表的字符串，例如 `P-521:P-384:P-256`，用于 ECDH 密钥协议。 设置为 `auto` 自动选择曲线。 使用 [`crypto.getCurves()`](http://nodejs.cn/api-v12/crypto.html#crypto_crypto_getcurves) 获取可用曲线名称的列表。 在最近的版本中，`openssl ecparam -list_curves` 还将显示每个可用椭圆曲线的名称和描述。 **默认值:** [`tls.DEFAULT_ECDH_CURVE`](http://nodejs.cn/api-v12/tls.html#tls_tls_default_ecdh_curve).
        
    -   `honorCipherOrder` [<boolean>](http://url.nodejs.cn/jFbvuT) 尝试使用服务器的密码套件首选项而不是客户端的。 当为 `true` 时，导致 `SSL_OP_CIPHER_SERVER_PREFERENCE` 在 `secureOptions` 中被设置，请参阅 [OpenSSL 选项](http://nodejs.cn/api-v12/crypto.html#crypto_openssl_options)了解更多信息。
        
    -   `key` [<string>](http://url.nodejs.cn/9Tw2bK) | [<string\[\]>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Buffer\[\]>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Object\[\]>](http://url.nodejs.cn/jzn6Ao) PEM 格式的私钥。 PEM 允许选择加密私钥。 加密的密钥将用 `options.passphrase` 解密。 使用不同算法的多个密钥可以作为未加密密钥字符串或缓冲区的数组提供，也可以作为 `{pem: <string|buffer>[, passphrase: <string>]}` 形式的对象数组提供。 对象形式只能出现在数组中。 `object.passphrase` 是可选的。 如果提供了加密的密钥，则将使用 `object.passphrase` 解密，否则使用 `options.passphrase` 解密。
        
    -   `privateKeyEngine` [<string>](http://url.nodejs.cn/9Tw2bK) 从中获取私钥的 OpenSSL 引擎的名称。 应与 `privateKeyIdentifier` 一起使用。
        
    -   `privateKeyIdentifier` [<string>](http://url.nodejs.cn/9Tw2bK) 由 OpenSSL 引擎管理的私钥的标识符。 应与 `privateKeyEngine` 一起使用。 不应与 `key` 一起设置，因为这两个选项定义的私钥的方式不同。
        
    -   `maxVersion` [<string>](http://url.nodejs.cn/9Tw2bK) 可选择设置允许的最大 TLS 版本。 `'TLSv1.3'`、`'TLSv1.2'`、`'TLSv1.1'` 或 `'TLSv1'` 之一。
        
        **默认值:** [`tls.DEFAULT_MAX_VERSION`](http://nodejs.cn/api-v12/tls.html#tls_tls_default_max_version).
        
    -   `minVersion` [<string>](http://url.nodejs.cn/9Tw2bK) 可选择设置允许的最低 TLS 版本。 `'TLSv1.3'`、`'TLSv1.2'`、`'TLSv1.1'` 或 `'TLSv1'` 之一。
        
        **默认值:** [`tls.DEFAULT_MIN_VERSION`](http://nodejs.cn/api-v12/tls.html#tls_tls_default_min_version).
        
    -   `passphrase` [<string>](http://url.nodejs.cn/9Tw2bK) 用于单个私钥和/或 PFX 的共享密码。
        
    -   `pfx` [<string>](http://url.nodejs.cn/9Tw2bK) | [<string\[\]>](http://url.nodejs.cn/9Tw2bK) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Buffer\[\]>](http://nodejs.cn/api/buffer.html#class-buffer) | [<Object\[\]>](http://url.nodejs.cn/jzn6Ao) PFX 或 PKCS12 编码的私钥和证书链。 `pfx` 是单独提供 `key` 和 `cert` 的替代方案。 PFX 通常是加密的，如果是的话，会用 `passphrase` 来解密。 多个 PFX 可以作为未加密的 PFX 缓冲区数组或 `{buf: <string|buffer>[, passphrase: <string>]}` 形式的对象数组提供。 对象形式只能出现在数组中。 `object.passphrase` 是可选的。 如果提供加密的 PFX 将使用 `object.passphrase` 解密，否则将使用 `options.passphrase` 解密。
        
    -   `secureOptions` [<number>](http://url.nodejs.cn/SXbo1v) 可选地影响 OpenSSL 协议行为，这通常不是必需的。 如果有的话应该小心使用！ 值是 [OpenSSL 选项](http://nodejs.cn/api-v12/crypto.html#crypto_openssl_options)中 `SSL_OP_*` 选项的数字位掩码。
        
    -   `secureProtocol` [<string>](http://url.nodejs.cn/9Tw2bK) 旧的机制选择使用的 TLS 协议版本，不支持独立控制最小和最大版本，也不支持将协议限制为 TLSv1.3。改用 `minVersion` 和 `maxVersion`。 可能的值被列为 [SSL\_METHODS](http://url.nodejs.cn/CipgPu)，使用函数名称作为字符串。 例如，使用 `'TLSv1_1_method'` 强制使用 TLS 版本 1.1，或使用 `'TLS_method'` 允许任何 TLS 协议版本最高为 TLSv1.3。不建议使用低于 1.2 的 TLS 版本，但可能需要互操作性。 \*\*默认:\*\*无，见 `minVersion`。
        
    -   `sessionIdContext` [<string>](http://url.nodejs.cn/9Tw2bK) 服务器使用不透明标识符来确保应用程序之间不共享会话状态。 客户端未使用。
        
    -   `ticketKeys`: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 48 字节的加密强伪随机数据。 请参阅[会话恢复](http://nodejs.cn/api-v12/tls.html#tls_session_resumption)了解更多信息。
        
    -   `sessionTimeout` [<number>](http://url.nodejs.cn/SXbo1v) 服务器创建的 TLS 会话将无法恢复之前的秒数。 请参阅[会话恢复](http://nodejs.cn/api-v12/tls.html#tls_session_resumption)了解更多信息。 **默认值:** `300`。
        

[`tls.createServer()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createserver_options_secureconnectionlistener) 将 `honorCipherOrder` 选项的默认值设置为 `true`，创建安全上下文的其他 API 未设置。

[`tls.createServer()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createserver_options_secureconnectionlistener) 使用从 `process.argv` 生成的 128 位截断 SHA1 哈希值作为 `sessionIdContext` 选项的默认值，其他创建安全上下文的 API 没有默认值。

`tls.createSecureContext()` 方法创建了 `SecureContext` 对象。 它可用作几个 `tls` API 的参数，例如 [`tls.createServer()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createserver_options_secureconnectionlistener) 和 [`server.addContext()`](http://nodejs.cn/api-v12/tls.html#tls_server_addcontext_hostname_context)，但没有公共方法。

使用证书的密码_需要_密钥。 `key` 或 `pfx` 都可以提供。

如果没有给出 `ca` 选项，则 Node.js 将默认使用 [Mozilla 的公开信任的 CA 列表](http://url.nodejs.cn/jtCebP)。

### `tls.createSecurePair([context][, isServer][, requestCert][, rejectUnauthorized][, options])`[#](http://nodejs.cn/api-v12/tls.html#tlscreatesecurepaircontext-isserver-requestcert-rejectunauthorized-options)

[中英对照](http://nodejs.cn/api-v12/tls/tls_createsecurepair_context_isserver_requestcert_rejectunauthorized_options.html)

-   `context` [<Object>](http://url.nodejs.cn/jzn6Ao) `tls.createSecureContext()` 返回的安全上下文对象
-   `isServer` [<boolean>](http://url.nodejs.cn/jFbvuT) `true` 指定此 TLS 连接应作为服务器打开。
-   `requestCert` [<boolean>](http://url.nodejs.cn/jFbvuT) `true` 指定服务器是否应从连接的客户端请求证书。 仅在 `isServer` 为 `true` 时适用。
-   `rejectUnauthorized` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果不是 `false`，则服务器会自动拒绝证书无效的客户端。 仅在 `isServer` 为 `true` 时适用。
-   `options`
    -   `enableTrace`: 参见 [`tls.createServer()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createserver_options_secureconnectionlistener)
    -   `secureContext`: 来自 [`tls.createSecureContext()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createsecurecontext_options) 的 TLS 上下文对象
    -   `isServer`: 如果 `true` TLS 套接字将在服务器模式下实例化。 **默认值:** `false`。
    -   `server` [<net.Server>](http://nodejs.cn/api/net.html#class-netserver) [`net.Server`](http://nodejs.cn/api-v12/net.html#net_class_net_server) 实例
    -   `requestCert`: 参见 [`tls.createServer()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createserver_options_secureconnectionlistener)
    -   `rejectUnauthorized`: 参见 [`tls.createServer()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createserver_options_secureconnectionlistener)
    -   `ALPNProtocols`: 参见 [`tls.createServer()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createserver_options_secureconnectionlistener)
    -   `SNICallback`: 参见 [`tls.createServer()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createserver_options_secureconnectionlistener)
    -   `session` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 包含 TLS 会话的 `Buffer` 实例。
    -   `requestOCSP` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 `true`，则指定将 OCSP 状态请求扩展添加到客户端 hello 并且在建立安全通信之前将在套接字上触发 `'OCSPResponse'` 事件。

使用两个流创建新的安全对对象，其中一个读取和写入加密数据，另一个读取和写入明文数据。 通常，加密流通过管道传输到/从传入的加密数据流，明文用作初始加密流的替代。

`tls.createSecurePair()` 返回具有 `cleartext` 和 `encrypted` 流属性的 `tls.SecurePair` 对象。

使用 `cleartext` 与 [`tls.TLSSocket`](http://nodejs.cn/api-v12/tls.html#tls_class_tls_tlssocket) 具有相同的 API。

现在不推荐使用 `tls.createSecurePair()` 方法而支持 `tls.TLSSocket()`。 例如代码：

```
pair = tls.createSecurePair(/* ... */);
pair.encrypted.pipe(socket);
socket.pipe(pair.encrypted);
```

可以替换为：

```
secureSocket = tls.TLSSocket(socket, options);
```

其中 `secureSocket` 与 `pair.cleartext` 具有相同的 API。

### `tls.createServer([options][, secureConnectionListener])`[#](http://nodejs.cn/api-v12/tls.html#tlscreateserveroptions-secureconnectionlistener)

[中英对照](http://nodejs.cn/api-v12/tls/tls_createserver_options_secureconnectionlistener.html)

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `ALPNProtocols`: [<string\[\]>](http://url.nodejs.cn/9Tw2bK) | [<Buffer\[\]>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray\[\]>](http://url.nodejs.cn/oh3CkV) | [<DataView\[\]>](http://url.nodejs.cn/yCdVkD) | [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) 字符串数组、`Buffer`、或 `TypedArray`、或 `DataView`、或包含支持的 ALPN 协议的单个 `Buffer` 或 `TypedArray` 或 `DataView`。 `Buffer` 的格式应该是 `[len][name][len][name]...`，例如 `0x05hello0x05world`，其中第一个字节是下一个协议名称的长度。 传入数组通常要简单得多，例如 `['hello', 'world']`。 （协议应按优先级排序。）
    -   `clientCertEngine` [<string>](http://url.nodejs.cn/9Tw2bK) 可以提供客户端证书的 OpenSSL 引擎的名称。
    -   `enableTrace` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 `true`, 则 [`tls.TLSSocket.enableTrace()`](http://nodejs.cn/api-v12/tls.html#tls_tlssocket_enabletrace) 将在新连接上调用。 建立安全连接后可以启用跟踪，但必须使用此选项来跟踪安全连接设置。 **默认值:** `false`。
    -   `handshakeTimeout` [<number>](http://url.nodejs.cn/SXbo1v) 如果 SSL/TLS 握手未在指定的毫秒数内完成，则中止连接。 每当握手超时时，`tls.Server` 对象上就会触发 `'tlsClientError'`。 **默认值:** `120000` （120 秒）。
    -   `rejectUnauthorized` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果不是 `false`，则服务器将拒绝任何未经提供的 CA 列表授权的连接。 此选项仅在 `requestCert` 为 `true` 时有效。 **默认值:** `true`。
    -   `requestCert` [<boolean>](http://url.nodejs.cn/jFbvuT) 如果为 `true`，则服务器将从连接的客户端请求证书并尝试验证该证书。 **默认值:** `false`。
    -   `sessionTimeout` [<number>](http://url.nodejs.cn/SXbo1v) 服务器创建的 TLS 会话将无法恢复之前的秒数。 请参阅[会话恢复](http://nodejs.cn/api-v12/tls.html#tls_session_resumption)了解更多信息。 **默认值:** `300`。
    -   `SNICallback(servername, callback)` [<Function>](http://url.nodejs.cn/ceTQa6) 如果客户端支持 SNI TLS 扩展，将调用的函数。 调用时将传入两个参数：`servername` 和 `callback`。 `callback` 是错误优先的回调，它有两个可选参数：`error` 和 `ctx`。 `ctx` 是 `SecureContext` 实例（如果提供）。 [`tls.createSecureContext()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createsecurecontext_options) 可用于获得正确的 `SecureContext`。 如果使用非真的 `ctx` 参数调用 `callback`，则将使用服务器的默认安全上下文。 如果未提供 `SNICallback`，则将使用具有高级 API 的默认回调（见下文）。
    -   `ticketKeys`: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) 48 字节的加密强伪随机数据。 请参阅[会话恢复](http://nodejs.cn/api-v12/tls.html#tls_session_resumption)了解更多信息。
    -   `pskCallback` [<Function>](http://url.nodejs.cn/ceTQa6)
        -   socket: [<tls.TLSSocket>](http://nodejs.cn/api/tls.html#class-tlstlssocket) 此连接的服务器 [`tls.TLSSocket`](http://nodejs.cn/api-v12/tls.html#tls_class_tls_tlssocket) 实例。
        -   identity: [<string>](http://url.nodejs.cn/9Tw2bK) 客户端发送的身份参数。
        -   返回: [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) | [<TypedArray>](http://url.nodejs.cn/oh3CkV) | [<DataView>](http://url.nodejs.cn/yCdVkD) 预共享密钥必须是缓冲区或 `null` 才能停止协商过程。 返回的 PSK 必须与所选密码的摘要兼容。 当协商 TLS-PSK（预共享密钥）时，使用客户端提供的身份调用此函数。 如果返回值为 `null`，则协商过程将停止，并向对方发送 "unknown\_psk\_identity" 警告消息。 如果服务器希望隐藏 PSK 身份未知的事实，则回调必须提供一些随机数据作为 `psk` 以使连接失败并在协商完成之前出现 "decrypt\_error"。 默认情况下禁用 PSK 密码，因此使用 TLS-PSK 需要使用 `ciphers` 选项明确指定密码套件。 可以在 [RFC 4279](http://url.nodejs.cn/Gq5awY) 中找到更多信息。
    -   `pskIdentityHint` [<string>](http://url.nodejs.cn/9Tw2bK) 发送给客户端的可选提示，以帮助在 TLS-PSK 协商期间选择身份。 将在 TLS 1.3 中被忽略。设置 pskIdentityHint 失败时，`'tlsClientError'` 将与 `'ERR_TLS_PSK_SET_IDENTIY_HINT_FAILED'` 代码一起触发。
    -   ...: 可以提供任何 [`tls.createSecureContext()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createsecurecontext_options) 选项。 对于服务器，通常需要身份选项（`pfx`、`key`/`cert` 或 `pskCallback`）。
    -   ...: 可以提供任何 [`net.createServer()`](http://nodejs.cn/api-v12/net.html#net_net_createserver_options_connectionlistener) 选项。
-   `secureConnectionListener` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<tls.Server>](http://nodejs.cn/api/tls.html#class-tlsserver)

创建新的 [`tls.Server`](http://nodejs.cn/api-v12/tls.html#tls_class_tls_server)。 `secureConnectionListener`，如果提供，将自动设置为 [`'secureConnection'`](http://nodejs.cn/api-v12/tls.html#tls_event_secureconnection) 事件的监听器。

`ticketKeys` 选项在 `cluster` 模块工作器之间自动共享。

以下说明了一个简单的回显服务器：

```
const tls = require('tls');
const fs = require('fs');

const options = {
  key: fs.readFileSync('server-key.pem'),
  cert: fs.readFileSync('server-cert.pem'),

  // 这仅在使用客户端证书身份验证时才需要。
  requestCert: true,

  // 仅当客户端使用自签名证书时才需要这样做。
  ca: [ fs.readFileSync('client-cert.pem') ]
};

const server = tls.createServer(options, (socket) => {
  console.log('server connected',
              socket.authorized ? 'authorized' : 'unauthorized');
  socket.write('welcome!\n');
  socket.setEncoding('utf8');
  socket.pipe(socket);
});
server.listen(8000, () => {
  console.log('server bound');
});
```

可以通过使用 [`tls.connect()`](http://nodejs.cn/api-v12/tls.html#tls_tls_connect_options_callback) 的示例客户端连接到服务器来测试服务器。

### `tls.getCiphers()`[#](http://nodejs.cn/api-v12/tls.html#tlsgetciphers)

[中英对照](http://nodejs.cn/api-v12/tls/tls_getciphers.html)

新增于: v0.10.2

-   返回: [<string\[\]>](http://url.nodejs.cn/9Tw2bK)

返回包含支持的 TLS 密码名称的数组。 由于历史原因，名称为小写，但必须大写才能在 [`tls.createSecureContext()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createsecurecontext_options) 的 `ciphers` 选项中使用。

以 `'tls_'` 开头的密码名称适用于 TLSv1.3，所有其他密码均适用于 TLSv1.2 及以下。

```
console.log(tls.getCiphers()); // ['aes128-gcm-sha256', 'aes128-sha', ...]
```

### `tls.rootCertificates`[#](http://nodejs.cn/api-v12/tls.html#tlsrootcertificates)

[中英对照](http://nodejs.cn/api-v12/tls/tls_rootcertificates.html)

新增于: v12.3.0

-   [<string\[\]>](http://url.nodejs.cn/9Tw2bK)

不可变的字符串数组，代表当前 Node.js 版本提供的捆绑 Mozilla CA 存储中的根证书（以 PEM 格式）。

Node.js 提供的捆绑 CA 存储是 Mozilla CA 存储的快照，在发布时已修复。 它在所有支持的平台上都是相同的。

### `tls.DEFAULT_ECDH_CURVE`[#](http://nodejs.cn/api-v12/tls.html#tlsdefault_ecdh_curve)

[中英对照](http://nodejs.cn/api-v12/tls/tls_default_ecdh_curve.html)

tls 服务器中用于 ECDH 密钥协议的默认曲线名称。 默认值为 `'auto'`。 请参阅 [`tls.createSecureContext()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createsecurecontext_options) 了解更多信息。

### `tls.DEFAULT_MAX_VERSION`[#](http://nodejs.cn/api-v12/tls.html#tlsdefault_max_version)

[中英对照](http://nodejs.cn/api-v12/tls/tls_default_max_version.html)

新增于: v11.4.0

-   [<string>](http://url.nodejs.cn/9Tw2bK) [`tls.createSecureContext()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createsecurecontext_options) 的 `maxVersion` 选项的默认值。 它可以分配任何支持的 TLS 协议版本，`'TLSv1.3'`、`'TLSv1.2'`、`'TLSv1.1'` 或 `'TLSv1'`。 **默认值:** `'TLSv1.3'`, 除非使用 CLI 选项更改。 使用 `--tls-max-v1.2` 将默认设置为 `'TLSv1.2'`。 使用 `--tls-max-v1.3` 将默认设置为 `'TLSv1.3'`。 如果提供了多个选项，则使用最高的最大值。

### `tls.DEFAULT_MIN_VERSION`[#](http://nodejs.cn/api-v12/tls.html#tlsdefault_min_version)

[中英对照](http://nodejs.cn/api-v12/tls/tls_default_min_version.html)

新增于: v11.4.0

-   [<string>](http://url.nodejs.cn/9Tw2bK) [`tls.createSecureContext()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createsecurecontext_options) 的 `minVersion` 选项的默认值。 它可以分配任何支持的 TLS 协议版本，`'TLSv1.3'`、`'TLSv1.2'`、`'TLSv1.1'` 或 `'TLSv1'`。 **默认值:** `'TLSv1.2'`, 除非使用 CLI 选项更改。 使用 `--tls-min-v1.0` 将默认设置为 `'TLSv1'`。 使用 `--tls-min-v1.1` 将默认设置为 `'TLSv1.1'`。 使用 `--tls-min-v1.3` 将默认设置为 `'TLSv1.3'`。 如果提供了多个选项，则使用最低的最小值。
