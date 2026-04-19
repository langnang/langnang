import { login } from "@/api/user";
import { setToken } from "@/utils/auth";
import { removeToken } from "../../utils/auth";
const state = {
  info: null,
};

const mutations = {
  SET_INFO(state, payload) {
    state.info = payload;
  },
};

const actions = {
  login({ state, commit }, payload = {}) {
    const { authCode } = payload;

    return login(payload)
      .then((res) => {
        commit("SET_INFO", res);
        if (!authCode) {
          setToken(res.authCode);
          window.location.reload();
        }
        // this._vm.$router.push("/home");
      })
      .catch((res) => {
        removeToken();
        this._vm.$message.error("登录失败");
      });
  },
  logout({ state, commit }, payload) {
    return this._vm.$confirm("确定要登出吗？", "警告", {
      confirmButtonText: "确定",
      cancelButtonText: "取消",
      type: "warning",
    }).then(() => {
      removeToken();
      window.location.reload();
    }).catch(() => { });
  },
  getItem({ state, commit }, payload) { },
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
};
