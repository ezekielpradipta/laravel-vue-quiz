<template>
  <form @submit="onSubmit">
    <div class="flex mb-4">
      <button
        v-if="hasPrevious"
        type="button"
        @click="goToPrev"
        class="
          focus:outline-none
          text-white
          bg-purple-700
          hover:bg-purple-800
          focus:ring-4 focus:ring-purple-300
          font-medium
          rounded-lg
          text-sm
          px-5
          py-2.5
          mb-2
          mr-6
          dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900
        "
      >
        Previous
      </button>
      <button
        type="submit"
        class="
          focus:outline-none
          text-white
          bg-purple-700
          hover:bg-purple-800
          focus:ring-4 focus:ring-purple-300
          font-medium
          rounded-lg
          text-sm
          px-5
          py-2.5
          mb-2
          dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900
        "
      >
        {{ isLastStep ? "Submit" : "Next" }}
      </button>
    </div>
    <slot></slot>
  </form>
</template>

<script setup>
import { ref, computed, provide } from "vue";
import { useForm } from "vee-validate";
const FormData = ref({});
const currentStepIndex = ref(0);
const emit = defineEmits(["next", "submit"]);
const stepCounter = ref(0);
provide("STEP_COUNTER", stepCounter);
provide("CURRENT_STEP_INDEX", currentStepIndex);

const isLastStep = computed(() => {
  return currentStepIndex.value === stepCounter.value - 1;
});
const hasPrevious = computed(() => {
  return currentStepIndex.value > 0;
});
const { resetForm, handleSubmit } = useForm();
const onSubmit = handleSubmit((value) => {
  FormData.value = {
    ...FormData.value,
    ...value,
  };
  resetForm({
    values: {
      ...FormData.value,
    },
  });
  if (!isLastStep.value) {
    currentStepIndex.value++;
    emit("next", FormData.value);
    return;
  }
  emit("submit", FormData.value);
});
function goToPrev() {
  if (currentStepIndex.value === 0) {
    return;
  }
  currentStepIndex.value--;
  resetForm({
    values: {
      ...FormData.value,
    },
  });
}
</script>

<style lang="scss" scoped>
</style>