<?php

namespace Langnang\Typecho;


/**
 * @package TypechoInterface
 * @method create 创建表
 * @method create_secondary 创建副表
 * @method create_summary 创建总表
 * @method drop 删除表
 * @method insert 新增列
 * @method delete 删除列
 * @method update 更新列
 * @method replace 替换列
 * @method count 统计列
 * @method is_exists 校验列存在
 * @method select 查询列
 * @method list 查询多列
 */
interface TypechoInterface
{
  // 创建表
  function create();
  // 创建副表
  function create_secondary();
  // 创建总表
  function create_summary();
  // 删除表
  function drop();
  // 新增列
  function insert();
  // 删除列
  function delete();
  // 更新列
  function update();
  // 存在则更新，不存在则新增
  function replace();
  // 统计列
  function count();
  // 校验列是否存在
  function is_exists();
  // 依据主关键字查询列
  function select();
  // 批量查询列
  function list($options);
}
