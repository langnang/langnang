const examples = [
  {
    title: '基础表格',
    description: '基础的表格展示用法。',
    bind: {
      cols: [
        { prop: 'date', label: '日期', width: '180px' },
        { prop: 'name', label: '姓名', width: '180px' },
        { prop: 'address', label: '地址' },
      ],
      data: [
        {
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
        }
      ]
    },
    on: {
      'current-change': (val) => {
        console.log(val)
      }
    }
  },
]
const options = [
  {
    bind: {
      title: 'Pageable Table', type: 'attribute', data: [
        ['pagination', 'el-pagination 组件对应的参数', 'object', '-', '-']
      ],
      prototype: 'https://element.eleme.cn/#/zh-CN/component/pagination#attributes'
    }
  },
  { bind: { title: '', type: 'event', data: [] } },
  { bind: { title: '', type: 'method', data: [] } },
  {
    bind: {
      title: '', type: 'slot', data: [
        { name: 'empty', description: '空数据显示内容' }
      ]
    }
  },
  {
    bind: {
      title: 'Pageable Table Column', type: 'attribute', data: [
        { name: 'label' },
        { name: 'prop', },
        { name: 'width', },
      ]
    }
  },
]

export default [
  ...examples.map(item => { return { ...item, component: 'ElPageableTable' } }),
  ...options.map(item => { return { ...item, component: 'OptionsTable' } }),
]