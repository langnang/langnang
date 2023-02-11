const host =
  process.env.NODE_ENV === "production"
    ? "http://docs.langnang.ml"
    : "http://docs.langnang-develop.ml";

module.exports = {
  // 导航栏链接
  nav: [
    { text: "Home", link: "/" },
    { text: "Guide", link: "/guide/" },
    {
      text: "VuePress",
      items: [
        { text: "Official", link: "https://vuepress.vuejs.org/" },
        { text: "模板", link: host + "/template/" },
        { text: "规范", link: host + "/specification/" },
        { text: "工具", link: host + "/toolkit/" },
        { text: "数据结构与算法", link: host + "/dsa/" },
        { text: "前端开发", link: host + "/front-end/" },
        process.env.NODE_ENV === "production"
          ? null
          : { text: "后端开发", link: host + "/back-end/" },
        process.env.NODE_ENV === "production"
          ? null
          : { text: "移动端开发", link: host + "/mobile-terminal/" },
        { text: "源码提炼", link: host + "/learning/" },
        process.env.NODE_ENV === "production"
          ? null
          : { text: "计算机科学", link: host + "/computer-science/" },
        process.env.NODE_ENV === "production"
          ? null
          : { text: "知识体系", link: host + "/system/" },
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
