<template>
    <div class="min-h-screen bg-gray-50 flex flex-col py-6 sm:px-6 lg:px-8 px-6">
        <div class="flex flex-column flex-col-reverse sm:flex-row  flex-wrap  justify-between">
            <div class="flex flex-column sm:flex-row flex-wrap justify-start space-y-4 sm:space-y-0 items-center gap-x-2 mb-4">
              <input-dropdown/>
              <input-search label="Search" placeholder="Search for words"/>
              <button-default text="Add new translation"/>
            </div>
            <div class="flex flex-wrap justify-start sm:justify-end space-y-4 sm:space-y-0 items-center gap-x-2 mb-4">
              <div @click="toggleProfile()" v-click-outside="() => toggleProfile(true)" class="flex items-center gap-4">
                <img type="button"
                     data-dropdown-placement="bottom-start" class="w-10 h-10 rounded-full cursor-pointer"
                     src="../../static/img/no-image-man.png" alt="User dropdown">
                <div class="font-medium dark:text-white">
                  <div>{{ user.name }}</div>
                  <div class="text-sm text-gray-500 dark:text-gray-400">Joined in {{ user.created_at }}</div>
                </div>
              </div>
              <!-- User dropdown -->
              <div v-if="showMenu" class="absolute z-10 sm:right-20 top-16 sm:top-20 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                  <div class="font-medium truncate">{{ user.email }}</div>
                </div>
                <div class="py-1">
                  <button @click="openProfileDialog()"
                          class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                    Settings
                  </button>
                </div>
                <div class="py-1">
                  <button @click="authStore.logout()"
                     class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                    Sign out
                  </button>
                </div>
              </div>
            </div>
        </div>
        <div class="relative overflow-x-auto shadow-md rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 shadow-md">
                <thead class="border-y text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="col" class="px-6 py-3">
                        Word
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Transcription
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Translation
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Apple MacBook Pro 17"
                    </th>
                    <td class="px-6 py-4">
                        Silver
                    </td>
                    <td class="px-6 py-4">
                        Laptop
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Microsoft Surface Pro
                    </th>
                    <td class="px-6 py-4">
                        White
                    </td>
                    <td class="px-6 py-4">
                        Laptop PC
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Magic Mouse 2
                    </th>
                    <td class="px-6 py-4">
                        Black
                    </td>
                    <td class="px-6 py-4">
                        Accessories
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Apple Watch
                    </th>
                    <td class="px-6 py-4">
                        Silver
                    </td>
                    <td class="px-6 py-4">
                        Accessories
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        iPad
                    </th>
                    <td class="px-6 py-4">
                        Gold
                    </td>
                    <td class="px-6 py-4">
                        Tablet
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                    </td>
                </tr>
                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Apple iMac 27"
                    </th>
                    <td class="px-6 py-4">
                        Silver
                    </td>
                    <td class="px-6 py-4">
                        PC Desktop
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

  <modal v-if="showProfileDialog" @closeDialog="closeProfileDialog">
    <template #title>Edit Profile</template>
    <template #body>
      <form>
        <div class="flex flex-col">
          <input-text v-model="name" label="Name"/>
          <input-text v-model="email" label="Email"/>
          <input-text v-model="password" label="Password" type="password"/>
          <input-text v-model="passwordConfirm" label="Confirm password" type="password"/>
        </div>

        <div class="flex items-center space-x-4">
          <button-default @click.prevent="saveProfile" text="Save data"/>
          <button-cancel @click.prevent="closeProfileDialog"/>
        </div>
      </form>
    </template>
  </modal>
</template>

<script setup>
import {ref} from "vue";
import InputSearch from "../components/InputSearch.vue";
import InputDropdown from "../components/InputDropdown.vue";
import InputText from "../components/InputText.vue";
import ButtonDefault from "../components/ButtonDefault.vue";
import ButtonCancel from "../components/ButtonCancel.vue";
import Modal from "../components/Modal.vue";
import {useAuthStore} from "../stores/AuthStore.js";

const authStore = useAuthStore();

const user = JSON.parse(localStorage.getItem('authUser'))

const showMenu = ref(false)
const showProfileDialog = ref(false)

const name = ref('')
const email = ref('')
const password = ref('')
const passwordConfirm = ref('')

const toggleProfile = (clickOutside = false) => {
  if (clickOutside) {
    showMenu.value = false
  } else {
    showMenu.value = !showMenu.value
  }
}

const openProfileDialog = () => {
  showProfileDialog.value = true

  name.value = user.name
  email.value = user.email
}

const closeProfileDialog = () => {
  showProfileDialog.value = false
}

const saveProfile = () => {
  console.log('saving')
}

</script>
