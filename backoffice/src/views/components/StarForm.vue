<template>
  <Face v-if="data.id !== 0" :star="data" :src="face.path" :handle="handle" />
  <Field
    label="Prénom"
    name="first_name"
    placeholder="Le prénom"
    :errors="error?.errors?.first_name"
    :handle="handle"
    :value="firstName"
  />
  <Field
    :errors="error?.errors?.last_name"
    :handle="handle"
    label="Nom"
    name="last_name"
    :value="lastName"
    placeholder="Le nom"
  />
  <Field
    inputType="number"
    label="Popularité (1 à 99)"
    name="popularity"
    placeholder="99"
    :value="popularity"
    :handle="handle"
    :errors="error?.errors?.popularity"
  />
  <Field
    type="textarea"
    label="Description"
    name="description"
    placeholder="La description de cette star"
    :value="description"
    :handle="handle"
    :errors="error?.errors?.description"
  />
</template>

<script lang="ts">
import { type PropType } from 'vue'
import { StarInterface } from '@/models'
import { Field } from '@/components'
import Face from './Face.vue'

export default {
  components: {
    Field,
    Face
  },
  props: {
    star: {
      type: Object as PropType<StarInterface>,
      required: true
    },
    data: {
      type: Object as PropType<StarInterface>,
      required: true
    },
    handle: {
      type: Function,
      required: true
    },
    error: {
      type: Object as PropType<any>
    }
  },
  data: function () {
    return {
      firstName: this.star.first_name,
      lastName: this.star.last_name,
      face: this.star.face,
      popularity: `${this.star.popularity}`,
      description: this.star.description
    }
  }
}
</script>
