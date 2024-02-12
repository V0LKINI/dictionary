<template>
  <div class="mt-1">
    <label
        class="block text-gray-600 relative text-center border border-dashed border-2 rounded-lg border-gray-200 p-7 cursor-pointer opacity-80 hover:opacity-100"
        @dragover="dragover"
        @dragleave="dragleave"
        @drop="drop"
        :class="{'bg-white opacity-100': isDragging}"
    >
      <input id="file" type="file" @change="onChange" ref="file" accept=".jpg,.jpeg,.png" class="opacity-0 overflow-hidden absolute w-px h-px">

      <span class="flex align-center justify-center text-sm font-medium font-medium mb-3">
        <svg class="mr-5" width="29" height="30" viewBox="0 0 29 30" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M1.16602 21.667L8.80935 14.0237C9.43444 13.3988 10.2821 13.0477 11.166 13.0477C12.0499 13.0477 12.8976 13.3988 13.5227 14.0237L21.166 21.667M17.8327 18.3337L20.476 15.6903C21.1011 15.0654 21.9488 14.7144 22.8327 14.7144C23.7166 14.7144 24.5643 15.0654 25.1893 15.6903L27.8327 18.3337M17.8327 8.33366H17.8493M4.49935 28.3337H24.4993C25.3834 28.3337 26.2312 27.9825 26.8564 27.3573C27.4815 26.7322 27.8327 25.8844 27.8327 25.0003V5.00033C27.8327 4.11627 27.4815 3.26842 26.8564 2.6433C26.2312 2.01818 25.3834 1.66699 24.4993 1.66699H4.49935C3.61529 1.66699 2.76745 2.01818 2.14233 2.6433C1.5172 3.26842 1.16602 4.11627 1.16602 5.00033V25.0003C1.16602 25.8844 1.5172 26.7322 2.14233 27.3573C2.76745 27.9825 3.61529 28.3337 4.49935 28.3337Z" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <template v-if="file"><span class="pt-1">{{ file.name }}</span></template>
        <template v-else><span class="pt-1">Upload an image</span></template>
      </span>
    </label>
  </div>
</template>

<script>
export default {
  props: ['modelValue'],
  emits: ['update:modelValue'],
  data() {
    return {
      isDragging: false,
      file: false,
    };
  },
  methods: {
    onChange() {
      this.file = this.$refs.file.files[0];
      this.$emit('update:modelValue', this.file);
    },
    dragover(e) {
      e.preventDefault();
      this.isDragging = true;
    },
    dragleave() {
      this.isDragging = false;
    },
    drop(e) {
      e.preventDefault();
      this.$refs.file.files = e.dataTransfer.files;
      this.onChange();
      this.isDragging = false;
    },
  },
};
</script>
