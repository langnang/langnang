import Vue from "vue";
import App from "./layout/index.vue";
import router from "./router";
import store from "./store";
import "./plugins";
import "./directives";
import "./filters";
import "./permission";
import "./style/index.scss";

import "./assets/css/fonts/linecons/css/linecons.css";
import "./assets/css/fonts/fontawesome/css/font-awesome.min.css";
import "./assets/css/bootstrap.css";
import "./assets/css/xenon-core.css";
import "./assets/css/xenon-components.css";
import "./assets/css/xenon-skins.css";
import "./assets/css/nav.css";

Vue.config.productionTip = false;

new Vue({
  router,
  store,
  render: (h) => h(App),
}).$mount("#app");
