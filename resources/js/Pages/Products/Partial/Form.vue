<script setup lang="ts">
import route from "ziggy-js";
import { InertiaForm, useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import NumericInput from "@/Components/NumericInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps<{
  title: string;
  form: InertiaForm<{ description: string; price: number }>;
}>();

const form = useForm({
  description: "",
  price: 0,
});
</script>
<template>
  <section>
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
      <form @submit.prevent="$emit('submit')">
        <section>
          <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
              {{ title }}
            </h2>
          </header>

          <div class="mt-6">
            <InputLabel for="description" :value="$t('Descrizione')" />
            <TextInput
              id="description"
              type="text"
              class="mt-1 block w-full"
              v-model="props.form.description"
              required
              autofocus
            />
            <InputError class="mt-2" :message="props.form.errors.description" />
          </div>
          <div>
            <InputLabel for="price" :value="$t('Prezzo')" />
            <NumericInput
              id="price"
              class="mt-1 block w-full"
              v-model="props.form.price"
              :options="{ currency: 'EUR' }" 
              required
            />
            <InputError class="mt-2" :message="props.form.errors.price" />
          </div>

          <div class="flex items-center gap-4 mt-4 flex justify-end">
            <PrimaryButton :disabled="props.form.processing">{{
              $t("form.create")
            }}</PrimaryButton>
          </div>
        </section>
      </form>
    </div>
  </section>
</template>
