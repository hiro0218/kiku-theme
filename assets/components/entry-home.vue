<template>
  <div class="container">
    <entry-list :total="total" :posts="posts"></entry-list>
    <home-content></home-content>
    <entry-pagination :totalpages="totalpages"></entry-pagination>
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
    props: {
      total: {
        type: Number,
        default: -1,
        required: true,
      },
      posts: {
        type: Array,
        default: {},
        required: true,
      },
      totalpages: {
        type: Number,
        default: 0,
        required: true,
      },
    },
  };
</script>
