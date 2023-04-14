<template>
  <section>
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
      <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
          {{ title }}
        </h2>
      </header>
      <FormKit type="form" @submit="$emit('submit')" :value="form">
        <FormKit type="text" name="name" :label="$t('user.name')" validation="required"></FormKit>
        <FormKit type="password" name="password" :label="$t('user.password')"
          validation="required|length:6|matches:/[^a-zA-Z]/">
        </FormKit>
        <FormKit v-if="!form.id" type="password" name="password_confirm" :label="$t('user.confirm')"
          validation="required|confirm">
        </FormKit>
        <FormKit type="text" name="email" :label="$t('user.email')" validation="required">
        </FormKit>
      </FormKit>
    </div>
  </section>
</template>

<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";

defineEmits(['submit']);

const props = defineProps<{ model?: any; title: string }>();

const form = useForm<{ id?: number, name: string, password: string, email: string, confirm?: string }>({
  id: props.model?.id,
  name: props.model?.name,
  password: props.model?.id ? 'FAKE_PASSWORD' : '',
  email: props.model?.email,
  confirm: ''
});

</script>

<style scoped></style>
