module.exports = {
  // 导航栏链接
  nav: [
    { text: "Home", link: "/" },
    { text: "Guide", link: "/guide/" },
    {
      text: "VuePress",
      items: [
        { text: "Official", link: "https://vuepress.vuejs.org/" },
        { text: "模板", link: "http://docs.langnang.ml/template/" },
        { text: "规范", link: "http://docs.langnang.ml/specification/" },
        { text: "工具", link: "http://docs.langnang.ml/toolkit/" },
        { text: "源码提炼", link: "http://docs.langnang.ml/learning/" },
        { text: "知识体系", link: "http://docs.langnang.ml/system/" },
      ],
    },
    { text: "GitHub", link: "https://github.com/langnang/langnang/" },
  ],
  // 侧边栏
  sidebar: "auto",
  // 显示所有页面的标题链接
  displayAllHeaders: true,
  // 最后更新时间
  lastUpdated: "Last Updated",
};
