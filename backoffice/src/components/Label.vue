<template>
  <label
    for="error"
    :class="[
      error ? 'text-red-700 dark:text-red-500' : 'text-black-700 dark:text-black-500',
      `block my-2 text-sm font-medium`
    ]"
  >
    <slot></slot>
  </label>
</template>

<script lang="ts">
export default {
  props: {
    error: {
      type: Boolean,
      default: false
    }
  }
}
</script>
