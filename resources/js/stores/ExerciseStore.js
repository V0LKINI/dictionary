import {defineStore} from 'pinia'
import axios from "axios";

export const useExerciseStore = defineStore("ExerciseStore", () => {
  const saveAnswer = async (wordId) => {
    await axios.post('/api/exercises/saveAnswer', {
      wordId: wordId,
    }).then((r) => {
      let response = r.data;

      if (response.success) {
        console.log('seuccess')
      }
    });
  };

  return {
    saveAnswer
  }
})
