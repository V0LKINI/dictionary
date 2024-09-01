<template>
  <div class="mt-6">
    <label
        class="block text-sm font-medium leading-5 text-gray-700"
        :class="{'text-red-700': isError()}"
    >
      {{ label }}
    </label>
    <div class="mt-1 rounded-md shadow-sm">
      <input
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
          @focusout="validate()"
          :type="type"
          :placeholder="placeholder"
          :autocomplete="autocomplete"
          :class="{'border-red-300 placeholder-red-400 focus:border-red-300': isError()}"
          class="appearance-none block w-full px-3 py-2 border rounded-md
                    transition duration-150 ease-in-out sm:text-sm sm:leading-5 border-gray-300 placeholder-gray-400
                    focus:outline-none focus:shadow-outline-blue focus:border-blue-300">
    </div>
    <p v-if="hint && !isError()" class="mt-2 text-sm text-gray-500">{{ hint }}</p>
    <p v-if="isError()" class="mt-2 text-sm text-red-600">{{ serverError !== '' ? serverError : v$.$errors[0].$message }}</p>
  </div>
</template>

<script setup>
import {toRefs} from "vue";

const props = defineProps({
    label: {type: String, default: ''},
    placeholder: {type: String, default: ''},
    type: {type: String, default: 'text'},
    modelValue: {type: String, default: "" },
    autocomplete: {type: String, default: ''},
    hint: {type: String, default: ''},
    v$: Object,
    serverError: Object,
});

const {v$, serverError} = toRefs(props);

function validate() {
  if (v$.value !== undefined) {
    v$.value.$touch();
  }
}

const isError = () => {
  return v$.value !== undefined && v$.value.$error || serverError.value !== undefined && serverError.value !== '';
}
</script>
