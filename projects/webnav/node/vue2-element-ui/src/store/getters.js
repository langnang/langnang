export default {
  permission_routes: (state) => state.permission.routes,
  branch_list: (state) =>
    state.app.branch.list.filter((v) => v.slug !== "default"),
  branch_active: (state) => state.app.branch.active,
  branch_prefix: (state) => state.app.branch.prefix,
  loading: (state) => state.app.loading,
  tree: (state) => state.app.tree,
  user_info: (state) => state.user.info,
  user_role: (state) => (state.user.info || {}).role,
};
