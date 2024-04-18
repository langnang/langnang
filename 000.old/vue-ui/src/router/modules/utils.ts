
const utilRoutes = {
  path: '/utils',
  redirect: '/utils',
  name: '工具',
  component: () => import('@/layout/index.vue'),
  meta: {
    icon: '',
  },
  children: [
    // {
    //   path: 'layout-builder',
    //   name: "LayoutBuilder",
    //   meta: {
    //     name: "LayoutBuilder",
    //   },
    //   component: () => import('../../views/utils/layout-builder/index.vue')
    // }
  ]
}

export default utilRoutes;