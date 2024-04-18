<template>
  <a :href="link">
    <div class="anchor">
      <div class="anchor-header"></div>
      <div class="anchor-icon">
        <slot name="icon"></slot>
      </div>
      <div class="anchor-body">
        <div class="anchor-name">NAME</div>
        <div class="anchor-description">Description</div>
        <div class="anchor-keywords">Keywords</div>
      </div>
    </div>
  </a>
</template>

<script>
export default {
  name: "Anchor",
  props: {
    link: {
      type: String,
      default: "#"
    },
    icon: {
      type: String,
      default: null
    },
    name: {
      type: String,
      default: null
    },
    description: {
      type: String,
      default: null
    },
    keywords: {
      type: Array,
      default: () => ([])
    }
  },
  data() {
    return {}
  }
}
</script>

<style scoped>
.anchor {
  padding: 20px;
  width: 50%;
  background-color: grey;
  border-radius: 8px;
}
</style>