<template>
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 px-6">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                Sign in to your account
            </h2>
            <p class="mt-2 text-center text-sm leading-5 text-blue-500 max-w">
                Or
                <link-router text="create a new one" route="Register"/>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form>
                    <input-text v-model="credentials" label="Email"/>
                    <input-text v-model="password" label="Password" type="password"/>

                    <div class="mt-6 flex items-center justify-between">
                        <input-checkbox label="Remember me"/>
                        <div class="text-sm leading-5">
                            <link-default text="Forgot your password?" href="#"/>
                        </div>
                    </div>

                    <button-default @click="login" text="Sign In"/>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>

import {ref} from "vue";
import {useAuthStore} from "../stores/AuthStore.js";
import ButtonDefault from "../components/ButtonDefault.vue";
import LinkDefault from "../components/LinkDefault.vue";
import LinkRouter from "../components/LinkRouter.vue";
import InputText from "../components/InputText.vue";
import InputCheckbox from "../components/InputCheckbox.vue";

const authStore = useAuthStore();
const credentials = ref('');
const password = ref('');

const login = () => {
    authStore.login(credentials.value, password.value)
}

</script>
