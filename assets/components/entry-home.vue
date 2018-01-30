<template>
  <div class="container">
    <entry-list/>
    <home-content/>
    <entry-pagination/>
  </div>
</template>

<script>
import entryList from '@components/entry-list.vue';
import entryPagination from '@components/entry-pagination.vue';

export default {
  name: 'EntryHome',
  components: {
    entryList,
    entryPagination,
  },
};
</script>
