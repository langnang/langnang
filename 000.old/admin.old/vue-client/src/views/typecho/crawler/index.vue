<template>
  <div class="app-container">
    <component :is="currentComponent" :query="queryParams" :readonly="readonly" @toggle="toggleComponent" />
  </div>
</template>
<script>
import TypechoPostListView from "./list";
import TypechoPostInfoView from "./info";
export default {
  name: "TypechoPostView",
  components: { TypechoPostListView, TypechoPostInfoView },
  props: {
    readonly: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      queryParams: {},
      currentComponent: TypechoPostListView
    };
  },
  watch: {
    readonly() {
      this.currentComponent = TypechoPostListView;
      this.queryParams = {};
    }
  },
  beforeRouteUpdate(to, form, next) {
    this.currentComponent = TypechoPostListView;
    this.queryParams = {};
    next();
  },
  methods: {
    toggleComponent({ data, to, from, history }) {
      this.queryParams = { data, to, from, history };
      to === "info" ? (this.currentComponent = TypechoPostInfoView) : (this.currentComponent = TypechoPostListView);
    }
  }
};
</script>
