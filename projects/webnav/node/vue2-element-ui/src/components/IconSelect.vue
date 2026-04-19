<template>
  <el-popover placement="bottom" width="700" trigger="click">
    <el-input slot="reference" v-model="value" disabled>
      <template slot="append"><i class="el-icon-setting"></i></template>
    </el-input>
    <el-tabs v-model="activeName">
      <el-tab-pane v-for="(list, index) in iconGroup" :key="index" :label="list.label" :name="list.label">
        <el-row :gutter="20" style="margin:0;">
          <el-scrollbar style="height:300px;">
            <el-col v-for="icon in list.children" :key="icon" :label="icon" :span="3" style="margin-right:0;margin-bottom:4px;" @click.native="onClick(icon)">
              <!-- <span class="el-radio__input">
                <span class="el-radio__inner"></span>
                <input :name="list" type="radio" class="el-radio__original" :value="icon">
              </span>
              <span class="el-radio__label"></span> -->
              <!-- <input v-model="value" type="radio" :name="list" :value="icon" /> -->
              <span :class="['icon-select__item', { 'is-active': value === icon }]">
                <i :class="icon"></i>
              </span>
            </el-col>
          </el-scrollbar>
        </el-row>
      </el-tab-pane>
    </el-tabs>
  </el-popover>
</template>

<script>
import { elementIcons } from '@/constants'
export default {
  name: "IconSelect",
  props: {
    value: String,
  },
  data() {
    return {
      activeName: "",
      iconGroup: [
        { label: "ElementUI", children: elementIcons },
        { label: "FontAwesome", children: [] }
      ],
    }
  },
  methods: {
    onClick(val) {
      // this.dispatch("ElForm", 'input', [val])
      this.value = val
    }
  }
}
</script>

<style lang="scss" scoped>
.icon-select__item {
  font-size: 48px;
  text-align: center;
  border: 1px solid #DCDFE6;
  padding: 4px;
  border-radius: 4px;

  &:hover {
    border-color: #409EFF;
  }

  &.is-active {
    border-color: #409EFF;
  }
}

::v-deep {
  .is-horizontal {
    display: none;
  }

  .el-scrollbar__wrap {
    overflow-x: hidden;
  }
}
</style>