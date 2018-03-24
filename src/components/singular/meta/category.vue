<template>
  <div v-cloak v-if="categories">
    <ul class="entry-category">
      <li v-for="(category, index) in categories" :key="index">
        <span v-if="index == 0" class="icon" v-html="iconFolder"/><router-link :to="category.link | formatBaseLink">{{ category.name }}</router-link>
      </li>
    </ul>
  </div>
</template>

<script>
import iconFolder from '@images/icon/folder.svg?inline';

export default {
  name: 'Category',
  props: {
    categories: {
      type: Array,
      default: () => [],
      required: false,
    },
  },
  data() {
    return {
      iconFolder,
    };
  },
};
</script>

<style lang="scss" scoped>
.icon /deep/ {
  display: inline-block;
  vertical-align: middle;
  width: 1rem;
  height: 1rem;
  margin-right: 0.25rem;

  svg {
    display: block;
    fill: $grey-400;
  }
}
</style>
