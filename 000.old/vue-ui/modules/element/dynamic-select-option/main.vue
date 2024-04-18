<template>
  <component :is="componentName" v-bind="$props" :name="prop">
    <ElDynamicTableColumn v-for="(col, index) in children" :key="index" v-bind="col" />
  </component>
</template>
<script>
import { Option } from 'element-ui';

export default {
  name: 'ElDynamicSelectOption',
  extends: Option,
  props: {
    isSlot: {
      type: Boolean,
      default: false,
    },
    component: {
      type: String,
      default: null,
    },
    children: {
      type: Array,
      default() {
        return [];
      },
    },
  },
  computed: {
    componentName() {
      if (this.isSlot) return 'slot';
      if (this.component) return this.component;
      return 'el-option';
    },
  },
};
</script>
