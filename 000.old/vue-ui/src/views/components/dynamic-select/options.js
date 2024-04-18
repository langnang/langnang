
const bind_1 = {
  options: [{
    value: '选项1',
    label: '黄金糕'
  }, {
    value: '选项2',
    label: '双皮奶'
  }, {
    value: '选项3',
    label: '蚵仔煎'
  }, {
    value: '选项4',
    label: '龙须面'
  }, {
    value: '选项5',
    label: '北京烤鸭'
  }],
}

const examples = [
  {
    title: '基础用法',
    bind: {
      ...bind_1,
    }
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
  ...examples.map(item => { return { ...item, component: 'ElDynamicSelect' } }),
  ...options.map(item => { return { ...item, component: 'OptionsTable' } }),
]