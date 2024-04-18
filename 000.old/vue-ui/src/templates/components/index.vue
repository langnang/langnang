<template>
  <div>
    <div v-for="(opt, index) in options" :key="index">
      <h1 class="title">{{ opt.title }}</h1>
      <p>{{ opt.description }}</p>
      <el-card>
        <component :is="opt.component" v-bind="opt.bind" v-on="opt.on" v-model="values[index]"></component>
      </el-card>
    </div>
  </div>
</template>
<script>
import OptionsTable from '@/components/options-table';
export default {
  components: { OptionsTable },
  props: {},
  data() {
    return {
      options: [],
      values: [],
    };
  },
  watch: {
    $route: {
      handler(route) {
        this.getOptions();
      },
      deep: true,
    },
  },
  created() {
    this.getOptions();
  },
  methods: {
    getOptions() {
      if (!this.$route.meta.options) {
        this.options = require(`@/views${this.$route.path}/options`)['default'];
      }
      // this.options.forEach(val => {
      //   this.values.push(val.value || null);
      // });
    },
  },
};
</script>
