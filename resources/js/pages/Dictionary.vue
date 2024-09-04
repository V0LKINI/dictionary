<template>
    <div class="flex flex-col h-screen bg-gray-50 py-4 sm:px-6 lg:px-8 px-6">
        <div class="flex flex-col flex-col-reverse h-12 sm:flex-row flex-wrap justify-between mb-4">
            <div class="flex flex-col sm:flex-row flex-wrap justify-start space-y-4 sm:space-y-0 items-center gap-x-2">
              <input-dropdown v-model="period" :options="periodOptions"/>
              <input-search v-model.lazy="searchInput" label="Search" placeholder="Search for words"/>
              <button-default @click.prevent="openWordDialog" text="Add new translation"/>
            </div>
            <div class="flex flex-wrap justify-start sm:justify-end space-y-4 sm:space-y-0 items-center gap-x-2">
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
        <div v-if="loadData" class="sticky top-1/3">
          <spinner/>
        </div>
        <div v-else-if="!loadData && words.length === 0" class="flex justify-center items-center flex-1 bg-white shadow-md rounded-lg">
          <div class=" max-w-screen-xl px-4 py-8 mx-auto lg:px-6 sm:py-16 lg:py-24">
            <div class="text-center">
              <h2 class="text-3xl font-extrabold leading-tight tracking-tight text-gray-900 sm:text-4xl">
                <p>Sorry, we didn't find any words =( </p>
                <p>To add new words, you need to follow a few steps:</p>
              </h2>
            </div>
            <div class="max-w-3xl p-5 mx-auto mt-8 space-y-5 border border-gray-100 rounded-lg bg-gray-50">
              <div class="border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                  1: Press "Add new translation" button at the top of the screen
                </h3>
              </div>
            </div>
            <div class="max-w-3xl p-5 mx-auto mt-8 space-y-5 border border-gray-100 rounded-lg bg-gray-50">
              <div class="border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                  2: Enter a word and its translation or use an auto translation icon
                </h3>
              </div>
            </div>
            <div class="max-w-3xl p-5 mx-auto mt-8 space-y-5 border border-gray-100 rounded-lg bg-gray-50">
              <div class="border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                  3: Click "Save" button
                </h3>
              </div>
            </div>
          </div>
        </div>
        <div v-else class="relative overflow-x-auto shadow-md rounded-lg">
          <div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 shadow-md">
              <thead class="border-y text-xs text-gray-700 uppercase bg-gray-50">
              <tr class="hover:bg-gray-50">
                <th @click="changeSort('word')" scope="col" class="cursor-pointer px-6 py-3">
                  <div class="flex gap-1">
                    Word
                    <svg v-if="sortBy.word === 'ASC'"  class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 14-4-4m4 4 4-4"/>
                    </svg>
                    <svg v-else-if="sortBy.word === 'DESC'" class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v13m0-13 4 4m-4-4-4 4"/>
                    </svg>
                  </div>
                </th>
                <th @click="changeSort('transcription')" scope="col" class="cursor-pointer px-6 py-3">
                  <div class="flex gap-1">
                    Transcription
                    <svg v-if="sortBy.transcription === 'ASC'"  class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 14-4-4m4 4 4-4"/>
                    </svg>
                    <svg v-else-if="sortBy.transcription === 'DESC'" class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v13m0-13 4 4m-4-4-4 4"/>
                    </svg>
                  </div>
                </th>
                <th @click="changeSort('translation')" scope="col" class="cursor-pointer px-6 py-3">
                  <div class="flex gap-1">
                    Translation
                    <svg v-if="sortBy.translation === 'ASC'" class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 14-4-4m4 4 4-4"/>
                    </svg>
                    <svg v-else-if="sortBy.translation === 'DESC'" class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v13m0-13 4 4m-4-4-4 4"/>
                    </svg>
                  </div>
                </th>
                <th @click="changeSort('date')" scope="col" class="cursor-pointer px-6 py-3">
                  <div class="flex gap-1">
                    Date
                    <svg v-if="sortBy.date === 'DESC'"  class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 14-4-4m4 4 4-4"/>
                    </svg>
                    <svg v-else-if="sortBy.date === 'ASC'" class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v13m0-13 4 4m-4-4-4 4"/>
                    </svg>
                  </div>
                </th>
                <th scope="col" class="px-6 py-3">
                  Actions
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
                <td class="px-6 py-3 flex">
                    <div @click.prevent="showWord(word.id)" class="p-1 cursor-pointer text-blue-600 rounded hover:bg-gray-200">
                      <svg class="w-6 h-6 text-blue-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"/>
                      </svg>
                    </div>
                    <div @click.prevent="deleteWord(word.id)" class="p-1 cursor-pointer text-blue-600 rounded hover:bg-gray-200">
                      <svg class="w-6 h-6 text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                      </svg>
                  </div>
                </td>
              </tr>
              </tbody>
            </table>
            <div v-if="pagination && pagination.lastPage > 1" class="flex-col px-4 py-7 w-full text-left">
              <nav>
                <ul class="inline-flex -space-x-px">
                  <li v-for="(link, index) of pagination.links">
                    <a v-if="link.url" href="#"
                       @click.prevent="entityPaginate(link.url)"
                       :class="classInputPagination(index, link.active, pagination)"
                       class="px-3 py-2 border border-gray-300">
                      <span v-html="link.label"></span>
                    </a>
                    <a v-else
                       :class="classInputPagination(index, link.active, pagination)"
                       class="px-3 py-2 ml-0 leading-tight  bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">
                      <span v-html="link.label"></span>
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
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
          <button-default @click.prevent="saveProfile" text="Save"/>
          <button-cancel @click.prevent="closeProfileDialog"/>
        </div>
      </form>
    </template>
  </modal>

  <modal v-if="showAddDialog" @closeDialog="closeWordDialog">
    <template #title>{{ entry && entry.id ? 'Edit translation' : 'Add new translation' }}</template>
    <template #body>
      <form>
        <div class="flex flex-col">
          <input-text :v$="v$.text" v-model="entry.text" label="Word or phrase"/>
        </div>

        <div class="flex flex-col">
          <input-text v-model="entry.transcription" label="Transcription"/>
        </div>

        <div class="flex flex-col">
          <input-text :v$="v$.translation" v-model="entry.translation" label="Translation"/>
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
import {computed, reactive, ref, watch} from "vue";
import InputSearch from "../components/InputSearch.vue";
import InputDropdown from "../components/InputDropdown.vue";
import InputText from "../components/InputText.vue";
import DropFile from "../components/DropFile.vue";
import ButtonDefault from "../components/ButtonDefault.vue";
import ButtonCancel from "../components/ButtonCancel.vue";
import Modal from "../components/Modal.vue";
import Spinner from "../components/Spinner.vue";
import {useAuthStore} from "../stores/AuthStore.js";
import axios from "axios";
import defaultProfileImage from "../../static/img/no-image-man.png";
import {required} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";

