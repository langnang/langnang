<template>
  <div ref="container" style="position:relative;width: 100%;height: 19px;">
    <slot name="append">
      <el-form v-if="false" v-model="form" :inline="true" size="mini">
        <el-select v-model="editorLanguage">
          <el-option v-for="item in languageOptions" :key="item" :value="item" />
        </el-select>
        <el-button-group size="mini">
          <el-button size="mini" type="dark" @click="handleAppend('h1')">H1</el-button>
          <el-button size="mini" type="dark" @click="handleAppend('h2')">H2</el-button>
          <el-button size="mini" type="dark" @click="handleAppend('h3')">H3</el-button>
        </el-button-group>
      </el-form>
    </slot>

    <el-link :underline="false" target="_blank" href="https://microsoft.github.io/monaco-editor/" style="position:absolute;top:0px;right:4px;z-index:1;line-height:14px;">
      Monaco Editor
    </el-link>
  </div>
</template>
<script>
import * as monaco from "monaco-editor";
import { languageOptions } from "./default-options";
export default {
  name: "MonacoEditor",
  props: {
    value: { type: String, default: "" },
    language: { type: String, default: "markdown" },
    theme: { type: String, default: "vs-dark" },
    readonly: { type: Boolean, default: false }
  },
  date() {
    return {
      editor: null,
      form: { language: "" },
      languageOptions: []
    };
  },
  created() {
    this.languageOptions = languageOptions;
  },
  mounted() {
    const vm = this;
    this.initEditor();
    if (this.value !== "") {
      const value = vm.getValue();
      vm.$refs.container.style.height = value.split("\n").length * 19 + "px";
    }
    // 内容改变后
    this.editor.onDidChangeModelContent(function() {
      const value = vm.getValue();
      vm.$refs.container.style.height = value.split("\n").length * 19 + "px";
      vm.$emit("value-change", vm.getValue());
    });
    // 监听保存按钮
    this.editor.addCommand(monaco.KeyMod.CtrlCmd | monaco.KeyCode.KEY_S, function() {
      console.log("SAVE pressed!");
    });
    // 滚动条
    this.editor.onDidScrollChange(v => {});
  },
  methods: {
    // 初始化编辑器，确保dom已经渲染
    initEditor() {
      this.editor = monaco.editor.create(this.$refs.container, {
        value: this.value, // 编辑器初始显示文字
        language: this.language, // 语言支持自行查阅demo
        theme: this.theme, // 官方自带三种主题vs, hc-black, or vs-dark
        automaticLayout: true, // 自动布局
        roundedSelection: false,
        readOnly: this.readonly, // 只读
        scrollBeyondLastLine: false,
        renderWhitespace: true,
        tabSize: 2, //
        wordWrap: "on",
        // 预览面板
        minimap: {
          enabled: false
        }
      });
    },
    // 获取编辑器中的文本
    getValue() {
      return this.editor.getValue();
    },
    // 设置编辑器内容
    setValue(value) {
      if (typeof value !== "string") {
        value = value.toString();
      }
      this.editor.setValue(value);
    },
    // 设置编辑器语言
    setLanguage(language) {
      monaco.editor.setModelLanguage(this.editor.getModel(), language);
      this.$emit("language-change", language);
    },
    // 设置编辑器主题
    setTheme(theme) {
      monaco.editor.setTheme(theme);
      this.$emit("theme-change", theme);
    },
    // 在光标处插入指定代码片段
    handleAppend() {
      var selection = this.editor.getSelection();
      var range = new monaco.Range(selection.startLineNumber, selection.startColumn, selection.endLineNumber, selection.endColumn);
      var id = { major: 1, minor: 1 };
      var text = "\n# ";
      var op = { identifier: id, range: range, text: text, forceMoveMarkers: true };
      this.editor.executeEdits("my-source", [op]);
    }
  }
};
</script>
<style lang="scss" scoped>
::v-deep .el-button--mini {
  padding: 7px 6px;
}
</style>
