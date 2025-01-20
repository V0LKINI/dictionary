<template>
    <div class="recovery-confirm">
        <div v-if="!isLoaded">
            <spinner/>
        </div>

        <div v-else-if="isLoaded && isTokenCorrect && credentials && !isChanged">
            <div class="recovery-confirm__container">
                <div class="recovery-confirm__form">
                    <h2 class="recovery-confirm__title">{{ __('recovery_confirm.title') }}</h2>
                    <form>
                        <input-text v-model="password" :v$="v$.password" :label="__('recovery_confirm.password')" type="password"/>
                        <input-text v-model="passwordConfirm" :v$="v$.passwordConfirm" :label="__('recovery_confirm.password_confirm')" type="password"/>
                        <button-default @click="changePassword" :text="__('recovery_confirm.change_button')"/>
                    </form>
                </div>
            </div>
        </div>

        <div class="recovery-confirm__container">
            <h2 class="recovery-confirm__title">{{ __('recovery_confirm.popup_title') }}</h2>
            <p class="recovery-confirm__text">{{ __('recovery_confirm.popup_text') }}</p>
            <p class="recovery-confirm__text"><link-router :text="__('recovery_confirm.popup_button')" route="Login"/></p>
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
