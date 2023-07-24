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
          class="object-cover h-56 w-48 rounded-t-lg"
          :src="star.face.path"
          :alt="`Face of ${star.first_name} ${star.last_name}`"
        />
        <hr />
        <div class="px-2 text-base pt-1 truncate md:w-48 w-32">
          {{ star.first_name }}
        </div>
        <div class="px-2 text-sm truncate md:w-48 w-32">
          {{ star.last_name }}
        </div>
        <div :class="`flex justify-end text-sm gap-2 p-2 items-center ${popularityColor()}`">
          <div class="text-xs text-gray-500 font-extralight">Popularité</div>
          <div>{{ star.popularity > 95 ? '💫' : `${star.popularity}%` }}</div>
        </div>
      </div>
    </TransitionRoot>
  </div>
</template>

<script lang="ts">
import type { PropType } from 'vue'
import { TransitionRoot } from '@headlessui/vue'
import { StarInterface } from '@/models'

export default {
  components: {
    TransitionRoot
  },
  props: {
    star: {
      type: Object as PropType<StarInterface>,
      required: true
    }
  },
  methods: {
    popularityColor: function (): string {
      if (this.star.popularity < 21) {
        return 'text-red-500'
      } else if (this.star.popularity < 40) {
        return 'text-orange-500'
      } else if (this.star.popularity < 60) {
        return 'text-black-500'
      }

      return 'text-green-500'
    }
  }
}
</script>
