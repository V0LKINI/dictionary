<template>
    <div class="input-checkbox">
        <input class="input-checkbox__input" id="inputCheckbox" type="checkbox" :value="value">
        <label class="input-checkbox__label" for="inputCheckbox">{{ label }}</label>
    </div>
</template>

<script setup>
const props = defineProps({
    label: {type: String, default: ''},
    value: {String, Number},
});
</script>
