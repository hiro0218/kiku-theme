<template>
  <div class="entry-list">
    <template v-if="requestHeader.total === 0">
      <div class="alert alert-warning">
        No results found.
      </div>
    </template>

    <a v-for="(post,index) in postLists" :key="index" href="javascript:void(0)" @click="transitionPage(index, post.link)">
      <article class="entry-container">
        <div class="entry-image">
          <template v-if="post.thumbnail">
            <img :data-src="post.thumbnail" class="entry-thumbnail" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==">
          </template>
          <template v-else>
            <div class="no-image"/>
          </template>
        </div>
        <div class="entry-body">
          <header class="entry-header">
            <h2 class="entry-title" v-html="$options.filters.escapeBrackets(post.title.rendered)"/>
          </header>
          <div class="entry-summary" v-html="$options.filters.escapeBrackets(post.excerpt.rendered)"/>
          <footer class="entry-footer">
            <div class="entry-time">
              <span class="icon-update"/>{{ post.date | formatDate }}
            </div>
          </footer>
        </div>
      </article>
    </a>

  </div>
</template>

<script>
import { mapState } from 'vuex';
import lozad from 'lozad';

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
        this.loadImages();
      });
    },
  },
  methods: {
    loadImages: function() {
      let images = document.querySelectorAll('[data-src]');

      if (images) {
        for (let i = 0; i < images.length; i++) {
          images[i].removeAttribute('data-loaded');
        }

        const observer = lozad(images);
        observer.observe();
      }
    },
    transitionPage: function(index, path) {
      this.$store.dispatch('setPost', this.postLists[index]).then(() => {
        this.$router.push({
          path: path,
        });
      });
    },
  },
};
</script>

<style lang="scss" scoped>
$entry-thumbnail-size: 5rem; // 80px;
$image-size: 8rem;
$text-color: $grey-500;

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

.entry-header,
.entry-summary {
  margin-bottom: 0.5rem;
}

.entry-image {
  display: flex;
  align-items: center;
  justify-content: center;
  height: $image-size;
  width: $image-size;
  background: $grey-50;
  overflow: hidden;
  user-select: none;

  .entry-thumbnail {
    max-width: 80%;
    max-height: 80%;
  }

  .no-image {
    width: 4rem;
    height: 4rem;
  }
}

.entry-body {
  flex: 1;
  margin-left: 1.5rem;
}

.entry-title {
  margin: 0;
  font-size: $font-size-h3;
  font-weight: normal;
}

.entry-summary {
  color: $grey-600;
  word-break: break-all;
}

.entry-time {
  color: $text-color;
  text-align: right;
}

.icon-update {
  margin-right: 0.25rem;
  background-image: url('~@images/icon/update.svg?fill=#{$text-color} svg');
  @include svg-icon(1rem);
}
</style>
