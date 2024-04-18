<template>
  <el-table v-bind="vBind" v-on="vOn">
    <template v-for="(column, index) in columns">
      <ElDynamicTableColumn :key="index" v-bind="column" />
    </template>
    <template slot="empty">
      <el-empty slot="empty"></el-empty>
    </template>
    <template slot="append">
      <slot name="append"></slot>
    </template>
  </el-table>
</template>

<script>
import ElDynamicTableColumn from './../dynamic-table-column/main.vue';
// import { Table } from 'element-ui';
export default {
  name: 'ElDynamicTable',
  components: {
    ElDynamicTableColumn,
  },
  props: {
    index: {
      type: Boolean,
      default: false,
    },
    columns: {
      type: Array,
      default() {
        return [];
      },
    },
    data: {
      type: Array,
      default() {
        return [];
      },
    },
    // 选择框
    isSelect: {
      type: Boolean,
      default: false,
    },
    selectableHandle: {
      //hwq: 某一行的 CheckBox 是否可以勾选控制
      type: Function,
      default: function () {
        return true;
      },
    },
    // 总页数
    allTotal: {
      type: Number,
      default: 0,
    },
    // 页面多少
    pageSize: {
      type: Number,
      default: 10,
    },
    // 当期页
    currentPage: {
      type: Number,
      default: 1,
    },
    isPagination: {
      type: Boolean,
      default: true,
    },
  },
  watch: {
    cancelData: {
      handler(curVal) {
        this.$refs.multipleTable.toggleRowSelection(curVal, false);
      },
      deep: true,
    },
    currentPage(val) {
      this.currentPageTemp = val;
    },
  },
  computed: {
    vBind() {
      return {
        data: this.data,
      };
    },
    vOn() {
      return {
        selectionChange: this.handleSelectionChange,
        sortChange: this.handleSortChange,
        cellClick: this.handleCellClick,
      };
    },
  },
  data() {
    return {
      currentPageTemp: this.currentPage,
    };
  },
  methods: {
    //  表格选择
    handleSelectionChange(val) {
      this.$emit('selectTableOut', val);
    },
    // 分页
    paginationChange(val) {
      // console.log(`每页 ${val} 条`);
      this.$emit('pageSizeOut', val);
    },
    paginationCurrentChange(val) {
      // console.log(`当前页: ${val}`);
      this.$emit('pageOut', val);
    },
    handleSortChange(...args) {
      this.$emit('sort-change', ...args);
    },
    //hwq: 清空用户选择
    clearSelection() {
      this.$refs.multipleTable.clearSelection();
    },
    //hwq: 选择某行数据方法
    toggleRowSelection(row, selected) {
      this.$refs.multipleTable.toggleRowSelection(row, selected);
    },
    handleCellClick(...args) {
      this.$emit('cellClickOut', ...args);
    },
  },
};
</script>
