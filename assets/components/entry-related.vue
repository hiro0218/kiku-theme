<template>
  <div class="related" v-cloak v-if="relateds.length !== 0">
    <div class="related-container container">
      <h2 class="related-heading">Related Posts</h2>
      <div class="entry-related">
        <div class="related-section" v-for="(related,index) in relateds" :key="index">
          <a :href="related.uri">
            <div class="related-image">
              <div class="image-sheet" :style="related.image ? 'background-image: url('+ related.image +')' : ''"/>
            </div>
            <div class="related-title" v-html="$options.filters.escapeBrackets(related.title)"/>
            <div class="related-description" v-html="$options.filters.escapeBrackets(related.description)"/>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'EntryRelated',
  props: {
    relateds: {
      type: Array,
      default: () => [],
      required: false,
    },
  },
};
</script>

<style lang="scss" scoped>
.related {
  margin-bottom: 2rem;
}

.related-container {
  padding: 0 1rem;
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

.related-heading {
  margin-top: 0;
  font-size: $font-size-h3;
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
