<template>
  <div class="app-container">
    <component :is="option.component" v-for="(option, index) in options" :key="index" :name="option.name" :data="option.data" />
  </div>
</template>
<script>
/**
 * Ln组件配置信息表
 *
 */
import AttributeTable from "./AttributeTable";
import EventTable from "./EventTable";
import MethodTable from "./MethodTable";
import SlotTable from "./SlotTable";
export default {
  name: "LnComponentConfigTable",
  components: { AttributeTable, EventTable, MethodTable, SlotTable },
  props: {
    options: {
      type: Array,
      required: true,
      default() {
        return [];
      }
    }
  },
  data() {
    return {};
  },
  created() {}
};
</script>
