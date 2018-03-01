<template>
  <div v-cloak v-if="categories">
    <ul class="entry-category">
      <li v-for="(category, index) in categories" :key="index">
        <span v-if="index == 0" class="icon-folder"/><router-link :to="category.link">{{ category.name }}</router-link>
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
