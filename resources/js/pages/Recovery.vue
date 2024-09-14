<template>
    <div v-if="!isSent" class="page">
        <div class="container">
            <h2 class="h2">Forgot your password?</h2>
            <p class="text-small"><link-router text="Back to login" route="Login"/></p>
        </div>

        <div class="container">
            <div class="form">
                <form>
                    <input-text
                        v-model="credentials" hint="Enter your email address to send the recovery link"
                        :v$="v$.credentials"
                        :server-error="serverErrors.credentials"
                        label="Email"
                    />
                    <button-default @click="recovery" text="Send email"/>
                </form>
            </div>
        </div>
    </div>

    <div v-if="isSent" class="page">
        <div class="container">
            <h2 class="h2">Success</h2>
            <p class="text-small">The link to password recovery has been successfully sent to your email account</p>
            <p class="text-small"><link-router text="Back to login" route="Login"/></p>
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
