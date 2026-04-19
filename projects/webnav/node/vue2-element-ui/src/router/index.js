import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home.vue";
import { loadJs } from "./../assets/js/app.js";
import store from "./../store/index";
Vue.use(VueRouter);

async function getDynamicRoutes() { }

// const dynamicRoutes = getDynamicRoutes();

// console.log("🚀 ~ file: index.js:14 ~ dynamicRoutes:", dynamicRoutes);

export function beforeEnter(to, form, next) {
  store.commit("app/SET_BRANCH_PREFIX", to.meta.prefix);
  next();
}
export const asyncRoutes = [];
export const constantRoutes = [
  {
    path: "/home/:name?",
    name: "Home",
    meta: { title: "Home", prefix: "home" },
    component: () => import("../views/Main.vue"),
    beforeEnter,
  },
  {
    path: "/public/:branch/:name?",
    component: () => import("../views/Main.vue"),
    beforeEnter,
  },
  {
    path: "/private/:branch/:name?",
    component: () => import("../views/Main.vue"),
    beforeEnter,
  },
  {
    path: "/draft/:branch/:name?",
    component: () => import("../views/Main.vue"),
    beforeEnter,
  },
  {
    path: "/about",
    name: "About",
    meta: { title: "About" },
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import("../views/About.vue"),
  },
  {
    path: "*",
    redirect: "/home",
  },
];

const router = new VueRouter({
  mode: "hash",
  base: process.env.BASE_URL,
  routes: constantRoutes,
});

export default router;
