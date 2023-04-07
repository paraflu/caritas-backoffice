<template>
  <section>
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
      <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
          {{ title }}
        </h2>
      </header>
      <FormKit type="form">
        <FormKit type="hidden" name="id" v-if="model?.id"></FormKit>
        <FormKit
          type="text"
          name="name"
          :label="$t('user.name')"
          validation="required"
        ></FormKit>
        <FormKit
          type="text"
          name="name"
          :label="$t('user.email')"
          validation="required"
        ></FormKit>
      </FormKit>
    </div>
  </section>
</template>

<script setup lang="ts">
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps<{ model?: any; title: string }>();

const form = useForm({});

const submit = () => {};
</script>

<style scoped></style>
