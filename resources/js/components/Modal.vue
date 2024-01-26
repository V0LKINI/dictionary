<template>
  <div class="flex bg-gray-900 bg-opacity-50 fixed inset-0 z-60">
    <div tabindex="-1" class="flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
      <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow sm:p-5 overflow-hidden">
          <!-- Modal header -->
          <div class="p-1 flex justify-between items-center rounded-t border-b">
            <h3 class="text-lg font-semibold text-gray-900">
              <slot name="title"></slot>
            </h3>
            <button @click="$emit('closeDialog')" type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
              <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                      clip-rule="evenodd"></path>
              </svg>
              <span class="sr-only">Close</span>
            </button>
          </div>
          <!-- Modal body -->
          <slot name="body"></slot>
        </div>
      </div>
    </div>
  </div>
</template>
