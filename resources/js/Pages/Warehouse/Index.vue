<script setup lang="ts">
/** global route */
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
import route from 'ziggy-js';
import { createRequest } from '@/helper/datatable_defaults';
import { Ref, ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

DataTable.use(DataTablesCore);

const loading: Ref<boolean> = ref(true);

const options = createRequest(route('warehouse.pagedata'));

const goto = (route) => window.location.href = route;

</script>

<template>
    <Head :title="$t('warehouse.title')" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $t('warehouse.title') }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 flex justify-end mb-4">
                <PrimaryButton @click="goto(route('warehouse.create'))">
                    {{ $t('warehouse.insert') }}
                </PrimaryButton>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <DataTable :options="options">
                    <thead>
                        <tr>
                            <th>{{ $t('Mese') }}</th>
                            <th>{{ $t('Anno') }}</th>
                        </tr>
                    </thead>
                </DataTable>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
