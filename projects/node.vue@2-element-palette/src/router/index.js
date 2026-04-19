import Vue from 'vue'
import VueRouter from 'vue-router'
import RouteView from '../views/RouteView.vue'
import Home from '../views/Home.vue'
import Single from '../views/Single.vue'
import WebSafe from '../views/WebSafe.vue'
import Palette from '../views/Palette.vue'
import Random from '../views/Random.vue'
import Gradient from '../views/Gradient.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: { title: "Home" }
  },
  {
    path: "/single",
    name: "Single Color",
    component: RouteView,
    children: [
      {
        path: "websafe",
        name: "WebSafe",
        component: WebSafe,
        meta: { title: "216 Web Safe" }
      },
      {
        path: "random",
        name: "Random",
        component: Random,
        meta: { title: "Random" }
      },
      {
        path: ":key",
        name: "Single",
        component: Single,
        meta: { title: "Single Colors" }
      },
    ],
  },
  {
    path: "/gradient",
    name: "Gradient Colors",
    component: RouteView,
    children: [
      {
        path: ":key",
        name: "Gradient",
        component: Gradient,
        meta: { title: "Gradient Colors" }
      },
    ]
  },
  {
    path: "/palette",
    name: "Color Palettes",
    component: RouteView,
    children: [
      {
        path: ":key",
        name: "Palette",
        component: Palette,
        meta: { title: "Color Palettes" }
      },
    ]
  },
  {
    path: '/about',
    name: 'About',
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  }
]

const router = new VueRouter({
  routes
})

router.beforeEach((to, from, next) => {
  next();
})
// router.afterEach((to, from) => {
//   console.log(to);
//   console.log(from);
// })

export default router
