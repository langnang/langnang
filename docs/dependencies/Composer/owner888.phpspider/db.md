---
created: 2023-03-19T14:05:18 (UTC +08:00)
tags: []
source: https://doc.phpspider.org/db.html
author: seatle
---

# configs 详解——之 db · phpspider 开发文档

> ## Excerpt
>
> 本节介绍 db 类用法

---

**本节介绍 db 类用法**

## 数据库配置链接

```
$db_config = array(
    'host'  => '127.0.0.1',
    'port'  => 3306,
    'user'  => 'root',
    'pass'  => 'root',
    'name'  => 'qiushibaike',
);
// 数据库配置
db::set_connect('default', $db_config);
// 数据库链接
db::init_mysql();
```

## 原生 SQL 操作

### `query($sql)`

举个栗子:

```
// 查询
$rsid = db::query("Select * From `content`");
while ( $row = db::fetch($rsid) )
{
    echo "id = {$row['id']}; name = {$row['name']}\n";
}

// 新增
db::query("Insert Into `content`(`name`) Value('test'));

// 更新
db::query("Update `content` Set `name`='test' Where `id`=1");

// 删除
db::query("Delete From `content` Where `id`='1'");
```

## CRUD 操作

### `get_one($sql)`

**单条查询**

举个栗子:

```
$row = db::get_one("Select * From `content` Where `id`='1'");
```

### `get_all($sql)`

**多条查询**

举个栗子:

```
$rows = db::get_all("Select * From `content` Limit 5");
```

### `insert($table, $data)`

**单条插入**

举个栗子:

```
$data = array(
    'name' => 'test',
    'url'  => 'http://www.baidu.com'
);
$rows = db::insert('content', $data);
```

### `insert_batch($table, $data)`

**单条修改**

举个栗子:

```
$data = array(
    array(
        'name' => 'test111',
        'url'  => 'http://www.baidu.com'
    ),
    array(
        'name' => 'test222',
        'url'  => 'http://www.baidu.com'
    ),
);
$rows = db::insert_batch('content', $data);
```

### `update_batch($table, $data, $index)`

**批量修改**

举个栗子:

```
$data = array(
    array(
        'name' => 'test111',
        'url'  => 'http://www.baidu.com'
    ),
    array(
        'name' => 'test222',
        'url'  => 'http://www.baidu.com'
    ),
);
// 以name为条件进行修改
$rows = db::update_batch('content', $data, "name");
```

### `delete($table, $where)`

**单条删除**

举个栗子:

```
$rows = db::delete('content', "`id`='1'");
```
