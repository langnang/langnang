<?php
/**
* @name filesystem.php PHP文件系统相关扩展
*
* @description 基于PHP的filesystem扩展，编写相关函数，方便调用
* @author tsora <1624327728@qq.com>
* @version 0.0.1
* @update 2018-09-20
* @vendor PHP-7.2.6 Apache-2.4.33
* @todo ...
* 
* ========== PHP的filesystem函数 ==================
* basename() 返回路径中的文件名部分。
* chgrp() 改变文件组。
* chmod() 改变文件模式。
* chown() 改变文件所有者。
* clearstatcache() 清除文件状态缓存。
* copy() 复制文件。
* delete() 参见 unlink() 或 unset()。
* dirname() 返回路径中的目录名称部分。
* disk_free_space() 返回目录的可用空间。
* disk_total_space() 返回一个目录的磁盘总容量。
* diskfreespace() disk_free_space() 的别名。
* fclose() 关闭打开的文件。
* feof() 测试文件指针是否到了文件结束的位置。
* fflush() 向打开的文件输出缓冲内容。
* fgetc() 从打开的文件中返回字符。
* fgetcsv() 从打开的文件中解析一行，校验 CSV 字段。
* fgets() 从打开的文件中返回一行。
* fgetss() 从打开的文件中读取一行并过滤掉 HTML 和 PHP 标记。
* file() 把文件读入一个数组中。
* file_exists() 检查文件或目录是否存在。
* file_get_contents(path[,include_path[,context[,start[,max_length]]]]) 将文件读入字符串。
* file_put_contents() 将字符串写入文件。
* fileatime() 返回文件的上次访问时间。
* filectime() 返回文件的上次改变时间。
* filegroup() 返回文件的组 ID。
* fileinode() 返回文件的 inode 编号。
* filemtime() 返回文件的上次修改时间。
* fileowner() 文件的 user ID （所有者）。
* fileperms() 返回文件的权限。
* filesize() 返回文件大小。
* filetype() 返回文件类型。
* flock() 锁定或释放文件。
* fnmatch() 根据指定的模式来匹配文件名或字符串。
* fopen() 打开一个文件或 URL。
* fpassthru() 从打开的文件中读数据，直到 EOF，并向输出缓冲写结果。
* fputcsv() 将行格式化为 CSV 并写入一个打开的文件中。
* fputs() fwrite() 的别名。
* fread() 读取打开的文件。
* fscanf() 根据指定的格式对输入进行解析。
* fseek() 在打开的文件中定位。
* fstat() 返回关于一个打开的文件的信息。
* ftell() 返回文件指针的读/写位置
* ftruncate() 将文件截断到指定的长度。
* fwrite() 写入文件。
* glob() 返回一个包含匹配指定模式的文件名/目录的数组。
* is_dir() 判断指定的文件名是否是一个目录。
* is_executable() 判断文件是否可执行。
* is_file() 判断指定文件是否为常规的文件。
* is_link() 判断指定的文件是否是连接。
* is_readable() 判断文件是否可读。
* is_uploaded_file() 判断文件是否是通过 HTTP POST 上传的。
* is_writable() 判断文件是否可写。
* is_writeable() is_writable() 的别名。
* link() 创建一个硬连接。
* linkinfo() 返回有关一个硬连接的信息。
* lstat() 返回关于文件或符号连接的信息。
* mkdir() 创建目录。
* move_uploaded_file() 将上传的文件移动到新位置。
* parse_ini_file() 解析一个配置文件。
* pathinfo() 返回关于文件路径的信息。
* pclose() 关闭有 popen() 打开的进程。
* popen() 打开一个进程。
* readfile() 读取一个文件，并输出到输出缓冲。
* readlink() 返回符号连接的目标。
* realpath() 返回绝对路径名。
* rename() 重名名文件或目录。
* rewind() 倒回文件指针的位置。
* rmdir() 删除空的目录。
* set_file_buffer() 设置已打开文件的缓冲大小。
* stat() 返回关于文件的信息。
* symlink() 创建符号连接。
* tempnam() 创建唯一的临时文件。
* tmpfile() 建立临时文件。
* touch() 设置文件的访问和修改时间。
* umask() 改变文件的文件权限。
* unlink() 删除文件。
*/

// 引用文件
include_once "open.php";
include_once "read.php";
include_once "write.php";
include_once "create.php";




