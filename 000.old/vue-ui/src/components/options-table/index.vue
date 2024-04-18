<template>
  <div>
    <h1 class="title">{{ title ? title + ' ' : '' }}{{ type.charAt(0).toUpperCase() + type.slice(1) }}s</h1>
    <ElDynamicTable :cols="_cols" :data="_tableData">
      <template v-if="prototype" slot="append">
        <div style="display: flex; justify-content: center; align-items: center; height: 48px">
          <el-link :href="prototype" :underline="false">
            <el-button type="primary">Prototypes</el-button>
          </el-link>
        </div>
      </template>
      <template slot="empty">
        <el-empty>
          <el-link v-if="prototype" :href="prototype" :underline="false">
            <el-button type="primary">Prototypes</el-button>
          </el-link>
        </el-empty>
      </template>
    </ElDynamicTable>
  </div>
</template>
<script>
export default {
  props: {
    // 类型
    type: {
      type: String,
      default: 'attribute',
      validator: val => ['attribute', 'event', 'method', 'slot'].includes(val),
    },
    // 标题
    title: {
      type: String,
      default: null,
    },
    data: {
      type: Array,
      default() {
        return [];
      },
    },
    prototype: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      attributeColumns: [
        { label: '参数', prop: 'name' },
        { label: '说明', prop: 'description' },
        { label: '类型', prop: 'type' },
        { label: '可选值', prop: 'optionals' },
        { label: '默认值', prop: 'default' },
      ],
      eventColumns: [
        { label: '事件名', prop: 'name' },
        { label: '说明', prop: 'description' },
        { label: '回调参数', prop: 'params' },
      ],
      methodColumns: [
        { label: '方法名', prop: 'name' },
        { label: '说明', prop: 'description' },
        { label: '参数', prop: 'params' },
      ],
      slotColumns: [
        { label: '名称', prop: 'name' },
        { label: '说明', prop: 'description' },
      ],
    };
  },
  computed: {
    _cols() {
      return this.$data[this.type + 'Columns'] || [];
    },
    _tableData() {
      return this.data.map(item => {
        return this._cols.reduce((tol, col, index) => {
          tol[col.prop] = item[index];
          return tol;
        }, {});
      });
    },
  },
};
</script>
