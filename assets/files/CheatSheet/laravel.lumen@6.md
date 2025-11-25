# Lumen

## File

```php
app('files')->exists($path);
app('files')->get($path, $lock = false);
// 加锁读取文件内容
app('files')->sharedGet($path);
// 获取文件内容，不存在会抛出 FileNotFoundException 异常
app('files')->getRequire($path);
// 获取文件内容, 仅能引入一次
app('files')->requireOnce($file);
// 生成文件路径的 MD5 哈希
app('files')->hash($path);
// 将内容写入文件
app('files')->put($path, $contents, $lock = false);
// 写入文件，存在的话覆盖写入
app('files')->replace($path, $content);
// 将内容添加在文件原内容前面
app('files')->prepend($path, $data);
// 将内容添加在文件原内容后
app('files')->append($path, $data);
// 修改路径权限
app('files')->chmod($path, $mode = null);
// 通过给定的路径来删除文件
app('files')->delete($paths);
// 将文件移动到新目录下
app('files')->move($path, $target);
// 将文件复制到新目录下
app('files')->copy($path, $target);
// 创建硬连接
app('files')->link($target, $link);
// 从文件路径中提取文件名，不包含后缀
app('files')->name($path);
// 从文件路径中提取文件名，包含后缀
app('files')->basename($path);
// 获取文件路径名称
app('files')->dirname($path);
// 从文件的路径地址提取文件的扩展
app('files')->extension($path);
// 获取文件类型
app('files')->type($path);
// 获取文件 MIME 类型
app('files')->mimeType($path);
// 获取文件大小
app('files')->size($path);
// 获取文件的最后修改时间
app('files')->lastModified($path);
// 判断给定的路径是否是文件目录
app('files')->isDirectory($directory);
// 判断给定的路径是否是可读取
app('files')->isReadable($path);
// 判断给定的路径是否是可写入的
app('files')->isWritable($path);
// 判断给定的路径是否是文件
app('files')->isFile($file);
// 查找能被匹配到的路径名
app('files')->glob($pattern, $flags = 0);
// 获取一个目录下的所有文件, 以数组类型返回
app('files')->files($directory, $hidden = false);
// 获取一个目录下的所有文件 (递归).
app('files')->allFiles($directory, $hidden = false);
// 获取一个目录内的目录
app('files')->directories($directory);
// 创建一个目录
app('files')->makeDirectory($path, $mode = 0755, $recursive = false, $force = false);
// 移动目录
app('files')->moveDirectory($from, $to, $overwrite = false);
// 将文件夹从一个目录复制到另一个目录下
app('files')->copyDirectory($directory, $destination, $options = null);
// 删除目录
app('files')->deleteDirectory($directory, $preserve = false);
// 递归式删除目录
app('files')->deleteDirectories($directory);
// 清空指定目录的所有文件和文件夹
app('files')->cleanDirectory($directory);
```
