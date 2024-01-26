<template>
    <div class="mt-6">
        <span class="block w-full rounded-md shadow-sm">
          <button @click="closeProfileDialog"
                  type="button"
                  class=" w-full flex justify-center py-2 px-4  text-blue-600 inline-flex items-center hover:text-white
                    border border-blue-500 hover:bg-blue-600 focus:outline-none font-medium rounded-lg text-sm rounded-md
                    focus:bg-blue-500 active:bg-indigo-700 transition duration-150 ease-in-out">
            <svg class="mr-1 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                    clip-rule="evenodd"></path>
            </svg>
            Cancel
          </button>
        </span>
    </div>
</template>
