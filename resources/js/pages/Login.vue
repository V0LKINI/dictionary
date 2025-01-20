<template>
    <div class="login">
        <div class="login__container">
            <h2 class="login__title">{{ __('login.title') }}</h2>
            <p class="login__text">{{ __('login.not_registered') }} <link-router :text="__('login.not_registered_link')" route="Register"/></p>
        </div>
        <div class="login__container">
            <div class="login__form">
                <form>
                    <input-text v-model="credentials" :v$="v$.credentials" :server-error="serverErrors.credentials" :label="__('login.label_email')"/>
                    <input-text v-model="password" :v$="v$.password" :server-error="serverErrors.password" :label="__('login.label_password')" type="password"/>
                    <div class="login__form-bottom">
                        <input-checkbox :label="__('login.remember_me_checkbox')"/>
                        <div class="login__form-link"><link-router :text="__('login.forgot_password_link')" route="Recovery"/></div>
                    </div>
                    <button-default @click="login" :text="__('login.sign_in_button')"/>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>

import {watch, computed, reactive, ref} from "vue";
import {useAuthStore} from "../stores/AuthStore.js";
import ButtonDefault from "../components/ButtonDefault.vue";
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
