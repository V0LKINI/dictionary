<template>
    <div class="min-h-screen bg-gray-50 flex flex-col py-6 sm:px-6 lg:px-8 px-6">
        <div class="flex flex-column flex-col-reverse sm:flex-row  flex-wrap  justify-between">
            <div class="flex flex-column sm:flex-row flex-wrap justify-start space-y-4 sm:space-y-0 items-center gap-x-2 mb-4">
              <input-dropdown v-model="period" :options="periodOptions"/>
              <input-search v-model="searchInput" label="Search" placeholder="Search for words"/>
              <button-default @click.prevent="openWordDialog" text="Add new translation"/>
            </div>
            <div class="flex flex-wrap justify-start sm:justify-end space-y-4 sm:space-y-0 items-center gap-x-2 mb-4">
              <div @click="toggleProfile()" v-click-outside="() => toggleProfile(true)" class="flex items-center gap-4">
                <img type="button"
                     data-dropdown-placement="bottom-start" class="w-10 h-10 rounded-full cursor-pointer object-cover"
                     :src="user.image != null ? user.image : defaultProfileImage" alt="User dropdown">
                <div class="font-medium">
                  <div>{{ user.name }}</div>
                  <div class="text-sm text-gray-500">Joined in {{ user.created_at }}</div>
                </div>
              </div>
              <!-- User dropdown -->
              <div v-if="showMenu" class="absolute z-10 sm:right-20 top-16 sm:top-20 bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                <div class="px-4 py-3 text-sm text-gray-900">
                  <div class="font-medium truncate">{{ user.email }}</div>
                </div>
                <div class="py-1">
                  <button @click="openProfileDialog()"
                          class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Settings
                  </button>
                </div>
                <div class="py-1">
                  <button @click="authStore.logout()"
                     class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Sign out
                  </button>
                </div>
              </div>
            </div>
        </div>
        <div class="relative overflow-x-auto shadow-md rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 shadow-md">
                <thead class="border-y text-xs text-gray-700 uppercase bg-gray-50">
                  <tr class="hover:bg-gray-50">
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
                          Date
                      </th>
                      <th scope="col" class="px-6 py-3">
                          Action
                      </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="word in words" class="bg-white border-b hover:bg-gray-50">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                      {{ word.text }}
                    </th>
                    <td class="px-6 py-4">
                      {{ word.transcription ?? '—' }}
                    </td>
                    <td class="px-6 py-4">
                      {{ word.translations }}
                    </td>
                    <td class="px-6 py-4">
                      {{ word.created_at }}
                    </td>
                    <td class="px-6 py-4">
                      <a @click.prevent="deleteWord(word.id)" class="cursor-pointer font-medium text-blue-600 hover:underline">Delete</a>
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
        <div class="flex flex-col mt-6">
          <div class="sm:col-span-2">
            <label for="file" class="block text-sm font-medium leading-5 text-gray-700">Profile image</label>
            <template v-if="image && typeof image !== 'object'">
              <div class="relative inline-block bg-white p-5 mb-3">
                <img :src="image" width="100" alt="">
                <button @click.prevent="deleteImage" class="flex text-primary-500 absolute left-0 bottom-0 hover:bg-primary-700">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                  </svg>
                </button>
              </div>
            </template>
            <drop-file v-model="image"/>
          </div>
          <input-text v-model="name" label="Name"/>
          <input-text v-model="email" label="Email"/>
          <input-text v-model="password" label="Password" type="password" autocomplete="new-password"/>
          <input-text v-model="passwordConfirm" label="Confirm password" type="password" autocomplete="new-password"/>
        </div>

        <div class="flex items-center space-x-4">
          <button-default @click.prevent="saveProfile" text="Save data"/>
          <button-cancel @click.prevent="closeProfileDialog"/>
        </div>
      </form>
    </template>
  </modal>

  <modal v-if="showAddDialog" @closeDialog="closeWordDialog">
    <template #title>Add new translation</template>
    <template #body>
      <form>
        <div class="flex flex-col">
          <input-text v-model="text" label="Word or phrase"/>
        </div>

        <div class="flex flex-col">
          <input-text v-model="translation" label="Translation"/>
        </div>

        <div class="flex items-center space-x-4">
          <button-default @click.prevent="saveWord" text="Save"/>
          <button-cancel @click.prevent="closeWordDialog"/>
        </div>
      </form>
    </template>
  </modal>