const showMenu = ref(false)
const showProfileDialog = ref(false)
const showAddDialog = ref(false)

const loadData = ref(true);

//Auth
const authStore = useAuthStore();
const user = ref(JSON.parse(localStorage.getItem('authUser')))
const image = ref(null);
const name = ref('')
const email = ref('')
const password = ref('')
const passwordConfirm = ref('')

//Words
const pagination = ref(null);
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
const entry = ref({
    'id': null,
    'text': '',
    'transcription': '',
    'translation': '',
})

const toggleProfile = (clickOutside = false) => {
  if (clickOutside) {
    showMenu.value = false;
  } else {
    showMenu.value = !showMenu.value;
  }
}

//Word validation
const rules = computed(() => ({
  text: {required},
  translation: {required},
}));

let state = reactive({
  text: "",
  translation: "",
});

watch(entry.value, () => {
  state.text = entry.value.text;
  state.translation = entry.value.translation;
});

const v$ = useVuelidate(rules, state)

//Words sort
const sortBy = reactive({
  word: "",
  transcription: "",
  translation: "",
  date: "DESC",
});

const changeSort = (field) => {
  let current = sortBy[field]

  sortBy.word = ''
  sortBy.transcription = ''
  sortBy.translation = ''
  sortBy.date = ''

  if (current === 'ASC') {
    sortBy[field] = 'DESC'
  } else if (current === '' && field === 'date') {
    sortBy[field] = 'DESC'
  } else {
    sortBy[field] = 'ASC'
  }

  getWords()
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
      closeProfileDialog();
    } else {
      error.value = response.error.message;
    }
  });
}

//Word dialog
const resetEntry = () => {
  entry.value.id = ''
  entry.value.text = ''
  entry.value.transcription = ''
  entry.value.translation = ''
}

const setEntry = (data) => {
  entry.value.id = data.id
  entry.value.text = data.text
  entry.value.transcription = data.transcription
  entry.value.translation = data.translation
}

const openWordDialog = () => {
  showAddDialog.value = true
}

const closeWordDialog = () => {
  showAddDialog.value = false
  resetEntry()
}

const saveWord = async () => {
  const result = await v$.value.$validate()

  if (result) {
    axios.post('/api/dictionary/save', entry.value).then((r) => {
      let response = r.data;

      if (response.success) {
        showAddDialog.value = false

        v$.value.$reset()

        resetEntry()
        getWords()
      } else {
        error.value = response.error.message
      }
    });
  }
}

const deleteWord = (id) => {
  axios.delete('/api/dictionary/' + id).then((r) => {
    let response = r.data;

    if (response.success) {
      getWords()
    } else {
      error.value = response.error.message
    }
  });
}

const showWord = (id) => {
  axios.get('/api/dictionary/' + id).then((r) => {
    let response = r.data;

    if (response.success) {
      setEntry(response.data)
      openWordDialog()
    } else {
      error.value = response.error.message
    }
  });
}

const getWords = (url = '/api/dictionary/list') => {
  loadData.value = true

  let sortColumn, sortDirection = null;

  for (const key in sortBy) {
    if (sortBy[key] === "ASC" || sortBy[key] === "DESC") {
      sortColumn = key;
      sortDirection = sortBy[key];
      break;
    }
  }

  let config = {
    params: {
      search: searchInput.value,
      period: period.value,
      sortColumn: sortColumn,
      sortDirection: sortDirection,
    },
  }

  axios.get(url, config).then((r) => {
    loadData.value = false

    let response = r.data;

    if (response.success) {
      words.value = response.data.items
      pagination.value = response.data.pagination
    } else {
      error.value = response.error.message
    }
  });
}

//get initial data
getWords()

//Search and filter
let timeoutActive = false;

watch([searchInput, period], () => {
    if (!timeoutActive) {
        timeoutActive = true;

        setTimeout(() => {
            getWords();
            timeoutActive = false;
        }, 500);
    }
});

//Pagination
const entityPaginate = (url) => {
  if (url) {
    getWords(url);
  }
}

//Pagination styles
const classInputPagination = (index, active, pagination) => ({
  'rounded-l-lg': index === 0,
  'rounded-r-lg': (index + 1) === pagination.links.length,
  'text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-700': active,
  'text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700': !active,
});
</script>
