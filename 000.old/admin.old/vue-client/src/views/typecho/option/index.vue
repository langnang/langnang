<template>
  <div class="app-container">
    <h2>系统配置</h2>
    <h2>参数配置</h2>
    <el-table :data="summary" size="small">
      <el-table-column align="center" show-overflow-tooltip prop="key" label="键" width="180">
        <template v-slot="{ row }"> <el-input v-model="row.key" /> </template>
      </el-table-column>
      <el-table-column align="center" show-overflow-tooltip prop="value" label="值">
        <template v-slot="{ row }"> <el-input v-model="row.value" /> </template>
      </el-table-column>
      <el-table-column align="center" show-overflow-tooltip label="操作">
        <template v-slot="{}">
          <el-button type="primary" icon="el-icon-plus">编辑</el-button>
          <el-button>复制</el-button>
          <el-button>删除</el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>
<script>
import typechoMixin from "@/mixins/typecho";
export default {
  name: "TypechoOptionView",
  components: {},
  mixins: [typechoMixin],
  data() {
    return {
      typeList: [{ label: "服务器" }, { label: "数据库" }, { label: "账号" }, { label: "服务器" }, { label: "服务器" }],
      summary: []
    };
  },
  created() {
    this.selectOptionInfo().then(res => {
      console.log(res);
      if (res === undefined) return;
      const summary = [];
      for (const key in res.rows) {
        summary.push({
          key,
          value: res.rows[key]
        });
      }
      console.log(summary);
      this.summary = summary;
    });
  }
};
</script>
