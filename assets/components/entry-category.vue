<template>
  <div v-cloak v-if="categories">
    <ul class="entry-category">
      <li v-for="(category, index) in categories" :key="index">
        <span v-if="index == 0" class="icon-folder"/><a :href="category.link">{{ category.name }}</a>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'EntryCategory',
  props: {
    categories: {
      type: Array,
      default: () => [],
      required: false,
    },
  },
};
</script>
