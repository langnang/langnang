<template>
  <div class="app-container">
    <component :is="componentId">
      <el-row :gutter="20">
        <el-col v-for="(item, index) in list" :key="index" :span="6">
          <el-card shadow="hover">
            <LnBox :height="'20%'"> {{ item.label }}.v{{ item.version }} </LnBox>
          </el-card>
        </el-col>
      </el-row>
    </component>
  </div>
</template>
<script>
import packages from "@/../package.json";
export default {
  name: "TypechoResourceView",
  data() {
    return {
      componentId: "div",
      packages
    };
  },
  computed: {
    list() {
      const dependencies = { ...this.packages.dependencies, ...this.packages.devDependencies };
      const res = [];
      for (const key in dependencies) {
        res.push({
          label: key,
          version: dependencies[key]
        });
      }
      return res;
    }
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
    margin-top: 40%;
  }
}
</style>
