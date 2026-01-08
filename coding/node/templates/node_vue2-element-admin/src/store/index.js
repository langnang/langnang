import Vue from 'vue'
import Vuex from 'vuex'
import getters from './getters'
import app from './modules/app'
import settings from './modules/settings'
import user from './modules/user'
import VuexPersist from 'vuex-persist'

Vue.use(Vuex)
const vuexLocal = new VuexPersist({
  storage: window.localStorage

})
const store = new Vuex.Store({
  modules: {
    app,
    settings,
    user
  },
  getters,
  plugins: [vuexLocal.plugin]
})

export default store
