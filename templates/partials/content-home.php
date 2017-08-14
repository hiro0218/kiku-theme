<template v-if="loaded">
  <h1 class="page-header"><?= App\title(); ?></h1>
  <div class="entry-list">
    <a v-bind:href="post.link" v-for="(post,index) in posts">
      <article class="entry-container">
        <div class="entry-image" v-bind:data-thumbnail-image="post.thumbnail">
          <div class="image-container">
            <div class="image-sheet">
              <span class="icon icon-image"></span>
            </div>
          </div>
        </div>
        <div class="entry-body">
          <header>
            <h2 class="entry-title" v-html="$options.filters.escapeBrackets(post.title)"></h2>
          </header>
          <div class="entry-summary" v-html="$options.filters.escapeBrackets(post.excerpt)"></div>
          <footer>
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
  <?php get_template_part('partials/pagination', 'home'); ?>
</template>
<template v-else>
  <?php get_template_part('partials/placeholder-home'); ?>
</template>
