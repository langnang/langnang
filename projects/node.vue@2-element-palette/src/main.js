import Vue from 'vue'
import './plugins'
import './globals'
import App from './App.vue'
import router from './router'
import store from './store'
// import 'particles.js';

Vue.config.productionTip = false
Vue.use(require('vue-wechat-title'))


new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')


