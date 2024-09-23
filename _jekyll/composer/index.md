---
title: Composer
---

## Illuminate

- Account
- Annotation: 注释
- [Application](./app.md): 应用启动器
- Artisan
- ASCII
- Auth: 安全-用户认证
- Autoload
- Blade
- Broadcast
- Bus
- Cache
- Calendar: 日历
- Command
- [Config](): 配置
- Console
- Container
- Contract: 契约
- Controller: 控制器
- Cookie
- Crypt
- [Database](./database.md)
  - Schema
  - Table
  - Column
- Date
- DevTool
- Eloquent: 数据库-模型关联
- Environment(env): 环境变量
- Err
- Event
- Facade
- Faker
- FFmpeg
- File
  - [Markdown](./file.markdown.md)
  - Html
  - Xlsx
  - Pdf  
  - Js
  - Css
  - Sql
  - Txt
  - Zip
- FileSystem
- Filter
- Ftp
- Gate: 安全-用户授权
- Hash
- Helper: 辅助函数
  - [Arr](./helper.arr.md): 数组
  - [Collection]
  - Date: 时间日期
  - [Str](./helper.str.md): 字符串
  - Filter: 过滤
- Http
  - Request
  - Reponse
- Internationalization(i18n): 国际化
- Log: 日志
- Mail: 邮件
- Migration
- [Model]
- [Modular](): 模块化
- Notification
- Paginator: 数据库-数据分页
- Password
- Pipeline
- [Plugin](): 插件
- Process
- Query: 数据库-查询构造器
  - Builder
- Queue: 队列
- RateLimiter
- Redirect
- [RegExp](./reg-exp.md): 正则
  - Validator
- Request
- Response: 响应
- Route: 路由
  - URL
  - Redirect: 重定向
- Schedule
- Schema: 架构
- Seeder
- Selector
- Session
- Spider: 数据采集
  - Selector: DOM 选择器
- Storage: 存储
- Traitor
- Usage
- User
- [VarDumper]
- [View](): 视图
- Yielder

### Facades

- Str

- `make`
- `handle`
- `set`
- `get`
- `call`
- `singleton`
- `toArray`
- `toString`
- `toJson`
- `toHtml`
- `print`
- `dump`
- `singleton`
<!-- - `toHtml` -->

### Methods

#### MagicMethods

```php
function __construct(){}
function __clone(){}
function __call(){}
function __debugInfo(){}
function __get(){}
function __invoke(){}
function __isset(){}
function __serialize(){}
function __set(){}
function __unset(){}
/**
 * __sleep在一个对象序列化前调用，它不接收任何参数，但会返回数组
 */
function __sleep(){}
/**
 * 而__wakeup则相反，它是在反序列化前触发的
 * __wakeup()，执行unserialize()时，先会调用这个函数
 */
function __wakeup(){}
function __toString(){}

static function __callStatic(){}
```

#### LifeCycleMethods

```php
function _(){}
/**
 * 初始化
 */
function _init(){}
/**
 * 自动装载
 */
function _autoload(){}
/**
 * 运行化
 */
function _run(){}
/**
 * 标准化
 */
function _standard(){}
/**
 * 规则化
 */
function _validate(){}
/**
 * 日志化
 */
function _log(){}
/**
 * 调试
 */
function _debug(){}
/**
 * 打印
 */
function _print(){}
```
