<?php

namespace Illuminate\DB\Traits;

trait LifeCycleMethods
{
  function _() {}

  function _autoload()
  {
    // var_dump(config('database'));
    $config = config('database.connections.' . config('database.default'));

    // var_dump($config);
    // var_dump($this->alias);
  }

  function _init()
  {
    // 获取配置
    $config = $this->link_name == 'default' ? self::_get_default_config() : $this->configs[$this->link_name];

    // 创建连接
    if (empty($this->links[$this->link_name]) || empty($this->links[$this->link_name]['conn'])) {
      // 第一次连接，初始化fail和pid
      if (empty($this->links[$this->link_name])) {
        $this->links[$this->link_name]['fail'] = 0;
        $this->links[$this->link_name]['pid'] = function_exists('posix_getpid') ? posix_getpid() : 0;
        //echo "progress[".$this->links[$this->link_name]['pid']."] create db connect[".$this->link_name."]\n";
      }
      $this->links[$this->link_name]['conn'] = mysqli_connect($config['host'], $config['user'], $config['pass'], $config['name'], $config['port']);
      if (mysqli_connect_errno()) {
        $this->links[$this->link_name]['fail']++;
        $errmsg = 'Mysql Connect failed[' . $this->links[$this->link_name]['fail'] . ']: ' . mysqli_connect_error();
        echo util::colorize(date("H:i:s") . " {$errmsg}\n\n", 'fail');
        log::add($errmsg, "Error");
        // 连接失败5次，中断进程
        if ($this->links[$this->link_name]['fail'] >= 5) {
          exit(250);
        }
        self::_init($config);
      } else {
        mysqli_query($this->links[$this->link_name]['conn'], " SET character_set_connection=utf8, character_set_results=utf8, character_set_client=binary, sql_mode='' ");
      }
    } else {
      $curr_pid = function_exists('posix_getpid') ? posix_getpid() : 0;
      // 如果父进程已经生成资源就释放重新生成，因为多进程不能共享连接资源
      if ($this->links[$this->link_name]['pid'] != $curr_pid) {
        self::clear_link();
      }
    }
  }
}
