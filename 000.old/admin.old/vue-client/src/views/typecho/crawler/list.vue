<template>
  <div class="app-container">
    <TypechoPostList prefix="crawler" :table-columns="columns" @toggle="toggleView">
      <template v-slot:table-append>
        <el-table-column align="center" show-overflow-tooltip prop="domains" label="域名">
          <template slot-scope="{ row }">
            <el-tag v-for="domain in JSON.parse(row.text)['domains']" :key="domain" size="mini">{{ domain }}</el-tag>
          </template>
        </el-table-column>
        <el-table-column label="操作" align="center" width="120">
          <template slot-scope="{ row }">
            <el-button type="text" size="mini" :disabled="row.status > 0" @click="handleStart(row)">启动</el-button>
            <el-button type="text" size="mini" @click="$emit('toggle', { to: 'info', data: row, from: 'list' })">编辑</el-button>
          </template>
        </el-table-column>
      </template>
    </TypechoPostList>
  </div>
</template>
<script>
import { crawlerPostList, crawlerPostUpdate } from "@/api/crawler";
import TypechoPostList from "@/views/typecho/post/list";
import typechoMixin from "@/mixins/typecho";
export default {
  components: {
    TypechoPostList
  },
  mixins: [typechoMixin],
  data() {
    return {
      queryParams: {},
      columns: [{ type: "selection" }, { prop: "cid", label: "编号", width: 45 }, { prop: "title", label: "标题", width: 180 }, { prop: "statusText", label: "状态", width: 60 }]
    };
  },
  mounted() {
    // this.postList.func = crawlerPostList;
    // this.postList.columns = [
    //   { type: "selection", width: 45 },
    //   { prop: "id", label: "编号", width: 80 },
    //   { prop: "name", label: "标题", width: 180 },
    //   { prop: "statusText", label: "状态", width: 60 },
    //   { prop: "domains", label: "域名" }
    // ];
  },
  methods: {
    handleStart(row) {
      crawlerPostUpdate({ id: row.id, status: 1 }).then(res => {
        this.handleQuery();
      });
    },
    crawlerPostList(data) {
      return crawlerPostList(data);
    },
    toggleView(query) {
      this.$emit("toggle", query);
    }
  }
};
</script>
