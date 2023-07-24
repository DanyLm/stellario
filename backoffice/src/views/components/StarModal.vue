<template>
  <BaseModal :openModal="openModal" @close-modal="toggleModal">
    <template v-slot:title>
      <div class="flex justify-between items-baseline">
        <div>{{ data.id === 0 ? 'Création' : 'Edition' }} d'une star</div>
        <div class="text-sm font-extralight">
          {{ data.id !== 0 ? `[ id:${data.id} ]` : null }}
        </div>
      </div>
      <div v-if="data.id !== 0" class="text-sm text-right font-extralight">
        <br />
        Mis à jour le {{ data.updated_at }}
      </div>
    </template>
    <StarForm v-bind:error="error" :handle="handle" v-if="star" :star="star" :data="data" />
    <template v-slot:actions>
      <Button
        v-if="data.id !== 0"
        buttonType="button"
        color="bg-red-100 text-red-900 hover:bg-red-200 focus-visible:ring-red-500"
        :on-click="_delete"
      >
        Supprimer
      </Button>
      <Button :on-click="validate">
        {{ data.id === 0 ? 'Créer cette star' : 'Valider les changements' }}
      </Button>
    </template>
  </BaseModal>
</template>

<script setup lang="ts">
import { ref, type Ref } from 'vue'
import type { PropType } from 'vue'
import { BaseModal, Button } from '@/components'
import type { StarInterface } from '@/models'
import { StarForm } from '.'
import { editStar, deleteStar, createStar } from '@/services/starApi'

const appState: Ref<string> = ref('idle')
const error: Ref<any> = ref({})

const { star, toggleModal, openModal } = defineProps({
  star: {
    type: Object as PropType<StarInterface | null>,
    required: true
  },
  toggleModal: {
    type: Function as PropType<StarInterface>,
    required: true
  },
  openModal: {
    type: Boolean,
    required: true
  },
  searchInput: {
    type: String
  }
})

const data: Ref<StarInterface> = ref({ ...star })

const handle = (key: string, value: any) => {
  data.value[key] = value
}

const _delete = async () => {
  appState.value = 'loading'
  try {
    await deleteStar(data.value)
    appState.value = 'idle'
    toggleModal()
  } catch (err: any) {
    error.value = err.response.data
  }
}

const validate = async () => {
  appState.value = 'loading'

  try {
    if (star.id === 0) {
      const res: any = await createStar(data.value)
      data.value = { ...res.data }
    } else {
      const res: any = await editStar(data.value)
      data.value.updated_at = res.data.updated_at
    }
    appState.value = 'idle'
    error.value = {}
  } catch (err: any) {
    error.value = err.response.data
  }
}
</script>
