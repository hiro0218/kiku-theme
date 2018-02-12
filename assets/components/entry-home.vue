<template>
  <div class="container">
    <entry-list/>
    <advertise :idName="'ads3'" :content="advertise.ads3.content" :script="advertise.ads3.script" />
    <entry-pagination/>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import entryList from '@components/entry-list.vue';
import advertise from '@components/advertise.vue';
import entryPagination from '@components/entry-pagination.vue';

export default {
  name: 'EntryHome',
  components: {
    entryList,
    advertise,
    entryPagination,
  },
  computed: mapState(['advertise']),
};
</script>
