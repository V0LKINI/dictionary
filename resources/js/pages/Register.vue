<template>
    <div class="register">
        <div class="register__container">
            <h2 class="register__title">{{ __('register.title') }}</h2>
            <p class="register__text">{{ __('register.or') }} <link-router :text="__('register.login_link')" route="Login"/></p>
        </div>
        <div class="register__container">
            <div class="register__form">
                <form>
                    <input-text v-model="name" :label="__('register.form_name')"/>
                    <input-text v-model="credentials" :label="__('register.form_email')"/>
                    <input-text v-model="password" :label="__('register.form_password')" type="password"/>
                    <input-text v-model="passwordConfirm" :label="__('register.form_confirm_password')" type="password"/>
                    <button-default @click="register" :text="__('register.form_button')"/>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import ButtonDefault from "../components/ButtonDefault.vue";
import LinkRouter from "../components/LinkRouter.vue";
import InputText from "../components/InputText.vue";
import {useAuthStore} from "../stores/AuthStore.js";
import {ref} from "vue";

const authStore = useAuthStore();
const name = ref('');
const credentials = ref('');
const password = ref('');
const passwordConfirm = ref('');

const register = () => {
  authStore.register(name.value, credentials.value, password.value, passwordConfirm.value)
}
</script>
