# Illuminate

- Application: 应用启动器
- Arr: 数组辅助函数
- Config: 配置
- Controller: 控制器
- Database: 数据库操作
- Date: 时间日期辅助函数
- Env: 环境变量
- File:
- FileSystem:
- Filter: 过滤器
- Http:
- Log: 日志
- Module: 模块
- Redirect:
- Request:
- Reponse:
- Route: 路由
- Selector: DOM 选择器
- Spider: 提取器
- Storage: 存储
- Str: 字符串辅助函数
- View: 视图

## Facades

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

## Methods

### MagicMethods

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

### LifeCycleMethods

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
