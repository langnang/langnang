
const bind_1 = {
  cols: [
    { prop: 'date', label: '日期', width: '180px' },
    { prop: 'name', label: '姓名', width: '180px' },
    { prop: 'address', label: '地址' },
  ],
  data: [{
    date: '2016-05-02',
    name: '王小虎',
    address: '上海市普陀区金沙江路 1518 弄'
  }, {
    date: '2016-05-04',
    name: '王小虎',
    address: '上海市普陀区金沙江路 1517 弄'
  }, {
    date: '2016-05-01',
    name: '王小虎',
    address: '上海市普陀区金沙江路 1519 弄'
  }, {
    date: '2016-05-03',
    name: '王小虎',
    address: '上海市普陀区金沙江路 1516 弄'
  }]
}

const examples = [
  {
    title: '基础表格',
    description: '基础的表格展示用法。',
    bind: {
      ...bind_1,
    }
  },
  {
    title: '带斑马纹表格',
    description: '使用带斑马纹的表格，可以更容易区分出不同行的数据。',
    bind: {
      ...bind_1,
      stripe: true,
    },
  },
  {
    title: '带边框表格',
    bind: {
      ...bind_1,
      border: true,
    },
  },
  {
    title: '带状态表格',
    description: '可将表格内容 highlight 显示，方便区分「成功、信息、警告、危险」等内容。',
    bind: {
      ...bind_1,
      'row-style': ({ row, rowIndex }) => {
        if (rowIndex === 1) {
          return { background: 'oldlace' };
        } else if (rowIndex === 3) {
          return { background: '#f0f9eb' };
        }
        return {};
      },
    },
  },
]
const options = [
  {
    bind: {
      prototype: 'https://element.eleme.cn/#/zh-CN/component/table#table-attributes', title: 'Dynamic Table', type: 'attribute', data: [
        ['cols', '动态列参数', 'object', '-', '-']
      ]
    }
  },
  {
    bind: {
      prototype: 'https://element.eleme.cn/#/zh-CN/component/table#table-events',
      title: 'Dynamic Table', type: 'event', data: []
    }
  },
  { bind: { title: '', type: 'method', data: [] } },
  {
    bind: {
      title: '', type: 'slot', data: [
      ]
    }
  },
  {
    bind: {
      title: 'Dynamic Table Column', type: 'attribute', data: [
      ]
    }
  },
]
export default [
  ...examples.map(item => { return { ...item, component: 'ElDynamicTable' } }),
  ...options.map(item => { return { ...item, component: 'OptionsTable' } }),
]