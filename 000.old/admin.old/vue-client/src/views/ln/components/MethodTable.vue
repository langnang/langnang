<template>
  <el-table :data="data">
    <el-table-column text-align="center" show-overflow-tooltip prop="name" label="事件名" />
    <el-table-column text-align="center" show-overflow-tooltip prop="desc" label="说明" />
    <el-table-column text-align="center" show-overflow-tooltip prop="params" label="参数">
      <template v-slot="{ row }">
        {{ row.params ? row.params : "-" }}
      </template>
    </el-table-column>
  </el-table>
</template>
<script>
export default {
  name: "EventTable",
  props: {
    data: {
      type: Array,
      required: true,
      default() {
        return [];
      }
    }
  }
};
</script>
