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
                    <input-text label="Email or phone"/>
                    <input-text label="Password" type="password"/>
                    <input-text label="Confirm password" type="password"/>
                    <button-default text="Sign up"/>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import ButtonDefault from "../../components/ButtonDefault.vue";
import LinkRouter from "../../components/LinkRouter.vue";
import InputText from "../../components/InputText.vue";
</script>
