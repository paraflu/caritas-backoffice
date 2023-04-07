<template>
  <Head :title="$t('user.list')" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex w-full justify-between">
        <div class="flex-grow-1">
          <h2
            class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
          >
            {{ $t("user.list") }}
          </h2>
        </div>
        <a :href="route('users.create')" class="btn flex-grow-0">{{
          $t("user.create")
        }}</a>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <DataTable :options="options" class="w-full" ref="table"></DataTable>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import DataTable from "datatables.net-vue3";
import DataTablesCore, { Config } from "datatables.net";
import { useI18n } from "vue-i18n";
import { createRequest } from "@/helper/datatable_defaults";
import route from "ziggy-js";
import { Head, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useDatatable } from "@/composable/useDatatable";
import { ref } from "vue";
import { deleteAlert } from "@/helper/deleteAlert";
import { UserService } from "@/services/user";

DataTable.use(DataTablesCore);

const { t } = useI18n();

const options = createRequest(route("users.pagedata"), {
  columns: [
    {
      data: "id",
      name: "id",
      title: "#",
    },
    {
      data: "name",
      name: "name",
      title: t("user.name"),
    },
    {
      data: "email",
      name: "email",
      title: t("user.email"),
    },
    {
      data: "action",
      name: "action",
      orderable: false,
      searchable: false,
    },
  ],
});

const table = ref<HTMLElement | null>(null);
useDatatable(table, async ({ action, id, row }) => {
  console.log(action, id);
  switch (action) {
    case "edit":
      router.visit(route("users.edit", id));
      break;
    case "destroy":
      const res = await deleteAlert({
        title: t("user.delete_title"),
        text: t("user.delete_confirm", { name: row.name }),
      });
      if (res?.isConfirmed) {
        const srv = new UserService();
        await srv.deleteUser(Number(id!));
      }
      break;
    default:
      break;
  }
});
</script>

<style scoped></style>
