<template>
  <div class="guide-contextmenu__wrapper">
    <slot v-contextmenu:contextmenu v-if="user_info" ref="slot"></slot>
    <slot v-else></slot>
    <v-contextmenu ref="contextmenu">

      <v-contextmenu-item v-if="['branch'].includes(type)"
                          @click="$event => $refs.guide.toggle({ type: 'branch', parent: 0 })">
        新增分支
      </v-contextmenu-item>
      <v-contextmenu-item v-if="['branch', 'category'].includes(type)"
                          @click="$event => $refs.guide.toggle({ type: 'category', parent: branch_active.id })">
        新增目录
      </v-contextmenu-item>
      <v-contextmenu-item v-if="['category'].includes(type)" :disabled="branch_active.id !== (row || {}).parent"
                          @click="$event => $refs.guide.toggle({ type: 'category', parent: row.id })">
        新增子目录
      </v-contextmenu-item>
      <v-contextmenu-item v-if="['branch', 'category', 'site'].includes(type)"
                          @click="$event => $refs.guide.toggle({ type: 'site', parent: row.type === 'site' ? parent.id : row.id })">
        新增站点
      </v-contextmenu-item>

      <hr/>

      <v-contextmenu-item v-if="['branch'].includes(type)"
                          :disabled="!row || !row.id || row.type !== 'branch' || row.slug === 'default'"
                          @click="$event => $refs.guide.toggle(row)">
        编辑分支
      </v-contextmenu-item>
      <v-contextmenu-item v-if="['category', 'site'].includes(type)"
                          :disabled="!row || !row.id || row.type !== 'category' || row.id === branch_active.id"
                          @click="$event => $refs.guide.toggle(row)">
        编辑目录
      </v-contextmenu-item>
      <v-contextmenu-item v-if="['site'].includes(type)" :disabled="!row || !row.id || row.type !== 'site'"
                          @click="$event => $refs.guide.toggle(row)">
        编辑站点
      </v-contextmenu-item>

      <hr/>

      <v-contextmenu-item v-if="['branch'].includes(type)"
                          :disabled="!row || !row.id || row.type !== 'branch' || row.id != branch_active.id || tree.length > 0 || row.slug === 'default'"
                          @click="$event => $store.dispatch('app/deleteItem', row)">
        删除分支
      </v-contextmenu-item>
      <v-contextmenu-item v-if="['category', 'site'].includes(type)"
                          :disabled="!row || !row.id || row.type !== 'category' || row.id === branch_active.id"
                          @click="$event => $store.dispatch('app/deleteItem', row)">
        删除目录
      </v-contextmenu-item>
      <v-contextmenu-item v-if="['site'].includes(type)" :disabled="!row || !row.id || row.type !== 'site'"
                          @click="$event => $store.dispatch('app/deleteItem', row)">
        删除站点
      </v-contextmenu-item>

      <hr/>

      <v-contextmenu-item v-if="['site'].includes(type)" @click="$event => $parent.toggleBatch()">批量切换
      </v-contextmenu-item>
      <v-contextmenu-item v-if="['category', 'site'].includes(type)" @click="handleMigration(null)">数据迁移
      </v-contextmenu-item>

      <v-contextmenu-item :disabled="!row || !row.id" @click="$refs.guide.toggle(row, true)">详情</v-contextmenu-item>
    </v-contextmenu>
    <GuideDialog ref="guide" :type="type" @submit="handleSubmitDialog"/>
  </div>
</template>

<script>
import {mapGetters} from 'vuex';
import GuideDialog from './GuideDialog.vue';

export default {
  name: "GuideContextMenu",
  components: {
    GuideDialog
  },
  props: {
    type: {
      type: String,
      default: "",
    }
  },
  data() {
    return {
      row: null,
      parent: null,
    };
  },
  computed: {
    ...mapGetters(["user_info", "branch_active", "tree"])
  },
  created() {
  },
  methods: {
    /**
     * 右键表格行，显示菜单
     */
    handleRowContextMenu(row, event, parent) {
      console.log("handleRowContextMenu", {row, event, parent})
      event.preventDefault()
      this.row = row;
      this.parent = parent;
      this.$refs.contextmenu.show({top: event.clientY, left: event.clientX});
    },
    /**
     * 隐藏菜单
     */
    handleMouseDown() {
      this.row = null;
      // this.$refs.contextmenu.hide()
    },
    handleSubmitDialog(row) {
      if (row.id) {
        this.$store.dispatch('app/updateItem', row);
      } else {
        this.$store.dispatch('app/insertItem', row);
        // this.handleInsertItem(row);
      }
    },
    handleMigration(rows = []) {
      if (!rows || rows.length == 0) rows = [{...this.row}]
      this.$prompt('请输入迁移至分支或目录的编号', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        inputType: 'number',
      }).then(({value}) => {
        rows = rows.map(v => ({...v, parent: value}));
        // this.handleSubmitDialog(this.row);
        this.$store.dispatch('app/updateList', rows)
      }).catch(() => {
      });
    }
  }
}
</script>

<style lang="scss" scoped></style>