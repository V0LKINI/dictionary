<template>
    <router-link :to="{name: route, params: params}" class="link-router">{{ text }}</router-link>
</template>

<script setup>
const props = defineProps({
    text: {type: String, default: ''},
    route: {type: String, default: '#'},
    params: {type: JSON},
});
</script>
