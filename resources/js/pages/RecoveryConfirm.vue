<template>
    <div  class="min-h-screen flex flex-col justify-center">
        <div v-if="!isLoaded">
            <spinner/>
        </div>

        <div v-else-if="isLoaded && isTokenCorrect && credentials && !isChanged">
            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                    <h2 class="text-center text-3xl leading-9 font-extrabold text-gray-900">
                        Enter new password
                    </h2>
                    <form>
                        <input-text v-model="password" :v$="v$.password" label="Password" type="password"/>
                        <input-text v-model="passwordConfirm" :v$="v$.passwordConfirm" label="Password confirm" type="password"/>

                        <button-default @click="changePassword" text="Change password"/>
                    </form>
                </div>
            </div>
        </div>

        <div v-else class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 px-6">
            <div class="sm:mx-auto sm:w-full sm:max-w-md">
                <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                    Success
                </h2>
                <p class="mt-2 text-center text-sm leading-5 text-blue-500 max-w">
                    Your password has been successfully changed
                </p>
                <p class="mt-2 text-center text-sm leading-5 text-blue-500 max-w">
                    <link-router text="Back to login" route="Login"/>
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>

import {computed, reactive, ref, watch, onMounted} from "vue";
import Spinner from "../components/Spinner.vue";
import LinkRouter from "../components/LinkRouter.vue";
import ButtonDefault from "../components/ButtonDefault.vue";
import InputText from "../components/InputText.vue";
import {sameAs, required} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import {useRoute} from 'vue-router'
import {useAuthStore} from "../stores/AuthStore.js";

const route = useRoute()

const authStore = useAuthStore();

const isLoaded = ref(false)
const isTokenCorrect = ref(false)
const isChanged = ref(false)

const credentials = ref('');
const password = ref('');
const passwordConfirm = ref('');

//Validation
const rules = computed(() => ({
    password: {required},
    passwordConfirm: {required, sameAs: sameAs(password)},
}));

let state = reactive({
    password: "",
    passwordConfirm: "",
});

watch([password, passwordConfirm], () => {
    state.password = password;
    state.passwordConfirm = passwordConfirm;
});

const v$ = useVuelidate(rules, state)

const verifyToken = async () => {
    let token = route.query.token

    authStore.verifyToken(token).then(() => {
        if (!authStore.error && authStore.credentials) {
            credentials.value = authStore.credentials
            isTokenCorrect.value = true
        }

        isLoaded.value = true
    });
}

onMounted(() => {
    verifyToken()
})

const changePassword = async () => {
    const result = await v$.value.$validate()

    if (result) {
        authStore.changePassword(credentials.value, password.value, passwordConfirm.value).then(() => {
            if (!authStore.error) {
                isChanged.value = true
            }
        });
    }
}

</script>
