<template>
  <el-form ref="form" :model="form" size="small" label-position="top" label-width="120px" :disabled="disabled">
    <el-link href="https://doc.phpspider.org/" target="_blank" :underline="false" style="position:absolute;top:-35px;right:10px;z-index:1;">owner888/phpspider</el-link>
    <el-tabs type="border-card" :stretch="true">
      <el-tab-pane label="基本配置">
        <el-table :data="table.filter(v => !v.hidden)" row-key="key" size="mini" stripe border default-expand-all :tree-props="{ children: 'children', hasChildren: 'hasChildren' }">
          <el-table-column show-overflow-tooltip label="名称" prop="name" width="130">
            <template slot-scope="{ row }">
              {{ row.name }}
              <el-tooltip v-if="row.desc" effect="dark" :content="row.desc" placement="right">
                <i class="el-icon-info" />
              </el-tooltip>
            </template>
          </el-table-column>
          <el-table-column align="center" show-overflow-tooltip label="类型" prop="type" width="100" />
          <el-table-column align="center" show-overflow-tooltip label="可选值" prop="selection" width="160">
            <template slot-scope="{ row }">
              {{ row.selection ? row.selection : "-" }}
            </template>
          </el-table-column>
          <el-table-column align="center" show-overflow-tooltip label="默认值" prop="default" width="100">
            <template slot-scope="{ row }">
              {{ row.default != null ? row.default.toString() : "-" }}
            </template>
          </el-table-column>
          <el-table-column align="center" show-overflow-tooltip label="必填" prop="required" width="50">
            <template slot-scope="{ row }">
              {{ row.required ? "Y" : "-" }}
            </template>
          </el-table-column>
          <el-table-column align="center" show-overflow-tooltip label="表单" prop="form">
            <template slot-scope="{ row, column, $index }">
              <component
                :is="row.component"
                v-if="row.parent_key != null"
                v-model="form[row.parent_key][row.key]"
                :placeholder="row.placeholder"
                :multiple="row.multiple"
                :filterable="row.filterable"
                :allow-create="row.allowCreate"
                :default-first-option="row.defaultFirstOption"
                :disabled="row.disabled"
                :type="row.type"
                @change="handleChange({ row, column, $index, key: row.key, parent_key: row.parent_key, value: form[row.parent_key][row.key] })"
              >
                <el-option v-for="item in row.options" :key="item.value" :label="item.label" :value="item.value" />
              </component>
              <component
                :is="row.component"
                v-else
                v-model="form[row.key]"
                :placeholder="row.placeholder"
                :multiple="row.multiple"
                :filterable="row.filterable"
                :allow-create="row.allowCreate"
                :default-first-option="row.defaultFirstOption"
                :disabled="row.disabled"
                :type="row.type"
                @change="handleChange({ row, column, $index, key: row.key, value: form[row.key] })"
              >
                <el-option v-for="item in row.options" :key="item.value" :label="item.label" :value="item.value" />
              </component>
            </template>
          </el-table-column>
        </el-table>
      </el-tab-pane>
      <el-tab-pane label="规则配置">
        <el-form-item prop="test_urls">
          <template slot="label"> <el-tag>Array</el-tag> <el-tag type="danger">Required</el-tag> 页面地址 <small>// 测试用页面地址</small> </template>
          <el-select v-model="form.test_urls" placeholder="测试用页面地址" multiple filterable allow-create default-first-option />
        </el-form-item>
        <el-form-item label="fields" prop="fields">
          <template slot="label"> <el-tag>Array</el-tag> <el-tag type="danger">Required</el-tag> 规则 <small>// 定义内容页的抽取规则</small> </template>
          <el-table :data="form.fields" style="width: 100%" size="mini" border resizable :tree-props="{ children: 'children', hasChildren: 'hasChildren' }" row-key="name" default-expand-all>
            <el-table-column prop="name" label="列名" width="200">
              <template v-slot="{ row }">
                <el-input v-model="row.name" type="text" style="width:auto;position:absolute;top:6px; margin-right:10px;" />
              </template>
            </el-table-column>
            <el-table-column align="center" show-overflow-tooltip prop="description" label="描述" width="160">
              <template v-slot="{ row }">
                <el-input v-model="row.description" type="text" />
              </template>
            </el-table-column>
            <el-table-column align="center" show-overflow-tooltip prop="selector" label="元素选择器">
              <template v-slot="{ row }">
                <el-input v-model="row.selector" type="text" />
              </template>
            </el-table-column>
            <el-table-column align="center" show-overflow-tooltip prop="required" label="必要" width="65">
              <template v-slot="{ row }">
                <el-switch v-model="row.required" />
              </template>
            </el-table-column>
            <el-table-column align="center" show-overflow-tooltip prop="repeated" label="多项" width="65">
              <template v-slot="{ row }">
                <el-switch v-model="row.repeated" />
              </template>
            </el-table-column>
            <el-table-column align="center" show-overflow-tooltip label="操作" width="120">
              <template slot="header">
                <el-button type="primary" round icon="el-icon-plus" @click="form.fields.push({})" />
              </template>
              <template v-slot="scope">
                <el-button type="text" icon="el-icon-circle-plus-outline" @click="handlePushFieldChildrenRow(scope)" />
                <el-button type="text" icon="el-icon-delete" @click="handleDeleteFieldRow(scope)" />
                <el-button type="text" icon="el-icon-copy-document" @click="handleCopyFieldRow(scope)" />
              </template>
            </el-table-column>
          </el-table>
        </el-form-item>
      </el-tab-pane>
    </el-tabs>
    <el-row :gutter="20" style="margin-top:20px;">
      <el-form-item align="center">
        <el-button type="primary" @click="handleTest">测试</el-button>
      </el-form-item>
    </el-row>
    <el-dialog ref="resultDialog" :title="testResultDialog.title" :visible.sync="testResultDialog.visible" width="80%">
      <el-table :data="testResultDialog.data" size="mini" border>
        <el-table-column align="center" show-overflow-tooltip type="index" label="序号" />
        <el-table-column v-for="(col, index) in form.fields" :key="index" align="center" show-overflow-tooltip :label="col.description || col.name" :prop="col.name" />
      </el-table>
    </el-dialog>
  </el-form>
