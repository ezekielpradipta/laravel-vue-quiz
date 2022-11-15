<template>
  <div v-if="telepon">
    <div class="relative">
      <div
        class="
          flex
          absolute
          inset-y-0
          left-0
          items-center
          pointer-events-none
          text-gray-700
        "
      >
        +62
      </div>
      <input
        type="text"
        :name="name"
        :id="id"
        :value="modelValue"
        v-on="nomer ? { keypress: () => isNumber($event) } : {}"
        @input="$emit('update:modelValue', $event.target.value)"
        class="
          block
          py-2.5
          px-0
          w-full
          pl-8
          text-gray-700
          bg-transparent
          border-0 border-b border-indigo-500
          appearance-none
          focus:outline-none focus:ring-0 focus:border-indigo-600
          peer
        "
        :placeholder="placeholder"
      />
    </div>
  </div>
  <div v-else>
    <input
      :type="type"
      :name="name"
      :id="id"
      :value="modelValue"
      v-on="nomer ? { keypress: () => isNumber($event) } : {}"
      @input="$emit('update:modelValue', $event.target.value)"
      class="
        block
        py-2.5
        px-0
        w-full
        text-gray-700
        bg-transparent
        border-0 border-b border-indigo-500
        appearance-none
        focus:outline-none focus:ring-0 focus:border-indigo-600
        peer
      "
      :placeholder="placeholder"
      :maxlength="maxlength"
    />
  </div>
</template>

<script setup>
const props = defineProps({
  name: String,
  id: String,
  modelValue: String,
  placeholder: String,
  type: String,
  nomer: Boolean,
  telepon: Boolean,
  maxlength: String,
});
</script>
<script>
export default {
  methods: {
    isNumber: function (evt) {
      evt = evt ? evt : window.event;
      var charCode = evt.which ? evt.which : evt.keyCode;
      if (
        charCode > 31 &&
        (charCode < 48 || charCode > 57) &&
        charCode !== 46
      ) {
        evt.preventDefault();
      } else {
        return true;
      }
    },
  },
};
</script>
<style lang="scss" scoped>
</style>