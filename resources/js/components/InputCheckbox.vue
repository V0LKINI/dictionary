<template>
    <div class="flex items-center">
        <input id="inputCheckbox" type="checkbox" :value="value" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
        <label for="inputCheckbox" class="ml-2 block text-sm leading-5 text-gray-900">{{ label }}</label>
    </div>
</template>

<script setup>
const props = defineProps({
    label: {type: String, default: ''},
    value: {String, Number},
});
</script>
