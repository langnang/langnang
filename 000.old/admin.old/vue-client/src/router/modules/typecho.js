/** When your routing table is too long, you can split it into small modules**/

import Layout from "@/layout";
// import { AppMain, TagsView } from "@/layout/components";

const typechoRouter = {
  path: "/typecho",
  component: Layout,
  redirect: "noRedirect",
  name: "Typecho",
  meta: { title: "博客管理", icon: "el-icon-s-order" },
  children: [
    {
      path: "meta",
      component: () => import("@/views/typecho/meta"),
      name: "TypechoMeta",
      meta: { title: "标识管理", icon: "el-icon-star-off", noCache: true }
    },
    {
      path: "post",
      component: () => import("@/views/typecho/post"),
      name: "TypechoPost",
      meta: { title: "文章管理", icon: "el-icon-star-off", noCache: true }
    },
    {
      path: "option",
      component: () => import("@/views/typecho/option"),
      name: "TypechoOption",
      meta: { title: "配置管理", icon: "el-icon-star-off", noCache: true }
    },
    {
      path: "crawler",
      component: () => import("@/views/typecho/crawler"),
      name: "TypechoCrawler",
      meta: { title: "爬虫管理", icon: "el-icon-star-off", noCache: true }
    },
    {
      path: "resource",
      component: () => import("@/views/typecho/resource"),
      name: "TypechoResource",
      meta: { title: "资源管理", icon: "el-icon-star-off", noCache: true }
    },
    {
      path: "script",
      component: () => import("@/views/typecho/script"),
      name: "TypechoScript",
      meta: { title: "脚本管理", icon: "el-icon-star-off", noCache: true }
    }
  ]
};

export default typechoRouter;
