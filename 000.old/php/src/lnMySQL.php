<?

namespace Langnang;

class lnMySQL extends LnSQL
{
  public $config;
  public $conn;
  function __construct($config)
  {
    $this->config = $config;
    $this->conn = new mysqli($config['host'], $config['user'], $config['pass']);
    if ($this->conn->connect_error) {
      die("连接失败: " . $this->conn->connect_error);
    }
    echo "连接成功";
  }
}