</template>
<script>
import { crawlerPostTest } from "@/api/crawler";
import { tableData, defaultForm } from "./config-table";
// function recurvePushFieldRow(obj, $index, currentIndex = 0) {
//   obj.forEach(value => {
//     currentIndex++;
//     if (currentIndex === $index) {
//       const item = { name: "new_" + (currentIndex + 1) };
//       if (obj.children) {
//         obj.children.push(item);
//       } else {
//         obj.children = [item];
//       }
//       break;
//     } else {
//     }
//   });
// }
export default {
  name: "PhpSpiderEditor",
  props: {
    value: {
      type: String,
      default: ""
    },
    disabled: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      form: {
        test_urls: [],
        log_show: false,
        log_file: "data/phpspider.log",
        export: {},
        db_config: {
          host: "127.0.0.1",
          port: "3306",
          user: "develop",
          pass: "develop",
          name: "develop"
        },
        queue_config: {},
        domains: [],
        scan_urls: [],
        fields: [
          { name: "title", selector: "//title", required: true, description: "标题" },
          { name: "keywords", selector: "//meta[@name='keywords']/@content", description: "关键字" },
          { name: "description", description: "描述", selector: "//meta[@name='description']/@content" }
        ],
        log_type: "",
        _log_type: [],
        ...defaultForm
      },
      table: [...tableData],
      testResultDialog: {
        visible: false,
        title: "测试结果展示",
        data: []
      }
    };
  },
  watch: {
    value: function(newV, oldV) {
      if (newV !== oldV) {
        this.form = { ...this.form, ...JSON.parse(newV) };
      }
    },
    form: {
      deep: true,
      handler(newV, oldV) {
        if (newV !== oldV) {
          // this.value = JSON.stringify(newV);
        }
      }
    },
    "form._log_type": {
      handler(val) {
        this.form.log_type = val.join(",");
      }
    }
  },
  created() {
    if (this.value) {
      this.form = { ...this.form, ...JSON.parse(this.value) };
    }
    this.form._log_type = this.form.log_type === "" ? [] : this.form.log_type.split(",");
  },
  methods: {
    handleRowUpdate() {},
    handleDblClickCell(row, column, cell, event) {},
    handleEdit(index, row) {
      console.log(index, row);
    },
    handleDelete(index, row) {
      console.log(index, row);
    },
    handleTest() {
      crawlerPostTest(this.form)
        .then(res => {
          this.testResultDialog.data = res.rows;
          this.testResultDialog.visible = true;
        })
        .catch(() => {
          this.$message.error("操作失败");
        });
    },
    handleChange(data) {
      const vm = this;
      if (data.row.handleChange != null) {
        data.row.handleChange({ ...data, vm, $config: vm.table });
      }
    },
    getValue() {
      return JSON.stringify(this.form);
    },
    handlePushFieldRow({ row, column, $index }) {
      // console.log(row, column, $index);
      // form.fields[$index].children ? form.fields[$index].children.push({ name: 'new' }) : $set(form.fields[$index], 'children', [{ name: 'new' }])
    },
    // 新增字段规则子项
    handlePushFieldChildrenRow({ row, column, $index }, obj = this.form.fields, currentIndex = 0) {
      if (currentIndex === undefined) return;
      for (let i = 0; i <= obj.length - 1; i++) {
        if (currentIndex === $index) {
          const new_item = { name: new Date().valueOf() };
          obj[i].children ? obj[i].children.push(new_item) : (obj[i].children = [new_item]);
          this.$set(this.form, "fields", [...this.form.fields]);
          // console.log($index, currentIndex);
          return;
        } else {
          currentIndex = obj[i].children ? this.handlePushFieldChildrenRow({ row, column, $index }, obj[i].children, currentIndex + 1) : currentIndex + 1;
        }
      }
      return currentIndex;
      // let ind = 0;
      // this.form.fields.forEach((v, index) => {
      //   if (index === $index) {
      //   }
      // });
      // console.log(row, column, $index);
      // if (column.level === 1) {
      //   this.form.fields[$index].children ? this.form.fields[$index].children.push({ name: "new_" + ($index + 1) }) : this.$set(this.form.fields[$index], "children", [{ name: "new_" + ($index + 1) }]);
      // }
    },
    handleCopyFieldRow({ row, column, $index }) {
      this.form.fields.splice($index + 1, 0, {
        ...this.form.fields[$index],
        ...{ name: new Date().valueOf() }
      });
    },
    handleDeleteFieldRow({ row, column, $index }) {
      this.form.fields.splice($index, 1);
    }
  }
};
</script>
<style lang="css">
.el-select {
  width: 100%;
}
.el-collapse {
  border: 0;
}
.el-table__indent ~ .el-input {
  /* width: calc(100% - 36px) !important; */
}
</style>
