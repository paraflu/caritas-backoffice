<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
  <v-app id="inspire">
    <v-app-bar title="Application bar"></v-app-bar>
    <v-navigation-drawer model-value class="pt-4" color="grey-lighten-3" rail>
      <v-avatar
        v-for="n in 6"
        :key="n"
        :color="`grey-${n === 1 ? 'darken' : 'lighten'}-1`"
        :size="n === 1 ? 36 : 20"
        class="d-block text-center mx-auto mb-9"
      ></v-avatar>
    </v-navigation-drawer>

    <v-main class="mt-6 ml-6">
      <slot name="header" />
      <main>
        <slot></slot>
      </main>
    </v-main>
  </v-app>
</template>
