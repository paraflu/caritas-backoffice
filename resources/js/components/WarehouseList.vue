<template>
    <div class="w-full">
        <div class="flex mb-4 justify-end">
            <PrimaryButton :route="route('warehouse.create')">{{ $t('Inserisci mese') }}</PrimaryButton>
        </div>
        <DataTable :data="data" :options="options">
            <thead>
                <tr>
                    <th>{{ $t('Mese') }}</th>
                    <th>{{ $t('Anno') }}</th>
                </tr>
            </thead>
        </DataTable>
    </div>
</template>

<script setup>
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
import PrimaryButton from './PrimaryButton.vue';
import route from 'ziggy-js';

DataTable.use(DataTablesCore);


const token = document.head.querySelector('meta[name="csrf-token"]')?.attributes.content.value;

const options = {
    serverSide: true,
    processing: true,
    language: {
        url: '//cdn.datatables.net/plug-ins/1.13.3/i18n/it-IT.json'
    },
    ajax: {
        url: route('warehouse.pagedata'),
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': token }
    }
}

const data = [
    [1, 2],
    [3, 4],
];
</script>
