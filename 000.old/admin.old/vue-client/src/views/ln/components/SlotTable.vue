<template>
  <el-table :data="data">
    <el-table-column text-align="center" show-overflow-tooltip prop="name" label="事件名" />
    <el-table-column text-align="center" show-overflow-tooltip prop="desc" label="说明" />
  </el-table>
</template>
<script>
export default {
  name: "SlotTable",
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
