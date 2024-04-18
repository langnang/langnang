/* * 标识管理页面 * 新增 * 删除 * 修改 * 查询 * * 单条 * * 列表 * * 树型 */
<template>
  <div class="app-container">
    <TypechoMetaForm ref="queryParams" v-model="queryParams" :inline="true" :items="[{ slot: 'prefix' }, { prop: 'type' }, { prop: 'parent' }, { prop: 'name' }]">
      <el-form-item slot="prefix" label="分支" prop="prefix">
        <el-select v-model="queryParams.prefix" clearable filterable default-first-option placeholder="请选择分支，默认第一条">
          <el-option v-for="item in optionList.data" :key="item.prefix" :label="item.prefix" :value="item.prefix" />
        </el-select>
      </el-form-item>
      <el-form-item>
        <el-tooltip effect="dark" content="根据左侧表单查询标识" placement="top">
          <el-button type="primary" @click="handleQuery">查询</el-button>
        </el-tooltip>
        <el-tooltip effect="dark" content="重置左侧表单内容" placement="top">
          <el-button type="danger" @click="$refs.queryParams.resetFields()">重置</el-button>
        </el-tooltip>
      </el-form-item>
    </TypechoMetaForm>
    <el-row style="margin-bottom: 18px">
      <el-col>
        <span style="float: right">
          <el-tooltip effect="dark" content="新增标识" placement="top">
            <el-button size="mini" icon="el-icon-plus" type="primary" circle @click="toggleInfoDialog('insert')" />
          </el-tooltip>
          <el-tooltip effect="dark" content="批量删除标识" placement="top">
            <el-button size="mini" icon="el-icon-delete" type="danger" circle :disabled="tableMultipleSelection.length === 0 || queryParams.prefix != ''" @click="handleDelete()" />
          </el-tooltip>
          <el-tooltip effect="dark" content="批量修改标识" placement="top">
            <el-button size="mini" icon="el-icon-edit" type="primary" circle disabled />
          </el-tooltip>
        </span>
      </el-col>
    </el-row>
    <el-tabs v-model="tab" type="border-card" :stretch="true">
      <el-tab-pane label="列表" name="list">
        <span slot="label"> <svg-icon icon-class="list" /> 列表</span>
        <TypechoMetaTable ref="typechoMetaTable" :query-params="metaList.queryParams" @selection-change="handleMetaTableSelectionChange">
          <el-table-column align="center" show-overflow-tooltip label="操作" width="120">
            <template slot-scope="scope">
              <el-button type="text" size="mini" @click="toggleInfoDialog('select', scope.row)"> 查看 </el-button>
              <el-button type="text" size="mini" :disabled="metaList.queryParams.prefix != ''" @click="toggleInfoDialog('update', scope.row)">编辑</el-button>
              <el-button type="text" size="mini" :disabled="metaList.queryParams.prefix != ''" @click="handleDelete(scope.row)">删除</el-button>
            </template>
          </el-table-column>
        </TypechoMetaTable>
      </el-tab-pane>
      <el-tab-pane label="树型" name="tree">
        <span slot="label"><svg-icon icon-class="tree-table" /> 树型</span>
        <TypechoMetaTree ref="typechoMetaTree" :query-params="metaTree.queryParams" />
      </el-tab-pane>
    </el-tabs>
    <el-dialog title="标识信息" :visible.sync="dialog.visible">
      <TypechoMetaForm ref="typechoMetaForm" v-model="meta" label-width="90px" size="small" :items="[{ prop: 'mid' }, { prop: 'name' }, { prop: 'slug' }, { prop: 'type' }, { prop: 'description' }, { prop: 'count' }, { prop: 'order' }, { prop: 'parent' }]" :disabled="dialog.target === 'select'" />
      <div v-show="dialog.target != 'select'" slot="footer" class="dialog-footer">
        <el-button @click="toggleDialog()">取 消</el-button>
        <el-button type="primary" @click="handleSubmitInfoDialog()"> 确 定 </el-button>
      </div>
    </el-dialog>
  </div>
