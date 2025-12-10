
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
      { text: 'Guide', link: '/guide/' },
      { text: 'Config', link: '/Config/' },
      { text: 'GitHub', link: 'https://github.com/langnang-temp/vuepress' },
      {
        text: 'Langnang', items: [
          { text: 'Langnang', link: 'https://langnang.github.io/langnang' },
          { text: 'Templates', link: 'https://langnang-temp.github.io/langnang-temp' },
          { text: 'Packages', link: 'https://langnang-package.github.io/langnang-package' },
        ]
      },
      {
        text: 'Vue', items: [
          { text: 'Vue', link: 'https://cn.vuejs.org/zh/' },
          { text: 'Vue Router', link: 'https://router.vuejs.org/zh/' },
          { text: 'Vuex', link: 'https://vuex.vuejs.org/zh/' },
          { text: 'VuePress', link: 'https://vuepress.vuejs.org/zh/' },
          { text: 'Awesome VuePress', link: 'https://github.com/vuepress/awesome-vuepress' },
          { text: 'Vuepress Community', link: 'https://vuepress-community.netlify.app/zh/' },
        ]
      }
    ],
    /**
     * 侧边栏
     * 基本的配置，需要一个包含了多个链接的数组：
     * @type Array | Object
     * @default undefined
     */
    sidebar: 'auto'
  },
  /**
   * 你可以通过 themeConfig.lastUpdated 选项来获取每个文件最后一次 git 提交的 UNIX 时间戳(ms)，同时它将以合适的日期格式显示在每一页的底部：
   * @type String|Boolean
   * @default undefined
   */
  lastUpdated: 'Last Updated',
}