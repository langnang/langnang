---
created: 2023-03-19T14:05:18 (UTC +08:00)
tags: []
source: https://doc.phpspider.org/development_skills/simulateLanding.html
author: seatle
---

# 如何实现模拟登录？ · phpspider 开发文档

> ## Excerpt
>
> 通过模拟登录, 可以解决登录后才能爬取某些网站数据的问题.PHPSpider 框架提供两种登录方式：

---

## 如何实现模拟登录？

> 通过模拟登录, 可以解决登录后才能爬取某些网站数据的问题.  
> PHPSpider 框架提供两种登录方式：
>
> > 1、通过发送 HTTP 请求来实现模拟登录  
> > 2、从 Chrome 浏览器拷贝 Cookie 字符串

### 通过发送 HTTP 请求来实现模拟登录

举个栗子:

```
// 登录请求url
$login_url = "http://www.waduanzi.com/login?url=http%3A%2F%2Fwww.waduanzi.com%2F";
// 提交的参数
$params = array(
    "LoginForm[returnUrl]" => "http%3A%2F%2Fwww.waduanzi.com%2F",
    "LoginForm[username]" => "13712899314",
    "LoginForm[password]" => "854230",
    "yt0" => "登录",
);
// 发送登录请求
requests::post($login_url, $params);
// 登录成功后本框架会把Cookie保存到www.waduanzi.com域名下，我们可以看看是否是已经收集到Cookie了
$cookies = requests::get_cookies("www.waduanzi.com");
print_r($cookies);  // 可以看到已经输出Cookie数组结构

// requests对象自动收集Cookie，访问这个域名下的URL会自动带上
// 接下来我们来访问一个需要登录后才能看到的页面
$url = "http://www.waduanzi.com/member";
$html = requests::get($url);
echo $html;     // 可以看到登录后的页面，非常棒👍
```

### `如何获得提交参数？`

登录需要登录验证信息，下面我们来看看如何获得一个网站所需要的登录信息  
还是以挖段子(www.waduanzi.com)为例，看看如何获得下面的信息

**1、打开挖段子网站点击登录按钮进入登陆页：**  
`http://www.waduanzi.com/login?url=http%3A%2F%2Fwww.waduanzi.com%2F`

**2、鼠标点击右键 -> 检查 从而打开 Chrome 浏览器的开发者工具**

![](https://doc.phpspider.org/development_skills/login1.png)

**选择 Network 选项卡，勾选 Preserve log 选项**

![](https://doc.phpspider.org/development_skills/login2.png)

**3、填写登陆信息点击登录按钮，得到登录验证 URL**

![](https://doc.phpspider.org/development_skills/login3.png)

**4、上面的登录提交字段填入框架代码**

```
$params => array(
    "LoginForm[returnUrl]" => "http%3A%2F%2Fwww.waduanzi.com%2F",
    "LoginForm[username]" => "用户名",
    "LoginForm[password]" => "密码",
    "yt0" => "登录",
)
```

### 从 Chrome 浏览器拷贝 Cookie 字符串

上面的方式适用于简单的登录验证方式，如果遇到验证码，token 表单字段，还有各种用 js 加密算法生成的登录字段，模拟登录就会变得异常复杂，为了节省时间，我们一般人工登录后，拷贝 Cookie 字符串来登录

**1、登录成功后，在跳转的页面找 Cookie 字符串**

![](https://doc.phpspider.org/development_skills/chome_login.png)

**2、上面的登录提交字段填入框架代码**

```
// 模拟登录
$cookies = "复制上面Cookie:后面那一串字符串...";
requests::set_cookies($cookies, 'www.waduanzi.com');

// 接下来我们来访问一个需要登录后才能看到的页面
$url = "http://www.waduanzi.com/member";
$html = requests::get($url);
echo $html;     // 可以看到登录后的页面，非常棒👍
```
