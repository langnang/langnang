<template>
  <el-form>
    <el-row :gutter="20">
      <el-col :span="6">
        <el-form-item label="活动名称">
          <el-input v-model="form.name" />
        </el-form-item>
      </el-col>
    </el-row>
  </el-form>
</template>
<script>
/**
 * 表单构造器
 *
 */
export default {
  name: "FormBuilder",
  props: {
    option: {
      type: Object,
      default() {
        return {};
      }
    }
  },
  data() {
    return {};
  }
};
</script>
