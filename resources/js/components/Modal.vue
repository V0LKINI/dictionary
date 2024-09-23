<template>
  <div class="modal">
    <div tabindex="-1" class="modal-wrapper">
      <div class="modal-wrapper__inner" v-click-outside="() => $emit('closeDialog')">
        <div class="modal-content">
          <!-- Modal header -->
          <div class="modal-content-header">
            <h3 class="modal-content-header__title">
              <slot name="title"></slot>
            </h3>
            <button class="modal-content-header__button" @click="$emit('closeDialog')" type="button">
              <svg class="modal-content-header__button-icon" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
              <span class="modal-content-header__button-close">Close</span>
            </button>
          </div>
          <!-- Modal body -->
          <slot name="body"></slot>
        </div>
      </div>
    </div>
  </div>
</template>
