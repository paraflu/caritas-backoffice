<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import WarehouseIndex from '@/Pages/Warehouse/Index.vue';
import WarehouseList from '@/Components/WarehouseList.vue';
import { goto } from '@/helper/gotourl';
import route from 'ziggy-js';
import PrimaryButton from '@/Components/PrimaryButton.vue';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $t("warehouse.title") }}
            </h2>
        </template>

        <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8 space-y-6 flex justify-end mb-4">
            <PrimaryButton @click="goto(route('warehouse.create'))">
                {{ $t("warehouse.insert") }}
            </PrimaryButton>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <WarehouseList></WarehouseList>
        </div>
    </AuthenticatedLayout>
</template>
