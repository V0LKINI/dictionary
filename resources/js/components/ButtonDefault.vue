<template>
    <div class="button-default">
        <span class="button-default__wrapper">
          <button class="button-default__button" type="button">{{ text }}</button>
        </span>
    </div>
</template>

<script setup>
const props = defineProps({
    text: {type: String, default: ''},
});
</script>
