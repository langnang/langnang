# Modules

## Core<!-- {docsify-ignore-all} -->

> 核心

### App\Http\Controllers

#### Controller

```php
namespace App\Http\Controllers;

class Controller{

}
```

### \App\Support\Module

### \App\Traits\Model\HasCrud

### \App\Traits\Model\HasFamily

```php
namespace App\Traits\Model;

trait HasFamily{
    protected $prevKey;

    public function prev(){}

    protected $nextKey;
    
    public function next(){}

    protected $parentKey;

    public function parent(){}

    public function children(){}
}
```

## Market

> 应用市场

- 搜索
- 分片下载
- 解压
- 移动到对应路径
- 更新配置文件

### \Market\Support\Market

```php
use Modules\Market\Support\Market;

Market::installPackage($name,$version,$relativePath=null);
```

### \Market\Http\Controllers\MarketModuleController

### \Market\Http\Controllers\MarketSoftwareController

### \Market\Http\Controllers\MarketExampleController

### \Market\Http\Controllers\MarketThemeController

### \Market\Http\Controllers\MarketPackageController

## Spider

> 数据爬虫
