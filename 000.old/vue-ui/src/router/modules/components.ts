
import componentTemplate from '@/templates/components/index.vue'


const componentRoutes = {
  path: '/components',
  redirect: '/components/dynamic-table',
  component: () => import('@/layout/index.vue'),
  name: '组件',
  meta: {
  },
  children: [
    {
      path: 'dynamic-select',
      name: "Dynamic Select 动态渲染选择器",
      meta: {
      },
      component: componentTemplate
    },
    {
      path: 'dynamic-table',
      name: "Dynamic Table 动态渲染表格",
      meta: {
      },
      component: componentTemplate
    },
    {
      path: 'pageable-select',
      name: "Pageable Select 分页选择器",
      meta: {
      },
      component: componentTemplate
    },
    {
      path: 'pageable-table',
      name: "Pageable Table 分页表格",
      meta: {
      },
      component: componentTemplate
    },
    {
      path: 'progress',
      name: "Progress 进度条",
      meta: {
      },
      component: () => import('../../views/components/progress/index.vue')
    },
  ]
}

export default componentRoutes;