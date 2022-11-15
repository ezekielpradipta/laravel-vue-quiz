<template>
  <div>
    <label
      class="block uppercase tracking-wide text-gray-700 text-xs font-bold"
    >
      <slot></slot>
      {{ judul }}
    </label>
  </div>
</template>

<script setup>
const props = defineProps({
  judul: String,
});
</script>

<style lang="scss" scoped>
</style>