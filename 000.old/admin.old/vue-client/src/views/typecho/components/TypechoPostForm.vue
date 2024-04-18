<template>
  <el-form ref="post" :model="value" label-position="top" size="mini">
    <el-row :gutter="20">
      <el-col :span="18">
        <el-col :span="20">
          <el-form-item label="标题" prop="title">
            <el-input v-model="value.title" />
          </el-form-item>
        </el-col>
        <el-col :span="4">
          <el-form-item label="别名" prop="slug">
            <el-input v-model="value.slug" />
          </el-form-item>
        </el-col>

        <el-form-item label="内容" prop="text" label-width="100%">
          <template slot="label" style="width:100%;">
            内容&nbsp;
          </template>
          <markdown-editor v-if="editor === 'markdownEditor'" ref="markdownEditor" v-model="value.text" :options="{ hideModeSwitch: true, previewStyle: 'tab' }" height="500px" />
          <json-editor v-if="editor === 'jsonEditor'" ref="jsonEditor" />
          <phpSpiderEditor v-if="editor === 'crawlerPostForm'" ref="crawlerPostForm" v-model="value.text" />
        </el-form-item>
        <el-form-item label="附加字段">
          <template slot="label">
            附加字段&nbsp;
            <el-button type="primary" style="float: right" @click="value.fields.push({ name: null, type: 'str' })">新增</el-button>
          </template>
          <el-row v-for="(field, index) in value.fields" :key="index">
            <el-col :span="6">
              <el-input v-model="field.name">
                <template slot="prepend">
                  <el-button icon="el-icon-minus" @click="value.fields.splice(index, 1)" />
                </template>
              </el-input>
            </el-col>
            <el-col :span="4">
              <el-select v-model="field.type" placeholder="请选择">
                <el-option value="str" />
                <el-option value="int" />
                <el-option value="float" />
              </el-select>
            </el-col>
            <el-col :span="14">
              <el-input v-if="field.type === 'str'" v-model="field.str_value" />
              <el-input v-if="field.type === 'int'" v-model="field.int_value" />
              <el-input v-if="field.type === 'float'" v-model="field.float_value" />
            </el-col>
          </el-row>
        </el-form-item>
      </el-col>
      <el-col :span="6">
        <el-form-item label="分支">
          <el-select v-model="prefix" clearable filterable default-first-option placeholder="请选择分支，默认第一条">
            <el-option v-for="item in prefixOptions" :key="item.prefix" :label="item.prefix" :value="item.prefix" />
          </el-select>
        </el-form-item>
        <el-form-item label="目录">
          <TypechoMetaTree ref="typechoMetaTree" :query-params="{ type: 'category', prefix }" :depth="categoryDepth" />
        </el-form-item>
        <el-form-item label="标签">
          <el-select v-model="tags" multiple filterable remote allow-create reserve-keyword placeholder="请输入标识名称" :remote-method="handleQueryMetaList">
            <el-option v-for="item in tagOptions" :key="item.mid" :label="item.name" :value="item.mid">
              <span style="float: left">{{ item.name }}</span>
              <span style="float: right; color: #8492a6; font-size: 13px">
                {{ item.type }}
              </span>
            </el-option>
          </el-select>
        </el-form-item>
      </el-col>
    </el-row>
    <slot />
  </el-form>
</template>
<script>
import { typechoOptionList, typechoMetaList } from "@/api/typecho";
import TypechoMetaTree from "./TypechoMetaTree";
import phpSpiderEditor from "@/components/phpSpiderEditor";
import MarkdownEditor from "@/components/MarkdownEditor";
import JsonEditor from "@/components/JsonEditor";
export default {
  name: "TypechoPostForm",
  components: { TypechoMetaTree, MarkdownEditor, phpSpiderEditor, JsonEditor },
  filters: {},
  props: {
    value: {
      type: Object,
      default() {
        return {};
      }
    },
    editor: {
      type: String,
      default: "markdownEditor"
    },
    disabled: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      prefixOptions: [],
      target: "info", // info, insert, update
      tags: [],
      tagOptions: [],
      prefix: "",
      categoryDepth: [],
      categoryMultiSelection: []
    };
  },
  computed: {
    json_parse() {
      return JSON.parse(this.post.text);
    }
  },
  watch: {
    prefix: function(val) {
      this.$refs.typechoMetaTree.handleQuery({ prefix: val, type: "category" });
      // 获取目录标识树
      if (this.prefix === "") {
        this.categoryDepth = [];
      } else {
        this.categoryDepth = [0, "children"];
      }
      // this.selectMetaTree({ prefix: val, type: "category" });
    }
  },
  created() {
    typechoOptionList({ prefix: "*" }).then(res => {
      this.prefixOptions = res.rows;
    });
    this.tagOptions = this.value.metas.filter(v => v.type === "tag");
    this.tags = this.tagOptions.map(v => v.mid);
  },
  mounted() {
    this.$refs.typechoMetaTree.handleQuery();
    this.$refs.typechoMetaTree.multipleSelection = this.value.metas.filter(v => v.type === "category");
  },
  methods: {
    getValue() {
      const data = { ...this.value };
      data.type = "post";
      data.metas = [
        ...this.tags.map(v => {
          if (typeof v === "number") {
            return {
              mid: v
            };
          } else {
            return {
              type: "tag",
              name: v
            };
          }
        }),
        ...this.$refs.typechoMetaTree.multipleSelection
      ];
      data.text = this.$refs[this.contentEditor].getValue();
      return data;
    },
    handleQueryMetaList(name) {
      typechoMetaList({
        prefix: this.prefix,
        name,
        type: "tag"
      }).then(res => {
        this.tagOptions = res.rows;
      });
    }
  }
};
</script>
