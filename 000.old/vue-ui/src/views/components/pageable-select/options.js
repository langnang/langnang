const examples = [
  {
    title: '基础用法',
    description: '适用广泛的基础单选',
    bind: {
    },
    on: {
    }
  },
]
const options = [
  {
    bind: {
      title: 'Pageable Table',
      type: 'attribute',
      data: [
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
  ...examples.map(item => { return { ...item, component: 'ElPageableSelect' } }),
  ...options.map(item => { return { ...item, component: 'OptionsTable' } }),
]