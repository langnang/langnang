<template>
  <div>
    <h2 style="font-weight:inherit">{{ name === "" ? "" : name + " " }}Attributes</h2>
    <el-table :data="data">
      <el-table-column align="center" show-overflow-tooltip prop="name" label="参数" />
      <el-table-column align="center" show-overflow-tooltip prop="desc" label="说明" />
      <el-table-column align="center" show-overflow-tooltip prop="type" label="类型" />
      <el-table-column align="center" show-overflow-tooltip prop="options" label="可选值">
        <template v-slot="{ row }">
          {{ row.options ? row.options : "-" }}
        </template>
      </el-table-column>
      <el-table-column align="center" show-overflow-tooltip prop="default" label="默认值">
        <template v-slot="{ row }">
          {{ row.default ? row.default : "-" }}
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>
<script>
export default {
  name: "AttributeTable",
  props: {
    name: {
      type: String,
      required: true,
      default: ""
    },
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
