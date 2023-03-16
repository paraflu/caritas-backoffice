<template>
  <select
    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
    :value="modelValue"
    @input="onInput"
    ref="input"
  >
    <slot></slot>
  </select>
</template>

<script setup lang="ts">
import { onMounted, ref } from "vue";

defineProps<{ modelValue: any }>();

const emits = defineEmits(["update:modelValue"]);

const input = ref<HTMLSelectElement | null>(null);

onMounted(() => {
  if (input.value?.hasAttribute("autofocus")) {
    input.value?.focus();
  }
});

defineExpose({ focus: () => input.value?.focus() });

const onInput = (event: InputEvent) => emits("update:modelValue", (event.target as HTMLInputElement).value);
</script>

<style scoped>

</style>