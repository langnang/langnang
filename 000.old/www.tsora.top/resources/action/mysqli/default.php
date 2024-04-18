<?php
/**
* @name mysqli.php PHP的MySQL增强版扩展
*
* @description 基于PHP的MySQL增强版扩展，编写相关函数，方便调用
* @author tsora <1624327728@qq.com>
* @version 0.0.1
* @update 2018-09-20
* @vendor PHP-7.2.6 Apache-2.4.33 MySQL-5.0.12
* @todo ...
* 
* =================== PHP的MySQLi 函数 ===================
* mysqli_affected_rows()	返回前一个 Mysql 操作的受影响行数。
* mysqli_autocommit()	打开或关闭自动提交数据库修改功能。
* mysqli_change_user()	更改指定数据库连接的用户。
* mysqli_character_set_name()	返回数据库连接的默认字符集。
* mysqli_close()	关闭先前打开的数据库连接。
* mysqli_commit()	提交当前事务。
* mysqli_connect_errno()	返回最后一次连接调用的错误代码。
* mysqli_connect_error()	返回上一次连接错误的错误描述。
* mysqli_connect()	打开到 Mysql 服务器的新连接。
* mysqli_data_seek()	调整结果指针到结果集中的一个任意行。
* mysqli_debug()	执行调试操作。
* mysqli_dump_debug_info()	转储调试信息到日志中。
* mysqli_errno()	返回最近的函数调用产生的错误代码。
* mysqli_error_list()	返回最近的函数调用产生的错误列表。
* mysqli_error()	返回字符串描述的最近一次函数调用产生的错误代码。
* mysqli_fetch_all()	抓取所有的结果行并且以关联数据，数值索引数组，或者两者皆有的方式返回结果集。
* mysqli_fetch_array()	以一个关联数组，数值索引数组，或者两者皆有的方式抓取一行结果。
* mysqli_fetch_assoc()	以一个关联数组方式抓取一行结果。
* mysqli_fetch_field_direct()	以对象返回结果集中单字段的元数据。
* mysqli_fetch_field()	以对象返回结果集中的下一个字段。
* mysqli_fetch_fields()	返回代表结果集中字段的对象数组。
* mysqli_fetch_lengths()	返回结果集中当前行的列长度。
* mysqli_fetch_object()	以对象返回结果集的当前行。
* mysqli_fetch_row()	从结果集中抓取一行并以枚举数组的形式返回它。
* mysqli_field_count()	返回最近一次查询获取到的列的数目。
* mysqli_field_seek()	设置字段指针到特定的字段开始位置。
* mysqli_field_tell()	返回字段指针的位置。
* mysqli_free_result()	释放与某个结果集相关的内存。
* mysqli_get_charset()	返回字符集对象。
* mysqli_get_client_info()	返回字符串类型的 Mysql 客户端版本信息。
* mysqli_get_client_stats()	返回每个客户端进程的统计信息。
* mysqli_get_client_version()	返回整型的 Mysql 客户端版本信息。
* mysqli_get_connection_stats()	返回客户端连接的统计信息。
* mysqli_get_host_info()	返回 MySQL 服务器主机名和连接类型。
* mysqli_get_proto_info()	返回 MySQL 协议版本。
* mysqli_get_server_info()	返回 MySQL 服务器版本。
* mysqli_get_server_version()	返回整型的 MySQL 服务器版本信息。
* mysqli_info()	返回最近一次执行的查询的检索信息。
* mysqli_init()	初始化 mysqli 并且返回一个由 mysqli_real_connect() 使用的资源类型。
* mysqli_insert_id()	返回最后一次查询中使用的自动生成 id。
* mysql_kill()	请求服务器终结某个 MySQL 线程。
* mysqli_more_results()	检查一个多语句查询是否还有其他查询结果集。
* mysqli_multi_query()	在数据库上执行一个或多个查询。
* mysqli_next_result()	从 mysqli_multi_query() 中准备下一个结果集。
* mysqli_num_fields()	返回结果集中的字段数。
* mysqli_num_rows()	返回结果集中的行数。
* mysqli_options()	设置选项。
* mysqli_ping()	Ping 一个服务器连接，或者如果那个连接断了尝试重连。
* mysqli_prepare()	准备一条用于执行的 SQL 语句。
* mysqli_query()	在数据库上执行查询。
* mysqli_real_connect()	打开一个到 Mysql 服务端的新连接。
* mysqli_real_escape_string()	转义在 SQL 语句中使用的字符串中的特殊字符。
* mysqli_real_query()	执行 SQL 查询。
* mysqli_reap_async_query()	返回异步查询的结果。
* mysqli_refresh()	刷新表或缓存，或者重置复制服务器信息。
* mysqli_rollback()	回滚当前事务。
* mysqli_select_db()	改变连接的默认数据库。
* mysqli_set_charset()	设置默认客户端字符集。
* mysqli_set_local_infile_default()	清除用户为 load local infile 命令定义的处理程序。
* mysqli_set_local_infile_handler()	设置 LOAD DATA LOCAL INFILE 命令执行的回调函数。
* mysqli_sqlstate()	返回前一个 Mysql 操作的 SQLSTATE 错误代码。
* mysqli_ssl_set()	使用 SSL 建立安装连接。
* mysqli_stat()	返回当前系统状态。
* mysqli_stmt_init()	初始化一条语句并返回一个由 mysqli_stmt_prepare() 使用的对象。
* mysqli_store_result()	传输最后一个查询的结果集。
* mysqli_thread_id()	返回当前连接的线程 ID。
* mysqli_thread_safe()	返回是否设定了线程安全。
* mysqli_use_result()	初始化一个结果集的取回。
* mysqli_warning_count()	返回连接中最后一次查询的警告数量。
* ===============================================================================
*/


// 引入文件
// 链接数据库
include_once "connect.php";
// 增
include_once "create.php";
include_once "insert.php";
// 删
include_once "delete.php";
// 改
// 查
include_once "show.php";
include_once "select.php";



function mysql_default($link,$sql){
	return $result=mysqli_query($link,$sql);
}