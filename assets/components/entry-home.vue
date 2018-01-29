<template>
  <div class="container">
    <entry-list></entry-list>
    <home-content></home-content>
    <entry-pagination></entry-pagination>
  </div>
</template>

<script>
  import entryList from '@components/entry-list.vue';
  import entryPagination from '@components/entry-pagination.vue';

  export default {
    name: 'entry-home',
    components: {
      entryList,
      entryPagination,
    },
  };
</script>
