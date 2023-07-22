<template>
  <button
    :type="props.buttonType"
    :class="props.buttonClass || defaultClass"
    @click="props.onClick"
  >
    <slot>Annuler</slot>
  </button>
</template>

<script setup lang="ts">
import type { PropType } from 'vue'
import { computed } from 'vue'

const props = defineProps({
  buttonType: {
    type: String as () => 'button' | 'submit' | 'reset',
    default: 'button'
  },
  onClick: {
    type: Function as PropType<(event: MouseEvent) => void | undefined>
  },
  color: {
    type: String,
    default: 'blue'
  },
  buttonClass: {
    type: String
  }
})

const defaultClass = computed(
  () =>
    `rounded-md border border-transparent bg-${props.color}-100 px-4 py-2 text-sm font-medium text-${props.color}-900 hover:bg-${props.color}-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-${props.color}-500 focus-visible:ring-offset-2`
)
</script>
