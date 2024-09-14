<template>
  <div class="input-text">
    <label class="input-text__label" :class="{'text-red-700': isError()}">{{ label }}</label>
    <div class="text-wrapper">
      <input
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
          @focusout="validate()"
          :type="type"
          :placeholder="placeholder"
          :autocomplete="autocomplete"
          :class="{'text-wrapper__input-error': isError()}"
          class="text-wrapper__input">
    </div>
    <p v-if="hint && !isError()" class="text-wrapper__hint">{{ hint }}</p>
    <p v-if="isError()" class="text-wrapper__error">{{ serverError !== '' ? serverError : v$.$errors[0].$message }}</p>
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
