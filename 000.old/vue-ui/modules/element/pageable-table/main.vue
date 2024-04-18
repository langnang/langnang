<template>
  <ElDynamicTable v-bind="$props" v-on="$listeners">
    <template slot="append">
      <el-pagination v-bind="pagination" v-on="$listeners"></el-pagination>
    </template>
  </ElDynamicTable>
</template>
<script>
import ElDynamicTable from '../dynamic-table/main.vue';
import { Pagination } from 'element-ui';
export default {
  name: 'ElPageableTable',
  extends: ElDynamicTable,
  components: { ElDynamicTable },
  props: {
    pagination: {
      type: Object,
      default() {
        return {};
      },
    },
  },
  methods: {
    ...Pagination.methods,
  },
  created() {
    console.log(this);
  },
};
</script>
