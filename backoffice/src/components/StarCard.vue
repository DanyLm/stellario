<template>
  <div class="md:h-48 md:w-48 m-auto h-32 w-32 table">
    <TransitionRoot
      appear
      :show="true"
      as="template"
      enter="transform transition duration-[400ms]"
      enter-from="opacity-0 scale-50"
      enter-to="opacity-100 scale-100"
      leave="transform duration-200 transition ease-in-out"
      leave-from="opacity-100 scale-100 "
      leave-to="opacity-0 scale-95 "
    >
      <div class="rounded-lg bg-white shadow-lg hover:bg-blue-50 hover:cursor-pointer text-center">
        <img
          class="object-cover h-28 w-48 rounded-t-lg"
          :src="star.face"
          :alt="`Face of ${star.first_name} ${star.last_name}`"
        />
        <hr />
        <div class="text-base pt-1">
          {{ star.first_name }}
        </div>
        <div class="text-sm">
          {{ star.last_name }}
        </div>
        <div :class="`text-right text-sm p-2 text-${popularityColor()}-500`">
          {{ star.popularity }}%
        </div>
      </div>
    </TransitionRoot>
  </div>
</template>

<script setup lang="ts">
import type { PropType } from 'vue'
import { TransitionRoot } from '@headlessui/vue'

// eslint-disable-next-line vue/no-setup-props-destructure
const { star } = defineProps({
  star: {
    type: Object as PropType<{
      first_name: string
      last_name: string
      face: string
      popularity: number
    }>,
    required: true
  }
})

function popularityColor(): string {
  if (star.popularity < 21) {
    return 'red'
  }

  if (star.popularity < 50) {
    return 'black'
  }

  return 'green'
}
</script>
