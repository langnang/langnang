<template>
  <div>
    <h1 class="title">{{ title }}</h1>
    <p>{{ description }}</p>
    <el-card>
      <component :is="component" v-bind="bind">
        <slot></slot>
      </component>
    </el-card>
  </div>
</template>
<script>
import OptionsTable from '@/components/options-table';
export default {
  components: {
    OptionsTable,
  },
  props: {
    title: {
      type: String,
      default: '',
    },
    description: {
      type: String,
      default: '',
    },
    component: {
      type: String,
      default: 'div',
    },
    bind: {
      type: Object,
      default() {
        return {};
      },
    },
  },
};
</script>
