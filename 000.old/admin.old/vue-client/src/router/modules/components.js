/** When your routing table is too long, you can split it into small modules **/

import Layout from "@/layout";
// import LayoutAppMain from "@/layout/components/AppMain";

const componentsRouter = {
  path: "/components",
  component: Layout,
  redirect: "noRedirect",
  name: "Components",
  meta: { title: "组件示例", icon: "svg-component" },
  children: [
    {
      path: "icon",
      component: () => import("@/views/ln/icon"),
      name: "Icon",
      meta: { title: "图标", icon: "svg-icon", noCache: true }
    },
    {
      path: "box",
      component: () => import("@/views/ln/box"),
      name: "Box",
      meta: { title: "盒子", icon: "fas-square", noCache: true }
    },
    {
      path: "editor",
      component: () => import("@/views/ln/editor"),
      name: "Editor",
      meta: { title: "编辑器", icon: "fas-code", noCache: true }
    },
    {
      path: "monaco-editor",
      component: () => import("@/views/components-demo/monaco-editor"),
      name: "MonacoEditorDemo",
      meta: { title: "MonacoEditor" }
    },
    {
      path: "tinymce",
      component: () => import("@/views/components-demo/tinymce"),
      name: "TinymceDemo",
      meta: { title: "Tinymce" }
    },
    {
      path: "markdown",
      component: () => import("@/views/components-demo/markdown"),
      name: "MarkdownDemo",
      meta: { title: "Markdown" }
    },
    {
      path: "json-editor",
      component: () => import("@/views/components-demo/json-editor"),
      name: "JsonEditorDemo",
      meta: { title: "JSON Editor" }
    },
    {
      path: "split-pane",
      component: () => import("@/views/components-demo/split-pane"),
      name: "SplitpaneDemo",
      meta: { title: "SplitPane" }
    },
    {
      path: "avatar-upload",
      component: () => import("@/views/components-demo/avatar-upload"),
      name: "AvatarUploadDemo",
      meta: { title: "Upload" }
    },
    {
      path: "dropzone",
      component: () => import("@/views/components-demo/dropzone"),
      name: "DropzoneDemo",
      meta: { title: "Dropzone" }
    },
    {
      path: "sticky",
      component: () => import("@/views/components-demo/sticky"),
      name: "StickyDemo",
      meta: { title: "Sticky" }
    },
    {
      path: "count-to",
      component: () => import("@/views/components-demo/count-to"),
      name: "CountToDemo",
      meta: { title: "Count To" }
    },
    {
      path: "mixin",
      component: () => import("@/views/components-demo/mixin"),
      name: "ComponentMixinDemo",
      meta: { title: "Component Mixin" }
    },
    {
      path: "back-to-top",
      component: () => import("@/views/components-demo/back-to-top"),
      name: "BackToTopDemo",
      meta: { title: "Back To Top" }
    },
    {
      path: "drag-dialog",
      component: () => import("@/views/components-demo/drag-dialog"),
      name: "DragDialogDemo",
      meta: { title: "Drag Dialog" }
    },
    {
      path: "drag-select",
      component: () => import("@/views/components-demo/drag-select"),
      name: "DragSelectDemo",
      meta: { title: "Drag Select" }
    },
    {
      path: "dnd-list",
      component: () => import("@/views/components-demo/dnd-list"),
      name: "DndListDemo",
      meta: { title: "Dnd List" }
    },
    {
      path: "drag-kanban",
      component: () => import("@/views/components-demo/drag-kanban"),
      name: "DragKanbanDemo",
      meta: { title: "Drag Kanban" }
    }
  ]
};

export default componentsRouter;
