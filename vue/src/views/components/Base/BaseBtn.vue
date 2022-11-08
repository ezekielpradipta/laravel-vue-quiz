<script setup>
const props = defineProps({
  block: Boolean,
  sm: Boolean,
  xl: Boolean,
  icon: Boolean,
  rounded: Boolean,
  icon: Boolean,
  purple_outline: Boolean,
  indigo_base: Boolean,
  white_base: Boolean,
  red_outline: Boolean,
});
</script>
<template>
  <button
    class="font-medium"
    :class="[
      props.block ? 'block w-full' : 'inline-block',
      props.sm ? 'sm' : '',
      props.xl ? 'xl' : '',
      props.rounded ? 'rounded-md' : '',
      props.icon ? 'py-2.5 px-5 inline-flex ' : ' inline-flex py-2 px-5',
      props.purple_outline
        ? ' text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800'
        : '',
      props.red_outline
        ? ' text-danger hover:text-white hover:bg-danger border border-danger '
        : '',
      props.indigo_base
        ? ' bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 '
        : '',
      props.white_base
        ? ' bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 '
        : '',
    ]"
  >
    <slot />
  </button>
</template>
<style lang="scss" scoped>
// loop colors

.btn {
  font-size: 0.813rem;
  transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out,
    border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out,
    -webkit-box-shadow 0.15s ease-in-out;

  &.ripple {
    position: relative;
    overflow: hidden;
    transform: translateZ(0);
  }
  &.sm {
    font-size: 0.71137rem;
    @apply py-1 px-3;
  }
  &.xl {
    font-size: 1.18rem;
    padding: 0.75rem 2rem;
  }
}
</style>
