<template>
  <LnTable v-loading="loading" :data="data" :columns="columns" :current-page="page" :page-size="size" :total="total" @selection-change="handleSelectionChange" @size-change="handleSizeChange" @current-change="handleCurrentChange">
    <el-table-column slot="modified" prop="modified" label="修改日期" width="133" align="center">
      <template slot-scope="scope">
        {{ scope.row.modified | parseTime }}
      </template>
    </el-table-column>
    <el-table-column slot="metas" prop="metas" label="标识" align="center">
      <template slot-scope="scope">
        {{ scope.row.metas.map(v => v.name).join() }}
      </template>
    </el-table-column>
    <el-table-column slot="fields" prop="fields" label="附加" width="50" align="center">
      <template slot-scope="scope">
        {{ scope.row.fields.length }}
      </template>
    </el-table-column>
    <slot />
  </LnTable>
</template>
<script>
import { typechoPostList } from "@/api/typecho";
export default {
  name: "TypechoPostTable",
  components: {},
  props: {
    queryParams: {
      type: Object,
      default() {
        return {};
      }
    },
    columns: {
      type: Array,
      default() {
        return [{ type: "selection" }, { prop: "cid", label: "编号", width: 45 }, { prop: "title", label: "标题", width: 180 }, { slot: "modified" }, { slot: "metas" }, { slot: "fields" }];
      }
    },
    callListFunc: {
      type: Function,
      default: typechoPostList
    }
  },
  data() {
    return {
      loading: false,
      data: [],
      page: 1,
      size: 10,
      total: 0,
      multipleSelection: []
    };
  },
  computed: {},
  methods: {
    handleQuery() {
      this.loading = true;
      return this.callListFunc({
        ...this.queryParams,
        page: this.page,
        size: this.size
      })
        .then(res => {
          this.data = res.rows;
          this.page = res.page;
          this.size = res.size;
          this.total = res.total;
          return Promise.resolve(res);
        })
        .finally(() => {
          this.loading = false;
        });
    },
    handleSelectionChange(val) {
      this.multipleSelection = val;
      this.$emit("selection-change", val);
    },
    handleCurrentChange(val) {
      this.page = val;
      this.handleQuery();
    },
    handleSizeChange(val) {
      this.size = val;
      this.handleQuery();
    }
  }
};
</script>
