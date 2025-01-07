<template>
  <div v-click-outside="() => toggleProfile(true)" class="profile">
    <div @click="toggleProfile()"  class="profile-info">
      <img type="button" data-dropdown-placement="bottom-start" class="profile-info__image"
           :src="user.image != null ? user.image : defaultProfileImage" alt="User avatar">
      <div>
        <div class="profile-info__name">{{ user.name }}</div>
        <div class="profile-info__joined">Joined in {{ user.created_at }}</div>
      </div>
    </div>
    <!-- User dropdown -->
    <div v-if="showMenu" class="profile-dropdown">
      <div class="profile-dropdown__email">
        <div class="profile-dropdown__email-text">{{ user.email }}</div>
      </div>
      <div class="profile-dropdown__item">
        <button @click="openProfileDialog()" class="profile-dropdown__item-button">
          <svg class="w-[20px] h-[20px] text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
               height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-width="2"
                  d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
          </svg>
          Profile
        </button>
      </div>
      <div class="profile-dropdown__item">
        <button @click="showLanguagesDropdown()" class="profile-dropdown__item-button">
          <svg class="w-[20px] h-[20px] text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
               height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m13 19 3.5-9 3.5 9m-6.125-2h5.25M3 7h7m0 0h2m-2 0c0 1.63-.793 3.926-2.239 5.655M7.5 6.818V5m.261 7.655C6.79 13.82 5.521 14.725 4 15m3.761-2.345L5 10m2.761 2.655L10.2 15"/>
          </svg>
          Language
        </button>
      </div>
      <div class="profile-dropdown__item">
        <button @click="authStore.logout()" class="profile-dropdown__item-button">
          <svg class="w-[20px] h-[20px] text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
               height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/>
          </svg>
          Sign out
        </button>
      </div>
    </div>

    <!-- Languages dropdown -->
   <div v-if="showLanguages" v-click-outside="() => hideLanguages()" class="languages-dropdown">
    <div @click="showMenuDropdown()" class="languages-dropdown__item">
     <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14 8-4 4 4 4"/>
     </svg>
     Back
    </div>
    <div @click="changeLanguages('en')" class="languages-dropdown__item">
     English
    </div>
    <div @click="changeLanguages('ru')"  class="languages-dropdown__item">
     Русский
    </div>
   </div>
  </div>

  <modal v-if="showProfileDialog" @closeDialog="closeProfileDialog">
    <template #title>Edit Profile</template>
    <template #body>
      <form>
        <div class="profile-form">
          <div class="profile-form__dropdown">
            <label for="file" class="profile-form__dropdown-label">Profile image</label>
            <template v-if="image && typeof image !== 'object'">
              <div class="profile-form__dropdown-image">
                <img :src="image" class="profile-form__dropdown-image-img" alt="profile-image">
                <button @click.prevent="deleteImage" class="profile-form__dropdown-image-button">
                  <svg class="profile-form__dropdown-image-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                       xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
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
        <div class="profile-form-buttons">
          <button-default @click.prevent="saveProfile" text="Save"/>
          <button-cancel @click.prevent="closeProfileDialog"/>
        </div>
      </form>
    </template>
  </modal>
</template>

<script setup>

import ButtonDefault from "./ButtonDefault.vue";
import Modal from "./Modal.vue";
import ButtonCancel from "./ButtonCancel.vue";
import InputText from "./InputText.vue";
import DropFile from "./DropFile.vue";
import defaultProfileImage from "../../static/img/no-image-man.png";
import {useAuthStore} from "../stores/AuthStore.js";
import {ref} from "vue";

const showProfileDialog = ref(false)
const showLanguages = ref(false)
const showMenu = ref(false)

//Auth
const authStore = useAuthStore();
const user = ref(JSON.parse(localStorage.getItem('authUser')))
const image = ref(null);
const name = ref('')
const email = ref('')
const password = ref('')
const passwordConfirm = ref('')

const toggleProfile = (clickOutside = false) => {
  if (clickOutside) {
    showMenu.value = false;
  } else {
    showMenu.value = !showMenu.value;
  }
}

const showMenuDropdown = () => {
  showLanguages.value = false
  showMenu.value = true;
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

//Languages dialog
const showLanguagesDropdown = () => {
  showLanguages.value = true;
  showMenu.value = false;
}

const hideLanguages = () => {
  showLanguages.value = false;
}

const changeLanguages = (code) => {
  //Todo change language logic
}


</script>