<template>
  <div class="mx-auto max-w-5xl shadow-md bg-white rounded-lg w-full">
    <slot />
  </div>
  <div class="p-4 text-center text-xs text-gray-500">Version {{ version }} © {{ years }}</div>
</template>

<script setup lang="ts">
const config = useRuntimeConfig()
const version: string = config.public.version
const years: number = new Date().getFullYear()
</script>
