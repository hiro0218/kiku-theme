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
        <div class="entry-image" :data-thumbnail-image="post.thumbnail">
          <div class="image-container">
            <div class="image-sheet"/>
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
import common from '@scripts/module/common';

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
        common.setThumbnailImage();
      });
    },
  },
};
</script>
