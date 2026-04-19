import Vue from "vue";
Vue.filter("type", function (list, type) {
  return list.filter((v) => v.type == type);
});
