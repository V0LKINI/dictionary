<template>
  <div v-if="pagination && pagination.lastPage > 1" class="pagination">
    <nav>
      <ul class="pagination__list">
        <li v-for="(link, index) of pagination.links" class="pagination__list-item">
          <a v-if="link.url"
             @click.prevent="onPaginate(link.url)"
             :class="classInputPagination(index, link.active, pagination)"
             class="default">
            <span v-html="link.label"></span>
          </a>
          <a v-else
             :class="classInputPagination(index, link.active, pagination)"
             class="default not-active">
            <span v-html="link.label"></span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script setup>
const props = defineProps({
    pagination: {type: Object, required: true},
    onPaginate: {type: Function, required: true},
});

const classInputPagination = (index, active, pagination) => ({
    'first': index === 0,
    'last': (index + 1) === pagination.links.length,
    'active': active,
});
</script>