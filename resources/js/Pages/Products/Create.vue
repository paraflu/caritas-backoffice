<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Form from "@/Pages/Products/Partial/Form.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import route from "ziggy-js";

defineProps<{ status?: string }>();

const form = useForm({ description: "", price: "0 €" });

const onSubmit = () => {
  form
    .transform(({ price, description }) => ({
      description,
      price: price.replace(",", "."),
    }))
    .post(route("product.store"));
};
</script>
<template>
  <Head :title="$t('product.create')" />
  <AuthenticatedLayout>
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        {{ $t("product.create") }}
      </h2>
    </template>

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <Form
          @submit="onSubmit"
          :form="form"
          :title="$t('product.create')"
        ></Form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
