<template>
  <div class="ln-table">
    <el-table size="mini" border :data="data" style="width: 100%" @selection-change="handleSelectionChange">
      <slot v-for="(col, index) in columns" :name="col.slot ? col.slot : 'el-table-column-' + index">
        <el-table-column align="center" show-overflow-tooltip :type="col.type" :prop="col.prop" :label="col.label" :width="col.width"> </el-table-column>
      </slot>
      <slot></slot>
    </el-table>
    <el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange" :current-page="currentPage" :page-sizes="[10, 20, 50, 100]" :page-size="pageSize" layout="total, sizes, prev, pager, next, jumper" :total="total"> </el-pagination>
  </div>
</template>
<script>
export default {
  name: "LnTableC",
  props: {
    data: {
      type: Array,
      default() {
        return [];
      }
    },
    columns: {
      type: Array,
      default() {
        return [];
      }
    },
    currentPage: {
      type: Number,
      default: 0
    },
    pageSize: {
      type: Number,
      default: 0
    },
    total: {
      type: Number,
      default: 0
    }
  },
  components: {},
  data() {
    return {};
  },
  methods: {
    // 多选内容变化
    handleSelectionChange(val) {
      this.$emit("selection-change", val);
    },
    handleSizeChange(val) {
      this.$emit("size-change", val);
    },
    handleCurrentChange(val) {
      this.$emit("current-change", val);
    }
  }
};
</script>
