<template>
  <el-form ref="form" :model="value" :label-width="labelWidth" :size="size" :inline="inline" :disabled="disabled">
    <slot v-for="(item, index) in items" :name="item.slot ? item.slot : 'el-form-item-' + index">
      <el-form-item v-if="item.prop === 'mid'" label="编号" prop="mid">
        <el-input v-model="value.mid" clearable readonly />
      </el-form-item>
      <el-form-item v-else-if="item.prop === 'name'" label="名称" prop="name">
        <el-input v-model="value.name" clearable />
      </el-form-item>
      <el-form-item v-else-if="item.prop === 'slug'" label="别名" prop="slug">
        <el-input v-model="value.slug" clearable />
      </el-form-item>
      <el-form-item v-else-if="item.prop === 'type'" label="类型" prop="type">
        <el-select v-model="value.type" filterable clearable allow-create default-first-option placeholder="请选择标识类型，默认第一条，可新建">
          <el-option v-for="type in typeOptions" :key="type.type" :label="type.type" :value="type.type" />
        </el-select>
      </el-form-item>
      <el-form-item v-else-if="item.prop === 'description'" label="描述" prop="description">
        <el-input v-model="value.description" clearable />
      </el-form-item>
      <el-form-item v-else-if="item.prop === 'count'" label="总数" prop="count">
        <el-input v-model="value.count" clearable readonly />
      </el-form-item>
      <el-form-item v-else-if="item.prop === 'order'" label="排序" prop="order">
        <el-input v-model="value.order" clearable />
      </el-form-item>
      <el-form-item v-else-if="item.prop === 'parent'" label="父标识" prop="parent">
        <el-select v-model="value.parent" filterable remote clearable placeholder="请输入标识名称" :remote-method="handleQueryMetaList">
          <el-option v-for="meta in parentOptions" :key="meta.mid" :label="meta.name" :value="meta.mid">
            <span style="float: left">{{ meta.name }}</span>
            <span style="float: right; color: #8492a6; font-size: 13px"> {{ meta.type }} </span>
          </el-option>
        </el-select>
      </el-form-item>
    </slot>
    <slot />
  </el-form>
</template>
<script>
import { typechoMetaTypeList, typechoMetaList, typechoMetaInfo } from "@/api/typecho";
export default {
  name: "TypechoMetaForm",
  props: {
    value: {
      type: Object,
      default() {
        return {};
      }
    },
    items: {
      type: Array,
      default() {
        return [];
      }
    },
    labelWidth: { type: String || Number, default: "" },
    size: { type: String, default: "mini" },
    inline: { type: Boolean, default: false },
    disabled: { type: Boolean, default: false },
    prefix: { type: String, default: "" }
  },
  data() {
    return {
      parentOptions: [],
      typeOptions: []
    };
  },
  created() {
    typechoMetaTypeList().then(res => {
      this.typeOptions = res.rows;
    });
    if (this.value.parent) {
      this.handleQueryMetaInfo([this.value.parent]);
    }
  },
  methods: {
    handleQueryMetaInfo(mids) {
      typechoMetaInfo({ mids }).then(res => {
        this.parentOptions = res.rows;
      });
    },
    // 远程搜索标识列表
    handleQueryMetaList(name) {
      typechoMetaList({
        prefix: this.prefix,
        name
      }).then(res => {
        this.parentOptions = res.rows;
      });
    },
    resetFields() {
      this.$refs.form.resetFields();
    }
  }
};
</script>
