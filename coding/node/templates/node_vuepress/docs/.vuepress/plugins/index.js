module.exports = [
  /**
   * 页面滚动时自动激活侧边栏链接的插件
   */
  ['@vuepress/active-header-links',],
  /**
   * back-to-top 插件
   */
  ['@vuepress/back-to-top',],
  ['@vuepress/blog',],
  /**
   * Google analytics 插件
   */
  ['@vuepress/google-analytics',],
  /**
   * last-updated 插件。
   */
  ['@vuepress/last-updated',],
  ['@vuepress/medium-zoom',],
  /**
   * 一个基于 nprogress (opens new window)的进度条插件
   */
  ['@vuepress/nprogress',],
  /**
   * PWA 插件
   */
  ['@vuepress/pwa',],
  /**
   * 注册组件的插件
   */
  ['@vuepress/register-components',],
  /**
   * 基于 Headers 的搜索插件
   */
  ['@vuepress/search',],
  /**
   * 使你的 VuePress 站点支持简洁链接。
   */
  ['vuepress-plugin-clean-urls',],
  /**
   * 在你的 VuePress 站点中注册新的 Markdown 容器。
   */
  ['vuepress-plugin-container',],
  /**
   * 处理你的 VuePress 站点中的复制操作。
   */
  ['copyright',],
  /**
   * 在你的 VuePress 页面信息中集成 git 日志。
   */
  ['vuepress-plugin-git-log',],
  /**
   * 让你的 VuePress 站点中的 Markdown 文件支持 TeX 语法。
   */
  ['vuepress-plugin-mathjax',],
  /**
   * 从其他网站迁移到 VuePress。
   */
  ['vuepress-plugin-migrate',],
  /**
   * 为你的 VuePress 站点增加目录组件
   */
  ['vuepress-plugin-table-of-contents',],
  /**
   * code-switcher
   */
  ['code-switcher',],
  /**
   *  appends a copy button to every instance of a given selector (defaults to div[class*="language-"] pre)
   */
  ['vuepress-plugin-code-copy',],
  /**
   * Merge Markdown files in a single Markdown
   */
  ['vuepress-plugin-merge-pages',],
  /**
   * Generate dynamic VuePress pages from JSON Schemas.
   */
  ['schema2md', {
    pages: {}
  }],
  /**
   * adding JavaScript charting library Chart.js to VuePress 2 to create interactive charts in Markdown
   */
  ['vuepress-plugin-chart',],
  /**
   * vuepress-plugin-flowchart
   */
  ['flowchart',],
  /**
   * VuePress Plugin for mermaid.js
   */
  ['vuepress-plugin-mermaidjs'],
  [
    require('./github-file'),
  ],
]