<template>
  <div class="input-dropdown">
    <button @click="toggleDropdown()"
            v-click-outside="() => toggleDropdown(true)"
            :value="modelValue"
            class="dropdown-button" type="button">
      <span class="dropdown-button__selected">
        <svg class="dropdown-button__time" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
        </svg>
        {{ selectedName }}
      </span>
      <svg class="dropdown-button__arrow" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
      </svg>
    </button>
    <!-- Dropdown menu -->
    <div v-if="showDropdown" class="dropdown-menu">
      <ul class="dropdown-menu__list" aria-labelledby="dropdownRadioButton">
        <li v-for="option of options" @click="changeValue(option)">
          <div class="dropdown-menu__wrapper">
            <input
                id="filter-radio-example-1"
                type="radio"
                :value="option.value"
                :checked="modelValue === option.value"
                name="filter-radio"
                class="dropdown-menu__input"
            >
            <label for="filter-radio-example-1" class="dropdown-menu__label">{{ option.name }}</label>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import {onMounted, ref, toRefs} from "vue";

const props = defineProps({
  options: Array,
  modelValue: {type: [String, Number], default: ''},
});

const {modelValue, options} = toRefs(props);
const emit = defineEmits(['update:modelValue'])

const selectedName = ref('')

const changeValue = (option) => {
  selectedName.value = option.name
  emit('update:modelValue', option.value)
}

onMounted(() => {
  options.value.forEach(function (item, index, array) {
    if (item.selected) {
      modelValue.value = item.value;
      selectedName.value = item.name;
    }
  });
})

//Dropdown
const showDropdown = ref(false)

const toggleDropdown = (clickOutside = false) => {
  if (clickOutside) {
    showDropdown.value = false;
  } else {
    showDropdown.value = !showDropdown.value;
  }
}

</script>
