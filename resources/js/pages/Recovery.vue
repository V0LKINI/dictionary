<template>
    <div v-if="!isSent" class="recovery">
        <div class="recovery__container">
            <h2 class="recovery__title">{{ __('recovery.title') }}</h2>
            <p class="recovery__text"><link-router :text="__('recovery.login_button')" route="Login"/></p>
        </div>

        <div class="recovery__container">
            <div class="recovery__form">
                <form>
                    <input-text
                        v-model="credentials" :hint="__('recovery.email_hint')"
                        :v$="v$.credentials"
                        :server-error="serverErrors.credentials"
                        :label="__('recovery.email')"
                    />
                    <button-default @click="recovery" :text="__('recovery.send_mail_button')"/>
                </form>
            </div>
        </div>
    </div>

    <div v-if="isSent" class="recovery">
        <div class="recovery__container">
            <h2 class="recovery__title">{{ __('recovery.popup_title') }}</h2>
            <p class="recovery__text">{{ __('recovery.popup_text') }}</p>
            <p class="recovery__text"><link-router :text="__('recovery.popup_button')" route="Login"/></p>
        </div>
    </div>
</template>

<script setup>

import {watch, computed, reactive, ref} from "vue";
import {useAuthStore} from "../stores/AuthStore.js";
import ButtonDefault from "../components/ButtonDefault.vue";
import LinkRouter from "../components/LinkRouter.vue";
import InputText from "../components/InputText.vue";
import useVuelidate from '@vuelidate/core'
import {required, email} from '@vuelidate/validators'

const authStore = useAuthStore();

const credentials = ref('');
const isSent = ref(false)

const serverErrors = ref({
    'credentials': '',
});

//Validation
const rules = computed(() => ({
  credentials: {required, email},
}));

let state = reactive({
  credentials: "",
});

watch([credentials], () => {
  state.credentials = credentials;

  serverErrors.value.credentials = ''
});

const v$ = useVuelidate(rules, state)

const recovery = async () => {
    const result = await v$.value.$validate()

    if (result) {
        authStore.recovery(credentials.value).then(() => {
            if (!authStore.error) {
                isSent.value = true
            } else {
                let error = authStore.error;

                if (error.credentials) {
                    serverErrors.value.credentials = error.credentials[0]
                }
            }
        });
    }
}

</script>
