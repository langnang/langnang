import Vue from 'vue'
import VueRouter from 'vue-router'

import componentRoutes from './modules/components'
import exampleRoutes from './modules/examples'
import utilRoutes from './modules/utils'


export const routes = [
  {
    path: '/',
    name: 'Home',
    component: () => import('../views/Home.vue')
  },
  {
    path: '/about',
    name: 'About',
    component: () => import('../views/About.vue')
  },
  componentRoutes,
  utilRoutes,
  exampleRoutes,
  {
    path: '*',
    name: '404',
    component: () => import('../views/404.vue')
  },
]
Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'hash',
  routes
})
export default router
