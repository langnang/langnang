<template>
  <TypechoPostInfoView ref="postInfoView" prefix="crawler" :query="query" @toggle="toggleView" @before-submit="handleBeforeSubmit">
    <template slot="editor">
      <phpSpiderEditor ref="editor" v-model="query.data.text" />
    </template>
  </TypechoPostInfoView>
</template>
<script>
import phpSpiderEditor from "@/views/typecho/components/phpSpiderEditor";
import TypechoPostInfoView from "@/views/typecho/post/info";
export default {
  name: "TypechoPostForm",
  components: { TypechoPostInfoView, phpSpiderEditor },
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
  created() {},
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
