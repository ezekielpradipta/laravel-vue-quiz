<template>
  <label
    class="block text-sm dark:text-gray-400 font-medium text-label truncate"
  >
    <div class="flex justify-between">
      <slot></slot>
      {{ Title }}
    </div>
  </label>
</template>

<script>
export default {
  name: "BaseLabel",
};
</script>

<script setup>
const props = defineProps({
  Title: {
    type: String,
    default: "",
  },
});
</script>