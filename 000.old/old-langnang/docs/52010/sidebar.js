module.exports = {
  // ...require('./5201040/sidebar'),
  // '/52010/5201040/': [
  //   {
  //     title: '排序算法',   // 必要的
  //     // path: '/Sorting/',      // 可选的, 标题的跳转链接，应为绝对路径且必须存在
  //     // collapsable: false, // 可选的, 默认值是 true,
  //     // sidebarDepth: 2,    // 可选的, 默认值是 1
  //     children: [
  //       '/Sorting/BubbleSort',
  //       '/Sorting/CountingSort'
  //     ]
  //   },
  // ],
  '/52010/': [
    require('./5201040/sidebar.js'),
    {
      title: '数据结构',
      path: '5201050/',
    },
    {
      title: '数据安全与计算机安全',
      path: '5201060/',
    },
  ]
}