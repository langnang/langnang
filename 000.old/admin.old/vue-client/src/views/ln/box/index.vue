<template>
  <div class="app-container">
    <LnComponentConfigTable :options="ComponentOptions" />
  </div>
</template>
<script>
import LnComponentConfigTable from "@/views/ln/components/LnComponentConfigTable";
import ComponentOptions from "@/components/Ln/Box/options";
export default {
  name: "LnBoxView",
  components: { LnComponentConfigTable },
  data() {
    return {
      ComponentOptions
    };
  }
};
</script>
