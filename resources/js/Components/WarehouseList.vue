<template>
    <DataTable :options="options" ref="table"> </DataTable>
</template>
<script setup lang="ts">
import { goto } from "@/helper/gotourl";
import Swal from "sweetalert2";
import { currency } from "@/helper/currency";
import { Action, useDatatable } from "@/composable/useDatatable";
import route from "ziggy-js";
import { createRequest } from "@/helper/datatable_defaults";
import { useForm } from "@inertiajs/vue3";
import { Ref, ref } from "vue";
import { useI18n } from "vue-i18n";
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net";
import Select from 'datatables.net-select';

DataTable.use(DataTablesCore);
DataTable.use(Select);

const loading: Ref<boolean> = ref(true);

const emits = defineEmits(['select']);

const { t } = useI18n();
const table = ref<HTMLTableElement | null>(null);

const { redraw } = useDatatable(table, async ({ action, id, payload }: Action) => {
    switch (action) {
        case 'destroy':
            {
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
                break;
            }
        case 'select':
            {
                emits('select', ...payload);
                break;
            }
        default:
            goto(route(`warehouse.${action}`, { id: id! }));
            break;
    }
}, ['select']);

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
    select: {
        style: 'single'
    }
});
</script>