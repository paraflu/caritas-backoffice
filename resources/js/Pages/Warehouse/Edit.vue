<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, Link } from "@inertiajs/vue3";
import { useI18n } from "vue-i18n";
import route from "ziggy-js";
import { DateTime } from "luxon";
import WarehouseForm from "./Partial/Form.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
// import InputLabel from "@/Components/InputLabel.vue";
// import TextInput from "@/Components/TextInput.vue";
// import PrimaryButton from "@/Components/PrimaryButton.vue";
// import SecondaryButton from "@/Components/SecondaryButton.vue";
// import { validate } from "@/helper/validate";

const { t } = useI18n();
const props = defineProps<{ status?: string, allow_resume: boolean, data: { id: number, month: number, year: number } }>();
const title = t("warehouse.edit");

interface Form {
  id: number,
  month: number,
  year: number
}

const form = useForm({
  id: props.data.id,
  month: props.data.month,
  year: props.data.year
});

const onSubmit = () => {
  form.put(route("warehouse.edit", [form.id]));
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
            <WarehouseForm :form="form" :action="route('warehouse.edit', [form.id])" :title="$t('warehouse.edit_title')"
                           @submit.prevent="onSubmit()">
              <input type="hidden" :value="data.id">
              <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                               :disabled="form.processing">
                  {{ $t("form.save") }}
                </PrimaryButton>
                <SecondaryButton class="ml-4" type="reset" :disabled="form.processing">
                  {{ $t("form.reset") }}
                </SecondaryButton>
              </div>
            </WarehouseForm>
          </div>
        </section>

      </div>
    </div>

  </AuthenticatedLayout>
</template>
