<template>
  <div v-cloak v-if="related.length !== 0" class="related">
    <h2 class="related-heading">Related Posts</h2>
    <div class="entry-related">
      <div v-for="(entry,index) in related" :key="index" class="related-section">
        <router-link :to="entry.uri">
          <div class="related-image">
            <template v-if="entry.image">
              <img :src="entry.image">
            </template>
            <template v-else>
              <div class="no-image"/>
            </template>
          </div>
          <div class="related-title" v-html="$options.filters.escapeBrackets(entry.title)"/>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Related',
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
}

.entry-related {
  display: flex;
  overflow-x: scroll;

  a {
    display: block;
    width: 15rem;
    overflow: hidden;

    &:hover,
    &:focus {
      opacity: 0.6;
    }
  }
}

.related-section {
  & + & {
    margin-left: 2rem;
  }
}

.related-title {
  display: block;
  max-width: 100%;
  font-size: $font-size-sm;
  color: $grey-800;
  transition: color 0.3s $animation-curve-fast-out-slow-in;
}

.related-image {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 10rem;
  margin-bottom: 0.5rem;
  background: $grey-50;
  overflow: hidden;

  img {
    max-width: 85%;
    max-height: 85%;
  }

  .no-image {
    width: 4.5rem;
    height: 4.5rem;
    background: $grey-50 50% no-repeat;
    background-image: url('~@images/icon/photo.svg?fill=#{$grey-400} svg');
    background-size: cover;
  }
}
</style>
