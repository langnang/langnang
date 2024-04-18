<template>
  <el-select v-bind="$props" v-on="$listeners">
    <el-option v-for="(option, index) in options" :key="index" v-bind="option" v-on="$listeners"></el-option>
  </el-select>
</template>
<script>
import { Select } from 'element-ui';
export default {
  name: 'ElDynamicSelect',
  extends: Select,
  props: {},
  methods: {
    // resetInputWidth() {
    //   this.inputWidth = this.$children[0].$refs.reference.$el.getBoundingClientRect().width;
    //   console.log(this.$children);
    // },
  },
  beforeCreate() {
    console.log(this);
  },
  created() {
    console.log(this);
  },
};
</script>
