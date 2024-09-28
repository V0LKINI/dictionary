<template>
    <div class="register">
        <div class="register__container">
            <h2 class="register__title">Sign up a new account</h2>
            <p class="register__text">Or <link-router text="login to existed one" route="Login"/></p>
        </div>
        <div class="register__container">
            <div class="register__form">
                <form>
                    <input-text v-model="name" label="Name"/>
                    <input-text v-model="credentials" label="Email"/>
                    <input-text v-model="password" label="Password" type="password"/>
                    <input-text v-model="passwordConfirm" label="Confirm password" type="password"/>
                    <button-default @click="register" text="Sign up"/>
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
