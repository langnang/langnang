<template>
  <el-row :gutter="20" class="container">
    <el-col :span="4" class="left">
      <el-row :gutter="10" class="comp-group">
        <el-col :span="12" class="comp-item" v-for="comp in components" :key="comp">
          <el-card>
            {{ comp }}
          </el-card>
        </el-col>
      </el-row>
    </el-col>
    <el-col :span="16" class="main">16</el-col>
    <el-col :span="4" class="right">
      <el-card></el-card>
    </el-col>
  </el-row>
</template>
<script>
export default {
  name: 'LayoutBuilderView',
  data() {
    return {
      components: ['el-container', 'el-header', 'el-aside', 'el-main', 'el-footer', 'el-row', 'el-col'],
    };
  },
};
</script>
<style lang="scss" scoped>
.comp-group {
}
.comp-item {
  .el-card {
    cursor: grab;
    &:focus {
      cursor: grabbing;
    }
  }
}
</style>
