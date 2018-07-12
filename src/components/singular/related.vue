<template>
  <section v-cloak v-if="related.length !== 0" class="related container">
    <h2 class="related-heading">Related Posts</h2>
    <div class="entry-related">
      <div v-for="(entry,index) in related" :key="index" class="related-section">
        <router-link :to="entry.uri">
          <div class="related-image">
            <template v-if="entry.image">
              <img :data-src="entry.image" class="entry-thumbnail" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==">
            </template>
            <template v-else>
              <div class="no-image"/>
            </template>
          </div>
          <div class="related-title" v-html="$options.filters.escapeBrackets(entry.title)"/>
        </router-link>
      </div>
    </div>
  </section>
</template>

<script>
import lozad from 'lozad';

export default {
  name: 'Related',
  props: {
    related: {
      type: Array,
      default: () => [],
      required: false,
    },
  },
  watch: {
    related: function() {
      this.$nextTick(() => {
        this.loadImages();
      });
    },
  },
  mounted: function() {
    this.$nextTick(() => {
      this.loadImages();
    });
  },
  methods: {
    loadImages: function() {
      let images = document.querySelectorAll('[data-src]');
      if (images) {
        const observer = lozad(images);
        observer.observe();
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.related {
  margin-top: 2rem;
  margin-bottom: 2rem;
  &.container {
    padding: 0;
  }
}

.related-heading {
  font-weight: normal;
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
  text-align: center;
  color: $grey-800;
  transition: color 0.3s $animation-curve-fast-out-slow-in;
}

.related-image {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 10rem;
  margin-bottom: 1rem;
  background: $grey-50;
  overflow: hidden;
  user-select: none;

  .entry-thumbnail {
    max-width: 85%;
    max-height: 85%;
  }

  .no-image {
    width: 4.5rem;
    height: 4.5rem;
  }
}
</style>
