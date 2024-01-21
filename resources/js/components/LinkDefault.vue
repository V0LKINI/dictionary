<template>
    <a class="font-medium text-blue-500 hover:text-blue-500 focus:outline-none focus:underline transition ease-in-out duration-150" :href="href">
        {{ text }}
    </a>
</template>

<script setup>
const props = defineProps({
    text: {type: String, default: ''},
    href: {type: String, default: '#'},
});
</script>
