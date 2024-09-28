<template>
 <div class="exercise">
  <div class="head-wrapper">
   <breadcrumbs/>
   <navigation/>
  </div>
  <div v-if="loadData" class="spinner-wrapper">
   <spinner/>
  </div>
  <div v-else class="exercise-wrapper">
   <div class="card">
    <div class="card__header">
     {{ sample.text }}
    </div>
    <div class="card__body">
     <div v-for="word in words"
          @click="checkAnswer(word)"
          class="card__answer"
          :class="{'card__answer-correct': word.result === true, 'card__answer-error': word.result === false}"
     >
       {{ word.translations }}
     </div>
     <button-cancel @click="nextSample" text="Skip"/>
     <button-default @click="nextSample" text="Next" :disabled="nextButtonDisabled"/>
    </div>
   </div>
  </div>
 </div>
</template>

<script setup>
  import Navigation from "../../layouts/Navigation.vue";
  import Breadcrumbs from "../../components/Breadcrumbs.vue";
  import axios from "axios";
  import {ref} from "vue";
  import Spinner from "../../components/Spinner.vue";
  import ButtonDefault from "../../components/ButtonDefault.vue";
  import ButtonCancel from "../../components/ButtonCancel.vue";

  const loadData = ref(false)
  const sample = ref(null)
  const words = ref([])
  const nextButtonDisabled = ref(true)

  const getSample = () => {
      loadData.value = true

      axios.get('/api/exercises/findTranslation/getData').then((r) => {
          loadData.value = false

          let response = r.data;

          if (response.success) {
            sample.value = response.data.sample
            words.value = response.data.words
          }
      });
  }

  const checkAnswer = (answer) => {
    let index = words.value.findIndex(element => element.id === answer.id);
    let result = answer.id === sample.value.id;

    if (result) {
      nextButtonDisabled.value = false
    }

    words.value[index].result = result
  }

  const nextSample = () => {
    nextButtonDisabled.value = true
    getSample()
  }

  //initial sample
  getSample()

</script>
