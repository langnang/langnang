<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col v-for="(item, key) in editorOptions" :key="key" :span="6" align="center" style="margin-bottom:20px;cursor:pointer;">
        <el-card :shadow="active === key ? 'always' : 'hover'" @click.native="handleClickCol(key)">
          <LnBox :height="'20%'"> {{ item.label }} </LnBox>
        </el-card>
      </el-col>
    </el-row>
    <LnEditor v-model="editorProps.value" :editor="editorProps.editor" />
    <LnComponentConfigTable :options="ComponentOptions" />
  </div>
</template>
<script>
import LnComponentConfigTable from "@/views/ln/components/LnComponentConfigTable";
import ComponentOptions from "@/components/Ln/Editor/options";
export default {
  name: "LnBoxView",
  components: { LnComponentConfigTable },
  data() {
    return {
      ComponentOptions,
      active: "",
      editorOptions: { monaco: { label: "Monaco Editor", editor: "monaco" }},
      editorProps: {
        editor: "",
        value: "1111111"
      }
    };
  },
  methods: {
    handleClickCol(key) {
      if (this.active === key) {
        key = "";
      }
      this.active = key;
      this.editorProps = { ...this.editorOptions[key] };
    }
  }
};
</script>
