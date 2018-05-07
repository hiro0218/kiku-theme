<template>
  <ul v-cloak v-if="categories" class="entry-category">
    <li v-for="(category, index) in categories" :key="index">
      <span v-if="index == 0" class="icon icon-folder"/><router-link :to="category.link | formatBaseLink">{{ category.name }}</router-link>
    </li>
  </ul>
</template>

<script>
export default {
  name: 'Category',
  props: {
    categories: {
      type: Array,
      default: () => [],
      required: false,
    },
  },
};
</script>

<style lang="scss" scoped>
.icon-folder {
  margin-right: 0.25rem;
  background-image: url('~@images/icon/folder.svg?fill=#{$grey-400} svg');
  @include svg-icon(1rem);
}

a {
  color: inherit;
  &:hover {
    color: inherit;
    text-decoration: underline;
  }
}

li {
  display: inline-flex;
  align-items: center;
  margin-bottom: 0;

  & + li::before {
    content: '';
    display: inline-block;
    background: url('~@images/icon/arrow_right.svg') no-repeat;
    background-size: contain;
    width: 1rem;
    height: 1rem;
    margin: 0 0.125rem;
  }
}
</style>
