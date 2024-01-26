<template>
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 px-6">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                Sign up a new account
            </h2>
            <p class="mt-2 text-center text-sm leading-5 text-blue-500 max-w">
                Or
                <link-router text="login to existed one" route="Login"/>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
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
