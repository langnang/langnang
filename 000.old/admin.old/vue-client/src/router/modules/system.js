/** When your routing table is too long, you can split it into small modules**/

import Layout from "@/layout";
// import { AppMain, TagsView } from "@/layout/components";

const systemRouter = {
  path: "/system",
  component: Layout,
  redirect: "noRedirect",
  name: "system",
  meta: { title: "系统管理", icon: "el-icon-setting" },
  children: [
    {
      path: "interface",
      name: "Interface",
      meta: { title: "接口管理", icon: "icon", noCache: true }
    },
    { path: "route", name: "route", meta: { title: "路由管理", icon: "icon", noCache: true }},
    { path: "component", name: "component", meta: { title: "组件管理", icon: "icon", noCache: true }},
    { path: "view", name: "view", meta: { title: "视图管理", icon: "icon", noCache: true }},
    { path: "template", name: "template", meta: { title: "模板管理", icon: "svg-icon", noCache: true }},
    {
      path: "log",
      component: () => import("@/views/system/log"),
      name: "SystemLog",
      meta: { title: "日志管理", noCache: true }
    },
    {
      path: "option",
      name: "SystemOption",
      meta: { title: "配置管理", noCache: true }
    }
  ]
};

export default systemRouter;
