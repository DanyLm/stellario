<template>
  <div class="mx-auto max-w-5xl py-6 pb-10 shadow-md bg-white rounded-lg mt-3">
    <slot />
  </div>
  <div class="p-4 text-center text-xs text-gray-500">Version {{ version }} © {{ years }}</div>
</template>

<script setup lang="ts">

const version: string = import.meta.env.VITE_APP_VERSION;
const years: number = new Date().getFullYear();
</script>
