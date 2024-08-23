<template>
  <div>
    <button @click="toggleDropdown()"
            v-click-outside="() => toggleDropdown(true)"
            :value="modelValue"
            class="inline-flex items-center justify-between w-44 text-gray-500 bg-white border border-gray-300
                focus:outline-none focus:shadow-outline-blue focus:border-blue-300 hover:bg-gray-100
                font-medium rounded-lg text-sm px-3 py-2" type="button">
      <div class="inline-flex items-center">
        <svg class="w-3 h-3 text-gray-500 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
        </svg>
        {{ selectedName }}
      </div>
      <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
      </svg>
    </button>
    <!-- Dropdown menu -->
    <div v-if="showDropdown" class="absolute z-10 top-16 sm:top-20 bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
      <ul class="p-3 space-y-1 text-sm text-gray-700" aria-labelledby="dropdownRadioButton">
        <li v-for="option of options" @click="changeValue(option)">
          <div class="flex items-center p-2 rounded hover:bg-gray-100">
            <input
                id="filter-radio-example-1"
                type="radio"
                :value="option.value"
                :checked="modelValue === option.value"
                name="filter-radio"
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2"
            >
            <label for="filter-radio-example-1" class="w-full ms-2 text-sm font-medium text-gray-900 rounded">{{ option.name }}</label>
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
