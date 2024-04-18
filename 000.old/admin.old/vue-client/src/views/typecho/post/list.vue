/** * 文章列表页面 * 删除 * 查询 */
<template>
  <div class="app-container">
    <el-form ref="typechoPostForm" :inline="true" :model="queryParams" size="mini">
      <el-form-item v-if="prefix === ''" label="分支" prop="prefix">
        <el-select v-model="queryParams.prefix" clearable filterable default-first-option placeholder="请选择分支，默认第一条">
          <el-option v-for="item in optionList.data" :key="item.prefix" :label="item.prefix" :value="item.prefix" />
        </el-select>
      </el-form-item>
      <el-form-item label="标识" prop="mids">
        <el-select v-model="queryParams.mids" multiple filterable remote placeholder="请输入标识名称" :remote-method="handleQueryMetaList">
          <el-option v-for="item in queryParams.metaOptions" :key="item.mid" :label="item.name" :value="item.mid">
            <span style="float: left">{{ item.name }}</span>
            <span style="float: right; color: #8492a6; font-size: 13px">
              {{ item.type }}
            </span>
          </el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="标题" prop="title">
        <el-input v-model="queryParams.title" placeholder="标题" />
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="handleQuery">查询</el-button>
        <el-button type="danger" @click="$refs.typechoPostForm.resetFields()">重置</el-button>
      </el-form-item>
    </el-form>
    <el-row style="margin-bottom: 18px">
      <el-col>
        <span style="float: right">
          <el-tooltip effect="dark" content="新增" placement="top">
            <el-button size="small" icon="el-icon-plus" type="primary" circle @click="$emit('toggle', { to: 'info', from: 'list' })" />
          </el-tooltip>
          <el-tooltip effect="dark" content="批量删除" placement="top">
            <el-button size="small" icon="el-icon-delete" type="danger" circle :disabled="postMultipleSelection.length === 0 || queryParams.prefix != ''" @click="handleDelete()" />
          </el-tooltip>
          <el-tooltip effect="dark" content="批量修改" placement="top">
            <el-button size="small" icon="el-icon-edit" type="primary" circle disabled />
          </el-tooltip>
        </span>
      </el-col>
    </el-row>
    <TypechoPostTable ref="typechoPostTable" :columns="tableColumns" :query-params="queryParams" :call-list-func="callListFunc" @selection-change="handlePostTableSelectionChange">
      <slot name="table-append">
        <el-table-column label="操作" align="center" width="120">
          <template slot-scope="scope">
            <el-button type="text" size="mini" @click="$emit('toggle', { to: 'info', data: scope.row, from: 'list' })">查看</el-button>
            <el-button type="text" size="mini" :disabled="queryParams.prefix != ''" @click="$emit('toggle', { to: 'info', data: scope.row, from: 'list' })">编辑</el-button>
            <el-button type="text" size="mini" :disabled="queryParams.prefix != ''" @click="handleDelete(scope.row)">删除</el-button>
          </template>
        </el-table-column>
      </slot>
    </TypechoPostTable>
  </div>
</template>
<script>
import typechoMixin from "@/mixins/typecho";
import TypechoPostTable from "./../components/TypechoPostTable";
export default {
  name: "TypechoPostListView",
  components: { TypechoPostTable },
  mixins: [typechoMixin],
  props: {
    prefix: {
      type: String,
      default: ""
    },
    tableColumns: {
      type: Array
    },
    callListFunc: {
      type: Function
    }
  },
  data() {
    return {
      queryParams: {
        prefix: "",
        title: "",
        mids: [],
        metaOptions: []
      },
      postMultipleSelection: []
    };
  },
  created() {
    if (this.prefix !== "") {
      this.queryParams.prefix = this.prefix;
    }
    this.selectOptionList();
  },
  mounted() {
    this.handleQuery();
  },
  methods: {
    handleQuery() {
      const data = { ...this.queryParams };
      this.$refs.typechoPostTable.handleQuery(data);
    },
    handlePostTableSelectionChange(val) {
      this.postMultipleSelection = val;
    },
    // 删除
    handleDelete(row) {
      let rows = [];
      if (row) {
        rows = [row];
      } else {
        rows = this.$refs.typechoPostTable.multipleSelection;
      }
      this.deletePostList(rows).then(res => {
        this.handleQuery();
      });
    },
    handleQueryMetaList(name) {
      this.typechoMetaList({
        name
      }).then(res => {
        this.queryParams.metaOptions = res.rows;
      });
    }
  }
};
</script>
