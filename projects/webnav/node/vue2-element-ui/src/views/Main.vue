<template>
  <div>
    <!-- 根目录站点 -->
    <div v-if="root_sites.length > 0">
      <WebItem :prefix="branch_prefix" :item="{ id: branch_active.id, name: '未归类', children: root_sites }" />
    </div>
    <div v-for="(item, idx) in tree" :key="idx">
      <!-- 主目录站点 -->
      <div v-if="item.children.filter(v => v.type === 'site').length > 0">
        <WebItem :item="item" :prefix="branch_prefix" />
      </div>
      <!-- 次目录站点 -->
      <div v-for="(subItem, idx) in item.children.filter(v => v.type === 'category')" :key="idx">
        <WebItem :item="subItem" :prefix="branch_prefix" />
      </div>
    </div>
  </div>
</template>

<script>
import WebItem from "../components/WebItem.vue";
import Footer from "../components/Footer.vue";
import itemsData from "../assets/designer.json";
// import { loadJs } from '../assets/js/app.js'
import { mapMutations, mapState, mapGetters } from "vuex";

export default {
  name: "Main",
  components: {
    WebItem,
  },
  data() {
    return {
      items: itemsData,
    };
  },
  computed: {
    ...mapGetters(["branch_prefix", "tree", "branch_active"]),
    root_sites() {
      return this.tree.filter(v => v.type === 'site');
    }
  },
  async beforeRouteEnter(to, from, next) {
    // this.$store.dispatch('app/selectTree', { name: 'langnang', type: "category" })
    next(async (vm) => {
      vm.$store.dispatch("app/selectTree", {
        slug: to.params.branch || "default",
        type: "category",
      });
    });
  },
  async beforeRouteUpdate(to, from, next) {
    await this.$store.dispatch("app/selectTree", {
      slug: to.params.branch || "default",
      type: "category",
    });
    next();
  },
  created() {
    console.log(this.$store.getters.tree);
    // this.SET_TREE(itemsData);
    // this.$store.dispatch('app/selectTree', { name: 'langnang', type: "category" })
    // loadJs();
    // getMetaList({ type: "branch" });
  },
  methods: {
    // ...mapMutations(["SET_TREE"]),
    transName(webItem) {
      return this.lang.key === "en" ? webItem.en_name : webItem.name;
    },
  },
};
</script>

<style scoped lang="scss">
.el-scrollbar,
.el-scrollbar__wrap {
  overflow-x: hidden !important;
}
</style>
