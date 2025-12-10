import Vue from "vue";
import App from "./App.vue";

import VueUI from './../packages'

Vue.config.productionTip = false;

Vue.use(VueUI)
new Vue({
  render: (h) => h(App),
}).$mount("#app");
