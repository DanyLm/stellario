<template>
  <img
    :src="star.face.path"
    class="object-cover h-56 w-56 mr-4 float-left shadow-lg border-white border-8 hidden md:block"
  />
  <div class="md:text-2xl text-xl font-bold">{{ star.first_name }} {{ star.last_name }}</div>
  <div :class="`flex text-md gap-2 items-center pb-4 ${popularityColor()}`">
    <div class="text-md text-gray-500 font-extralight">Popularité</div>
    <div>{{ star.popularity > 95 ? '💫' : `${star.popularity}%` }}</div>
  </div>

  <img
    :src="star.face.path"
    class="object-cover h-40 w-40 mr-4 float-left shadow-lg border-white border-8 md:hidden"
  />

  <div v-html="star.description" class="text-justify" />
</template>

<script setup lang="ts">
import type { PropType } from 'vue'
import { StarInterface } from '@/models'

const { star } = defineProps({
  star: {
    type: Object as PropType<StarInterface>,
    required: true
  }
})

function popularityColor(): string {
  if (star.popularity < 21) {
    return 'text-red-500'
  } else if (star.popularity < 40) {
    return 'text-orange-500'
  } else if (star.popularity < 60) {
    return 'text-black-500'
  }

  return 'text-green-500'
}
</script>
