<template>
  <form method="post" :action="action" @submit.prevent="$emit('submit', $event)">
    <header>
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
        {{ title }}</h2>
      <div class="toolbar" v-if="allow_resume">
        <PrimaryButton>{{ $t("warehouse.previous") }}</PrimaryButton>
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

    <slot>
      <div class="flex items-center justify-end mt-4">
        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                       :disabled="form.processing">
          {{ $t("form.create") }}
        </PrimaryButton>
        <SecondaryButton class="ml-4" type="reset" :disabled="form.processing">
          {{ $t("form.reset") }}
        </SecondaryButton>
      </div>
    </slot>
  </form>
</template>

<script setup lang="ts">
import { InertiaForm } from "@inertiajs/vue3";
import { DateTime } from "luxon";
import { validate } from "@/helper/validate";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

defineEmits(["submit"]);
defineProps<{ title: string, action: string, form: InertiaForm<any> }>();

const minYear = DateTime.now().year - 1;
const maxYear = DateTime.now().year + 1;

</script>