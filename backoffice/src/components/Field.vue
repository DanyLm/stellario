<template>
  <Label :error="Boolean(errors)">
    {{ label }}
  </Label>
  <input
    :name="name"
    :type="inputType"
    :class="[
      errors ? colors.red : colors.white,
      'border text-sm rounded-lg dark:bg-gray-700 block w-full p-2.5'
    ]"
    :placeholder="placeholder"
    @input="onChange(name, $event)"
    v-model="inputValue"
    v-if="type === 'input'"
  />
  <textarea
    :name="name"
    rows="8"
    :class="[
      errors ? colors.red : colors.white,
      'border text-sm rounded-lg dark:bg-gray-700 block w-full p-2.5'
    ]"
    :placeholder="placeholder"
    @input="onChange(name, $event)"
    v-model="inputValue"
    v-if="type === 'textarea'"
  ></textarea>
  <p v-if="errors" class="mt-2 text-sm text-red-600 dark:text-red-500">
    <span class="font-medium">
      <ul>
        <li v-for="(error, index) in errors" :key="index">👉 {{ error }}</li>
      </ul>
    </span>
  </p>
</template>

<script lang="ts">
import Label from './Label.vue'

const color: any = {
  red: 'text-red bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500',
  white:
    'text-white bg-white-50 border-white-500 text-white-900 placeholder-white-700 focus:ring-white-500 focus:border-white-500 dark:text-white-500 dark:placeholder-white-500 dark:border-white-500'
}

export default {
  components: {
    Label
  },
  props: {
    name: {
      type: String,
      required: true
    },
    label: {
      type: String,
      required: true
    },
    placeholder: {
      type: String,
      default: ''
    },
    errors: {
      type: Array<String>
    },
    value: {
      type: String
    },
    inputType: {
      type: String,
      default: 'text'
    },
    handle: {
      type: Function,
      required: true
    },
    type: {
      type: String,
      default: 'input'
    }
  },
  mounted: function () {},
  data: function () {
    return {
      colors: {
        red: 'text-red bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500',
        white:
          'text-white bg-white-50 border-white-500 text-white-900 placeholder-white-700 focus:ring-white-500 focus:border-white-500 dark:text-white-500 dark:placeholder-white-500 dark:border-white-500'
      },
      color: this.error ? color.red : color.white,
      inputValue: this.value
    }
  },
  methods: {
    onChange: function (name: string, event: any) {
      this.handle(name, event.target.value)
    }
  }
}
</script>
