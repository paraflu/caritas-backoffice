<template>
  <div>

    <Head :title="title" />

    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ title }} </h2>
      </template>
      <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
      </div>
      <Card>
        <div class="mb-4">
          <InputLabel for="product_id" :value="$t('warehouse.select_product')" />
          <div class="block  md:flex">
            <div class="mr-2 grow">
              <InputLabel for="product_id" :value="$t('warehouse.detail.product')"></InputLabel>
              <SelectInput class="w-full" v-model="productForm.id">
                <option value="null">{{ $t("warehouse.detail_select_product_placeholder") }}</option>
                <option :value="prod.id" v-for="prod in products">{{ prod.description }} (
                  {{ currency(prod.price) }} )
                </option>
              </SelectInput>
              <div class="text-orange-200" v-if="form.details.find(d => d.product_id === productForm.id)">
                {{ $t("warehouse.detail.present") }}
              </div>
            </div>
            <div class="mr-2 flex flex-col md:items-end">
              <InputLabel for="caritas" class="w-full text-left" :value="$t('warehouse.detail.origin')" />
              <TextInput type="number" :min="0" v-model="productForm.gift" class="mr-2 w-20"></TextInput>
            </div>
            <div class="mr-2 flex flex-col  md:items-end">
              <InputLabel for="caritas" class="w-full text-left" :value="$t('warehouse.detail.caritas')" />
              <TextInput type="number" :min="0" v-model="productForm.caritas" class="mr-2 w-20"></TextInput>
              <InputError class="mt-2" :message="productForm.errors.caritas" />
            </div>
            <div class="flex items-end">
              <PrimaryButton
                :disabled="!productForm.isDirty || (!productForm.caritas && !productForm.gift) || !productForm.id"
                @click="addRow">+
              </PrimaryButton>
            </div>
          </div>
        </div>
        <div class="mb-4 text-black">
          <DataTable :columns="columns" :data="data" class="text-black" ref="table">
            <thead>
              <tr>
                <th>{{ $t("product.type") }}</th>
                <th>{{ $t("product.description") }}</th>
                <th>{{ $t("product.quantity") }}</th>
                <th>{{ $t("product.price") }}</th>
                <th>{{ $t('warehouse.detail.action') }}</th>
              </tr>
            </thead>
          </DataTable>
        </div>
        <Modal :show="showModal" @close="closeModal">
          <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
              Are you sure you want to delete your account?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
              Once your account is deleted, all of its resources and data will be permanently deleted. Please
              enter your password to confirm you would like to permanently delete your account.
            </p>

            <div class="mt-6">
              <InputLabel for="password" value="Password" class="sr-only" />

              <TextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                class="mt-1 block w-3/4" placeholder="Password" />

              <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
              <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

              <DangerButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Delete Account
              </DangerButton>
            </div>
          </div>
        </Modal>
        <template #footer>
          <PrimaryButton @click="onSubmit" class="mr-2">{{ $t("form.save") }}</PrimaryButton>
          <SecondaryButton @click="onReset">{{ $t("form.reset") }}</SecondaryButton>
        </template>
      </Card>
    </AuthenticatedLayout>
  </div>
</template>

<script setup lang="ts">
import { Head, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Product } from "@/types/product";
import { Warehouse } from "@/types/warehouse";
import { WarehouseDetail } from "@/types/warehousedetail";
import { useI18n } from "vue-i18n";
import Card from "@/Components/Card.vue";
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net";

import { computed, ref, watchEffect } from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import SelectInput from "@/Components/SelectInput.vue";
import { currency } from "../../helper/currency";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import route from "ziggy-js";
import { useDatatable } from "@/composable/useDatatable";
import Swal from "sweetalert2";
import { WarehouseService } from "@/services";

DataTable.use(DataTablesCore);

const { t } = useI18n();
const table = ref<any | null>(null);
const props = defineProps<{ status: string, warehouse: Warehouse, products: Product[], warehouse_details: WarehouseDetail[] }>();

const elm = ref<{ product?: Product, quantity: number } | null>({ product: undefined, quantity: 0 });
const showModal = ref(false);
const title = ref(t("warehouse.detail_title", { month: props.warehouse.month, year: props.warehouse.year }));

const { onAction, redraw } = useDatatable(table);

const columns = [
  {
    data: "type",
    render: (data: string) => t(`warehouse.detail.${data}`),
    title: t("warehouse.detail.type")
  },
  { data: "description" },
  { data: "quantity" },
  {
    data: "price",
    render: (price: number) => currency(price)
  },
  {
    data: 'action',
    sortable: false,
    title: ''
  }
];

const productForm = useForm<{
  id?: number,
  caritas?: number,
  gift?: number
}>({
  id: 0
});

productForm.defaults({
  id: "",
  caritas: "",
  gift: ""
});

const form = useForm<{ warehouse_id: number, details: Partial<WarehouseDetail>[] }>({
  warehouse_id: props.warehouse.id as number,
  details: props.warehouse_details.map(det => ({
    id: det.id,
    origin: det.origin,
    product_id: det.product_id,
    quantity: det.quantity,
    price: det.price
  }))
});


watchEffect(async () => {
  if (onAction.value) {
    const { action, id } = onAction.value;
    console.log('action', action, 'id', id);
    switch (action) {
      case 'delete':
        const response = await Swal.fire({ icon: 'question', text: t('warehouse.detail.confirm_delete'), showCancelButton: true, focusCancel: true });
        if (response.isConfirmed) {
          const ws = new WarehouseService();
          // await ws.deleteDetail(Number(id));
          redraw();
        }
        break;
      case 'edit':
        {

        }

      default:
        break;
    }
  }
});

const buildActionButton = (it: Partial<WarehouseDetail>, product: Product) => {
  return [
    {
      action: 'edit',
      caption: t('warehouse.detail.edit'),
      icon: `<i class="fa-solid fa-pen-to-square"></i>`
    },
    {
      action: 'delete',
      caption: t('warehouse.detail.delete'),
      class: 'danger',
      icon: '<i class="fa-solid fa-trash"></i>'
    }
  ].map(({ action, caption, icon, class: className }: { action: string, caption: string, class?: string, icon: string }) => {
    return `<button data-action="${action}" data-id="${it.id}" class="btn btn-primary mr-2 ${className}" title="${caption}"><span class="">${icon}</span></button>`;
  }).join('');
}

const data = computed(() => form.details.map(it => {
  const product = props.products.find(p => p.id == Number(it.product_id) as number) as Product;
  return {
    description: product.description,
    price: product.price,
    type: it.origin,
    quantity: it.quantity,
    action: `<div class="flex justify-end">${buildActionButton(it, product)}</div>`
  };
}));

const addRow = () => {
  // prima cancello tutte le occorrenze

  form.details = form.details.filter(({ product_id }) => product_id !== productForm.id);

  const { id: product_id, price } = props.products.find(it => it.id === Number(productForm.id)) as Product;

  if (productForm.caritas) {
    form.details.push({ product_id, quantity: productForm.caritas, origin: "caritas", price });
  }
  if (productForm.gift) {
    form.details.push({ product_id, quantity: productForm.gift, origin: "donation", price });
  }
  productForm.reset("id", "caritas", "gift");
};




const closeModal = () => {
  showModal.value = false;
}

const onSubmit = () => {
  form.post(route("warehouse.detail.store"));
};

const onReset = () => {
  form.details = [];
};

</script>

<style scoped></style>