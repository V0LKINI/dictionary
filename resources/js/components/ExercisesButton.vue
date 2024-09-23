<template class="exercises-button">
 <button
   type="button"
   class="exercises-button__button"
   @click="toggleDropdown()"
   v-click-outside="() => toggleDropdown(true)"
 >
  <svg class="exercises-button__button-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
   <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
  </svg>
 </button>
 <div v-if="showDropdown" class="exercises-button__dropdown">
  <div class="exercises-button__dropdown-title">Exercises</div>
  <div class="exercises-button__dropdown-body">
   <router-link :to="{name: 'FindTranslation'}" class="exercises-button__dropdown-item">
    <svg class="exercises-button__dropdown-icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Zm2 0V2h7a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Zm-1.02 4.804a1 1 0 1 0-1.96.392l1 5a1 1 0 0 0 1.838.319L12 15.61l1.143 1.905a1 1 0 0 0 1.838-.319l1-5a1 1 0 0 0-1.962-.392l-.492 2.463-.67-1.115a1 1 0 0 0-1.714 0l-.67 1.116-.492-2.464Z" clip-rule="evenodd"/></svg>
    <div class="exercises-button__dropdown-text">Find translation</div>
   </router-link>
   <router-link :to="{name: 'FindTranslation'}" class="exercises-button__dropdown-item">
    <svg class="exercises-button__dropdown-icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Zm2 0V2h7a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Zm-1.02 4.804a1 1 0 1 0-1.96.392l1 5a1 1 0 0 0 1.838.319L12 15.61l1.143 1.905a1 1 0 0 0 1.838-.319l1-5a1 1 0 0 0-1.962-.392l-.492 2.463-.67-1.115a1 1 0 0 0-1.714 0l-.67 1.116-.492-2.464Z" clip-rule="evenodd"/></svg>
    <div class="exercises-button__dropdown-text">Find word</div>
   </router-link>
  </div>
 </div>
</template>

<script setup>
 import {ref} from "vue";

 const showDropdown = ref(false)

 const toggleDropdown = (clickOutside = false) => {
  if (clickOutside) {
   showDropdown.value = false;
  } else {
   showDropdown.value = !showDropdown.value;
  }
 }
</script>