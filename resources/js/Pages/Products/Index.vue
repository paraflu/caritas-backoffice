<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net";
import route from "ziggy-js";
import { createRequest } from "@/helper/datatable_defaults";
import { inject, Ref, ref } from "vue";
import { useI18n } from "vue-i18n";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { goto } from "@/helper/gotourl";

DataTable.use(DataTablesCore);

defineProps<{ canCreate?: boolean }>();

const loading: Ref<boolean> = ref(true);

const { t } = useI18n();

const options = createRequest(route("product.pagedata"), {
  columns: [
    { data: "id", title: t("#") },
    { data: "description", title: t("Descrizione") },
    { data: "price", title: t("Prezzo") },
  ],
});
</script>

<template>
  <Head :title="$t('product.title')" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        {{ $t("product.title") }}
      </h2>
    </template>

    <div class="py-12">
      <div
        class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 flex justify-end mb-4"
      >
        <PrimaryButton v-if="canCreate" @click="goto(route('product.create'))">
          {{ $t("product.insert") }}
        </PrimaryButton>
      </div>
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <DataTable :options="options"> </DataTable>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
