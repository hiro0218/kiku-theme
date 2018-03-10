<template>
  <footer v-if="$route.meta.type === 'post'" class="entry-footer">
    <entry-tag :tags="post.tags"/>
    <entry-share :title="post.title.rendered"/>
    <entry-pager :pager="post.attach.pager"/>
    <entry-related :related="post.attach.related"/>
  </footer>
</template>

<script>
import entryTag from '@components/entry-tag.vue';
import entryShare from '@components/entry-share.vue';
import entryPager from '@components/entry-pager.vue';
import entryRelated from '@components/entry-related.vue';

export default {
  name: 'EntryFooter',
  components: {
    entryPager,
    entryShare,
    entryTag,
    entryRelated,
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
</style>
