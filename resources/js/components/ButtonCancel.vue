<template>
    <div class="button-cancel">
        <span class="button-cancel__wrapper">
          <button @click="closeProfileDialog" type="button" class="button-cancel__button">{{ text }}</button>
        </span>
    </div>
</template>

<script setup>
const props = defineProps({
  text: {type: String, default: 'Cancel'},
});
</script>