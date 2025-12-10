import Vue from 'vue'

const directiveName = "$show"

Vue.directive(directiveName, {
  bind: function (el, binding, vnode, oldVnode) {
    // console.log(`[v-${directiveName}]bind`, { el, binding, vnode, oldVnode })
    if (binding.value == false) {
      el.style.display = 'none'
    } else {
      el.style.display = 'block'
    }
  },
  inserted: function (el, binding, vnode, oldVnode) {
    // console.log(`[v-${directiveName}]inserted`, { el, binding, vnode, oldVnode })
  },
  update: function (el, binding, vnode, oldVnode) {
    // console.log(`[v-${directiveName}]update`, { el, binding, vnode, oldVnode })
  },
  componentUpdated: function (el, binding, vnode, oldVnode) {
    // console.log(`[v-${directiveName}]componentUpdated`, { el, binding, vnode, oldVnode })
  },
  unbind: function (el, binding, vnode, oldVnode) {
    // console.log(`[v-${directiveName}]unbind`, { el, binding, vnode, oldVnode })
  },
})