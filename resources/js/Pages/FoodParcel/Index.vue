
<template>
    <Head :title="$t('foodparcel.title')" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $t("foodparcel.title") }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 flex justify-end mb-4">
                <PrimaryButton v-if="canCreate" @click="goto(route('foodparcel.create'))">
                    {{ $t("foodparcel.insert") }}
                </PrimaryButton>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <DataTable ref="table" :options="options"> </DataTable>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup lang="ts">
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { currency } from '@/helper/currency';
import { createRequest } from '@/helper/datatable_defaults';
import { goto } from '@/helper/gotourl';
import { Head, useForm } from "@inertiajs/vue3";
import DataTablesCore from "datatables.net";
import DataTable from "datatables.net-vue3";
import { useI18n } from 'vue-i18n';
import route from 'ziggy-js';

DataTable.use(DataTablesCore);


defineProps<{ canCreate?: boolean }>();

const { t } = useI18n();

const options = createRequest(route("foodparcel.pagedata"), {
    columns: [
        { data: "id", title: t("#") },
        { data: "description", title: t("Descrizione") },
        { data: "price", title: t("Prezzo"), render: currency },
        { data: "action" },
    ],
});

</script>