<template>
  <component :is="componentName" :index="path">
    <span v-if="componentName === 'el-menu-item'">{{ name }}</span>
    <span v-else>
      <ElRouteMenuItem v-for="item in childrenList" :key="item.path" v-bind="item" />
    </span>
    <template v-if="componentName === 'el-submenu'" slot="title">{{ name }}</template>
  </component>
</template>
<script>
export default {
  name: 'ElRouteMenuItem',
  props: {
    icon: {
      type: String,
      default: '',
    },
    name: {
      type: String,
      default: '',
    },
    path: {
      type: String,
      default: '',
    },
    children: {
      type: Array,
      default() {
        return [];
      },
    },
  },
  data() {
    return {};
  },
  computed: {
    componentName() {
      if (this.children && this.children.length > 0) {
        return 'el-submenu';
      }
      return 'el-menu-item';
    },
    childrenList() {
      return this.children.map(item => {
        return {
          ...item,
          ...item.meta,
          path: this.path + (item.path.charAt(0) === '/' ? '' : '/') + item.path,
        };
      });
    },
  },
};
</script>
