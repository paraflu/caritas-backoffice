
<template>
    <DataTable ref="table" :options="options"> </DataTable>
</template>
<script setup lang="ts">
import { currency } from '@/helper/currency';
import { createRequest } from '@/helper/datatable_defaults';
import DataTablesCore from "datatables.net";
import DataTable from "datatables.net-vue3";
import { useI18n } from 'vue-i18n';
import route from 'ziggy-js';

DataTable.use(DataTablesCore);

const props = defineProps<{ warehouse_id?: number }>();

const { t } = useI18n();

const options = createRequest(props.warehouse_id ? route('customer.pagedata') : route("customer.pagedataByWarehouse", { warehouse: props.warehouse_id! }), {
    columns: [
        { data: "id", title: t("#") },
        { data: "description", title: t("Descrizione") },
        { data: "price", title: t("Prezzo"), render: currency },
        { data: "action" },
    ],
});

</script>