<template>
  <div class="related">
    <div class="related-container container" v-cloak v-if="relateds">
      <h2 class="related-heading">Related Posts</h2>
      <div class="entry-related">
        <div class="related-section" v-for="(related,index) in relateds" v-bind:key="index">
          <a v-bind:href="related.uri">
            <div class="related-image">
              <div class="image-sheet" v-bind:style="related.image ? 'background-image: url('+ related.image  +')' : ''"></div>
            </div>
            <div class="related-title" v-html="$options.filters.escapeBrackets(related.title)"></div>
            <div class="related-description" v-html="$options.filters.escapeBrackets(related.description)"></div>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'entry-related',
    props: {
      relateds: {
        type: Array,
        default: [],
        required: false,
      },
    },
  };
</script>

<style lang="scss" scoped>
.related {
  height: 18rem;
  margin-bottom: 1rem;
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
  margin-bottom: .5rem;
  transition: color .3s $animation-curve-fast-out-slow-in;
  color: $grey-800;
  @include text-overflow;
}

.related-description {
  color: $grey-500;
  font-size: $font-size-xs;
  @include text-overflow;
}

.related-image {
  margin-bottom: .5rem;
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
