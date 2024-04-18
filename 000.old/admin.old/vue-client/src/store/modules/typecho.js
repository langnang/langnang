import { typechoOptionList } from "@/api/typecho";
const state = {
  metaTypeList: {},
  metaList: {},
  metaTree: {},
  posts: [],
  option: {},
  optionList: []
};
const mutations = {
  SET_OPTION_LIST: (state, list) => {
    state.optionList = list;
  }
};
const actions = {
  optionList({ commit }) {
    return new Promise((resolve, reject) => {
      typechoOptionList()
        .then(res => {
          commit("SET_OPTION_LIST", res.rows);
          resolve(res);
        })
        .catch(error => reject(error));
    });
  }
};

export default {
  namespaced: true,
  state,
  mutations,
  actions
};
