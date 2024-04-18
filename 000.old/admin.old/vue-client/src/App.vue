<template>
  <div id="app" v-loading="loading">
    <router-view />
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "App",
  computed: {
    ...mapGetters(["loading"])
  }
};
</script>
