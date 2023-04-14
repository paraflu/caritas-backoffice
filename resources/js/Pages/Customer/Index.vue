
<template>
    <Head :title="$t('customer.title')" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $t("customer.title") }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 flex justify-end mb-4">
                <PrimaryButton v-if="canCreate" @click="goto(route('customer.create'))">
                    {{ $t("customer.insert") }}
                </PrimaryButton>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <CustomerIndex></CustomerIndex>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup lang="ts">
import CustomerIndex from '@/Components/CustomerIndex.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { goto } from '@/helper/gotourl';
import { Head } from "@inertiajs/vue3";
import route from 'ziggy-js';

defineProps<{ canCreate?: boolean }>();
</script>