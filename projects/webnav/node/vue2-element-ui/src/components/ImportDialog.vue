<template>
  <el-dialog :visible.sync="visible" append-to-body title="导入">
    <el-upload class="upload-demo" drag action="/api/guide/import" multiple>
      <i class="el-icon-upload"></i>
      <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
      <div class="el-upload__tip" slot="tip">只能上传jpg/png文件，且不超过500kb</div>
    </el-upload>
  </el-dialog>
</template>

<script>
export default {
  name: "ImportDialog",
  data() {
    return {
      visible: false,
    }
  },
  methods: {
    toggle() {
      this.visible = !this.visible
    }
  }
}
</script>

<style lang="scss"></style>