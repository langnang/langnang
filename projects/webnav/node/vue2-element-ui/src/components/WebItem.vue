<template>
  <div :id="prefix + item.name" style="margin-bottom: -65px; padding-top: 85px">
    <GuideContextMenu ref="guide-contextmenu" type="site">
      <el-card :body-style="{ 'padding': '0 10px 10px 10px' }">
        <template slot="header">
          <h4 class="text-gray">
            <component :is="(item.icon || '').split(' ').length == 2 ? 'font-awesome-icon' : 'i'" :icon="(item.icon || '').split(' ')" :class="item.icon ? item.icon : 'linecons-tag'" style="margin:0 7px 0 0;width:17px;"></component>
            {{ item.name }}
            <span v-if="batch" class="pull-right" style="margin-top:-4px;">
              <el-button size="mini" circle type="primary" icon="el-icon-sort" style="transform: rotate(90deg);" @click="$event => $refs['guide-contextmenu'].handleMigration(multipleSelection)"></el-button>
              <el-button size="mini" circle type="warning" @click="() => $store.dispatch('app/crawlerList', multipleSelection)">
                <font-awesome-icon :icon="['fas', 'spider']"></font-awesome-icon>
              </el-button>
              <el-button size="mini" circle type="danger" icon="el-icon-delete" @click="() => $store.dispatch('app/deleteList', multipleSelection)"></el-button>
            </span>
          </h4>
        </template>

        <el-empty v-if="sites.length == 0" :image-size="0" @contextmenu.native.stop="$event => user_info ? $refs['guide-contextmenu'].handleRowContextMenu(item, $event) : null"></el-empty>
        <div v-else>
          <el-table v-if="batch" :data="sites" border stripe size="mini" style="margin-top: 10px;" @selection-change="(val) => handleSelectionChange(val)" @row-contextmenu="(row, column, $event) => user_info ? $refs['guide-contextmenu'].handleRowContextMenu(row, $event, item) : null">
            <el-table-column type="selection" width="34"> </el-table-column>
            <el-table-column align="center" show-overflow-tooltip prop="name" label="名称" width="240"></el-table-column>
            <el-table-column align="center" show-overflow-tooltip prop="url" label="地址" width="240"></el-table-column>
            <el-table-column align="center" show-overflow-tooltip prop="status" label="状态" width="80"></el-table-column>
            <el-table-column align="center" show-overflow-tooltip prop="description" label="描述"></el-table-column>
          </el-table>
          <el-row v-else :gutter="10" @contextmenu.native.stop="$event => user_info ? $refs['guide-contextmenu'].handleRowContextMenu(item, $event) : null">
            <el-col :xs="{ span: 24 }" :sm="{ span: 12 }" :md="{ span: 8 }" :lg="{ span: 6 }" :xl="{ span: 4 }" v-for="(web, idx) in sites" :key="idx" @contextmenu.native.stop="$event => user_info ? $refs['guide-contextmenu'].handleRowContextMenu(web, $event, item) : null">
              <el-tooltip effect="dark" :content="web.url" placement="bottom">
                <el-card shadow="hover" @click.native="openweb(web.url)" style="margin: 10px 0 0 0; height: 76px; cursor: pointer" body-style="padding:10px;">
                  <el-tag v-if="web.status !== 'public'" type="danger" effect="dark" style="float: right;height:unset;line-height: unset;padding:0; margin-right: -10px;margin-top: -10px;">{{ web.status }}</el-tag>
                  <div class="xe-comment-entry">
                    <div class="xe-user-img">
                      <img v-lazy="web.icon" style="width: 40px; height: 40px" class="lozad img-circle" width="40" />
                    </div>
                    <div class="xe-comment" style="margin-left: 40px;">
                      <a href="#" class="xe-user-name overflowClip_1">
                        <strong>{{ web.name }}</strong>
                      </a>
                      <p class="overflowClip_2">{{ web.description }}</p>
                    </div>
                  </div>
                </el-card>
              </el-tooltip>
            </el-col>
          </el-row>
        </div>

      </el-card>
    </GuideContextMenu>
    <v-contextmenu ref="contextmenu">
      <v-contextmenu-item @click="() => $refs['site'].toggle({ parent: item.id })">新增站点</v-contextmenu-item>
      <hr />
      <v-contextmenu-item :disabled="!item.id" @click="() => $store.dispatch('app/deleteItem', item)">删除目录</v-contextmenu-item>
      <v-contextmenu-item :disabled="!row || !row.id" @click="() => $store.dispatch('app/deleteItem', row)">删除站点</v-contextmenu-item>
      <hr />
      <v-contextmenu-item :disabled="!item.id" @click="() => $refs['category'].toggle(item)">更新目录</v-contextmenu-item>
      <v-contextmenu-item :disabled="!row || !row.id" @click="() => $refs['site'].toggle(row)">更新站点</v-contextmenu-item>
      <hr />
      <v-contextmenu-item @click="$event => $ref['site']">迁移站点</v-contextmenu-item>
      <hr />
      <v-contextmenu-item disabled>批量</v-contextmenu-item>
      <hr />
      <v-contextmenu-item disabled>详情</v-contextmenu-item>
    </v-contextmenu>
    <CategoryDialog ref="category" @submit="handleSubmitDialog" />
    <SiteDialog ref="site" @submit="handleSubmitDialog" />
  </div>
