<article class="entry mdl-cell mdl-cell--12-col">
  <header>
    <h1 class="entry-title"><?php the_title(); ?></h1>
    <?php get_template_part('partials/entry-meta'); ?>
  </header>
  <div class="entry-content">
    <?php the_content(); ?>
  </div>
  <footer>
    <nav>
      <?php get_template_part('partials/entry/breadcrumb'); ?>
    </nav>
  <?php global $Entry;
      $similar = $Entry->get_similar_posts();
      if( !empty($similar) ): ?>
    <section class="entry-similar">
      <h2><?php _e('Related Articles', 'kiku'); ?></h2>
      <ul>
      <?php foreach($similar as $post): ?>
        <li><a href="<?= $post['uri']; ?>"><?= $post['title']; ?></a></li>
      <?php endforeach; ?>
      </ul>
    </section>
  <?php endif; ?>
  </footer>
</article>
<nav class="mdl-cell mdl-cell--12-col"><?php Kiku\Components\the_pager(); ?></nav>
