<template>
  <el-tree :data="depth_data" show-checkbox default-expand-all node-key="mid" highlight-current :props="props" draggable :default-checked-keys="multipleSelection.map(v => v.mid)" @check-change="handleCheckChange" />
</template>
<script>
import { typechoMetaTree } from "@/api/typecho";
export default {
  name: "TypechoMetaTree",
  components: {},
  props: {
    queryParams: {
      type: Object,
      default() {
        return {};
      }
    },
    props: {
      type: Object,
      default() {
        return { children: "children", label: "name" };
      }
    },
    depth: {
      type: Array,
      default() {
        return [];
      }
    }
  },
  data() {
    return {
      loading: false,
      total: 0,
      data: [],
      tree: [],
      multipleSelection: []
    };
  },
  computed: {
    depth_data() {
      if (this.depth.length === 0 || this.tree.length === 0) return this.tree;
      return this.depth.reduce((total, val) => total[val], this.tree);
    }
  },
  created() {},
  methods: {
    handleQuery(data = {}) {
      this.loading = true;
      return typechoMetaTree({
        ...this.queryParams,
        ...data,
        page: this.page,
        size: this.size
      })
        .then(res => {
          this.tree = res.tree;
          this.data = res.rows;
          this.total = res.total;
          return Promise.resolve(res);
        })
        .finally(() => {
          this.loading = false;
        });
    },
    handleCheckChange(data, checked, indeterminate) {
      if (checked) {
        this.multipleSelection.push(data);
      } else {
        const index = this.multipleSelection.findIndex(v => v.mid === data.mid);
        this.multipleSelection.splice(index, 1);
      }
      this.$emit("check-change", this.multipleSelection, data, checked, indeterminate);
    }
  }
};
</script>