</template>

<script>
import draggable from 'vuedraggable'
import { insertItem, deleteList, updateItem } from "@/api/guide";
import Mock from 'mockjs'
import CategoryDialog from "@/components/CategoryDialog.vue";
import SiteDialog from "@/components/SiteDialog.vue";
import GuideContextMenu from '@/components/GuideContextMenu.vue';
import { mapGetters } from 'vuex';
export default {
  name: "WebItem",
  components: { draggable, CategoryDialog, SiteDialog, GuideContextMenu },
  props: {
    item: Object,
    prefix: String,
  },
  data() {
    return {
      row: null,
      multipleSelection: [],
      batch: false,
    }
  },
  created() {
  },
  computed: {
    ...mapGetters(["user_info"]),
    sites() {
      return this.item.children.filter(v => v.type === 'site')
    }
  },
  methods: {
    toggleBatch() {
      this.batch = !this.batch;
    },
    /**
     * 右键表格行，显示菜单
     */
    handleRowContextMenu() {
      console.log("🚀 ~ file: WebItem.vue:110 ~ handleRowContextMenu ~ handleRowContextMenu:", arguments);
    },
    /**
     * 隐藏菜单
     */
    handleMouseDown() {
      this.row = null;
      // this.$refs.contextmenu.hide()
    },
    openweb(url) {
      window.open(url, "_blank");
    },
    selectTree() {
      this.$store.dispatch("app/selectTree", {
        slug: this.$route.params.branch || "default",
        type: ["category", "site"],
      });
    },
    handleInsertItem(parent = null) {
      insertItem({ name: Mock.mock('@ctitle'), type: 'site', parent: this.item.id, icon: "el-icon-eleme" }).then(res => {
        this.selectTree();
      });
    },
    handleSubmitDialog(row) {
      if (row.id) {
        this.$store.dispatch('app/updateItem', row);
      } else {
        this.$store.dispatch('app/insertItem', row);
      }
    },
    handleSelectionChange(val) {
      this.multipleSelection = val;
    }
  },
};
</script>

<style scoped lang="scss">
::v-deep {
  // .el-checkbox {
  //   width: 100%;

  //   .el-checkbox__input {
  //     position: absolute;
  //     top: 10px;
  //     right: 0;
  //   }

  //   .el-checkbox__label {
  //     width: 100%;
  //   }

  //   &.is-checked .el-card {
  //     border-color: #409eff;
  //   }
  // }

  .el-card__header {
    padding: 8px 10px;
  }

  .el-empty {
    padding: 23px 0;
  }

  .el-empty__image {
    display: none;
  }
}

i {
  margin-right: 7px;
}
</style>
