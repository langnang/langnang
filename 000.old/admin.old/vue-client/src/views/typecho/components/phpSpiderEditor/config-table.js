const config = {
  log_show: {
    name: "显示日志",
    desc: "为true时显示调试信息 为false时显示爬取面板",
    type: "boolean",
    default: false,
    component: "el-switch"
  },
  _log_type: {
    name: "日志类型",
    desc: "显示和记录的日志类型",
    component: "el-select",
    options: [
      { value: "info", label: "普通类型: info" },
      { value: "warn", label: "警告类型: warn" },
      { value: "debug", label: "调试类型: debug" },
      { value: "error", label: "错误类型: error" }
    ],
    multiple: true,
    default: []
  },
  log_file: {
    name: "日志路径",
    desc: "日志文件路径",
    type: "string",
    default: "data/phpspider.log",
    component: "el-input"
  },
  input_encoding: {
    name: "输入编码",
    desc: "明确指定输入的页面编码格式(UTF-8,GB2312,…..)，防止出现乱码,如果设置null则自动识别",
    component: "el-select",
    options: [
      { label: "UTF-8", value: "UTF-8" },
      { label: "GB2312", value: "GB2312" }
    ],
    default: "UTF-8"
  },
  output_encoding: {
    name: "输出编码",
    desc: "明确指定输出的编码格式(UTF-8,GB2312,…..)，防止出现乱码,如果设置null则为utf-8",
    component: "el-select",
    options: [
      { label: "UTF-8", value: "UTF-8" },
      { label: "GB2312", value: "GB2312" }
    ],
    default: "UTF-8"
  },
  client_ip: {
    name: "伪IP",
    desc: "爬虫爬取网页所使用的伪IP，用于破解防采集",
    component: "el-select",
    filterable: true,
    allowCreate: true,
    defaultFirstOption: true,
    multiple: true,
    default: []
  },
  user_agent: {
    name: "浏览器类型",
    desc: "爬虫爬取网页所使用的浏览器类型",
    component: "el-select",
    filterable: true,
    allowCreate: true,
    defaultFirstOption: true,
    multiple: true,
    default: []
  },
  export: {
    name: "导出",
    desc: "爬虫爬取数据导出，注意导出到数据库的表和字段要和上面的fields对应",
    type: "object",
    children: {
      type: {
        name: "类型",
        desc: "导出类型 csv、sql、db",
        component: "el-select",
        options: [
          { label: "csv", value: "csv" },
          { label: "sql", value: "sql" },
          { label: "db", value: "db" }
        ],
        handleChange({ value, $config }) {
          const $index = $config.findIndex(v => v.key === "export");
          $config[$index]["children"][1]["disabled"] = false;
          $config[$index]["children"][2]["disabled"] = false;
          if (value === "csv") {
            $config[$index]["children"][2]["disabled"] = true;
          } else if (value === "db") {
            $config[$index]["children"][1]["disabled"] = true;
          }
        },
        default: "csv"
      },
      file: {
        name: "地址",
        desc: "导出 csv、sql 文件地址",
        component: "el-input",
        handleChange(val) {
          console.log(val);
        },
        default: ""
      },
      table: {
        name: "表名",
        desc: "导出db、sql数据表名",
        component: "el-input",
        handleChange(val) {
          console.log(val);
        },
        default: ""
      }
    }
  },
  domains: {
    name: "域名",
    desc: "定义爬虫爬取哪些域名下的网页, 非域名下的url会被忽略以提高爬取速度",
    required: true,
    component: "el-select",
    filterable: true,
    allowCreate: true,
    defaultFirstOption: true,
    multiple: true,
    default: []
  },
  db_config: {
    name: "数据库配置",
    desc: "数据库配置",
    children: {
      host: {
        name: "地址",
        type: "string",
        component: "el-input"
      },
      port: {
        name: "端口",
        type: "number",
        component: "el-input"
      },
      user: {
        name: "账号",
        type: "string",
        component: "el-input"
      },
      pass: {
        name: "密码",
        type: "string",
        component: "el-input"
      },
      name: {
        name: "数据库",
        type: "string",
        component: "el-input"
      }
    }
  },
  scan_urls: {
    name: "入口链接",
    desc: "定义爬虫的入口链接, 爬虫从这些链接开始爬取,同时这些链接也是监控爬虫所要监控的链接",
    required: true,
    component: "el-select",
    filterable: true,
    allowCreate: true,
    defaultFirstOption: true,
    multiple: true,
    default: []
  },
  content_url_regexes: {
    name: "内容页URL规则",
    desc: "内容页是指包含要爬取内容的网页",
    required: true,
    component: "el-select",
    filterable: true,
    allowCreate: true,
    defaultFirstOption: true,
    multiple: true,
    default: []
  },
  list_url_regexes: {
    name: "列表页URL规则",
    desc: "列表页是指包含内容页列表的网页。对于有列表页的网站, 使用此配置可以大幅提高爬虫的爬取速率",
    required: true,
    component: "el-select",
    filterable: true,
    allowCreate: true,
    defaultFirstOption: true,
    multiple: true,
    default: []
  },
  max_fields: {
    name: "最大条数",
    desc: "爬虫爬取内容网页最大条数，抓取到一定的字段后退出",
    component: "el-input",
    defeult: 0
  },
  max_depth: {
    name: "最大深度",
    desc: "爬虫爬取网页深度，超过深度的页面不再采集",
    component: "el-input",
    default: 0
  },
  max_try: {
    name: "尝试次数",
    desc: "爬虫爬取每个网页失败后尝试次数",
    component: "el-input",
    default: 0
  },
  timeout: {
    name: "超时时间",
    desc: "爬虫爬取每个网页的超时时间（单位：秒）",
    component: "el-input",
    default: 0
  },
  interval: {
    name: "时间间隔",
    desc: "爬虫爬取每个网页的时间间隔（单位：毫秒）",
    component: "el-input",
    default: 0
  },
  proxy: {
    name: "代理服务器",
    desc: "代理服务器，如果爬取的网站根据IP做了反爬虫, 可以设置此项",
    default: []
  },
  queue_config: {
    name: "redis配置",
    desc: "保存爬虫运行状态、多任务处理 和 多服务器处理 都需要redis来保存采集任务数据",
    children: {
      queue_config_host: {
        name: "地址",
        type: "string",
        component: "el-input"
      },
      queue_config_port: {
        name: "端口",
        type: "number",
        component: "el-input"
      },
      queue_config_user: {
        name: "账号",
        type: "string",
        component: "el-input"
      },
      queue_config_pass: {
        name: "密码",
        type: "string",
        component: "el-input"
      },
      queue_config_db: {
        name: "链接数",
        component: "el-input"
      },
      queue_config_prefix: {
        name: "前缀",
        default: "phpspider",
        component: "el-input"
      },
      queue_config_timeout: {
        name: "超时",
        default: 30,
        component: "el-input"
      }
    }
  },
  save_running_state: {
    name: "保存运行状态",
    desc: "保存爬虫运行状态，需要配合redis来保存采集任务数据，供程序下次执行使用",
    component: "el-switch",
    default: false
  },
  serverid: {
    name: "服务器ID",
    desc: "服务器ID",
    component: "el-input"
  },
  multiserver: {
    name: "多服务器处理",
    desc: "多服务器处理，需要配合redis来保存采集任务数据，供多服务器共享数据使用",
    default: false,
    component: "el-switch"
  },
  tasknum: {
    name: "同时任务数",
    desc: "同时工作的爬虫任务数，需要配合redis保存采集任务数据，供进程间共享使用",
    component: "el-input"
  },
  fields: {
    hidden: true,
    default: []
  }
};

const tableData = [];
const defaultForm = {};
for (const key in config) {
  const item = { ...config[key], key };
  // 默认值
  if (config[key].default !== undefined) {
    defaultForm[key] = config[key].default;
  }
  // 子项
  if (config[key].children) {
    defaultForm[key] = {};
    item.children = [];

    for (const child_key in config[key].children) {
      if (config[key].children[child_key].default !== undefined) {
        defaultForm[key][child_key] = config[key].children[child_key].default;
      }

      item.children.push({ ...config[key].children[child_key], key: child_key, parent_key: key });
    }
  }
  tableData.push(item);
}
export { tableData, defaultForm };
