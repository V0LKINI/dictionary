<template>
    <div class="mt-6">
        <span class="block w-full rounded-md shadow-sm">
            <button class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white
                           bg-blue-500 hover:bg-blue-700 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo
                           active:bg-indigo-700 transition duration-150 ease-in-out" type="button">
                {{ text }}
            </button>
        </span>
    </div>
</template>

<script setup>
const props = defineProps({
    text: {type: String, default: ''},
});
</script>
