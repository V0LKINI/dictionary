<template>
 <div class="navigation">
  {{ t("message.hello") }}
  <exercises-button/>
  <profile/>
 </div>
</template>

<script setup>
  import Profile from "../components/Profile.vue";
  import ExercisesButton from "../components/ExercisesButton.vue";
  import { useI18n } from 'vue-i18n';

  const { t } = useI18n();
</script>