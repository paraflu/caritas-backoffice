<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import WarehouseIndex from '@/Pages/Warehouse/Index.vue';
import WarehouseList from '@/Components/WarehouseList.vue';
import { goto } from '@/helper/gotourl';
import route from 'ziggy-js';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import CustomerIndex from '@/Components/CustomerIndex.vue';
import { ref } from 'vue';
import DataTables from 'datatables.net';

const warehouse_id = ref<number | null>(null);

const onElmSelect = (dt: any, type: 'row' | 'column' | 'cell', indexes: Array<number>) => {
    const { id } = dt.row(indexes[0]).data();
    warehouse_id.value = id;
}

</script>

<template>
    <Head :title="$t('navbar.dashboard')"></Head>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $t("warehouse.title") }}
            </h2>
        </template>

        <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8 space-y-6 flex justify-end mb-4">
            <PrimaryButton @click="goto(route('warehouse.create'))">
                {{ $t("warehouse.insert") }}
            </PrimaryButton>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <WarehouseList @select="onElmSelect"></WarehouseList>
        </div>
        <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8 space-y-6" v-if="warehouse_id">
            <CustomerIndex :warehouse_id="warehouse_id"></CustomerIndex>
        </div>
    </AuthenticatedLayout>
</template>
