<template>
  <el-select v-bind="$props" v-on="$listeners">
    <el-option v-for="(option, index) in opts" :key="index" v-bind="option" v-on="$listeners"></el-option>
    <el-pagination v-bind="pagination" v-on="$listeners"></el-pagination>
  </el-select>
</template>
<script>
import { Select } from 'element-ui';
export default {
  name: 'ElPageableSelect',
  extends: Select,
  props: {
    opts: {
      type: Array,
      default() {
        return [];
      },
    },
    pagination: {
      type: Object,
      default() {
        return {};
      },
    },
  },
};
</script>
