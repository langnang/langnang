"use strict";
// 静态页面
(function (define) {
  define(function (require, exports, module) {
    module.exports = {
      name: "static",
      path: "/static",
      proxyPath: "/",
      component: "views/static/home/index",
      children: [
        {
          name: "Home",
          path: "",
          component: "views/static/home/index",
        },
        {
          path: "/component",
          children: {
            Text: {
              name: "Text",
              description: "文本"
            },
            Button: {
              name: "Button",
              description: "按钮、按钮组",
              path: "/button",
              component: "views/static/component/button/index",
            },
            Loading: {
              name: "Loading",
              description: "加载状态",
              path: "/loading",
              component: "views/static/component/loading/index"
            },
            Progress: {
              name: "Progress",
              description: "进度条",
              path: "/progress",
              component: "views/static/component/progress/index"
            },
            Table: {name: "Table", description: "表格"},
            Navs: {name: "Navs", description: "标签页"},
            Navbar: {name: "Navbar", description: "导航条"},
            Figure: {
              name: "Figure",
              description: "图形",
              path: "/figure",
              component: "views/static/component/figure/index"
            },
            Scrollbar: {
              name: "Scrollbar",
              description: "滚动条",
              path: "/scrollbar",
              component: "views/static/component/scrollbar/index"
            },
            Input: {
              name: "Input",
              description: "输入框",
              path: "/input",
              component: "views/static/component/input/index"
            },
            Radio: {
              name: "Radio",
              description: "单选框",
              path: "/radio",
              component: "views/static/component/radio/index"
            },
            Checkbox: {
              name: "Checkbox",
              description: "多选框",
              path: "/checkbox",
              component: "views/static/component/checkbox/index"
            },
            Form: {name: "From", description: "表单"},
            textarea: {name: "Textarea", description: "文本框"},
            Select: {name: "Select", description: "选择框"},
            Dropdown: {name: "Dropdown", description: "下拉菜单"},
            Ul: {name: "Ul", description: "列表"},
            Breadcrumb: {name: "Breadcrumb", description: "路径导航"},
            Badge: {name: "Badge", description: "徽章",},
            jumbotron: {name: "jumbotron", description: "巨幕",},
            PageHeader: {name: "PageHeader", description: "页头",},
            Alert: {name: "Alert", description: "警告",},
            Media: {name: "Media", description: "媒体对象",},
            ListGroup: {name: "ListGroup", description: "列表组",},
            Panel: {name: "Panel", description: "面板"},
            Carousel: {name: "Carousel", description: "轮播图",},
            Collapse: {name: "Collapse", description: "",},
            Modal: {name: "Modal", description: "",},
            Pagination: {name: "Pagination", description: "",},
            Popovers: {name: "Popovers", description: "",},
            Tooltips: {name: "Tooltips", description: "",},
            Cascader: {name: "Cascader", description: "",},
            Switch: {name: "Switch", description: "",},
            Slider: {name: "Slider", description: "",},
            TimePicker: {name: "TimePicker", description: "",},
            DatePicker: {name: "DatePicker", description: "",},
            DateTimePicker: {name: "DateTimePicker", description: "",},
            Upload: {name: "Upload", description: "上传",},
            Rate: {name: "Rate", description: "评分",},
            ColorPicker: {name: "ColorPicker", description: "",},
            Transfer: {description: "穿梭框",},
            Tree: {name: "Tree", description: "",},
            Avatar: {name: "Avatar", description: "头像"},
            Skeleton: {name: "Skeleton", description: "骨架屏"},
            Empty: {name: "Empty", description: "空状态"},
            Tabs: {name: "Tabs", description: "",},
            Steps: {name: "Steps", description: "",},
            Timeline: {name: "Timeline", description: "时间线",},
            Calendar: {name: "Calendar", description: "日历",},
            Backtop: {name: "Backtop", description: "返回顶部",},
            InfiniteScroll: {name: "InfiniteScroll", description: "无线滚动",},
            Popconfirm: {name: "Popconfirm", description: "",},
            Tooltip: {name: "Tooltip", description: "",},
            Dialog: {name: "Dialog", description: "",},
            Affix: {name: "Affix", description: "固钉"},
            Anchor: {name: "Anchor", description: "",},
            ToDoList: {
              name: "ToDoList", description: "待办事项列表", path: "/todolist",
              component: "views/static/component/todolist/index"
            },
          },
        },

        {
          name: "Layout", description: "布局", path: "/layout", children: [
            {
              name: "Grid", description: "栅格", path: "/grid",
              component: "views/static/layout/grid/index"
            },
            {
              name: "Masonry", description: "瀑布流", path: "/masonry",
              component: "views/static/layout/masonry/index"
            }
          ]
        },
        {name: "Effect", description: "特效", path: "/effect", children: []},
        {
          name: "Skin", description: "皮肤", children: [
            {
              description: "默认", params: {
                skin: "default"
              }
            }
          ]
        },
        {
          name: "UI",
          description: "用户界面布局",
          children: [
            {
              description: "新拟态",
              params: {
                ui: "neumorphism"
              }
            },
            {
              description: "磨砂玻璃",
              params: {
                ui: "frosted"
              }
            },
            {
              // name: "Balanced",
              description: "舒适配色", params: {
                ui: "balanced"
              }
            },
            {
              description: "3D 色彩",
            },
            {
              description: "渐变色彩",
            },
            {
              description: "3D 交互",
            },
            {
              description: "质感设计",
            },
            {
              description: "暗黑模式",
            },
            {
              description: "扁平设计",
            },
            {
              description: "手绘元素",
            },
            {
              description: "微交互",
            },
            {
              description: "微动画",
            },
            {
              description: "文字主导",
            },
            {
              description: "数据可视",
            },
            {
              description: "拇指移动",
            },
            {
              description: "留白设计",
            },
            {
              description: "使用视频",
            },
            {
              description: "不对称布局",
            },
          ],
        },
      ],
    };
  });
})(define);
