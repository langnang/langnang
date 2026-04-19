<template>
  <el-container class="page-container" v-loading="loading">
    <LayoutAside />
    <el-container class="main-content" style="padding:0 10px;">
      <LayoutHeader />
      <el-scrollbar style="height:100vh">
        <el-main class="page-main" style="padding: 0 0 70px 0; ">
          <router-view></router-view>
        </el-main>
        <LayoutFooter />
      </el-scrollbar>
    </el-container>
    <el-backtop target=".page-main" :visibility-height="10" :bottom="100">
      <div style="{height: 100%;width: 100%;background-color: #f2f5f6;box-shadow: 0 0 6px rgba(0,0,0, .12);text-align: center;line-height: 40px;color: #1989fa;}">UP</div>
    </el-backtop>
  </el-container>
</template>

<script>
import WebItem from "../components/WebItem.vue";
import LayoutAside from "./aside.vue";
import LayoutHeader from "./header.vue";
import LayoutFooter from "./footer.vue";
import itemsData from "../assets/designer.json";
import { mapGetters } from "vuex";
export default {
  name: "Layout",
  components: { LayoutAside, LayoutHeader, LayoutFooter },
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
    ...mapGetters(['loading']),

  },
  created() {
    this.lang = this.langList[0];
    // loadJs();
  },
  mounted() {
  },
  methods: {
    transName(webItem) {
      return this.lang.key === "en" ? webItem.en_name : webItem.name;
    },
  },
};
</script>
<style lang="scss"></style>
