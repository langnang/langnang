<template>
  <TypechoPostInfoView ref="postInfoView" prefix="script" :query="query" @toggle="toggleView" @before-submit="handleBeforeSubmit">
    <template slot="editor">
      <MonacoEditor v-model="query.data.text" language="markdown" />
    </template>
  </TypechoPostInfoView>
</template>
<script>
import MonacoEditor from "@/components/MonacoEditor";
import TypechoPostInfoView from "@/views/typecho/post/info";
export default {
  name: "TypechoPostForm",
  components: { TypechoPostInfoView, MonacoEditor },
  filters: {},
  props: {
    query: {
      type: Object,
      default() {
        return {};
      }
    }
  },
  data() {
    return {};
  },
  computed: {},
  watch: {},
  created() {
    console.log(this.query);
  },
  mounted() {},
  methods: {
    handleBeforeSubmit() {
      const text = this.$refs.editor.getValue();
      // this.query.data._post.text = text;
      this.$refs.postInfoView.setText(text);
      // console.log(text);
    },
    toggleView(query) {
      this.$emit("toggle", query);
    }
  }
};
</script>
