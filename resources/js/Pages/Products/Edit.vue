<script setup lang="ts">
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { goto } from "@/helper/gotourl";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Form from "@/Pages/Products/Partial/Form.vue";
import { Product } from "@/types/product";
import { Head, useForm, router } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import route from "ziggy-js";

const props = defineProps<{ status?: string, product: Product }>();

const form = useForm({ description: props.product.description, price: props.product.price });

const onSubmit = () => {
  form
    .transform(data => ({ ...data, id: props.product.id }))
    .put(route("product.update", { id: props.product.id }), {
      onError: err => {
        console.error(err);
        Swal.fire({ icon: 'error', text: `${Object.keys(err).map(k => err[k]).join("<br/>")}` })
      }
    });
};
</script>
<template>
  <Head :title="$t('product.edit')" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ $t("product.edit") }}
      </h2>
    </template>

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <Form @submit.stop="onSubmit" :form="form" :title="$t('product.edit')">
          <template #footer>
            <PrimaryButton :disabled="form.processing">{{
              $t("form.edit")
            }}</PrimaryButton>
            <SecondaryButton @click="goto(route('product.index'))">{{ $t('form.back') }}</SecondaryButton>
          </template>
        </Form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
