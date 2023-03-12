<script setup lang="ts">
// import { onMounted, ref } from "vue";
// import { useI18n } from "vue-i18n";

import { onMounted, ref } from "vue";
import { useCurrencyInput } from "vue-currency-input";
import { object } from "yup";

// const props = withDefaults(
//   defineProps<{
//     modelValue: any;
//     withSign?: boolean;
//     currencyChar?: string;
//     length?: number;
//     decimal?: number;
//   }>(),
//   { currencyChar: "€", decimal: 2, length: 10 }
// );

// const { t } = useI18n();

// const emit = defineEmits(["update:modelValue"]);

// const input = ref(null);

// onMounted(() => {
//   if (input.value.hasAttribute("autofocus")) {
//     input.value.focus();
//   }
// });

// defineExpose({ focus: () => input.value.focus() });

// const trimEnd = (s: string, sub: string) =>
//   s.replace(new RegExp(sub + "$"), "").trim();

// const maxlength = props.length + (props.decimal ? props.decimal + 1 : 0);

// const getDecimal = (value: string) => {
//   if (value.indexOf(",") >= 0) {
//     return value.substring(value.indexOf(",") + 1);
//   }
//   return "";
// };

// const onKeydown = (event: KeyboardEvent) => {
//   let key = event.key;
//   const allowed_char = [".", ",", ...(props.withSign ? ["+", "-"] : [])];
//   const isDigit = (c: string) => c >= "0" && c <= "9";
//   if (key) {
//     if (key.length == 1) {
//       if (isDigit(key) || allowed_char.indexOf(key) >= 0) {
//         if (key === ".") {
//           key = ",";
//         }
//         const inputElement = event.target as HTMLInputElement;
//         let currentValue = inputElement.value;

//         // inputElement.setCustomValidity("");
//         if (props.length && trimCurrency(currentValue).length == maxlength) {
//           //   inputElement.setCustomValidity(
//           //     t("Dimensione massima raggiunta del campo")
//           //   );
//           event.preventDefault();
//           return;
//         }
//         if (
//           props.decimal &&
//           getDecimal(trimCurrency(currentValue)).length >= props.decimal
//         ) {
//           //   inputElement.setCustomValidity(
//           //     t("Dimensione massima raggiunta del campo")
//           //   );
//           event.preventDefault();
//           return;
//         }
//         // inputElement.reportValidity();

//         if (
//           inputElement.validity.valid &&
//           (key !== "," || currentValue.indexOf(",") < 0)
//         ) {
//           const firstPart = currentValue.substring(
//             0,
//             inputElement.selectionStart
//           );
//           const secondPart = currentValue.substring(inputElement.selectionEnd);
//           const newValue = addCurrency(
//             trimCurrency(firstPart) + key + trimCurrency(secondPart)
//           );
//           inputElement.value = newValue;

//           inputElement.setSelectionRange(
//             newValue.length - 2,
//             newValue.length - 2
//           );
//           emit("update:modelValue", newValue);
//         }
//       }
//       event.preventDefault();
//     }
//   }
// };

// const trimCurrency = (value: string): string => {
//   if (props.currencyChar) {
//     value = trimEnd(value, props.currencyChar);
//   }
//   return value;
// };

// const addCurrency = (value: string): string =>
//   `${trimCurrency(value)} ${props.currencyChar}`;

// const onFocus = (event: FocusEvent) => {
//   const inputElement = event.target as HTMLInputElement;
//   const value = addCurrency(inputElement.value);
//   inputElement.setSelectionRange(0, value.length - 2);
// };

const props = withDefaults(
  defineProps<{ modelValue: number; options?: any }>(),
  {
    options: { currency: "EUR" },
  }
);

const emit = defineEmits(["input", "change"]);

const formattedValue = ref("");

const { inputRef } = useCurrencyInput(props.options);
</script>

<template>
  <!-- <input
      class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
      :value="modelValue"
      @focus="($event) => ($event.target as HTMLInputElement).select()"
      @keydown="onKeydown"
      :maxlength="length + decimal ?? 0 + 1"
      :size="length + decimal ?? 0 + 1"
      type="text"
      ref="input"
    /> -->
  <input type="text"
    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
    @focus="($event) => ($event.target as HTMLInputElement).select()"
    ref="inputRef" />
</template>
