<template>
  <div class="entry-tag" v-cloak v-if="tags.length !== 0">
    <ul>
      <li v-for="(tag, index) in tags" :key="index">
        <a :href="tag.link" itemprop="keywords">{{ tag.name }}</a>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'EntryTag',
  props: {
    tags: {
      type: Array,
      default: () => [],
      required: false,
    },
  },
};
</script>
