<script setup lang="ts">
import { Head, Link, usePage } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
});
</script>

<template>
  <Head title="Home" />
  <div
    class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
  >
    <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
      <Link
        v-if="$page.props.auth.user"
        :href="route('dashboard')"
        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
        >Dashboard</Link
      >

      <template v-else>
        <Link
          :href="route('login')"
          class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
          >Log in</Link
        >
        <!-- 
        <Link
          v-if="canRegister"
          :href="route('register')"
          class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
          >Register</Link
        > -->
      </template>
    </div>

    <div class="max-w-7xl mx-auto p-6 lg:p-8">
      <div class="flex justify-center">
        <ApplicationLogo></ApplicationLogo>
      </div>

      <div class="mt-16">
        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aperiam ipsam
        harum porro hic natus sapiente recusandae, maxime pariatur. Harum vero
        tempora eligendi voluptates omnis ut officiis corrupti quidem voluptatum
        aperiam!
      </div>
    </div>
  </div>
</template>

<style></style>