</template>

<script setup>
import {ref, watch} from "vue";
import InputSearch from "../components/InputSearch.vue";
import InputDropdown from "../components/InputDropdown.vue";
import InputText from "../components/InputText.vue";
import DropFile from "../components/DropFile.vue";
import ButtonDefault from "../components/ButtonDefault.vue";
import ButtonCancel from "../components/ButtonCancel.vue";
import Modal from "../components/Modal.vue";
import {useAuthStore} from "../stores/AuthStore.js";
import axios from "axios";
import defaultProfileImage from "../../static/img/no-image-man.png";

const showMenu = ref(false)
const showProfileDialog = ref(false)
const showAddDialog = ref(false)

//Auth
const authStore = useAuthStore();
const user = ref(JSON.parse(localStorage.getItem('authUser')))
const image = ref(null);
const name = ref('')
const email = ref('')
const password = ref('')
const passwordConfirm = ref('')

//Words
const words = ref([])
const searchInput = ref('')

const period = ref('')

const periodOptions = ref([
  {value: '', name: 'Select a period', selected: true},
  {value: 'day', name: 'Last day', selected: false},
  {value: 'week', name: 'Last week', selected: false},
  {value: 'month', name: 'Last month', selected: false},
  {value: 'year', name: 'Last year', selected: false}
]);

//Word adding form
const text = ref('')
const translation = ref('')

const toggleProfile = (clickOutside = false) => {
  if (clickOutside) {
    showMenu.value = false;
  } else {
    showMenu.value = !showMenu.value;
  }
}

//Profile dialog
const openProfileDialog = () => {
  showProfileDialog.value = true;
  setUserFields();
}

const setUserFields = () => {
  image.value = user.value.image;
  name.value = user.value.name;
  email.value = user.value.email;
}

const closeProfileDialog = () => {
  showProfileDialog.value = false;
}

const deleteImage = () => {
  image.value = '';
}

const saveProfile = () => {
  let formData = new FormData();

  formData.append('_method', 'put');
  formData.append('image', image.value);
  formData.append('id', user.value.id);
  formData.append('name', name.value);
  formData.append('email', email.value);
  formData.append('password', password.value);
  formData.append('password_confirm', passwordConfirm.value);

  axios.post('/api/profile/', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      }
    }
  ).then((r) => {
    let response = r.data;

    if (response.success) {
      user.value = response.data.user;
      setUserFields();
      localStorage.setItem('authUser', JSON.stringify(response.data.user));
    } else {
      error.value = response.error.message;
    }
  }).catch((e) => {
    console.log(e);
  });
}

//Word dialog
const openWordDialog = () => {
    showAddDialog.value = true
}

const closeWordDialog = () => {
    showAddDialog.value = false
}

const getTranslation = () => {

}

const saveWord = () => {
  axios.post('/api/dictionary/save', {
    text: text.value,
    translation: translation.value,
  }).then((r) => {
    let response = r.data;

    if (response.success) {
      showAddDialog.value = false
      getWords()
    } else {
      error.value = response.error.message
    }
  }).catch((e) => {
    console.log(e);
  });
}

const deleteWord = (id) => {
  axios.delete('/api/dictionary/' + id).then((r) => {
    let response = r.data;

    if (response.success) {
      getWords()
    } else {
      error.value = response.error.message
    }
  }).catch((e) => {
    console.log(e);
  });
}

const getWords = () => {
  let config = {
    params: {
      search: searchInput.value,
      period: period.value,
    },
  }

  axios.get('/api/dictionary/list', config).then((r) => {
    let response = r.data;

    if (response.success) {
      words.value = response.data
    } else {
      error.value = response.error.message
    }
  }).catch((e) => {
    console.log(e);
  });
}

watch([searchInput, period], () => {
  getWords()
})

//get initial data
getWords()

</script>
