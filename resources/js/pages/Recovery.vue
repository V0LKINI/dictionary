<template>
    <div v-if="!isSent" class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 px-6">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                Recovery password
            </h2>
            <p class="mt-2 text-center text-sm leading-5 text-blue-500 max-w">
                <link-router text="Back to login" route="Login"/>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form>
                    <input-text
                        v-model="credentials" hint="Enter your email address to send the recovery link"
                        :v$="v$.credentials"
                        label="Email"
                    />
                    <button-default @click="recovery" text="Send email"/>
                </form>
            </div>
        </div>
    </div>

    <div v-if="isSent" class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 px-6">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                Success
            </h2>
            <p class="mt-2 text-center text-sm leading-5 text-gray-500 max-w">
                The link to password recovery has been successfully sent to your email account
            </p>
            <p class="mt-2 text-center text-sm leading-5 text-blue-500 max-w">
                <link-router text="Back to login" route="Login"/>
            </p>
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

//Validation
const rules = computed(() => ({
  credentials: {required, email},
}));

let state = reactive({
  credentials: "",
});

watch([credentials], () => {
  state.credentials = credentials;
});

const v$ = useVuelidate(rules, state)

const recovery = async () => {
    const result = await v$.value.$validate()

    if (result) {
        authStore.recovery(credentials.value).then(() => {
            if (!authStore.error) {
                isSent.value = true
            }
        });
    }
}

</script>
