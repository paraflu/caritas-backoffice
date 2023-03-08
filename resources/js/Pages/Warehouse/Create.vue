<script setup lang="ts">
/** global route */
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import route from 'ziggy-js';
const { t } = useI18n();

const title = t('warehouse.create');

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('warehouse.store'), {
        onFinish: () => form.reset('password'),
    });
};

</script>

<template>
    <Head :title="title" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ title }} </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <form method="POST"></form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
