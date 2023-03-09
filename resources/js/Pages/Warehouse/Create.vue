<script setup lang="ts">
/** global route */
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import route from 'ziggy-js';
import { DateTime } from 'luxon';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { validate } from '@/helper/validate';
const { t } = useI18n();


defineProps<{ status?: string, allow_resume: boolean }>();

const title = t('warehouse.create');

interface Form {
    month: number,
    year: number
}

const form = useForm({
    month: DateTime.now().month,
    year: DateTime.now().year
});

const submit = () => {
    form.post(route('warehouse.store'),);
};

const minYear = DateTime.now().year - 1;
const maxYear = DateTime.now().year + 1;

</script>

<template>
    <Head :title="title" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ title }} </h2>
        </template>


        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <section>
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <form @submit.prevent="submit">
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                    {{ $t('warehouse.create_title') }}</h2>
                                <div class="toolbar" v-if="allow_resume">
                                    <PrimaryButton>{{ $t('warehouse.previous') }}</PrimaryButton>
                                </div>
                            </header>
                            <div>
                                <InputLabel for="month" :value="$t('warehouse.mese')" />

                                <TextInput id="month" type="number" class="mt-1 block w-full" v-model="form.month" required
                                    min="1" max="12" autofocus />

                                <InputError class="mt-2" :message="form.errors.month" />
                            </div>
                            <div>
                                <InputLabel for="year" :value="$t('warehouse.year')" />

                                <TextInput id="year" type="number" class="mt-1 block w-full" v-model="form.year" required
                                    maxlength="4" size="4" :min="minYear" :max="maxYear" autofocus
                                    @keypress="validate($event, minYear, maxYear)" />

                                <InputError class="mt-2" :message="form.errors.year" />
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    {{ $t('form.create') }}
                                </PrimaryButton>
                                <SecondaryButton class="ml-4" type="reset" :disabled="form.processing">
                                    {{ $t('form.reset') }}
                                </SecondaryButton>
                            </div>
                        </form>
                    </div>
                </section>

            </div>
        </div>

    </AuthenticatedLayout>
</template>
