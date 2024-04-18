/** * 文章管理页面 * 新增 * 查询 */
<template>
  <div class="app-container">
    <el-button size="mini" type="info" style="position:absolute;right:0px;z-index:1;" @click="$emit('toggle', { to: 'list', from: 'info' })">返回</el-button>
    <el-form ref="post" :model="post" label-position="top" size="mini">
      <el-row :gutter="20">
        <el-col :span="18">
          <el-col :span="20">
            <el-form-item label="标题" prop="title">
              <el-input v-model="post.title" />
            </el-form-item>
          </el-col>
          <el-col :span="4">
            <el-form-item label="别名" prop="slug">
              <el-input v-model="post.slug" />
            </el-form-item>
          </el-col>

          <el-form-item label="内容" prop="text" label-width="100%">
            <template slot="label" style="width:100%;">
              内容&nbsp;
            </template>
            <slot name="editor">
              <markdown-editor ref="editor" v-model="post.text" :options="{ hideModeSwitch: true, previewStyle: 'tab' }" height="500px" />
            </slot>
          </el-form-item>
          <el-form-item label="附加字段">
            <template slot="label">
              附加字段&nbsp;
              <el-button type="primary" style="float: right" @click="post.fields.push({ name: null, type: 'str' })">新增</el-button>
            </template>
            <el-row v-for="(field, index) in post.fields" :key="index">
              <el-col :span="6">
                <el-input v-model="field.name">
                  <template slot="prepend">
                    <el-button icon="el-icon-minus" @click="post.fields.splice(index, 1)" />
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
          <el-form-item v-if="prefix === ''" label="分支">
            <el-select v-model="queryParams.prefix" clearable filterable default-first-option placeholder="请选择分支，默认第一条">
              <el-option v-for="item in prefixOptions" :key="item.prefix" :label="item.prefix" :value="item.prefix" />
            </el-select>
          </el-form-item>
          <el-form-item label="目录">
            <TypechoMetaTree ref="typechoMetaTree" :query-params="{ type: 'category', prefix: queryParams.prefix }" :depth="categoryDepth" />
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
      <el-form-item align="center" size="small">
        <el-button type="info" @click="handleSubmitDraft">保存草稿</el-button>
        <el-button type="primary" @click="handleSubmit">发布</el-button>
        <!-- <el-button @click="$router.push({ path: '/typecho/post/list' })">返回</el-button> -->
      </el-form-item>
    </el-form>
  </div>
</template>
<script>
import { typechoOptionList, typechoMetaList } from "@/api/typecho";
import typechoMixin from "@/mixins/typecho";
import TypechoMetaTree from "@/views/typecho/components/TypechoMetaTree";
import MarkdownEditor from "@/components/MarkdownEditor";
export default {
  name: "TypechoPostInfoView",
  components: { TypechoMetaTree, MarkdownEditor },
  mixins: [typechoMixin],
  props: {
    query: {
      type: Object,
      default() {
        return {};
      }
    },
    prefix: {
      type: String,
      default: ""
    }
  },
  data() {
    return {
      queryParams: {
        prefix: ""
      },
      target: "info", // info, insert, update
      tags: [],
      tagOptions: [],
      prefixOptions: [],
      categoryDepth: [],
      categoryMultiSelection: []
    };
  },
  watch: {
    "queryParams.prefix": function(val) {
      this.$refs.typechoMetaTree.handleQuery({ prefix: val, type: "category" });
      // 获取目录标识树
      if (val === "") {
        this.categoryDepth = [];
      } else {
        this.categoryDepth = [0, "children"];
      }
    }
  },
  created() {
    if (this.prefix !== "") {
      this.queryParams.prefix = this.prefix;
    } else {
      typechoOptionList({ prefix: "*" }).then(res => {
        this.prefixOptions = res.rows;
      });
    }
    if (this.query.data) {
      this.post = this.query.data;
      this.tagOptions = this.post.metas.filter(v => v.type === "tag");
      this.tags = this.tagOptions.map(v => v.mid);
    } else {
      this.resetPost();
    }
  },
  mounted() {
    if (this.prefix === "") {
      this.$refs.typechoMetaTree.handleQuery();
    }
    this.$refs.typechoMetaTree.multipleSelection = this.post.metas.filter(v => v.type === "category");
  },
  methods: {
    handleQuery() {
      this.selectPost(this.$route.query).then(res => {
        this.post = { ...this.post, ...res.rows[0] };
        // this.prefix = res.metas.filter((v) => v.type === "branch")[0].name;
        this.metaTree.multipleSelection = res.rows[0].metas.filter(v => v.type === "category");
        this.tagOptions = res.rows[0].metas.filter(v => v.type === "tag");
        this.tags = this.tagOptions.map(v => v.mid);
      });
    },
    handleSubmit() {
      this.$emit("before-submit");
      const data = { ...this.post };
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
      if (data.cid === null) {
        this.insertPost(data).then(res => {
          this.post = { ...this.post, ...res };
        });
      } else {
        this.updatePost(data);
      }
    },
    handleSubmitDraft() {},
    handleQueryMetaList(name) {
      typechoMetaList({
        name,
        type: "tag"
      }).then(res => {
        this.tagOptions = res.rows;
      });
    },
    setText(text) {
      this.post.text = text;
    }
  }
};
</script>
