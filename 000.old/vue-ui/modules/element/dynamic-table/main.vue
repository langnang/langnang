<template>
  <el-table ref="ElTable" v-bind="$props" v-on="$listeners">
    <template v-for="(col, index) in cols">
      <ElDynamicTableColumn :key="index" v-bind="col"></ElDynamicTableColumn>
    </template>
    <template slot="empty">
      <slot name="empty">
        <el-empty></el-empty>
      </slot>
    </template>
    <!-- 空数据下仍显示 -->
    <template slot="empty-append">
      <slot name="append"></slot>
    </template>
    <!-- 空数据下不显示 -->
    <template v-if="data && data.length > 0" slot="append">
      <slot name="append"></slot>
    </template>
  </el-table>
</template>

<script>
import { Table } from 'element-ui';
export default {
  name: 'ElDynamicTable',
  extends: Table,
  props: {
    cols: {
      type: Array,
      default() {
        return [];
      },
    },
  },
  computed: {
    bodyWrapper() {
      return this.$children[0].bodyWrapper;
    },
  },
  watch: {},
  mounted() {},
};
</script>
