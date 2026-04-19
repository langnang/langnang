<template>
  <div>
    <div v-for="(item, idx) in items" :key="idx">
      <div v-if="item.web">
        <WebItem :item="item" :transName="transName" :prefix="$route.meta.prefix" />
      </div>
      <div v-else v-for="(subItem, idx) in item.children" :key="idx">
        <WebItem :item="subItem" :transName="transName" :prefix="$route.meta.prefix" />
      </div>
    </div>
  </div>
</template>

<script>
import WebItem from "../components/WebItem.vue";
import Footer from "../components/Footer.vue";
import itemsData from "../assets/developer.json";
// import { loadJs } from '../assets/js/app.js'
import { mapMutations, mapState } from "vuex";
export default {
  name: "Index",
  components: {
    WebItem,
  },
  data() {
    return {
      items: itemsData,
      lang: {},
      langList: [
        {
          key: "zh",
          name: "简体中文",
          flag: "./assets/images/flags/flag-cn.png",
        },
        {
          key: "en",
          name: "English",
          flag: "./assets/images/flags/flag-us.png",
        },
      ],
    };
  },
  computed: {
    ...mapState(["tree"]),
  },
  created() {
    this.SET_TREE(itemsData);
    this.lang = this.langList[0];
    console.log(this.$route);
    // loadJs();
  },
  methods: {
    ...mapMutations(["SET_TREE"]),
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
