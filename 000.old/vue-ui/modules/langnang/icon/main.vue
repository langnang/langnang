<template>
  <component :is="componentName" :class="iconClass" :icon-class="iconClass" :icon="iconClass" />
</template>
<script>
export default {
  name: 'LnIcon',
  props: {
    // 图标名
    icon: {
      type: String,
      default: '',
    },
  },
  data() {
    return {};
  },
  computed: {
    componentName() {
      if (this.icon.indexOf('svg-') === 0) {
        return 'svg-icon';
      }
      if (this.icon.indexOf('fas-') === 0 || this.icon.indexOf('fab-') === 0 || this.icon.indexOf('far-') === 0) {
        return 'font-awesome-icon';
      }
      return 'i';
    },
    iconClass() {
      if (this.icon.indexOf('el-icon-') === 0) {
        return this.icon;
      }
      if (this.icon.indexOf('svg-') === 0) {
        return this.icon.substr(4);
      }
      if (this.icon.indexOf('fas-') === 0 || this.icon.indexOf('fab-') === 0 || this.icon.indexOf('far-') === 0) {
        return [this.icon.substr(0, 3), this.icon.substr(4)];
      }
      return this.icon;
    },
  },
  methods: {
    expands(component) {
      console.log(component);
    },
  },
};
</script>
