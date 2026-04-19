<!DOCTYPE html>
<html lang="en">

<head>
  <title>Toolkit</title>
  @include('shared.head')
</head>

<body>
  @include('shared.header')
  <main>
    <div class="container">
      <div class="progress">
        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="20" aria-valuemin="0"
          aria-valuemax="100" style="width: 0%">
          0% Complete
        </div>
      </div>
  </main>
  @php
    set_time_limit(0); //设置程序执行时间
    ignore_user_abort(true); //设置断开连接继续执行
    header('X-Accel-Buffering: no'); //关闭buffer
    ob_start(); //打开输出缓冲控制
    for ($i = 0; $i < 101; $i++) {
        sleep(rand(1, 2));
        $script = '<script>
          document.getElementsByClassName("progress-bar")[0].style.width = "%u%%";
          document.getElementsByClassName("progress-bar")[0].innerHTML = "%u%% Complete";
        </script>';
        echo sprintf($script, $i, $i);
        echo ob_get_clean(); //获取当前缓冲区内容并清除当前的输出缓冲
        flush(); //刷新缓冲区的内容，输出
    }
  @endphp
</body>

</html>
