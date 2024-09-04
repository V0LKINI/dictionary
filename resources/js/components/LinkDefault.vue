<template>
    <a class="link-default" :href="href">{{ text }}</a>
</template>

<script setup>
const props = defineProps({
    text: {type: String, default: ''},
    href: {type: String, default: '#'},
});
</script>
