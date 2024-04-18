
const exampleRoutes = {
  path: '/examples',
  redirect: '/examples/audio-player',
  name: "示例",
  component: () => import('@/layout/index.vue'),
  meta: {
  },
  children: [
    {
      path: 'audio-player',
      meta: {
        name: "AudioPlayer 音频播放器",
      },
      component: () => import('../../views/examples/audio-player/index.vue')
    },
    {
      path: 'icon',
      name: "Icon 图标",
      meta: {
      },
      component: () => import('../../views/examples/icon/index.vue')
    },
  ]
}

export default exampleRoutes;