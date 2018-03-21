<template>
  <header class="entry-header">
    <h1 class="entry-title" v-html="$options.filters.escapeBrackets(post.title.rendered)"/>
    <div class="entry-meta">
      <entry-time :date="post.date" :modified="post.modified"/>
      <entry-category :categories="post.categories"/>
    </div>
  </header>
</template>

<script>
import entryTime from '@components/entry-time.vue';
import entryCategory from '@components/entry-category.vue';

export default {
  name: 'EntryHeader',
  components: {
    entryTime,
    entryCategory,
  },
  props: {
    post: {
      type: Object,
      default: () => {},
      require: true,
    },
  },
};
</script>

<style lang="scss" scoped>
.entry-header {
  margin-bottom: 2rem;
  text-align: center;
}

.entry-title {
  font-weight: normal;
  word-wrap: break-word;
}
</style>
