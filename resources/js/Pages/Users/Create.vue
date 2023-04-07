<template>
  <Head :title="$t('user.create')" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex w-full justify-between">
        <div class="flex-grow-1">
          <h2
            class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
          >
            {{ $t("user.create") }}
          </h2>
        </div>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <UserModel></UserModel>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import UserModel from "./UserModel.vue";
import { Head } from "@inertiajs/vue3";
</script>

<style scoped></style>
