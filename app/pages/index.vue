<template>
  <Layout>
    <div class="sm:hidden">
      <!-- Mobile view -->
      <div v-for="(star, index) in stars" :key="index">
        <button
          @click="toggleAccordion(index)"
          v-if="!star.open"
          class="flex border border-gray-300 justify-between items-center w-full px-4 py-2 text-sm font-medium text-left text-gray-900 bg-gray-200"
        >
          {{ star.first_name }} {{ star.last_name }}
        </button>
        <div v-show="star.open" class="px-4 pt-2 pb-4">
          <Content :star="star" />
        </div>
      </div>
    </div>

    <div class="hidden sm:flex">
      <!-- Desktop view -->
      <ul class="border border-gray-200 divide-y divide-gray-300 my-10 w-56">
        <li v-for="(star, index) in stars" :key="index">
          <a
            @click="toggleAccordion(index)"
            :class="{ 'bg-white relative min-w-accordion-selected': star.open }"
            class="bg-gray-200 flex justify-between items-center px-4 py-2 text-sm font-medium text-left text-gray-900 cursor-pointer"
          >
            {{ star.first_name }} {{ star.last_name }}
            <div v-if="star.open">👉</div>
          </a>
        </li>
      </ul>
      <div class="w-3/4 p-4 border-l-2 border-l-gray-300">
        <!-- Content of the selected accordion item -->
        <Welcome v-if="!toggled" />
        <div
          v-for="(star, index) in stars"
          :key="index"
          v-show="star.open"
          class="border-l-1 border-l-gray-500"
        >
          <Content :star="star" />
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup lang="ts">
import { StarInterface } from '@/models'

const stars: any = ref([])
const toggled: any = ref(false)

const toggleAccordion = (index: number) => {
  stars.value.forEach((star: StarInterface, i: number) => {
    if (index === i) {
      star.open = !star.open
      toggled.value = star.open
    } else {
      star.open = false
    }
  })
}


const getStars = async () => {
  const res = await $fetch('/api/stars').catch((error) => console.log(error))
  stars.value = res?.data || []
}

onMounted(() => {
  getStars()
})
</script>
