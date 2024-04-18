<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col v-for="(item, index) in summary" :key="index" :span="6">
        <el-card shadow="hover">
          <div style="text-align:center">
            {{ item.label }}
          </div>
        </el-card>
      </el-col>
      <el-col :span="6">
        <el-card shadow="hover">
          <div style="text-align:center">
            <i class="el-icon-plus" />
          </div>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>
<script>
import { typechoOptionInfo } from "@/api/typecho";
export default {
  name: "TypechoResourceView",
  components: {},
  data() {
    return {
      componentId: "div",
      typeList: [{ label: "服务器" }, { label: "数据库" }, { label: "账号" }, { label: "服务器" }, { label: "服务器" }],
      summary: [
        { key: "server", label: "服务器资源", total: 0 },
        { key: "sql_server", label: "数据库", total: 0 }
      ]
    };
  },
  created() {},
  methods: {
    handleQuery() {
      typechoOptionInfo({ names: ["resourceSummary"] }).then(res => {
        if (res.total !== 0) {
          this.summary = JSON.parse(res.rows["resourceSummary"]);
        }
      });
    },
    handleTabsEdit() {}
  }
};
</script>
<style lang="scss">
.box {
  display: flex;
  justify-content: center;
  align-items: center;
  // width: 100%;
  // padding-bottom: 100%; /* padding百分比相对父元素宽度计算 */
  // height: 0; //避免被内容撑开多余的高度

  width: 100%;
  overflow: hidden;
  &::after {
    content: "";
    display: block;
    margin-top: 100%;
  }
}
</style>
