<template>
  <div class="ln-box" :style="{ '--height': height }">
    <slot />
  </div>
</template>
<script>
export default {
  name: "LnBox",
  props: {
    height: {
      type: String,
      default: "50%"
    }
  }
};
</script>
<style vars="{ height }">
.ln-box {
  display: flex;
  justify-content: center;
  align-items: center;
  /* // width: 100%; */
  /* // padding-bottom: 100%; padding百分比相对父元素宽度计算 */
  /* // height: 0; //避免被内容撑开多余的高度 */

  width: 100%;
  overflow: hidden;
}
.ln-box::after {
  content: "";
  display: block;
  margin-top: var(--height);
}
</style>
