<div class="container">
  <template v-if="loaded === false">
    <?php get_template_part('partials/placeholder-home'); ?>
  </template>

  <div class="entry-list" v-cloak v-show="loaded">
    <h1 class="page-header"><?php echo App\title(); ?></h1>
    <a v-bind:href="post.link" v-for="(post,index) in posts">
      <article class="entry-container">
        <div class="entry-image" v-bind:data-thumbnail-image="post.thumbnail">
          <div class="image-container">
            <div class="image-sheet">
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

  <section>
    <?php echo get_option('kiku_insert_data_top_of_pagination'); ?>
    <?php get_template_part('partials/pagination', 'home'); ?>
  </section>
</div>
