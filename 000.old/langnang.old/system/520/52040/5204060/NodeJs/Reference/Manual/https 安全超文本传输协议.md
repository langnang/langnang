---
created: 2022-07-29T13:12:52 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/https.html
author: 
---

# https 安全超文本传输协议 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/https/https.html)

**源代码:** [lib/https.js](https://github.com/nodejs/node/blob/v12.22.12/lib/https.js)

HTTPS 是基于 TLS/SSL 的 HTTP 协议。 在 Node.js 中，作为单独的模块实现。

### `https.Agent` 类[#](http://nodejs.cn/api-v12/https.html#class-httpsagent)

[中英对照](http://nodejs.cn/api-v12/https/class_https_agent.html)

HTTPS 的 [`Agent`](http://nodejs.cn/api-v12/https.html#https_class_https_agent) 对象，类似于 [`http.Agent`](http://nodejs.cn/api-v12/http.html#http_class_http_agent)。 有关详细信息，请参阅 [`https.request()`](http://nodejs.cn/api-v12/https.html#https_https_request_options_callback)。

#### `new Agent([options])`[#](http://nodejs.cn/api-v12/https.html#new-agentoptions)

[中英对照](http://nodejs.cn/api-v12/https/new_agent_options.html)

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) 要在代理上设置的可配置选项集。 可以具有与 [`http.Agent(options)`](http://nodejs.cn/api-v12/http.html#http_new_agent_options) 相同的字段，以及
    -   `maxCachedSessions` [<number>](http://url.nodejs.cn/SXbo1v) TLS 缓存会话的最大数量。 使用 `0` 禁用 TLS 会话缓存。 **默认值:** `100`。
        
    -   `servername` [<string>](http://url.nodejs.cn/9Tw2bK) 要发送到服务器的[服务器名称指示扩展](http://url.nodejs.cn/aNspMj)的值。 使用空字符串 `''` 禁用发送扩展名。 **默认值:** 目标服务器的主机名，除非使用 IP 地址指定目标服务器，在这种情况下，默认为 `''`（无扩展名）。
        
        有关 TLS 会话重用的信息，请参阅[会话恢复](http://nodejs.cn/api-v12/tls.html#tls_session_resumption)。
        

##### `'keylog'` 事件[#](http://nodejs.cn/api-v12/https.html#event-keylog)

[中英对照](http://nodejs.cn/api-v12/https/event_keylog.html)

新增于: v12.16.0

-   `line` [<Buffer>](http://nodejs.cn/api/buffer.html#class-buffer) ASCII 文本行，采用 NSS `SSLKEYLOGFILE` 格式。
-   `tlsSocket` [<tls.TLSSocket>](http://nodejs.cn/api/tls.html#class-tlstlssocket) 生成它的 `tls.TLSSocket` 实例。

当此代理管理的连接生成或接收密钥材料时（通常在握手完成之前，但不一定），则会触发 `keylog` 事件。 该密钥材料可以存储用于调试，因为它允许对捕获的 TLS 流量进行解密。 它可以为每个套接字多次触发。

一个典型的用例是将接收到的行附加到公共文本文件中，稍后软件（例如 Wireshark）使用它来解密流量：

```
// ...
https.globalAgent.on('keylog', (line, tlsSocket) => {
  fs.appendFileSync('/tmp/ssl-keys.log', line, { mode: 0o600 });
});
```

### `https.Server` 类[#](http://nodejs.cn/api-v12/https.html#class-httpsserver)

[中英对照](http://nodejs.cn/api-v12/https/class_https_server.html)

新增于: v0.3.4

-   继承自: [<tls.Server>](http://nodejs.cn/api/tls.html#class-tlsserver)

有关详细信息，请参阅 [`http.Server`](http://nodejs.cn/api-v12/http.html#http_class_http_server)。

#### `server.close([callback])`[#](http://nodejs.cn/api-v12/https.html#serverclosecallback)

[中英对照](http://nodejs.cn/api-v12/https/server_close_callback.html)

新增于: v0.1.90

-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<https.Server>](http://nodejs.cn/api/https.html#class-httpsserver)

有关详细信息，请参阅 HTTP 模块中的 [`server.close()`](http://nodejs.cn/api-v12/http.html#http_server_close_callback)。

#### `server.headersTimeout`[#](http://nodejs.cn/api-v12/https.html#serverheaderstimeout)

[中英对照](http://nodejs.cn/api-v12/https/server_headerstimeout.html)

新增于: v11.3.0

-   [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `60000`

参见 [`http.Server#headersTimeout`](http://nodejs.cn/api-v12/http.html#http_server_headerstimeout)。

#### `server.listen()`[#](http://nodejs.cn/api-v12/https.html#serverlisten)

[中英对照](http://nodejs.cn/api-v12/https/server_listen.html)

启动 HTTPS 服务器监听加密连接。 此方法与 [`net.Server`](http://nodejs.cn/api-v12/net.html#net_class_net_server) 中的 [`server.listen()`](http://nodejs.cn/api-v12/net.html#net_server_listen) 相同。

#### `server.maxHeadersCount`[#](http://nodejs.cn/api-v12/https.html#servermaxheaderscount)

[中英对照](http://nodejs.cn/api-v12/https/server_maxheaderscount.html)

-   [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `2000`

参见 [`http.Server#maxHeadersCount`](http://nodejs.cn/api-v12/http.html#http_server_maxheaderscount)。

#### `server.setTimeout([msecs][, callback])`[#](http://nodejs.cn/api-v12/https.html#serversettimeoutmsecs-callback)

[中英对照](http://nodejs.cn/api-v12/https/server_settimeout_msecs_callback.html)

新增于: v0.11.2

-   `msecs` [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `120000` （2 分钟）
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)
-   返回: [<https.Server>](http://nodejs.cn/api/https.html#class-httpsserver)

参见 [`http.Server#setTimeout()`](http://nodejs.cn/api-v12/http.html#http_server_settimeout_msecs_callback)。

#### `server.timeout`[#](http://nodejs.cn/api-v12/https.html#servertimeout)

[中英对照](http://nodejs.cn/api-v12/https/server_timeout.html)

新增于: v0.11.2

-   [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `120000` （2 分钟）

参见 [`http.Server#timeout`](http://nodejs.cn/api-v12/http.html#http_server_timeout)。

#### `server.keepAliveTimeout`[#](http://nodejs.cn/api-v12/https.html#serverkeepalivetimeout)

[中英对照](http://nodejs.cn/api-v12/https/server_keepalivetimeout.html)

新增于: v8.0.0

-   [<number>](http://url.nodejs.cn/SXbo1v) **默认值:** `5000` （5 秒）

参见 [`http.Server#keepAliveTimeout`](http://nodejs.cn/api-v12/http.html#http_server_keepalivetimeout)。

### `https.createServer([options][, requestListener])`[#](http://nodejs.cn/api-v12/https.html#httpscreateserveroptions-requestlistener)

[中英对照](http://nodejs.cn/api-v12/https/https_createserver_options_requestlistener.html)

新增于: v0.3.4

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) 接受来自 [`tls.createServer()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createserver_options_secureconnectionlistener)、[`tls.createSecureContext()`](http://nodejs.cn/api-v12/tls.html#tls_tls_createsecurecontext_options) 和 [`http.createServer()`](http://nodejs.cn/api-v12/http.html#http_http_createserver_options_requestlistener) 的 `options`。
-   `requestListener` [<Function>](http://url.nodejs.cn/ceTQa6) 要添加到 `'request'` 事件的监听器。
-   返回: [<https.Server>](http://nodejs.cn/api/https.html#class-httpsserver)

```
// curl -k https://localhost:8000/
const https = require('https');
const fs = require('fs');

const options = {
  key: fs.readFileSync('test/fixtures/keys/agent2-key.pem'),
  cert: fs.readFileSync('test/fixtures/keys/agent2-cert.pem')
};

https.createServer(options, (req, res) => {
  res.writeHead(200);
  res.end('hello world\n');
}).listen(8000);
```

或者

```
const https = require('https');
const fs = require('fs');

const options = {
  pfx: fs.readFileSync('test/fixtures/test_cert.pfx'),
  passphrase: 'sample'
};

https.createServer(options, (req, res) => {
  res.writeHead(200);
  res.end('hello world\n');
}).listen(8000);
```

### `https.get(options[, callback])`[#](http://nodejs.cn/api-v12/https.html#httpsgetoptions-callback)

### `https.get(url[, options][, callback])`[#](http://nodejs.cn/api-v12/https.html#httpsgeturl-options-callback)

[中英对照](http://nodejs.cn/api-v12/https/https_get_url_options_callback.html)

-   `url` [<string>](http://url.nodejs.cn/9Tw2bK) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) 接受与 [`https.request()`](http://nodejs.cn/api-v12/https.html#https_https_request_options_callback) 相同的 `options`，但 `method` 始终设置为 `GET`。
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)

类似于 [`http.get()`](http://nodejs.cn/api-v12/http.html#http_http_get_options_callback)，但用于 HTTPS。

`options` 可以是对象、字符串或 [`URL`](http://nodejs.cn/api-v12/url.html#url_the_whatwg_url_api) 对象。 如果 `options` 是字符串，则会自动使用 [`new URL()`](http://nodejs.cn/api-v12/url.html#url_new_url_input_base) 解析。 如果是 [`URL`](http://nodejs.cn/api-v12/url.html#url_the_whatwg_url_api) 对象，则会自动转换为普通的 `options` 对象。

```
const https = require('https');

https.get('https://encrypted.google.com/', (res) => {
  console.log('statusCode:', res.statusCode);
  console.log('headers:', res.headers);

  res.on('data', (d) => {
    process.stdout.write(d);
  });

}).on('error', (e) => {
  console.error(e);
});
```

### `https.globalAgent`[#](http://nodejs.cn/api-v12/https.html#httpsglobalagent)

[中英对照](http://nodejs.cn/api-v12/https/https_globalagent.html)

新增于: v0.5.9

所有 HTTPS 客户端请求的 [`https.Agent`](http://nodejs.cn/api-v12/https.html#https_class_https_agent) 全局实例。

### `https.request(options[, callback])`[#](http://nodejs.cn/api-v12/https.html#httpsrequestoptions-callback)

### `https.request(url[, options][, callback])`[#](http://nodejs.cn/api-v12/https.html#httpsrequesturl-options-callback)

[中英对照](http://nodejs.cn/api-v12/https/https_request_url_options_callback.html)

-   `url` [<string>](http://url.nodejs.cn/9Tw2bK) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api)
-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao) | [<string>](http://url.nodejs.cn/9Tw2bK) | [<URL>](http://nodejs.cn/api/url.html#the-whatwg-url-api) 接受来自 [`http.request()`](http://nodejs.cn/api-v12/http.html#http_http_request_options_callback) 的所有 `options`，默认值有一些不同：
    -   `protocol` **默认值:** `'https:'`
    -   `port` **默认值:** `443`
    -   `agent` **默认值:** `https.globalAgent`
-   `callback` [<Function>](http://url.nodejs.cn/ceTQa6)

发出请求到安全的 Web 服务器。

`options` 可以是对象、字符串或 [`URL`](http://nodejs.cn/api-v12/url.html#url_the_whatwg_url_api) 对象。 如果 `options` 是字符串，则会自动使用 [`new URL()`](http://nodejs.cn/api-v12/url.html#url_new_url_input_base) 解析。 如果是 [`URL`](http://nodejs.cn/api-v12/url.html#url_the_whatwg_url_api) 对象，则会自动转换为普通的 `options` 对象。

```
const https = require('https');

const options = {
  hostname: 'encrypted.google.com',
  port: 443,
  path: '/',
  method: 'GET'
};

const req = https.request(options, (res) => {
  console.log('statusCode:', res.statusCode);
  console.log('headers:', res.headers);

  res.on('data', (d) => {
    process.stdout.write(d);
  });
});

req.on('error', (e) => {
  console.error(e);
});
req.end();
```

使用 [`tls.connect()`](http://nodejs.cn/api-v12/tls.html#tls_tls_connect_options_callback) 中的选项的示例：

```
const options = {
  hostname: 'encrypted.google.com',
  port: 443,
  path: '/',
  method: 'GET',
  key: fs.readFileSync('test/fixtures/keys/agent2-key.pem'),
  cert: fs.readFileSync('test/fixtures/keys/agent2-cert.pem')
};
options.agent = new https.Agent(options);

const req = https.request(options, (res) => {
  // ...
});
```

或者，通过不使用 [`Agent`](http://nodejs.cn/api-v12/https.html#https_class_https_agent) 来选择退出连接池。

```
const options = {
  hostname: 'encrypted.google.com',
  port: 443,
  path: '/',
  method: 'GET',
  key: fs.readFileSync('test/fixtures/keys/agent2-key.pem'),
  cert: fs.readFileSync('test/fixtures/keys/agent2-cert.pem'),
  agent: false
};

const req = https.request(options, (res) => {
  // ...
});
```

使用 [`URL`](http://nodejs.cn/api-v12/url.html#url_the_whatwg_url_api) 作为 `options` 的示例：

```
const options = new URL('https://abc:xyz@example.com');

const req = https.request(options, (res) => {
  // ...
});
```

固定证书指纹或公钥（类似于 `pin-sha256`）的示例：

```
const tls = require('tls');
const https = require('https');
const crypto = require('crypto');

function sha256(s) {
  return crypto.createHash('sha256').update(s).digest('base64');
}
const options = {
  hostname: 'github.com',
  port: 443,
  path: '/',
  method: 'GET',
  checkServerIdentity: function(host, cert) {
    // 确保证书颁发给连接的主机
    const err = tls.checkServerIdentity(host, cert);
    if (err) {
      return err;
    }

    // 固定公钥，类似于 HPKP pin-sha25 固定
    const pubkey256 = 'pL1+qb9HTMRZJmuC/bB/ZI9d302BYrrqiVuRyW+DGrU=';
    if (sha256(cert.pubkey) !== pubkey256) {
      const msg = 'Certificate verification error: ' +
        `The public key of '${cert.subject.CN}' ` +
        'does not match our pinned fingerprint';
      return new Error(msg);
    }

    // 固定确切的证书，而不是公钥
    const cert256 = '25:FE:39:32:D9:63:8C:8A:FC:A1:9A:29:87:' +
      'D8:3E:4C:1D:98:DB:71:E4:1A:48:03:98:EA:22:6A:BD:8B:93:16';
    if (cert.fingerprint256 !== cert256) {
      const msg = 'Certificate verification error: ' +
        `The certificate of '${cert.subject.CN}' ` +
        'does not match our pinned fingerprint';
      return new Error(msg);
    }

    // 此循环仅供参考。
    // 打印链中所有证书的证书和公钥指纹。
    // 通常，在公共互联网上固定发行者的公钥，在敏感环境中固定服务的公钥。
    do {
      console.log('Subject Common Name:', cert.subject.CN);
      console.log('  Certificate SHA256 fingerprint:', cert.fingerprint256);

      hash = crypto.createHash('sha256');
      console.log('  Public key ping-sha256:', sha256(cert.pubkey));

      lastprint256 = cert.fingerprint256;
      cert = cert.issuerCertificate;
    } while (cert.fingerprint256 !== lastprint256);

  },
};

options.agent = new https.Agent(options);
const req = https.request(options, (res) => {
  console.log('All OK. Server matched our pinned cert or public key');
  console.log('statusCode:', res.statusCode);
  // 打印 HPKP 值
  console.log('headers:', res.headers['public-key-pins']);

  res.on('data', (d) => {});
});

req.on('error', (e) => {
  console.error(e.message);
});
req.end();
```

示例的输出：

```
Subject Common Name: github.com
  Certificate SHA256 fingerprint: 25:FE:39:32:D9:63:8C:8A:FC:A1:9A:29:87:D8:3E:4C:1D:98:DB:71:E4:1A:48:03:98:EA:22:6A:BD:8B:93:16
  Public key ping-sha256: pL1+qb9HTMRZJmuC/bB/ZI9d302BYrrqiVuRyW+DGrU=
Subject Common Name: DigiCert SHA2 Extended Validation Server CA
  Certificate SHA256 fingerprint: 40:3E:06:2A:26:53:05:91:13:28:5B:AF:80:A0:D4:AE:42:2C:84:8C:9F:78:FA:D0:1F:C9:4B:C5:B8:7F:EF:1A
  Public key ping-sha256: RRM1dGqnDFsCJXBTHky16vi1obOlCgFFn/yOhI/y+ho=
Subject Common Name: DigiCert High Assurance EV Root CA
  Certificate SHA256 fingerprint: 74:31:E5:F4:C3:C1:CE:46:90:77:4F:0B:61:E0:54:40:88:3B:A9:A0:1E:D0:0B:A6:AB:D7:80:6E:D3:B1:18:CF
  Public key ping-sha256: WoiWRyIOVNa9ihaBciRSC7XHjliYS9VwUGOIud4PB18=
All OK. Server matched our pinned cert or public key
statusCode: 200
headers: max-age=0; pin-sha256="WoiWRyIOVNa9ihaBciRSC7XHjliYS9VwUGOIud4PB18="; pin-sha256="RRM1dGqnDFsCJXBTHky16vi1obOlCgFFn/yOhI/y+ho="; pin-sha256="k2v657xBsOVe1PQRwOsHsw3bsGT2VzIqz5K+59sNQws="; pin-sha256="K87oWBWM9UZfyddvDfoxL+8lpNyoUB2ptGtn0fv6G2Q="; pin-sha256="IQBnNBEiFuhj+8x6X8XLgh01V9Ic5/V3IRQLNFFc7v4="; pin-sha256="iie1VXtL7HzAMF+/PVPR9xzT80kQxdZeJ+zduCB3uj0="; pin-sha256="LvRiGEjRqfzurezaWuj8Wie2gyHMrW5Q06LspMnox7A="; includeSubDomains
```
