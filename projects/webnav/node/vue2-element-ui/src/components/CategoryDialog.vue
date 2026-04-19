<template>
  <el-dialog :visible.sync="visible" append-to-body :title="title" width="800px">
    <el-form ref="form" :model="form" :rules="rules" label-width="60px">
      <el-form-item label="名称" prop="name">
        <el-input v-model="form.name"></el-input>
      </el-form-item>
      <el-form-item label="编码" prop="slug">
        <el-input v-model="form.slug"></el-input>
      </el-form-item>
      <el-form-item label="图标" prop="icon">
        <el-popover class="icon-select__wrapper" placement="bottom" width="700" trigger="click">
          <el-input slot="reference" v-model="form.icon" disabled>
            <template slot="append"><i class="el-icon-setting"></i></template>
          </el-input>
          <el-tabs v-model="iconGroupActive">
            <el-tab-pane v-for="(list, index) in iconGroup" :key="index" :label="list.label" :name="list.value">
              <el-row :gutter="20" style="margin:0;">
                <el-scrollbar style="height:300px;">
                  <el-col v-for="(icon, idx) in list.children" :key="idx" :label="icon" :span="3" style="margin-right:0;margin-bottom:4px;" @click.native="onIconSelectClick(icon)">
                    <div :class="['icon-select__item', { 'is-active': form.icon === icon }]">
                      <component :is="['font_awesome_solids', 'font_awesome_regulars', 'font_awesome_brands'].includes(list.value) ? 'font-awesome-icon' : 'i'" :icon="icon.split(' ')" :class="icon"></component>
                    </div>
                  </el-col>
                </el-scrollbar>
              </el-row>
            </el-tab-pane>
          </el-tabs>
        </el-popover>
      </el-form-item>
      <el-form-item label="状态" prop="status">
        <el-radio-group v-model="form.status">
          <el-radio label="public">公开</el-radio>
          <el-radio label="private">私有</el-radio>
          <el-radio label="draft">草稿</el-radio>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="排序">
        <el-input-number v-model="form.order"></el-input-number>
      </el-form-item>
      <el-form-item label="描述">
        <el-input type="textarea" v-model="form.desc"></el-input>
      </el-form-item>
      <el-form-item class="text-right">
        <el-button v-if="user_info" class="pull-left" type="warning" @click="onMock">Mock</el-button>
        <el-button type="primary" @click="onSubmit">确认</el-button>
        <el-button @click="onCancel">取消</el-button>
      </el-form-item>
    </el-form>
  </el-dialog>
</template>
<script>
import { elementIcons } from '@/constants'
import Element from 'element-ui'
console.log("🚀 ~ file: CategoryDialog.vue:54 ~ Element:", Element)
import { fas } from "@fortawesome/free-solid-svg-icons";
import { far } from "@fortawesome/free-regular-svg-icons";
import { fab } from "@fortawesome/free-brands-svg-icons";
const [fasIcons, farIcons, fabIcons] = [[...new Set(Object.values(fas).map(v => `${v.prefix} ${v.iconName}`).filter(v => v !== 'fas rectangle-ad'))], [...new Set(Object.values(far).map(v => `${v.prefix} ${v.iconName}`))], [...new Set(Object.values(fab).map(v => `${v.prefix} ${v.iconName}`))]];
import Mock from 'mockjs'
import { mapGetters } from 'vuex';
const originForm = {
  id: null,
  name: "",
  slug: null,
  icon: "",
  type: "category",
  status: "public",
  order: 0,
  description: "",
  parent: 0,
};
export default {
  name: "CategoryDialog",
  components: {
  },
  props: {
    target: {
      type: String,
      default: "category",
    },
    data: {
      type: Object,
      default: () => ({})
    },
  },
  data() {
    return {
      visible: false,
      title: "",
      form: {
        ...originForm,
      },
      rules: {
        name: [
          { required: true, message: '请输入名称', trigger: 'blur' },
        ],
        icon: [
          { required: true, message: '请选择图标', trigger: 'blur' }
        ],
      },
      iconGroupActive: "element_ui",
      iconGroup: [
        { label: "Element UI", value: "element_ui", children: elementIcons },
        { label: "Font Awesome Solids", value: "font_awesome_solids", children: fasIcons },
        { label: "Font Awesome Regulars", value: "font_awesome_regulars", children: farIcons },
        { label: "Font Awesome Brands", value: "font_awesome_brands", children: fabIcons }
      ],
    }
  },
  computed: {
    ...mapGetters(["user_info"])
  },
  watch: {
  },
  methods: {
    toggle(row = {}) {
      this.form = { ...originForm, status: this.user_info ? 'public' : 'draft', ...row }
      this.title = this.form.id ? '编辑目录' : '新增目录'
      this.visible = !this.visible
      this.$refs.form ? this.$refs.form.resetFields() : null;
    },
    onSubmit() {
      this.$refs.form.validate((valid) => {
        if (valid) {
          this.$emit('submit', { ...this.form });
          this.toggle();
        } else {
          return false;
        }
      });
    },
    onCancel() {
      this.toggle();
    },
    onIconSelectClick(val) {
      this.form.icon = val;
    },
    onMock() {
      this.form = {
        ...this.form,
        name: Mock.mock('@ctitle'),
        icon: Mock.mock({
          'array|1': [...elementIcons, ...fasIcons, ...farIcons, ...fabIcons],
        })['array']
      }
    }
  }
}
</script>

<style lang="scss" scoped>
::v-deep {
  .icon-select__wrapper {}

  .icon-select__item {
    font-size: 40px;
    height: 58px;
    text-align: center;
    border: 1px solid #DCDFE6;
    padding: 4px;
    line-height: 48px;
    border-radius: 4px;

    &:hover {
      border-color: #409EFF;
    }

    &.is-active {
      border-color: #409EFF;
      background-color: #409EFF;
      color: white;
    }
  }


  .is-horizontal {
    display: none;
  }

  .el-scrollbar__wrap {
    overflow-x: hidden;
  }

  [class*='fa-'] {
    margin: 0 !important;
    padding: 0 !important;
  }
}
</style>