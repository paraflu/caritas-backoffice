<template>
  <div>

    <Head :title="title"></Head>

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
              <div class="text-orange-200" v-if="details.includes(Number(productForm.id))">
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
          <DataTable :options="options" class="text-black" ref="table"></DataTable>
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
import DataTablesCore, { Config } from "datatables.net";

import { defineAsyncComponent, nextTick, onMounted, ref, watchEffect } from "vue";

import { currency } from "../../helper/currency";
import route from "ziggy-js";
import { Action, useDatatable } from "@/composable/useDatatable";
import Swal from "sweetalert2";
import { WarehouseService } from "@/services";
import { reportError } from "@/helper/reporterror";
import { createRequest } from "@/helper/datatable_defaults";
import { useCsrf } from "@/composable/usecsrf";
const Modal = defineAsyncComponent(() => import("@/Components/Modal.vue"));
const InputLabel = defineAsyncComponent(() => import("@/Components/InputLabel.vue"));
const TextInput = defineAsyncComponent(() => import("@/Components/TextInput.vue"));
const InputError = defineAsyncComponent(() => import("@/Components/InputError.vue"));
const SelectInput = defineAsyncComponent(() => import("@/Components/SelectInput.vue"));
const PrimaryButton = defineAsyncComponent(() => import("@/Components/PrimaryButton.vue"));
const SecondaryButton = defineAsyncComponent(() => import("@/Components/SecondaryButton.vue"));

DataTable.use(DataTablesCore);

const { t } = useI18n();
const table = ref<any | null>(null);
const props = defineProps<{ status: string, errors?: object, warehouse: Warehouse, products: Product[], warehouse_details: WarehouseDetail[] }>();

const elm = ref<{ product?: Product, quantity: number } | null>({ product: undefined, quantity: 0 });

const showModal = ref(false);
const title = ref(t("warehouse.detail_title", { month: props.warehouse.month, year: props.warehouse.year }));
const ws = new WarehouseService();

const details = ref<Array<number>>([]);
const { csrf } = useCsrf();

watchEffect(() => {
  if (props.errors && Object.values(props.errors).length) {
    reportError({ message: Object.values(props.errors) });
  }
})

const onActionCallback = async ({ action, id }: Action) => {
  console.log('action', action, 'id', id);
  switch (action) {
    case 'destroy':
      const response = await Swal.fire({ icon: 'question', text: t('warehouse.detail.confirm_delete'), showCancelButton: true, focusCancel: true });
      if (response.isConfirmed) {
        try {
          await ws.deleteDetail(Number(id));
          redraw()
        } catch (err) {
          console.error(err);
          reportError(err);
        }
      }
      break;
    case 'edit':
      {

      }

    default:
      break;
  }
}

const { redraw, dtInstance } = useDatatable(table, onActionCallback);

const columns = [
  {
    data: "origin",
    render: (data: string) => t(`warehouse.detail.${data}`),
    title: t("warehouse.detail.type")
  },
  { data: "product.description", name: 'product.description' },
  { data: "quantity" },
  { data: "id" },
  {
    data: "price",
    render: (price: number) => currency(price)
  },
  {
    data: 'action',
    title: '',
    sortable: false
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

interface FormDetail {
  warehouse_id: number,
  product_id: number,
  origin: 'caritas' | 'donation',
  price: number,
  quantity: number
};

const addRow = () => {
  const { id: product_id, price } = props.products.find(it => it.id === Number(productForm.id)) as Product;
  const formInsert = useForm<{ warehouse_id: number, details: FormDetail[] }>({ warehouse_id: props.warehouse.id!, details: [] });
  const payload: FormDetail[] = [];
  if (productForm.caritas) {
    payload.push({
      warehouse_id: props.warehouse.id as number,
      product_id: product_id as number,
      quantity: Number(productForm.caritas),
      origin: 'caritas',
      price
    })
  }
  if (productForm.gift) {
    payload.push({
      warehouse_id: props.warehouse.id as number,
      product_id: product_id as number,
      quantity: Number(productForm.gift),
      origin: 'donation',
      price
    })
  }

  formInsert.details = payload;
  formInsert.post(
    route('warehouse.detail.store'),
    {
      onSuccess: () => {
        productForm.reset("id", "caritas", "gift");
        redraw();
      },
    }
  )
};


const options: Config = createRequest(route('warehouse.detail.index', { id: props.warehouse.id as number }), {
  columns,
  ajax: (req, callback) => {
    ws.detail(props.warehouse.id!, req).then(data => {
      details.value = data.data.map((r: any) => r.product.id);
      callback(data);
    });


    //   console.log(_data, data, callback);
    //   details.value = data.data;
    //   callback(data);
    // })
    //  route('warehouse.detail.index', { id: props.warehouse.id as number }),
    // headers: { 'X-CSRF-TOKEN': csrf.value },
    // method: 'POST',
    // success: (e) => {
    //   console.info(e);
    // }
  }
});


const closeModal = () => {
  showModal.value = false;
}

// const onSubmit = () => {
//   form.post(route("warehouse.detail.store"));
// };

// const onReset = () => {
//   form.details = [];
// };

</script>

<style scoped></style>