<script setup lang="ts">
import { Label } from '.'
</script>

<template>
  <Label :color="color">
    {{ label }}
  </Label>
  <textarea
    :name="name"
    id="message"
    rows="8"
    :class="`text-${
      error ? 'red' : 'white'
    } bg-${color}-50 border border-${color}-500 text-${color}-900 placeholder-${color}-700 text-sm rounded-lg focus:ring-${color}-500 dark:bg-gray-700 focus:border-${color}-500 block w-full p-2.5 dark:text-${color}-500 dark:placeholder-${color}-500 dark:border-${color}-500`"
    :placeholder="placeholder"
    :value="inputValue"
  ></textarea>
  <p v-if="error" class="mt-2 text-sm text-red-600 dark:text-red-500">
    <span class="font-medium">{{ error?.msg }}</span>
  </p>
</template>

<script lang="ts">
import { type PropType } from 'vue'

export default {
  props: {
    name: {
      type: String,
      required: true
    },
    label: {
      type: String,
      required: true
    },
    placeholder: {
      type: String
    },
    error: {
      type: Object as PropType<any>
    },
    value: {
      type: String
    }
  },
  mounted: function () {},
  data: function () {
    return {
      color: this.error ? 'red' : 'black',
      inputValue: this.value
    }
  },
  watch: {}
}
</script>
