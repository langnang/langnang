const Mock = require("mockjs");

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
    url: "/vue-element-webstack/branch/list",
    type: "get",
    response: (config) => {
      const items = data.items;
      return {
        status: 200,
        data: {
          total: items.length,
          items: items,
        },
      };
    },
  },
];
