<?php

// use phpspider\core\phpspider;

return [
    /**
     * @var string 爬虫名称
     */
    'name' => '糗事百科',
    /**
     * @var string 爬虫标识
     */
    'slug' => 'qiushibaike',
    /**
     * @var boolean 是否显示日志
     */
    'log_show' => false,
    /**
     * @var string 日志文件路径
     */
    'log_file' => 'data/qiushibaike.log',
    /**
     * @var string 显示和记录的日志类型
     */
    'log_type' => 'error,debug',
    /**
     * @var string 输入编码
     * 明确指定输入的页面编码格式(UTF-8,GB2312,…..)，防止出现乱码,如果设置null则自动识别
     */
    'input_encoding' => null,
    /**
     * @var string 输出编码
     * 明确指定输出的编码格式(UTF-8,GB2312,…..)，防止出现乱码,如果设置null则为utf-8
     */
    'output_encoding' => null,
    /**
     * @var array 代理服务器
     */
    'proxy' => [],
    /**
     * @var int 爬取每个网页的时间间隔(单位：毫秒)
     */
    'interval' => 1000,
    /**
     * @var int 爬取每个网页的超时时间(单位：秒)
     */
    'timeout' => 5,
    /**
     * @var int 爬虫爬取每个网页失败后尝试次数
     * max_try默认值为0，即不重复爬取
     */
    'max_try' => 0,
    /**
     * @var int 爬虫爬取每个网页失败后尝试次数
     * max_depth默认值为0，即不限制
     */
    'max_depth' => 0,
    /**
     * @var int 爬虫爬取内容网页最大条数
     * max_fields默认值为0，即不限制
     */
    'max_fields' => 0,
    /**
     * @var array 爬虫爬取网页所使用的浏览器类型
     */
    'user_agent' => [
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36",
        "Mozilla/5.0 (iPhone; CPU iPhone OS 9_3_3 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13G34 Safari/601.1",
        "Mozilla/5.0 (Linux; U; Android 6.0.1;zh_cn; Le X820 Build/FEXCNFN5801507014S) AppleWebKit/537.36 (KHTML, like Gecko)Version/4.0 Chrome/49.0.0.0 Mobile Safari/537.36 EUI Browser/5.8.015S",
        // phpspider::AGENT_ANDROID,
        // phpspider::AGENT_IOS,
        // phpspider::AGENT_PC,
        // phpspider::AGENT_MOBILE,
    ],

    /**
     * @var array|string 爬虫爬取网页所使用的伪IP，用于破解防采集
     */
    'client_ip' => [
        '192.168.0.2',
        '192.168.0.3',
        '192.168.0.4',
    ],
    /**
     * @var array 爬虫爬取数据导出
     * @param string type 导出类型 csv、sql、db
     * @param string file 导出 csv、sql 文件地址
     * @param string table 导出db、sql数据表名
     */
    'export' => [
        'type' => 'csv',
        'file' => './data/qiushibaike.csv', // data目录下
    ],
    /**
     * @var array 数据库配置
     * @param string host
     * @param string port
     * @param string user
     * @param string pass
     * @param string name
     */
    'db_config' => [
        'host'  => '127.0.0.1',
        'port'  => 3306,
        'user'  => 'root',
        'pass'  => 'root',
        'name'  => 'demo',
    ],
    /**
     * @var array 定义爬虫爬取哪些域名下的网页, 非域名下的url会被忽略以提高爬取速度
     */
    'domains' => [
        'qiushibaike.com',
        'www.qiushibaike.com'
    ],
    /**
     * @var array 定义爬虫的入口链接, 爬虫从这些链接开始爬取,同时这些链接也是监控爬虫所要监控的链接
     */
    'scan_urls' => [
        'http://www.qiushibaike.com/'
    ],
    /**
     * @var array 正则表达式，定义列表页url的规则
     * 列表页是指包含内容页列表的网页 比如http://www.qiushibaike.com/8hr/page/2/?s=4867046 就是糗事百科的一个列表页
     */
    'list_url_regexes' => [
        "http://www.qiushibaike.com/8hr/page/\d+\?s=\d+"
    ],
    /**
     * @var array 正则表达式，定义内容页url的规则
     * 内容页是指包含要爬取内容的网页 比如http://www.qiushibaike.com/article/115878724 就是糗事百科的一个内容页
     */
    'content_url_regexes' => [
        "http://www.qiushibaike.com/article/\d+",
    ],

    /**
     * @var array 定义内容页的抽取规则
     * 规则由一个个field组成, 一个field代表一个数据抽取项
     */
    'fields' => [],
];
