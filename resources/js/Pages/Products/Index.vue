<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net";
import route from "ziggy-js";
import { createRequest } from "@/helper/datatable_defaults";
import { inject, onMounted, Ref, ref } from "vue";
import { useI18n } from "vue-i18n";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { goto } from "@/helper/gotourl";
import { currency } from "@/helper/currency";

import $ from "jquery";
import Swal from "sweetalert2";

DataTable.use(DataTablesCore);

defineProps<{ canCreate?: boolean }>();

const loading: Ref<boolean> = ref(true);
const table = ref<any | null>(null);

const { t } = useI18n();

const handleActionButton = async (evt: MouseEvent) => {
  const { action, id } = $(evt.target as HTMLElement)
    .closest("button")
    .data();
  if (action === "destroy") {
    const response = await Swal.fire({
      icon: "question",
      text: t("product.confirm_delete"),
      showCancelButton: true,
      cancelButtonText: t("form.cancel"),
      focusCancel: true,
    });
    if (response.isConfirmed) {
      const form = useForm({ id });
      form.delete(route(`product.${action}`, { id }), {
        onSuccess: () => {
          table.value.dt.draw();
        },
      });
      return;
    }
  } else {
    goto(route(`product.${action}`, [id]));
  }
};

onMounted(() => {
  let dt = table.value.dt;

  $(dt.table().body()).on("click", "button[data-action]", handleActionButton);
});

const options = createRequest(route("product.pagedata"), {
  columns: [
    { data: "id", title: t("#") },
    { data: "description", title: t("Descrizione") },
    { data: "price", title: t("Prezzo"), render: currency },
    { data: "action" },
  ],
});
</script>

<template>
  <Head :title="$t('product.title')" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ $t("product.title") }}
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 flex justify-end mb-4">
        <PrimaryButton v-if="canCreate" @click="goto(route('product.create'))">
          {{ $t("product.insert") }}
        </PrimaryButton>
      </div>
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <DataTable ref="table" :options="options"> </DataTable>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
