export default [
  {
    component: "AttributeTable",
    name: "Editor",
    data: [
      { name: "editor", desc: "编辑器", type: "String", options: "monaco", default: "monaco" },
      { name: "language", desc: "编程语言", type: "String", options: "html, css, js" },
      { name: "theme", desc: "主题", type: "String" }
    ]
  }
];
