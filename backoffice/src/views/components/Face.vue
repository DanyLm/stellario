<template>
  <img
    :src="face || 'https://placehold.co/192x192'"
    class="rounded-full m-auto h-52 w-52 p-2 object-cover"
  />
  <input ref="faceInput" type="file" class="hidden" accept="image/*" @change="uploadImage" />
  <div
    @click="fakeClick"
    class="h-10 w-10 bg-blue-200 rounded-full m-auto relative left-20 bottom-5 cursor-pointer"
  >
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="h-6 w-6 m-auto relative top-1.5"
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor"
      stroke-width="2"
    >
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"
      />
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
    </svg>
  </div>
</template>

<script lang="ts">
import type { PropType } from 'vue'
import { editFace } from '@/services/starApi'
import { StarInterface } from '@/models'
import { toast } from '@/services/toast'

export default {
  props: {
    src: {
      type: String,
      required: true
    },
    handle: {
      type: Function,
      required: true
    },
    star: {
      type: Object as PropType<StarInterface>,
      required: true
    }
  },
  data: function () {
    return {
      face: this.src
    }
  },
  methods: {
    fakeClick() {
      ;(this.$refs.faceInput as any).click()
    },
    async uploadImage(e: any) {
      const file = e.target.files[0]
      this.face = URL.createObjectURL(file)

      try {
        const res: any = await editFace(this.star, file)
        toast(res.toast.message, res.toast.type)
      } catch (err: any) {
        this.face = this.star.face.path
        const message: string = err.response.data.message || err.response.data.toast?.message
        const type: string =
          err.response.data.toast?.type || (err.response.data?.errors ? 'error' : 'warning')
        toast(message, type)
      }
    }
  }
}
</script>
