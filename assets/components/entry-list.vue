<template>
  <div class="entry-list">
    <h1 class="page-header" v-html="$options.filters.escapeBrackets(page_title)"></h1>
    <template v-if="total === 0">
      <div class='alert alert-warning'>
        No results found.
      </div>
    </template>

    <a v-bind:href="post.link" v-for="(post,index) in posts" v-bind:key="index">
      <article class="entry-container">
        <div class="entry-image" v-bind:data-thumbnail-image="post.thumbnail">
          <div class="image-container">
            <div class="image-sheet"></div>
          </div>
        </div>
        <div class="entry-body">
          <header class="entry-header">
            <h2 class="entry-title" v-html="$options.filters.escapeBrackets(post.title)"></h2>
          </header>
          <div class="entry-summary" v-html="$options.filters.escapeBrackets(post.excerpt)"></div>
          <footer class="entry-footer">
            <div class="entry-meta">
              <ul class="entry-time">
                <li><span class="icon-update"></span>{{ post.date | timeago }}</li>
              </ul>
            </div>
          </footer>
        </div>
      </article>
    </a>

  </div>
</template>

<script>
  import ago from 's-ago';
  import common from '@scripts/module/common';

  export default {
    name: 'entry-list',
    props: {
      total: {
        type: Number,
        default: -1,
        required: true,
      },
      posts: {
        type: Array,
        default: {},
        required: true,
      },
    },
    data() {
      return {
        page_title: WP.page_title,
      }
    },
    watch: {
      posts: function () {
        this.$nextTick(() => {
          common.setThumbnailImage();
        });
      },
    },
    filters: {
      timeago: function(date) {
        return ago(new Date(date));
      },
    },
  };
</script>
