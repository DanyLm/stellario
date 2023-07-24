<template>
  <button
    :disabled="disabled"
    :type="props.buttonType"
    :class="[
      `rounded-md mx-1 border border-transparent px-4 py-2 text-sm font-medium focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2`,
      props.color
    ]"
    @click="props.onClick"
  >
    <slot>Annuler</slot>
  </button>
</template>

<script setup lang="ts">
import type { PropType } from 'vue'

const props = defineProps({
  buttonType: {
    type: String as () => 'button' | 'submit' | 'reset',
    default: 'button'
  },
  onClick: {
    type: Function as PropType<any>
  },
  color: {
    type: String,
    default: 'bg-blue-100 text-blue-900 hover:bg-blue-200 focus-visible:ring-blue-500'
  },
  disabled: {
    type: Boolean,
    default: false
  }
})
</script>
