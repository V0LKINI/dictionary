<template>
    <div class="input-search">
        <label for="inputSearch" class="input-search__label">{{ label }}</label>
        <div class="search-wrapper">
            <div class="search-wrapper__loupe">
                <svg class="search-wrapper__loupe-icon" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
            </div>
            <input class="search-wrapper__input"
                   id="inputSearch"
                   type="text"
                   @keyup="changeValue"
                   :placeholder="placeholder"
                   v-model="modelValue"
            >
            <div v-if="modelValue" @click="eraseValue" class="search-wrapper__eraser">
                <svg aria-hidden="true" class="search-wrapper__eraser-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </div>
        </div>
    </div>
</template>

<script setup>
import {toRefs} from "vue";

const props = defineProps({
  label: {type: String, default: ''},
  placeholder: {type: String, default: ''},
  modelValue: {type: String, default: ''},
});

const {modelValue} = toRefs(props);

const emit = defineEmits(['update:modelValue', 'keyup'])

const changeValue = (event) => {
  emit('update:modelValue', event.target.value);
  emit('keyup', event.target.value);
}
const eraseValue = () => {
    emit('update:modelValue', '');
    emit('keyup', '');
}
</script>
