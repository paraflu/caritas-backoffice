<template>
  <section>
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
      <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
          {{ title }}
        </h2>
      </header>
      <FormKit type="form" @submit="$emit('submit', form)">
        <FormKit type="text" name="name" :label="$t('user.name')" v-model="form.name" validation="required"></FormKit>
        <FormKit type="password" name="password" :label="$t('user.password')" v-model="form.password"
          validation="required">
        </FormKit>
        <FormKit type="text" name="email" :label="$t('user.email')" v-model="form.email" validation="required"></FormKit>
      </FormKit>
    </div>
  </section>
</template>

<script setup lang="ts">
import { router, useForm } from "@inertiajs/vue3";
import route from "ziggy-js";

const props = defineProps<{ model?: any; title: string }>();

const form = useForm<{ id?: number, name: string, password: string, email: string }>({
  id: props.model?.id,
  name: props.model?.name,
  password: props.model.password,
  email: props.model.email
});


</script>

<style scoped></style>
