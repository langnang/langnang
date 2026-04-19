import Vue from 'vue';

Vue.prototype.$gradient = function (colors) {//全局函数1
    return `linear-gradient(to right, ${colors.join(",")})`;
};
