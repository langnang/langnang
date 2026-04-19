<template>
  <el-dialog :visible.sync="visible" append-to-body :title="title" width="800px" v-loading="loading">
    <el-form ref="form" :model="form" :rules="rules" label-width="60px" size="small" :disabled="readonly">
      <el-form-item label="名称" prop="name">
        <el-input v-model="form.name" clearable></el-input>
      </el-form-item>
      <el-form-item v-if="form.type === 'branch'" label="编码" prop="slug">
        <el-input v-model="form.slug" clearable></el-input>
      </el-form-item>
      <el-form-item v-if="['category', 'site'].includes(form.type)" label="徽标" prop="icon">
        <el-input v-if="form.type === 'site' && iconOptions.length == 0" v-model="form.icon" clearable></el-input>

        <el-popover v-if="form.type === 'site' && iconOptions.length > 0" placement="bottom" width="700" trigger="click">
          <el-input slot="reference" v-model="form.icon" clearable></el-input>
          <el-radio-group v-model="form.icon">
            <el-radio v-for="item in iconOptions" :key="item" :label="item"></el-radio>
          </el-radio-group>
        </el-popover>

        <el-popover v-if="form.type === 'category'" class="icon-select__wrapper" placement="bottom" width="700" trigger="click">
          <el-input slot="reference" v-model="form.icon" disabled>
            <el-button slot="append" icon="el-icon-setting">
            </el-button>
          </el-input>
          <el-tabs v-model="iconGroupActive" type="border-card" @tab-click="handleTabClick">
            <el-tab-pane v-for="(list, index) in iconGroup" :key="index" :label="list.label + '(' + (iconGroupActive == list.value ? (count * 8 < list.children.length ? count * 8 : list.children.length) : 0) + '/' + list.children.length + ')'" :name="list.value" lazy>
              <el-scrollbar style="height:300px;">
                <el-row :gutter="20" style="margin:0;" v-infinite-scroll="load">
                  <el-col v-for="(icon, idx) in list.children.slice(0, count * 8)" :key="idx" :label="icon" :span="3" style="margin-right:0;margin-bottom:4px;" @click.native="onIconSelectClick(icon)">
                    <div :class="['icon-select__item', { 'is-active': form.icon === icon }]">
                      <component :is="['font_awesome_solids', 'font_awesome_regulars', 'font_awesome_brands'].includes(list.value) ? 'font-awesome-icon' : 'i'" :icon="icon.split(' ')" :class="icon"></component>
                    </div>
                  </el-col>
                </el-row>
              </el-scrollbar>
            </el-tab-pane>
          </el-tabs>
        </el-popover>
      </el-form-item>
      <el-form-item v-if="form.type === 'site'" label="地址" prop="url">
        <el-input v-model="form.url" clearable>
          <el-button slot="append" @click="onCrawlerSite">
            <font-awesome-icon :icon="['fas', 'spider']" @click="onCrawlerSite"></font-awesome-icon>
          </el-button>
        </el-input>
      </el-form-item>
      <el-form-item v-if="user_info" label="状态" prop="status">
        <el-radio-group v-model="form.status">
          <el-radio v-for="item in guideStatusOptions" :key="item.value" :label="item.value">{{ item.label }}</el-radio>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="排序">
        <el-input-number v-model="form.order" :min="0" :max="99"></el-input-number>
      </el-form-item>
      <el-form-item label="描述">
        <el-input v-if="descOptions.length == 0" type="textarea" v-model="form.description" :rows="4"></el-input>
        <el-popover v-if="descOptions.length > 0" placement="bottom" width="700" trigger="click">
          <el-input slot="reference" type="textarea" v-model="form.description" :rows="4"></el-input>
          <el-radio-group v-model="form.description">
            <el-radio v-for="item in descOptions" :key="item" :label="item"></el-radio>
          </el-radio-group>
        </el-popover>
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
import { elementIcons, guideOriginForm, guideStatusOptions, guideTypeOptions, getGuideType } from '@/constants'
import { fas } from "@fortawesome/free-solid-svg-icons";
import { far } from "@fortawesome/free-regular-svg-icons";
import { fab } from "@fortawesome/free-brands-svg-icons";
import Mock from 'mockjs'
import { mapGetters } from 'vuex';
import { crawlerItem } from '@/api/guide';


const [fasIcons, farIcons, fabIcons] = [
  [...new Set(Object.values(fas).map(v => `${v.prefix} ${v.iconName}`).filter(v => v !== 'fas rectangle-ad'))],
  [...new Set(Object.values(far).map(v => `${v.prefix} ${v.iconName}`))],
  [...new Set(Object.values(fab).map(v => `${v.prefix} ${v.iconName}`))]
];


export default {
  name: "GuideDialog",
  components: {
  },
  props: {
    data: {
      type: Object,
      default: () => ({})
    },
  },
  data() {
    return {
      visible: false,
      loading: false,
      title: "",
      form: {
        ...guideOriginForm,
      },
      rules: {
        name: [
          { required: true, message: '请输入名称', trigger: 'blur' },
        ],
        slug: [
          { required: true, message: '请输入编码', trigger: 'blur' },
        ],
        url: [
          { required: true, message: '请输入地址', trigger: 'blur' },
        ],
        icon: [
          { required: true, message: '请选择徽标', trigger: 'blur' }
        ],
      },
      readonly: false,
      guideTypeOptions,
      iconOptions: [],
      descOptions: [],
      guideStatusOptions,
      iconGroupActive: "element_ui",
      iconGroup: [
        { label: "Element UI", value: "element_ui", children: elementIcons },
        { label: "Font Awesome Solids", value: "font_awesome_solids", children: fasIcons },
        { label: "Font Awesome Regulars", value: "font_awesome_regulars", children: farIcons },
        { label: "Font Awesome Brands", value: "font_awesome_brands", children: fabIcons }
      ],
      count: 10,
    }
  },
  computed: {
    ...mapGetters(["user_info"])
  },
  methods: {
    handleTabClick() {
      this.count = 10;
    },
    load() {
      this.count += 2;
    },
    toggle(row = {}, readonly = false) {
      this.readonly = readonly
      this.form = { ...guideOriginForm, status: this.user_info ? 'public' : 'draft', ...row }
      this.title = (readonly ? '查看' : this.form.id ? '编辑' : '新增') + getGuideType(row.type).label
      this.count = 10;
      this.visible = !this.visible
      this.$refs.form ? this.$refs.form.resetFields() : null;
    },
    onSubmit() {
      this.$refs.form.validate((valid) => {
        if (valid) {
          console.log("🚀 ~ file: GuideDialog.vue:124 ~ valid:", valid)
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
        slug: Mock.mock('@guid'),
        url: Mock.mock('@url'),
        icon: this.form.type === 'site'
          ? Mock.Random.image('200x200')
          : Mock.mock({
            'array|1': [...elementIcons, ...fasIcons, ...farIcons, ...fabIcons],
          })['array'],
        description: Mock.mock('@cparagraph'),
      }
    },
    onCrawlerSite() {
      this.loading = true;
      crawlerItem({ url: this.form.url }).then(res => {
        this.form = { ...this.form, name: res.title, icon: res.icons[0], description: res.descriptions[0] }
        this.iconOptions = res.icons;
        this.descOptions = res.descriptions;
      }).finally(() => {
        this.loading = false;
      })
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

  .el-input-number,
  .el-select {
    width: 100%;
  }




}
</style>