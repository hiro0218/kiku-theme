<template>
  <footer v-if="$route.meta.type === 'post'" class="entry-footer">
    <tag :tags="post._embedded['wp:term'][1]"/>
    <share :title="post.title.rendered"/>
    <pager :pager="post.attach.pager"/>
    <related :related="post.attach.related"/>
  </footer>
</template>

<script>
import Tag from '@components/singular/meta/tag.vue';
import Share from '@components/singular/share.vue';
import Pager from '@components/singular/meta/pager.vue';
import Related from '@components/singular/meta/related.vue';

export default {
  name: 'EntryFooter',
  components: {
    Pager,
    Share,
    Tag,
    Related,
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
