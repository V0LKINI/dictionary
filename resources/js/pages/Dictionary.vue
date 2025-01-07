<template>
  <div class="dictionary">
    <div class="head-wrapper">
      <div class="filter">
        <input-dropdown v-model="period" :options="periodOptions"/>
        <input-search v-model.lazy="searchInput" label="Search" placeholder="Search for words"/>
        <button-default @click.prevent="openWordDialog" text="Add new entry"/>
      </div>
      <navigation/>
    </div>
    <div v-if="loadData" class="spinner-wrapper">
      <spinner/>
    </div>
    <div v-else-if="!loadData && words.length === 0" class="not-found-wrapper">
      <div class="not-found">
        <div class="not-found-header">
          <h2 class="h2">
            <p>Sorry, we didn't find any words =( </p>
            <p>To add new entries, you need to follow a few steps:</p>
          </h2>
        </div>
        <div class="not-found-stage">
          <div class="not-found-stage__text">
            <h3 class="h3">1: Press "Add new entry" button at the top of the screen</h3>
          </div>
        </div>
        <div class="not-found-stage">
          <div class="not-found-stage__text">
            <h3 class="h3">2: Enter a word and its translation or use an auto translation icon</h3>
          </div>
        </div>
        <div class="not-found-stage">
          <div class="not-found-stage__text">
            <h3 class="h3">3: Click "Save" button</h3>
          </div>
        </div>
      </div>
    </div>
    <div v-else class="table-wrapper">
      <table class="table">
        <thead class="table-head">
          <tr class="table-head__row">
            <th @click="changeSort('word')" class="table-head__column">
              <div class="table-head__column-content">
                Word
                <svg v-if="sortBy.word === 'ASC'" class="table-head__column-arrow" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 19V5m0 14-4-4m4 4 4-4"/>
                </svg>
                <svg v-else-if="sortBy.word === 'DESC'" class="table-head__column-arrow" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v13m0-13 4 4m-4-4-4 4"/>
                </svg>
              </div>
            </th>
            <th @click="changeSort('transcription')" class="table-head__column">
              <div class="table-head__column-content">
                Transcription
                <svg v-if="sortBy.transcription === 'ASC'" class="table-head__column-arrow" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 19V5m0 14-4-4m4 4 4-4"/>
                </svg>
                <svg v-else-if="sortBy.transcription === 'DESC'" class="table-head__column-arrow" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v13m0-13 4 4m-4-4-4 4"/>
                </svg>
              </div>
            </th>
            <th @click="changeSort('translation')" class="table-head__column">
              <div class="table-head__column-content">
                Translation
                <svg v-if="sortBy.translation === 'ASC'" class="table-head__column-arrow" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 19V5m0 14-4-4m4 4 4-4"/>
                </svg>
                <svg v-else-if="sortBy.translation === 'DESC'" class="table-head__column-arrow" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v13m0-13 4 4m-4-4-4 4"/>
                </svg>
              </div>
            </th>
            <th @click="changeSort('date')" class="table-head__column">
              <div class="table-head__column-content">
                Date
                <svg v-if="sortBy.date === 'DESC'" class="table-head__column-arrow" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 19V5m0 14-4-4m4 4 4-4"/>
                </svg>
                <svg v-else-if="sortBy.date === 'ASC'" class="table-head__column-arrow" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v13m0-13 4 4m-4-4-4 4"/>
                </svg>
              </div>
            </th>
            <th class="table-head__column">
              Actions
            </th>
          </tr>
        </thead>
        <tbody class="table-body">
        <tr v-for="word in words" class="table-body__row">
          <td class="table-body__column">{{ word.text }}</td>
          <td class="table-body__column">{{ word.transcription ?? '—' }}</td>
          <td class="table-body__column">{{ word.translations }}</td>
          <td class="table-body__column">{{ word.created_at }}</td>
          <td class="table-body__column">
            <div @click.prevent="showWord(word.id)" class="table-body__column-icon">
              <svg class="table-body__column-icon-show" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                   height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"/>
              </svg>
            </div>
            <div @click.prevent="deleteWord(word.id)" class="table-body__column-icon">
              <svg class="table-body__column-icon-delete" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                   width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18 17.94 6M18 18 6.06 6"/>
              </svg>
            </div>
          </td>
        </tr>
        </tbody>
      </table>
    </div>

    <div v-if="!loadData">
      <pagination :pagination="pagination" :on-paginate="entityPaginate"/>
    </div>
  </div>

  <modal v-if="showAddDialog" @closeDialog="closeWordDialog">
    <template #title>{{ entry && entry.id ? 'Edit entry' : 'Add new entry' }}</template>
    <template #body>
      <form class="word-form">
        <div class="word-form__item">
          <input-text :v$="v$.text" v-model="entry.text" label="Word or phrase"/>
        </div>
        <div class="word-form__item">
          <input-text v-model="entry.transcription" label="Transcription"/>
        </div>
        <div class="word-form__item">
          <input-text :v$="v$.translation" v-model="entry.translation" label="Translation"/>
        </div>
        <div class="word-form__item">
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
import Navigation from "../layouts/Navigation.vue";
import ButtonDefault from "../components/ButtonDefault.vue";
import ButtonCancel from "../components/ButtonCancel.vue";
import Modal from "../components/Modal.vue";
import Spinner from "../components/Spinner.vue";
import Pagination from "../components/Pagination.vue";
import axios from "axios";
import {required} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";

const showAddDialog = ref(false)
const loadData = ref(true);
const pagination = ref(null);
const words = ref([])
const searchInput = ref('')
const period = ref('')

const periodOptions = ref([
  {value: '', name: 'Selected period', selected: true},
  {value: 'day', name: 'Last day', selected: false},
  {value: 'week', name: 'Last week', selected: false},
  {value: 'month', name: 'Last month', selected: false},
  {value: 'year', name: 'Last year', selected: false}
]);

const entry = ref({
    'id': null,
    'text': '',
    'transcription': '',
    'translation': '',
})

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

//Word dialog
const resetEntry = () => {
  entry.value.id = ''
  entry.value.text = ''
  entry.value.transcription = ''
  entry.value.translation = ''

  v$.value.$reset()
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

//Paginate entries
const entityPaginate = (url) => {
  if (url) {
    getWords(url);
  }
}
</script>
