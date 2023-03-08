<template>
    <DataTable :data="data" class="display" :options="options">
        <thead>
            <tr>
                <th>{{ $t('Mese') }}</th>
                <th>{{ $t('Anno') }}</th>
            </tr>
        </thead>
    </DataTable>
</template>

<script setup>
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
import route from 'ziggy-js';

DataTable.use(DataTablesCore);


const token = document.head.querySelector('meta[name="csrf-token"]')?.attributes.content.value;

const options = {
    serverSide: true,
    processing: true,
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
