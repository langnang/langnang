<template>
  <div class="app-container">
    <el-form v-if="channel === null" ref="queryParams" :inline="true" :model="queryParams" size="small">
      <el-form-item label="路径">
        <el-select v-model="queryParams.channel" filterable clearable default-first-option placeholder="请选择日志路径">
          <el-option v-for="item in queryParams.channelOptions" :key="item" :label="item" :value="item" />
        </el-select>
      </el-form-item>
      <el-form-item>
        <el-tooltip effect="dark" content="根据左侧表单查询" placement="top">
          <el-button type="primary" @click="handleQuery">查询</el-button>
        </el-tooltip>
        <el-tooltip effect="dark" content="重置左侧表单内容" placement="top">
          <el-button type="danger" @click="handleReset">重置</el-button>
        </el-tooltip>
      </el-form-item>
    </el-form>
    <el-row style="margin-bottom: 18px">
      <el-col>
        <span style="float: right">
          <el-tooltip effect="dark" content="批量删除日志" placement="top">
            <el-button size="small" icon="el-icon-delete" type="danger" circle :disabled="systemLogList.multipleSelection.length === 0" @click="handleDelete()" />
          </el-tooltip>
        </span>
      </el-col>
    </el-row>
    <el-table ref="table" v-loading="systemLogList.loading" :data="systemLogList.data" border style="width: 100%" size="mini" @selection-change="handleSelectionChange">
      <el-table-column type="selection" align="center" width="45" />
      <el-table-column prop="id" label="编号" show-overflow-tooltip align="center" width="55" />

      <el-table-column prop="channel" label="路径" show-overflow-tooltip align="center" width="180" />
      <el-table-column prop="time" label="修改日期" width="133" align="center">
        <template slot-scope="scope">
          {{ scope.row.time | parseTime }}
        </template>
      </el-table-column>
      <el-table-column prop="level" label="状态码" width="60" align="center" />
      <el-table-column prop="level_name" label="状态" width="80" align="center" />
      <el-table-column :prop="message" label="信息" align="center" />
      <el-table-column label="操作" align="center" width="50">
        <template slot-scope="scope">
          <el-button type="text" size="small" @click="handleDelete(scope.row)">
            删除
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <el-pagination :current-page="systemLogList.page" :page-sizes="[10, 20, 50, 100]" :page-size="systemLogList.size" layout="total, sizes, prev, pager, next, jumper" :total="systemLogList.total" @size-change="handleSizeChange" @current-change="handleCurrentChange" />
  </div>
</template>
<script>
import { logDelete, logChannelList, logList } from "@/api/log";
export default {
  props: {
    channel: {
      type: String,
      default: null
    },
    message: {
      type: String,
      default: "message"
    }
  },
  data() {
    return {
      queryParams: {
        channel: "",
        channelOptions: []
      },
      systemLogList: {
        loading: false,
        data: [],
        page: 1,
        size: 10,
        total: 0,
        multipleSelection: []
      },
      log: {},
      dialog: {
        target: "",
        visible: false,
        title: "",
        data: null
      }
    };
  },
  created() {
    if (this.channel !== null) {
      this.queryParams.channel = this.channel;
    } else {
      logChannelList().then(res => {
        this.queryParams.channelOptions = res.rows;
      });
    }
    this.handleQuery();
  },
  methods: {
    handleReset() {
      this.queryParams.channel = "";
    },
    handleQuery() {
      this.systemLogList.loading = true;
      logList({
        ...this.queryParams,
        page: this.systemLogList.page,
        size: this.systemLogList.size
      })
        .then(res => {
          this.systemLogList.data = res.rows;
          this.systemLogList.page = res.page;
          this.systemLogList.size = res.size;
          this.systemLogList.total = res.total;
        })
        .finally(() => {
          this.systemLogList.loading = false;
        });
    },
    handleSizeChange(val) {
      this.systemLogList.size = val;
      this.handleQuery();
    },
    handleCurrentChange(val) {
      this.systemLogList.page = val;
      this.handleQuery();
    },
    handleSelectionChange(val) {
      this.systemLogList.multipleSelection = val;
    },
    handleDelete(row) {
      let ids = [];
      if (!row) {
        ids = this.systemLogList.multipleSelection.map(v => v.id);
      } else {
        ids = [row.id];
      }
      return this.$confirm("此操作将永久删除所选日志, 是否继续?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          logDelete({ ids }).then(res => {
            if (res.total === ids.length) {
              this.$message.success(`删除成功`);
            } else {
              // 单条删除下，提示相应信息
              if (ids.length === 1) {
                this.$message.error(res.rows[0]);
              } else {
                this.$message.error(`${ids.length - res.total} 条数据删除失败`);
              }
            }
          });
          this.handleQuery();
        })
        .catch(() => {
          this.$message.info("已取消删除");
        });
    },
    toggleInfoDialog(target, row) {
      this.dialog.target = target;
      if (target === "select") {
        this.log = { ...this.log, ...row };
        this.dialog.title = `${row.id} - ${row.channel} - ${row.time}`;
      }
      this.dialog.visible = !this.dialog.visible;
    }
  }
};
</script>
