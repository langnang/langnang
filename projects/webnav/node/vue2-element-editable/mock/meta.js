const Mock = require("mockjs");

const designer = require("./../src/assets/designer.json");
const langnang = require("./../src/assets/langnang.json");

const meta = {
  mid: "@id",
  name: "",
  slug: "",
  "type|1": ["branch", "category", "tag"],
  description: "",
  count: 0,
  sort: 0,
  parent: 0,
};
const item = () => ({
  mid: "@id",
  title: "@sentence(10, 20)",
  "status|1": ["published", "draft", "deleted"],
  author: "name",
  display_time: "@datetime",
  pageviews: "@integer(300, 5000)",
});

const data = Mock.mock({
  "items|30": [item()],
});

module.exports = [
  {
    url: "/vue-element-webstack/meta/list",
    type: "post",
    response: (config) => {
      const { type } = config.body;
      const result = {
        status: 200,
        data: {
          total: 0,
          rows: [],
          page: 1,
          size: 99999,
        },
      };
      if (type === "branch") {
        result.data.rows = [
          { mid: "@integer(1)", slug: "branch_langnang", name: "Langnang" },
          { mid: "@integer(1)", slug: "branch_designer", name: "设计师" },
        ];
      }
      return result;
    },
  },
  {
    url: "/vue-element-webstack/meta/tree",
    type: "post",
    response: (config) => {
      const { parent, type, name } = config.body;
      const result = {
        status: 200,
        data: {
          total: 0,
          tree: [],
        },
      };
      if (type === "category") {
        if (name === "designer") {
          result.data.tree = designer;
        } else if (name === "langnang") {
          result.data.tree = langnang;
        }
      }
      return result;
    },
  },
];
