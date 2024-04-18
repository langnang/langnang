<template>
  <div class="ln-progress">
    <slot name="label">
      <div class="ln-progress-label"></div>
    </slot>
    <div class="ln-progress-container">
      <div class="ln-progress--inner"></div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'LnProgress',
  props: {
    // 文本位置
    textPosition: {
      type: String,
      default: 'inner',
    },
  },
};
</script>
<style lang="scss" scoped></style>
