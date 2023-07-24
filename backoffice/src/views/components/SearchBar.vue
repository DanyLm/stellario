<template>
  <Disclosure as="nav">
    <div class="mx-auto max-w-7xl pt-4 px-8">
      <div class="flex items-center gap-4">
        <div class="relative w-full">
          <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg
              class="w-4 h-4 text-gray-500 dark:text-gray-400"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 20 20"
            >
              <path
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
              />
            </svg>
          </div>
          <input
            type="search"
            id="default-search"
            v-model="searchInput"
            class="block w-full p-3 pl-10 text-sm bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Rechercher ou créer une star...."
          />
        </div>
        <Button
          :on-click="create"
          color="blue"
          class="w-60 p-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        >
          Créer {{ searchInput ? 'cette' : 'une' }} star
        </Button>
      </div>
      <caption class="block text-left text-sm p-2 text-gray-500">
        Si une star n'apparaît pas vous pouvez la créer.
      </caption>
    </div>
  </Disclosure>
</template>

<script setup lang="ts">
import { computed } from 'vue'

import { Disclosure } from '@headlessui/vue'
import { Button } from '@/components'
import { StarInterface } from '@/models'
import { splitName } from '@/utils/split'

const props = defineProps(['searchInput', 'toggleModal'])
const emit = defineEmits(['update:searchInput'])

const searchInput = computed({
  get() {
    return props.searchInput
  },
  set(value) {
    emit('update:searchInput', value)
  }
})

const create = () => {
  const star: StarInterface = {
    id: 0,
    face: {},
    description: '',
    popularity: 99,
    ...splitName(searchInput.value)
  }
  props.toggleModal(star)
}
</script>
