<template>
  <ul v-cloak v-if="categories" class="entry-category">
    <li v-for="(category, index) in categories" :key="index">
      <span v-if="index == 0" class="icon" v-html="iconFolder"/><router-link :to="category.link | formatBaseLink">{{ category.name }}</router-link>
    </li>
  </ul>
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

.entry-category {
  white-space: nowrap;
  overflow: scroll;
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
    background-size: 1rem;
    width: 1rem;
    height: 1rem;
    margin: 0 0.125rem;
  }
}
</style>
