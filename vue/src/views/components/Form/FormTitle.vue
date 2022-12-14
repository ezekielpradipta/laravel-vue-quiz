<template>
  <div>
    <label class="block text-sm font-bold text-gray-700">
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