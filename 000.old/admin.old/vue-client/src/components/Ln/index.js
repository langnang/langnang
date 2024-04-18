import Vue from "vue";

Vue.component("LnBox", () => import("./Box"));
Vue.component("LnEditor", () => import("./Editor"));
Vue.component("LnIcon", () => import("./Icon"));
Vue.component("LnTable", () => import("./Table"));
