<template>
  <div class="flex flex-col min-h-screen bg-stellario">
    <div class="text-3xl text-center py-5 uppercase font-extralight tracking-widest">Stellario 💫</div>
    <RouterView />
  </div>
</template>

<script setup lang="ts">
import { RouterView } from 'vue-router'
</script>

<style lang="scss" scoped></style>
