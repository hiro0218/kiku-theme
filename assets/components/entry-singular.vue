<template>
  <div>
    <div class="container">
      <article class="entry">
        <header class="entry-header">
          <h1 class="entry-title" v-html="$options.filters.escapeBrackets(post.title)"/>
          <div class="entry-meta">
            <entry-time :date="post.date"/>
            <entry-category :categories="post.categories"/>
          </div>
        </header>
        <section class="entry-content" v-html="post.content"/>
        <template v-if="page_type === 'posts'">
          <amazon-product :amazon_product="post.amazon_product"/>
          <footer class="entry-footer">
            <entry-tag :tags="post.tags"/>
            <entry-share :title="post.title" :link="post.link"/>
            <entry-pager :pagers="post.attach.pagers"/>
          </footer>
        </template>
      </article>
    </div>

    <template v-if="page_type === 'posts'">
      <entry-related :relateds="post.attach.relateds"/>
    </template>
    <entry-breadcrumb :title="post.title" :categories="post.categories"/>
  </div>
</template>

<script>
import amazonProduct from '@components/amazon-product.vue';
import entryBreadcrumb from '@components/entry-breadcrumb.vue';
import entryCategory from '@components/entry-category.vue';
import entryPager from '@components/entry-pager.vue';
import entryRelated from '@components/entry-related.vue';
import entryShare from '@components/entry-share.vue';
import entryTag from '@components/entry-tag.vue';
import entryTime from '@components/entry-time.vue';

export default {
  name: 'EntrySingular',
  components: {
    amazonProduct,
    entryBreadcrumb,
    entryCategory,
    entryPager,
    entryRelated,
    entryShare,
    entryTag,
    entryTime,
  },
  props: {
    post: {
      type: Object,
      required: true,
    },
    page_type: {
      type: String,
      required: true,
    },
  },
};
</script>
