<template>
  <el-row :gutter="20" class="app-container">
    <el-col :span="18">
      <MonacoEditor ref="monacoEditor" @value-change="handleValueChange" />
      <div style="margin-top:40px" v-html="markdownHtml" />
    </el-col>
    <el-col :span="6">
      <el-form :model="form" size="small" label-width="80px">
        <el-form-item label="语言">
          <el-select v-model="form.language" filterable @change="handleChangeLanguage">
            <el-option v-for="item in languageOptions" :key="item" :value="item" />
          </el-select>
        </el-form-item>
        <el-form-item label="主题">
          <el-select v-model="form.theme" @change="handleChangeTheme">
            <el-option v-for="item in themeOptions" :key="item" :value="item" />
          </el-select>
        </el-form-item>
      </el-form>
    </el-col>
  </el-row>
</template>

<script>
import MonacoEditor from "@/components/MonacoEditor";
import MarkdownIt from "markdown-it";
export default {
  name: "MonacoEditorDemoView",
  components: { MonacoEditor },
  data() {
    return {
      languageOptions: [
        "abap",
        "aes",
        "apex",
        "azcli",
        "bat",
        "bicep",
        "c",
        "cameligo",
        "clojure",
        "coffeescript",
        "cpp",
        "csharp",
        "csp",
        "css",
        "dart",
        "dockerfile",
        "ecl",
        "elixir",
        "flow9",
        "fsharp",
        "go",
        "graphql",
        "handlebars",
        "hcl",
        "html",
        "ini",
        "java",
        "javascript",
        "json",
        "julia",
        "kotlin",
        "less",
        "lexon",
        "liquid",
        "lua",
        "m3",
        "markdown",
        "mips",
        "msdax",
        "mysql",
        "objective-c",
        "pascal",
        "pascaligo",
        "perl",
        "pgsql",
        "php",
        "pla",
        "plaintext",
        "postiats",
        "powerquery",
        "powershell",
        "proto",
        "pug",
        "python",
        "qsharp",
        "r",
        "razor",
        "redis",
        "redshift",
        "restructuredtext",
        "ruby",
        "rust",
        "sb",
        "scala",
        "scheme",
        "scss",
        "shell",
        "sol",
        "sparql",
        "sql",
        "st",
        "swift",
        "systemverilog",
        "tcl",
        "twig",
        "typescript",
        "vb",
        "verilog",
        "xml",
        "yaml"
      ],
      themeOptions: ["vs", "vs-dark", "hc-black"],
      form: {
        value: "",
        language: "markdown",
        theme: "vs-dark"
      }
    };
  },
  computed: {
    markdownHtml() {
      return new MarkdownIt().render(this.form.value);
    }
  },
  mounted: function() {},
  methods: {
    handleValueChange(value) {
      this.form.value = value;
    },
    handleChangeLanguage(language) {
      this.$refs.monacoEditor.setLanguage(language);
    },
    handleChangeTheme(theme) {
      this.$refs.monacoEditor.setTheme(theme);
    }
  }
};
</script>
