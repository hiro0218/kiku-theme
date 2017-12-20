<template>
  <div>
    <a v-bind:href="post.link" v-for="(post,index) in lists" v-bind:key="index">
      <article class="entry-container">
        <div class="entry-image" v-bind:data-thumbnail-image="post.thumbnail">
          <div class="image-container">
            <div class="image-sheet">
            </div>
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
                <li><span class="icon-update"></span>{{post.date.timeAgo}}</li>
              </ul>
            </div>
          </footer>
        </div>
      </article>
    </a>
  </div>
</template>

<script>
  export default {
    name: 'entry-list',
    props: {
      lists: {
        type: Array,
        default: [],
        required: true,
      }
    },
    methods: {},
    mounted: function () {},
    filters: {
      escapeBrackets: function(text) {
        return text.replace(/</g, '&lt;').replace(/>/g, '&gt;');
      },
    },
  }
</script>
