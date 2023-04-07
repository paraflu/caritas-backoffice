<script setup lang="ts">
/** global route */
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net";
import route from "ziggy-js";
import { createRequest } from "@/helper/datatable_defaults";
import { Ref, ref } from "vue";
import { useI18n } from "vue-i18n";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { goto } from "@/helper/gotourl";
import Swal from "sweetalert2";
import { currency } from "@/helper/currency";
import { Action, useDatatable } from "@/composable/useDatatable";

DataTable.use(DataTablesCore);

const loading: Ref<boolean> = ref(true);

const { t } = useI18n();
const table = ref<HTMLTableElement | null>(null);

const { redraw } = useDatatable(table, async ({ action, id }: Action) => {
  if (action === "destroy") {
    const response = await Swal.fire({
      icon: "question",
      text: t("warehouse.confirm_delete"),
      showCancelButton: true,
      cancelButtonText: t("form.cancel"),
      focusCancel: true,
    });
    if (response.isConfirmed) {
      const form = useForm({ id });
      form.delete(route(`warehouse.${action}`, { id: id! }), {
        onSuccess: () => {
          redraw();
        },
      });
      return;
    }
  } else {
    goto(route(`warehouse.${action}`, { id: id! }));
  }
});

const options = createRequest(route("warehouse.pagedata"), {
  columns: [
    { data: "month", title: t("Mese") },
    { data: "year", title: t("Anno") },
    {
      data: "details.total",
      title: t("Numero prodotti"),
      className: "text-right",
    },
    {
      data: "details.cost",
      title: t("Totale"),
      className: "text-right",
      render: (data: number) => currency(data),
    },
    { data: "action" },
  ],
});
</script>

<template>
  <Head :title="$t('warehouse.title')" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        {{ $t("warehouse.title") }}
      </h2>
    </template>

    <div class="py-12">
      <div
        class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 flex justify-end mb-4"
      >
        <PrimaryButton @click="goto(route('warehouse.create'))">
          {{ $t("warehouse.insert") }}
        </PrimaryButton>
      </div>
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <DataTable :options="options" ref="table"> </DataTable>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
