<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :span="18">
        <FormBuilder />
      </el-col>
      <el-col :span="6">
        <FormBuilderController />
      </el-col>
    </el-row>
  </div>
</template>
<script>
import FormBuilder from "@/components/FormBuilder";
import FormBuilderController from "@/components/FormBuilder/Controller";
export default {
  name: "FormBuilderView",
  components: { FormBuilder, FormBuilderController }
};
</script>
