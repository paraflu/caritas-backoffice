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
              <InputLabel for="caritas" class="w-full text-left" :value="$t('warehouse.detail.gift')" />
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
          <DataTable :columns="columns" :data="data" class="text-black">
            <thead>
            <tr>
              <th>{{ $t("product.type") }}</th>
              <th>{{ $t("product.description") }}</th>
              <th>{{ $t("product.quantity") }}</th>
              <th>{{ $t("product.price") }}</th>
            </tr>
            </thead>
          </DataTable>
        </div>
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

import $ from "jquery";
import { computed, ref } from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import SelectInput from "@/Components/SelectInput.vue";
import { currency } from "../../helper/currency";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import route from "ziggy-js";

DataTable.use(DataTablesCore);

const { t } = useI18n();
const props = defineProps<{ status: string, warehouse: Warehouse, products: Product[], warehouse_details: WarehouseDetail[] }>();

const elm = ref<{ product?: Product, quantity: number } | null>({ product: undefined, quantity: 0 });

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
    origin: det.origin,
    product_id: det.product_id,
    quantity: det.quantity,
    price: det.price
  }))
});

const data = computed(() => form.details.map(it => {
  const product = props.products.find(p => p.id == Number(it.product_id) as number) as Product;
  return {
    description: product.description,
    price: product.price,
    type: it.origin,
    quantity: it.quantity
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

const title = ref(t("warehouse.detail_title", { month: props.warehouse.month, year: props.warehouse.year }));

const onSubmit = () => {
  form.post(route("warehouse.detail.store"));
};

const onReset = () => {
  form.details = [];
};
</script>

<style scoped>

</style>