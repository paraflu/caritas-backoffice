<script setup lang="ts">
withDefaults(
  defineProps<{
    type: "submit" | "button" | "reset";
  }>(),
  { type: "submit" }
);
</script>

<template>
  <button :type="type" class="btn">
    <slot />
  </button>
</template>
