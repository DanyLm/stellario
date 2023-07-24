<template>
  <div class="text-md px-8 pb-6 text-right text-gray-500">
    {{ props.stars?.data?.length }} star(s) trouvée(s)
  </div>
  <div class="grid md:grid-cols-4 md:gap-6 grid-cols-2 gap-4 px-7">
    <StarCard
      @click="props.toggleModal(star)"
      v-for="star in props.stars.data"
      :key="star.id"
      :star="star"
    />
  </div>
</template>

<script setup lang="ts">
import type { PropType } from 'vue'
import type { StarInterface } from '@/models'
import StarCard from './StarCard.vue'

const props = defineProps({
  stars: {
    type: Object as PropType<{
      data: Array<StarInterface>
    }>,
    required: true
  },
  toggleModal: {
    type: Function as PropType<StarInterface>,
    required: true
  }
})
</script>
