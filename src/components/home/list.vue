<template>
  <div class="entry-list">
    <template v-if="requestHeader.total === 0">
      <div class="alert alert-warning">
        No results found.
      </div>
    </template>

    <router-link v-for="(post,index) in postLists" :to="post.link" :key="index">
      <article class="entry-container">
        <div class="entry-image">
          <div class="image-container">
            <div :data-thumbnail-image="post.thumbnail" class="image-sheet"/>
          </div>
        </div>
        <div class="entry-body">
          <header class="entry-header">
            <h2 class="entry-title" v-html="$options.filters.escapeBrackets(post.title.rendered)"/>
          </header>
          <div class="entry-summary" v-html="$options.filters.escapeBrackets(post.excerpt.rendered)"/>
          <footer class="entry-footer">
            <div class="entry-meta">
              <span class="icon-update"/>{{ post.date | formatDate }}
            </div>
          </footer>
        </div>
      </article>
    </router-link>

  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  name: 'EntryList',
  computed: {
    ...mapState({
      requestHeader: 'requestHeader',
      postLists: 'postLists',
    }),
  },
  watch: {
    postLists: function() {
      this.$nextTick(() => {
        this.setThumbnailImage();
      });
    },
  },
  methods: {
    setThumbnailImage: function() {
      const imageSheet = document.querySelectorAll('.image-sheet');
      const length = imageSheet.length;

      for (let i = 0; i < length; i++) {
        let sheet = imageSheet[i];
        let imageUrl = sheet.dataset.thumbnailImage;
        sheet.style.backgroundImage = null;

        if (!imageUrl) {
          continue;
        }

        let img = new Image();
        img.onload = (function(element, url) {
          element.style.backgroundImage = `url(${url})`;
        })(sheet, imageUrl);
        img.src = imageUrl;
        img = null;
      }
    },
  },
};
</script>

<style lang="scss" scoped>
$entry-thumbnail-size: 5rem; // 80px;

.entry-list {
  overflow: hidden;

  a {
    display: block;
    color: inherit;
    padding: 1.75rem 0;

    &:hover,
    &:focus {
      opacity: 0.6;
    }

    & + a {
      border-top: 1px solid $grey-200;
    }
  }

  .entry-container {
    display: flex;
  }

  .entry-image,
  .entry-body {
    display: flex;
    flex-basis: 0;
    flex-grow: 1;
    flex-shrink: 1;
  }

  .entry-image {
    flex: none;
    width: $entry-thumbnail-size;
    margin-right: 1rem;
  }

  .entry-body {
    flex-direction: column;
    justify-content: space-between;
    min-width: 0; // for flex and text-overflow
  }

  .entry-title,
  .entry-summary {
    margin: 0 0 0.5rem 0;
    line-height: 2rem;
    @include text-overflow;
  }

  .entry-title {
    transition: color 0.3s $animation-curve-fast-out-slow-in;
    font-size: $font-size-h3;
    font-weight: normal;
  }

  .entry-summary {
    color: $grey-600;
    font-size: $font-size-sm;
    word-break: break-all;
  }

  .entry-meta {
    color: $grey-400;
    text-align: right;
  }
}

// image
.entry-image {
  .image-container {
    width: $entry-thumbnail-size;
    height: $entry-thumbnail-size;
    border: 1px solid $grey-200;
    overflow: hidden;
  }

  .image-sheet {
    width: $entry-thumbnail-size;
    height: $entry-thumbnail-size;
    background: $grey-50 50% no-repeat;
    background-image: url('~@images/no-image-128x128.png');
    background-size: cover;
  }
}

.icon-update {
  margin-right: 0.25rem;
  background-image: url('~@images/icon/update.svg?fill=#{$grey-400} svg');
  @include svg-icon(1rem);
}
</style>
