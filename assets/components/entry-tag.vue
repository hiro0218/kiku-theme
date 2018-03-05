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

<style lang="scss" scoped>
.entry-tag {
  margin-bottom: 1rem;

  ul {
    margin-bottom: 0;
    padding-left: 0;
    font-size: $font-size-xs;
    line-height: 2rem;
    list-style: none;
  }

  li {
    display: inline-block;
    margin: 0 0.5rem 0.5rem 0;
    &:last-child {
      margin-right: 0;
    }
  }

  a {
    padding: 0.5rem 0.7rem;
    border-radius: $radius-sm;
    background: $grey-100;
    color: $grey-700;
    &:hover {
      background: $grey-200;
    }
  }
}
</style>
