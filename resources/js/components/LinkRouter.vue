<template>
    <router-link :to="{name: route, params: params}"
                 class="font-medium text-blue-500 hover:text-blue-500 focus:outline-none focus:underline transition ease-in-out duration-150">
        {{ text }}
    </router-link>
</template>

<script setup>
const props = defineProps({
    text: {type: String, default: ''},
    route: {type: String, default: '#'},
    params: {type: JSON},
});
</script>
