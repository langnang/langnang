<template>
  <el-menu router :default-active="$route.path">
    <ElRouteMenuItem v-for="item in routeList" :key="item.path" v-bind="item" />
  </el-menu>
</template>
<script>
import ElRouteMenuItem from '../route-menu-item/item.vue';
export default {
  name: 'ElRouteMenu',
  props: {
    // 路由配置
    routes: {
      type: Array,
      default() {
        return [];
      },
    },
  },
  components: {
    ElRouteMenuItem,
  },
  date() {
    return {};
  },
  computed: {
    routeList() {
      return this.routes.map(item => {
        return {
          ...item,
          ...item.meta,
          path: (item.path.charAt(0) === '/' ? '' : '/') + item.path,
        };
      });
    },
  },
};
</script>
