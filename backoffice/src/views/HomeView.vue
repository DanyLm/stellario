<template>
  <main>
    <Layout>
      <SearchBar v-model:searchInput="searchInput" :toggleModal="toggleModal" />
      <hr class="my-4" />
      <ListStars :toggleModal="toggleModal" :stars="stars" />
    </Layout>

    <StarModal
      v-if="openModal"
      :openModal="openModal"
      :searchInput="searchInput"
      :toggleModal="toggleModal"
      :star="star"
    />
  </main>
</template>

<script setup lang="ts">
import { ref, watch, type Ref, onMounted } from 'vue'
import { getStars } from '@/services/starApi'
import { Layout } from '@/components'
import { ListStars, SearchBar, StarModal } from './components'
import { StarInterface } from '@/models'

const star: Ref<StarInterface> = ref({})
const searchInput: Ref<string> = ref('')
const stars: any = ref([])
const appState: Ref<string> = ref('idle')
const openModal: Ref<boolean> = ref(false)

const toggleModal = (currentStar: any) => {
  openModal.value = !openModal.value
  star.value = openModal.value ? currentStar : {}
  fetchStars(searchInput.value)
}

const fetchStars = async (newValue: string = '', controller: AbortController | null = null) => {
  try {
    const res: any = await getStars(newValue, controller)
    stars.value = res
    appState.value = 'idle'
  } catch (err) {
    console.error(err)
  }

  appState.value = 'loading'
}

watch(searchInput, (newValue: string, oldValue: string) => {
  if (newValue !== oldValue) {
    const controller: AbortController = new AbortController()

    const inputTimeout = setTimeout(async () => fetchStars(newValue, controller), 1000)

    return () => {
      controller.abort()
      clearTimeout(inputTimeout)
    }
  }
})

onMounted(() => {
  fetchStars()
})
</script>
