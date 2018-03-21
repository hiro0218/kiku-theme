<template>
  <div v-cloak v-if="related.length !== 0" class="related">
    <h2 class="related-heading">Related Posts</h2>
    <div class="entry-related">
      <div v-for="(entry,index) in related" :key="index" class="related-section">
        <router-link :to="entry.uri">
          <div class="related-image">
            <div :style="entry.image ? 'background-image: url('+ entry.image +')' : ''" class="image-sheet"/>
          </div>
          <div class="related-title" v-html="$options.filters.escapeBrackets(entry.title)"/>
          <div class="related-description" v-html="$options.filters.escapeBrackets(entry.description)"/>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'EntryRelated',
  props: {
    related: {
      type: Array,
      default: () => [],
      required: false,
    },
  },
};
</script>

<style lang="scss" scoped>
.related {
  margin: 2rem 0;
}

.related-heading {
  text-align: center;
  font-weight: normal;
}

.entry-related {
  display: flex;
  overflow-x: scroll;

  a {
    display: block;
    width: 15rem;
    overflow: hidden;
  }
}

.related-section {
  &:hover {
    .related-title {
      color: $blue-300;
    }
  }
  & + & {
    margin-left: 2rem;
  }
}

.related-title {
  display: block;
  max-width: 100%;
  margin-bottom: 0.5rem;
  transition: color 0.3s $animation-curve-fast-out-slow-in;
  color: $grey-800;
  @include text-overflow;
}

.related-description {
  color: $grey-500;
  font-size: $font-size-xs;
  @include text-overflow;
}

.related-image {
  margin-bottom: 0.5rem;
  .image-sheet {
    height: 10rem;
    border: 1px solid $grey-200;
    background: $grey-50 50% no-repeat;
    background-image: url('../images/no-image.png');
    background-size: cover;
    overflow: hidden;
  }
}
</style>
