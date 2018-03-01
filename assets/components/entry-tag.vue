<template>
  <div v-cloak v-if="tags.length !== 0" class="entry-tag">
    <ul>
      <li v-for="(tag, index) in tags" :key="index">
        <router-link :to="tag.link" itemprop="keywords">{{ tag.name }}</router-link>
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
