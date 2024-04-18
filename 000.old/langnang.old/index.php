<?php
$dirs = scan_dir(__DIR__);
/**
 * 读取目录下文件信息
 */
function scan_dir($dir, $options = [
  "depth" => 0,
  // 忽略，过滤掉的
  "ignore" => ['.', "..", ".git", ".github", "node_modules", "xxx", ".vuepress"],
  // 文件类型
  "type" => ["dir"],
])
{
  $file_list = [];
  if ($handle = opendir($dir)) {
    while (false !== ($file = readdir($handle))) {
      if (in_array($file, $options['ignore'])) continue;
      $file_info = file_info($dir . "/" . $file);
      if (!in_array($file_info['type'], $options['type'])) continue;
      array_push($file_list, $file_info);
    }
  }
  return $file_list;
}
/**
 * 获取文件信息
 */
function file_info($path)
{
  return [
    "type" => filetype($path),
    "name" => basename($path),
    "size" => filesize($path),
    "ctime" => filectime($path),
    "atime" => fileatime($path),
    "group" => filegroup($path),
    "inode" => fileinode($path),
    "mtime" => filemtime($path),
    "owner" => fileowner($path),
    "perms" => fileperms($path),
    "path" => $path,
  ];
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Langnang</title>
  <!-- import CSS -->
  <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
  <style>
    body {
      padding: 0;
      margin: 0;
    }

    a,
    a:hover,
    a:visited,
    a:active,
    a:focus {
      text-decoration: none;
    }

    .el-header {
      height: 3.6rem !important;
      padding: .7rem 1.5rem;
      line-height: 2.2rem;
      border-bottom: solid 1px #e6e6e6
    }

    .el-menu.el-menu--horizontal {
      border-bottom: unset;
    }

    .el-menu--horizontal>.el-menu-item,
    .el-menu--horizontal>.el-submenu .el-submenu__title {
      height: 2rem !important;
      line-height: 2rem !important;
      font-size: .9rem;
    }
  </style>
</head>

<body>
  <div id="app">

    <el-container>
      <el-header>
        <h1 style="display:inline-block;margin-block-start: 0;margin-block-end:0;">Langnang</h1>
        <el-menu class="el-menu-demo" mode="horizontal" style="float: right;margin-top:-1px;">
          <el-submenu index="2">
            <template slot="title">VuePress</template>
            <el-menu-item index="2-1"><a href="https://vuepress.vuejs.org/" target="_blank">Official</a></el-menu-item>
          </el-submenu>
          <el-menu-item index="4"><a href="https://www.ele.me" target="_blank">GitHub</a></el-menu-item>
        </el-menu>
      </el-header>
      <el-main>
        <el-row :gutter="20">
          <el-col v-for="dir in _dirs" :key="dir.name" :span="6" style="margin-bottom: 10px;">
            <a :href="dir.link">
              <el-card class="box-card" shadow="hover">
                <h2 align="center">{{dir.name | titleCase}}</h2>
              </el-card>
            </a>
          </el-col>
        </el-row>
      </el-main>
    </el-container>

  </div>
</body>
<!-- import Vue before Element -->
<script src="https://unpkg.com/vue@2/dist/vue.js"></script>
<!-- import JavaScript -->
<script src="https://unpkg.com/element-ui/lib/index.js"></script>
<script>
  new Vue({
    el: '#app',
    data() {
      return {
        dirs: <? echo json_encode($dirs, JSON_UNESCAPED_UNICODE) ?>
      }
    },
    filters: {
      // 首字母大写
      titleCase(string) {
        const res = string.split(/-|_| /).map(item => item[0].toUpperCase() + item.slice(1)).join(' ')
        return res;
      },
      relativePath(string) {
        return string;
      }
    },
    computed: {
      _dirs() {
        const rootPath = '<? echo addslashes(__DIR__) ?>';
        const res = this.dirs.map(item => {
          item.link = item.path.slice(rootPath.length) + '/'
          if (['localhost', '127.0.0.1'].includes(window.location.hostname)) {
            item.link = " http://localhost:8080" + item.link;

          }
          return item;
        })
        return res;
      }
    },
    mounted() {
      console.log(this);
    }
  })
</script>

</html>