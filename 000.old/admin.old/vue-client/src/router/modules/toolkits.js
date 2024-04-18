/** When your routing table is too long, you can split it into small modules**/

import Layout from "@/layout";
// import { AppMain, TagsView } from "@/layout/components";

const typechoRouter = {
  path: "/toolkit",
  component: Layout,
  redirect: "/toolkit/index",
  name: "Toolkit",
  meta: { title: "工具管理", icon: "el-icon-s-order" },
  children: [
    {
      path: "index",
      component: () => import("@/views/toolkit/index"),
      name: "ToolkitIndex",
      meta: { title: "工具管理", icon: "el-icon-star-off", noCache: true }
    }
  ]
};

export default typechoRouter;
