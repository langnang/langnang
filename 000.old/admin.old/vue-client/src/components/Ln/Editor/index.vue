<template>
  <component :is="componentName" v-model="value" :language="language" :theme="theme" />
</template>
<script>
import MonacoEditor from "@/components/MonacoEditor";
export default {
  name: "LnEditor",
  components: {
    MonacoEditor
  },
  props: {
    // 编辑器
    editor: {
      type: String,
      default: "monaco"
    },
    // 编程语言
    language: {
      type: String,
      default: "txt"
    },
    // 主题
    theme: {
      type: String,
      default: ""
    },
    value: {
      type: String,
      default: ""
    }
  },
  data() {
    return {};
  },
  computed: {
    componentName() {
      if (this.editor === "monaco") return "MonacoEditor";
      return "";
    }
  },
  methods: {
    setValue() {},
    getValue() {}
  }
};
</script>
