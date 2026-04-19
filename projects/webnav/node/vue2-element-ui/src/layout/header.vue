<template>
  <el-header class="navbar user-info-navbar" role="navigation" style="height: unset;position: fixed;z-index: 99999;     width: calc(100vw - 300px);margin-left: 0;padding-top: 30px;padding-right:30px;">
    <GuideContextMenu ref="guide-contextmenu" type="branch">
      <ul class="user-info-menu left-links list-inline list-unstyled">
        <li class="hidden-sm hidden-xs">
          <a href="#" data-toggle="sidebar">
            <i class="fa-bars"></i>
          </a>
        </li>
        <li class="hidden-sm hidden-xs" @contextmenu="$event => user_info ? $refs['guide-contextmenu'].handleRowContextMenu($store.state.app.branch.list.find((v) => v.slug === 'default'), $event) : null">
          <router-link to="/home">Home</router-link>
        </li>
        <li class="hidden-sm hidden-xs" v-for="(item, idx) in branch_list" :key="idx" @contextmenu="$event => user_info ? $refs['guide-contextmenu'].handleRowContextMenu(item, $event) : null">
          <router-link :to="'/public/' + item.slug">
            <el-badge v-if="item.status !== 'public'" :value="item.status" class="item">{{ item.name }}</el-badge>
            <span v-else>{{ item.name }}</span>
          </router-link>
        </li>
      </ul>
    </GuideContextMenu>
    <ul class="user-info-menu right-links list-inline list-unstyled">
      <li class="hidden-sm hidden-xs" @click="() => $refs.guide.toggle({ type: 'site', parent: branch_active.id })">
        <a style="cursor:pointer">站点收录</a>
      </li>
      <li class="hidden-sm hidden-xs" v-if="user_info">
        <a style="cursor:pointer" @click="$evnet => $refs.import.toggle()">导入</a>
      </li>
      <li class="hidden-sm hidden-xs" v-if="user_info">
        <a style="cursor:pointer">导出</a>
      </li>
      <li class="hidden-sm hidden-xs">
        <a v-if="!user_info" style="cursor:pointer" @click="$evnet => $refs.login.toggle()">登录</a>
        <a v-else style="cursor:pointer" @click="$evnet => $store.dispatch('user/logout')">登出</a>
      </li>
      <li class="hidden-sm hidden-xs">
        <a href="https://github.com/langnang-service/vue-element-webstack" target="_blank">
          <i class="fa-github"></i> GitHub
        </a>
      </li>
    </ul>
    <LoginDialog ref="login" @submit="handleSubmitLoginDialog" />
    <SiteDialog ref="site" @submit="handleSubmitDialog" />
    <GuideDialog ref="guide" @submit="handleSubmitDialog" />
    <ImportDialog ref="import" />
  </el-header>
</template>
<script>
import { mapGetters } from 'vuex';
import LoginDialog from '@/components/LoginDialog.vue';
import SiteDialog from '@/components/SiteDialog.vue'
import GuideDialog from '@/components/GuideDialog.vue'
import GuideContextMenu from '@/components/GuideContextMenu.vue';
import ImportDialog from '../components/ImportDialog.vue';
export default {
  name: "LayoutHeader",
  components: {
    LoginDialog,
    SiteDialog,
    GuideContextMenu,
    GuideDialog,
    ImportDialog
  },
  data() {
    return {
      row: null,
    }
  },
  computed: {
    ...mapGetters(["branch_prefix", "branch_active", "branch_list", "user_info"])
  },
  created() {
  },
  methods: {
    handleSubmitLoginDialog(row) {
      this.$store.dispatch('user/login', row);
    },
    handleSubmitDialog(row) {
      this.$store.dispatch('app/insertItem', row);
    }
  }

}
</script>
<style lang="scss" scoped>
.router-link-active {
  border-bottom: 1px solid #1e80ff !important;
}
</style>