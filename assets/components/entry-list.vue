<template>
  <div class="entry-list">
    <h1 class="page-header" v-html="$options.filters.escapeBrackets(pageTitle)"/>
    <template v-if="requestHeader.total === 0">
      <div class="alert alert-warning">
        No results found.
      </div>
    </template>

    <a :href="post.link" v-for="(post,index) in postLists" :key="index">
      <article class="entry-container">
        <div class="entry-image">
          <div class="image-container">
            <div class="image-sheet" :data-thumbnail-image="post.thumbnail"/>
          </div>
        </div>
        <div class="entry-body">
          <header class="entry-header">
            <h2 class="entry-title" v-html="$options.filters.escapeBrackets(post.title)"/>
          </header>
          <div class="entry-summary" v-html="$options.filters.escapeBrackets(post.excerpt)"/>
          <footer class="entry-footer">
            <div class="entry-meta">
              <ul class="entry-time">
                <li><span class="icon-update"/>{{ post.date | timeago }}</li>
              </ul>
            </div>
          </footer>
        </div>
      </article>
    </a>

  </div>
</template>

<script>
import { mapState } from 'vuex';
import ago from 's-ago';

export default {
  name: 'EntryList',
  filters: {
    timeago: function(date) {
      return ago(new Date(date));
    },
  },
  computed: mapState(['requestHeader', 'pageTitle', 'postLists']),
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

.page-header {
  margin: 0 0 0.5rem;
  font-size: $font-size-h3;
  line-height: 3rem;
  word-wrap: break-word;
}

.entry-list {
  overflow: hidden;

  a {
    display: block;
    padding: 1rem 0;
    color: inherit;
    & + a {
      border-top: 1px solid $grey-200;
    }
  }

  .entry-container {
    display: flex;

    &:hover {
      .entry-title {
        color: $blue-300;
      }
    }
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
    background-image: url('../images/no-image-128x128.png');
    background-size: cover;
  }
}
</style>
