<template>
    <DataTable :data="data" class="display" :options="options">
        <thead>
            <tr>
                <th>A</th>
                <th>B</th>
            </tr>
        </thead>
    </DataTable>
</template>

<script setup>
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
import route from 'ziggy-js';

DataTable.use(DataTablesCore);

const options = {
    serverSide: true,
    processing: true,
    ajax: {
        url: route('warehouse.pagedata'),
        method: 'POST',
    }
}

const data = [
    [1, 2],
    [3, 4],
];
</script>