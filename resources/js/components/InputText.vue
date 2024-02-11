<template>
    <div class="mt-6">
        <label class="block text-sm font-medium leading-5 text-gray-700">{{ label }}</label>
        <div class="mt-1 rounded-md shadow-sm">
            <input
                   :value="modelValue"
                   @input="$emit('update:modelValue', $event.target.value)"
                   :type="type"
                   :placeholder="placeholder"
                   :autocomplete="autocomplete"
                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400
                          focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
        </div>
    </div>
</template>

<script>
export default {
  props: {
    label: {type: String, default: ''},
    placeholder: {type: String, default: ''},
    type: {type: String, default: 'text'},
    modelValue: {type: String, default: "" },
    autocomplete: {type: String, default: ''}
  },
}
</script>