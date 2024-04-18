const sidebar = require('./sidebar')
module.exports = {
  /**
   * 当你使用自定义主题的时候，需要指定它。
   * @type String
   * @default undefined
   */
  theme: undefined,
  /**
   * 为当前的主题提供一些配置，这些选项依赖于你正在使用的主题。
   * @type Object
   * @default {}
   */
  themeConfig: {
    /**
     * 导航栏
     * @type Boolean
     * @default true
     */
    navbar: true,
    /**
     * 导航栏链接
     */
    nav: [
      { text: 'Home', link: '/' },
      { text: '面试题', link: '/Interview/' },
      { text: '软件工具&服务', link: '/toolkit/', },
      {
        text: '计算机科学技术', items: [
          {
            text: '计算机科学技术基础', link: '/52010/', items: [
              { text: '算法理论', link: '/52010/5201040/' },
              { text: '数据结构', link: '/52010/5201050/' },
              { text: '数据安全与计算机安全', link: '/52010/5201060/' },
            ],
          },
          {
            text: '计算机软件', link: '/52040/', items: [
              { text: '软件理论', link: '/52040/5204010/', },
              { text: '操作系统与操作环境', link: '/52040/5204020/', },
              { text: '程序设计及其语言', link: '/52040/5204030/', },
              { text: '数据库', link: '/52040/5204050/', },
              { text: '软件开发环境与开发技术', link: '/52040/5204060/HTML/' },
              { text: '软件工程', link: '/52040/5204070/', },
            ],
          },
        ]
      },
      { text: 'GitHub', link: 'https://github.com/langnang/langnang' },
      {
        text: 'Langnang', items: [
          { text: 'Langnang', link: 'https://langnang.github.io/langnang' },
          { text: 'Templates', link: 'https://langnang-temp.github.io/langnang-temp' },
          { text: 'Packages', link: 'https://langnang-package.github.io/langnang-package' },
        ]
      },
    ],
    /**
     * 侧边栏
     * 基本的配置，需要一个包含了多个链接的数组：
     * @type Array | Object
     * @default undefined
     */
    sidebar,
  },
  /**
   * 你可以通过 themeConfig.lastUpdated 选项来获取每个文件最后一次 git 提交的 UNIX 时间戳(ms)，同时它将以合适的日期格式显示在每一页的底部：
   * @type String|Boolean
   * @default undefined
   */
  lastUpdated: 'Last Updated',
}