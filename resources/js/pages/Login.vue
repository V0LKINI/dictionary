<template>
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 px-6">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                Sign in to your account
            </h2>
            <p class="mt-2 text-center text-sm text-gray-500 max-w">
                Not registered?
                <link-router text="Create an account." route="Register"/>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form>
                    <input-text v-model="credentials" :v$="v$.credentials" :server-error="serverErrors.credentials" label="Email"/>
                    <input-text v-model="password" :v$="v$.password" :server-error="serverErrors.password" label="Password" type="password"/>

                    <div class="mt-6 flex items-center justify-between">
                        <input-checkbox label="Remember me"/>
                        <div class="text-sm leading-5">
                            <link-router text="Forgot your password?" route="Recovery"/>
                        </div>
                    </div>

                    <button-default @click="login" text="Sign In"/>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>

import {watch, computed, reactive, ref} from "vue";
import {useAuthStore} from "../stores/AuthStore.js";
import ButtonDefault from "../components/ButtonDefault.vue";
import LinkDefault from "../components/LinkDefault.vue";
import LinkRouter from "../components/LinkRouter.vue";
import InputText from "../components/InputText.vue";
import InputCheckbox from "../components/InputCheckbox.vue";
import useVuelidate from '@vuelidate/core'
import {required, email} from '@vuelidate/validators'

const authStore = useAuthStore();
const credentials = ref('');
const password = ref('');

const serverErrors = ref({
    'credentials': '',
    'password': '',
});

//Validation
const rules = computed(() => ({
  credentials: {required, email},
  password: {required},
}));

let state = reactive({
  credentials: "",
  password: "",
});

watch([credentials, password], () => {
  state.credentials = credentials;
  state.password = password;

  serverErrors.value.credentials = ''
  serverErrors.value.password = ''
});

const v$ = useVuelidate(rules, state)

const login = async () => {
    const result = await v$.value.$validate()

    if (result) {
        authStore.login(credentials.value, password.value).then(() => {
            if (authStore.error) {
                if (authStore.error.email) {
                    serverErrors.value.credentials = authStore.error.email[0]
                }

                if (authStore.error.password) {
                    serverErrors.value.password = authStore.error.password[0]
                }
            }
        });
    }
}

</script>