</template>
<script>
import typechoMixin from "@/mixins/typecho";
import TypechoMetaTable from "./../components/TypechoMetaTable";
import TypechoMetaTree from "./../components/TypechoMetaTree";
import TypechoMetaForm from "./../components/TypechoMetaForm";
export default {
  components: { TypechoMetaTree, TypechoMetaTable, TypechoMetaForm },
  mixins: [typechoMixin],
  data() {
    return {
      tab: "list",
      queryParams: {
        prefix: "",
        type: null,
        parent: null,
        parentOptions: [],
        name: ""
      },
      tableMultipleSelection: [],
      dialog: {
        visible: false,
        parentOptions: [],
        data: [],
        title: "",
        target: ""
      }
    };
  },
  computed: {},
  watch: {
    // 分支修改
    // "queryParams.prefix": function() {
    //   this.queryParams.type = null;
    //   // 重新查询标识类型
    //   this.handleQueryMetaTypeList();
    //   this.queryParams.parent = null;
    //   this.queryParams.parentOptions = [];
    // }
  },
  created() {
    // 查询分支列表
    this.selectOptionList();
    //
    this.handleQueryMetaTypeList();
  },
  methods: {
    // 查询标识类型列表
    handleQueryMetaTypeList() {
      this.selectMetaTypeList(this.queryParams).then(res => {
        this.handleQuery();
      });
    },
    // 查询标识列表
    handleQuery() {
      const data = { ...this.queryParams };
      if (data.type === null || data.type === "") {
        delete data.type;
      }
      if (data.parent === null || data.parent === "") {
        delete data.parent;
      }
      this.metaList.queryParams = { ...data };
      this.metaTree.queryParams = { ...data };

      // if (vm.queryParams.type === "") {
      //   vm.$message.warning("请选择标识类型");
      //   return;
      // }
      if (this.tab === "list") {
        // this.selectMetaList();
        this.$refs.typechoMetaTable.handleQuery(data);
      } else if (this.tab === "tree") {
        this.$refs.typechoMetaTree.handleQuery(data);
        // this.selectMetaTree();
      }
    },
    // 删除标识列表
    handleDelete(row) {
      let rows = [];
      if (row) {
        rows = [row];
      } else {
        rows = this.$refs.typechoMetaTable.multipleSelection;
      }
      this.deleteMetaList(rows).then(res => {
        if (res) {
          this.handleQueryMetaTypeList();
        }
      });
    },
    handleSizeChange(val) {
      this.metaList.size = val;
      this.handleQuery();
    },
    handleCurrentChange(val) {
      this.metaList.page = val;
      this.handleQuery();
    },
    toggleInfoDialog(target, row) {
      this.dialog.target = target;
      // 新增
      if (target === "insert") {
        if (!this.dialog.visible) {
          this.resetMeta();
          this.meta.type = this.queryParams.type;
        }
      } else if (target === "update") {
        // 改
        this.$set(this.$data, "meta", { ...row });
      } else if (target === "select") {
        // 查
        this.$set(this.$data, "meta", { ...row });
      } else {
        //
        if (this.dialog.visible) {
          // this.dialog.visible = !this.dialog.visible;
        }
      }
      this.dialog.visible = !this.dialog.visible;

      // 如果指定上一级，查询上一级信息并加入至选择列表里
      if (this.meta.parent && this.$refs.typechoMetaForm) {
        this.$refs.typechoMetaForm.handleQueryMetaInfo([this.meta.parent]);
      }
      return;
    },
    dialogOpened() {},
    // 提交信息对话框中的表单
    handleSubmitInfoDialog() {
      if (this.dialog.target === "insert") {
        this.insertMeta().then(res => {
          this.handleCloseInfoDialog();
          this.handleQueryMetaTypeList();
        });
        return;
      }

      if (this.dialog.target === "update") {
        this.updateMeta().then(res => {
          this.handleCloseInfoDialog();
          this.handleQueryMetaTypeList();
        });
        return;
      }
    },
    // 关闭对话框，重置数据
    handleCloseInfoDialog() {
      this.dialog.visible = false;
      this.resetMeta();
      this.dialog.target = "";
    },
    // 远程搜索标识列表
    handleQueryMetaList(name) {
      this.typechoMetaList({
        prefix: this.queryParams.prefix,
        name
      }).then(res => {
        this.queryParams.parentOptions = res.rows;
        this.dialog.parentOptions = res.rows;
      });
    },
    handleMetaTableSelectionChange(val) {
      this.tableMultipleSelection = val;
    }
  }
};
</script>
