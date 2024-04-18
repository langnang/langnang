<template>
  <div>
    <el-table v-loading="loading" size="mini" border :data="data" style="width: 100%" @selection-change="handleSelectionChange">
      <slot v-for="(col, index) in columns" :name="col.slot ? col.slot : 'el-table-column-' + index">
        <el-table-column align="center" show-overflow-tooltip :type="col.type" :prop="col.prop" :label="col.label" :width="col.width" />
      </slot>
      <slot />
    </el-table>
    <el-pagination :current-page="page" :page-sizes="[10, 20, 50, 100]" :page-size="size" layout="total, sizes, prev, pager, next, jumper" :total="total" @size-change="handleSizeChange" @current-change="handleCurrentChange" />
  </div>
</template>
<script>
import { typechoMetaList } from '@/api/typecho'
export default {
  name: 'TypechoMetaTable',
  components: {},
  props: {
    queryParams: {
      type: Object,
      default() {
        return {}
      }
    },
    columns: {
      type: Array,
      default() {
        return [
          { type: 'selection', width: 45 },
          { prop: 'mid', label: '编号', width: 80 },
          { prop: 'name', label: '名称', width: 180 },
          { prop: 'slug', label: '别名', width: 180 },
          { prop: 'type', label: '类型', width: 100 },
          { prop: 'description', label: '描述' },
          { prop: 'count', label: '关联', width: 55 },
          { prop: 'order', label: '排序', width: 55 },
          { prop: 'parent', label: '上一级', width: 80 }
        ]
      }
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
    }
  },
  created() {},
  methods: {
    handleQuery(data = {}) {
      this.loading = true
      return typechoMetaList({
        ...this.queryParams,
        ...data,
        page: this.page,
        size: this.size
      })
        .then(res => {
          this.data = res.rows
          this.page = res.page
          this.size = res.size
          this.total = res.total
          return Promise.resolve(res)
        })
        .finally(() => {
          this.loading = false
        })
    },
    handleSelectionChange(val) {
      this.multipleSelection = val
      this.$emit('selection-change', val)
    },
    handleCurrentChange(val) {
      this.page = val
      this.handleQuery()
    },
    handleSizeChange(val) {
      this.size = val
      this.handleQuery()
    }
  }
}
</script>
