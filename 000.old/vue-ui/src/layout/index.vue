<template>
  <el-container>
    <el-header>
      <el-menu mode="horizontal" router :default-active="$route.matched[0].path">
        <el-menu-item index="/components">组件</el-menu-item>
        <el-menu-item index="/examples">示例</el-menu-item>
        <el-menu-item index="/utils">工具</el-menu-item>
      </el-menu>
    </el-header>
    <el-container>
      <el-aside>
        <ElRouteMenu :routes="routes" />
      </el-aside>
      <el-main>
        <el-page-header @back="handleRouteBack" :content="$route.name"></el-page-header>
        <el-scrollbar style="height: calc(100vh - 140px)">
          <router-view></router-view>
        </el-scrollbar>
      </el-main>
    </el-container>
    <el-footer v-if="false"></el-footer>
  </el-container>
</template>
<script>
import componentRoutes from '@/router/modules/components';
import exampleRoutes from '@/router/modules/examples';
import utilRoutes from '@/router/modules/utils';
export default {
  components: {},
  data() {
    return {
      dynamicRoutes: [componentRoutes, exampleRoutes, utilRoutes],
    };
  },
  computed: {
    routes() {
      const route = this.dynamicRoutes.find(route => route.path === this.$route.matched[0].path);
      return route.children.map(item => {
        return {
          ...item,
          ...item.meta,
          path: route.path + (item.path.charAt(0) === '/' ? '' : '/') + item.path,
        };
      });
    },
  },
  created() {
    console.log(this);
  },
  methods: {
    handleRouteBack() {
      this.$router.go(-1);
    },
  },
};
</script>
<style>
.el-scrollbar__wrap {
  overflow-x: hidden;
}
</style>
