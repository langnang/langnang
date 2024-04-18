<template>
  <el-select v-model="value" :placeholder="placeholder">
    <el-option v-for="item in options" :key="item[optionProps.key]" :label="item[optionProps.label]" :value="item[optionProps.value]" />
  </el-select>
</template>
<script>
import { typechoMetaTypeList } from "@/api/typecho";
export default {
  // 博客标识选择器
  name: "TypechoMetaSelect",
  components: {},
  props: {
    value: {
      type: String,
      default: ""
    },
    placeholder: {
      type: String,
      default: ""
    },
    // 标识类型
    // * 标识整表内容不限
    // meta_type 表中类型类型
    // tag, category, ... 其它typecho_metas表中的type字段对应的值
    type: {
      type: String,
      default: "tag"
    }
  },
  data() {
    return {
      options: []
    };
  },
  computed: {
    optionProps() {
      if (this.$props.type === "meta_type") {
        return { key: "prefix", label: "prefix", value: "prefix" };
      }
      return { key: "mid", label: "name", value: "mid" };
    }
  },
  watch: {},
  created() {
    console.log(this);
    this.handleQuery();
  },
  methods: {
    handleQuery() {
      typechoMetaTypeList({}).then(res => {
        if (this.form.type === "") {
          this.form.type = res.rows[0].type;
        } else if (!res.rows.map(v => v.type).includes(this.form.type)) {
          this.form.type = res.rows[0].type;
        }
        this.typeList = res.rows;
        this.handleQuery();
      });
    }
  }
};
</script>
