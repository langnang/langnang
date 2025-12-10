module.exports = {
  /**
   * base 将会作为前缀自动地插入到所有以 / 开始的其他选项的链接中，所以你只需要指定一次。
   * @type String
   * @default /
   */
  base: '/langnang-temp/',
  /**
   * 网站的标题，它将会被用作所有页面标题的前缀，同时，默认主题下，它将显示在导航栏（navbar）上。
   * @type String
   * @default undefined
   */
  title: 'Langnang Template',
  /**
   * 网站的描述，它将会以 <meta> 标签渲染到当前页面的 HTML 中。
   * @type String
   * @default undefined
   */
  description: 'Welcome',
  /**
   * 额外的需要被注入到当前页面的 HTML <head> 中的标签，每个标签都可以以 [tagName, { attrName: attrValue }, innerHTML?] 的格式指定，
   * @type Array
   * @default []
   */
  head: [
  ],
  /**
   * 指定用于 dev server 的主机名。
   * @type String
   * @default 0.0.0.0
   */
  host: '0.0.0.0',
  /**
   * 指定 dev server 的端口。
   * @type Number
   * @default 8080
   */
  port: 8080,
  /**
   * 插件通常会为 VuePress 添加全局功能。插件的范围没有限制。
   * 你可以在 Awesome VuePress (opens new window)中找到更多的插件。
   * @type Object|Array
   * @default undefined
   */
  plugins: require('./plugins/index.js'),
  /**
   * 主题配置
   */
  ...require('./theme.js'),
  /**
   * Markdown 配置
   */
  markdown: require('./markdown.js'),
}