---
created: 2023-03-19T14:05:18 (UTC +08:00)
tags: []
source: https://doc.phpspider.org/development_skills/file_get_contents-proxy.html
author: seatle
---

# file_get_contents 设置代理抓取页面 · phpspider 开发文档

> ## Excerpt
>
> No results matching ""

---

### `普通页面获取`

```
$url = "http://www.epooll.com/archives/806/";
$contents = file_get_contents($url);
preg_match_all("/<h1>(.*?)</h1>/is", $content, $matchs);
print_r($matchs[0]);
```

### `设置代理IP去采集数据`

```
$context = array(
    'http' => array(
        'proxy' => 'tcp://192.168.0.2:3128',  //这里设置你要使用的代理ip及端口号
        'request_fulluri' => true,
    ),
);
$context = stream_context_create($context);
$html = file_get_contents("http://www.epooll.com/archives/806/", false, $context);
echo $html;
```

### `设置需要验证的代理IP去采集数据`

```
$auth = base64_encode('USER:PASS');   //LOGIN:PASSWORD 这里是代理服务器的账户名及密码
$context = array(
    'http' => array(
        'proxy' => 'tcp://192.168.0.2:3128',  //这里设置你要使用的代理ip及端口号
        'request_fulluri' => true,
        'header' => "Proxy-Authorization: Basic $auth",
    ),
);
$context = stream_context_create($context);
$html = file_get_contents("http://www.epooll.com/archives/806/", false, $context);
echo $html;
```
