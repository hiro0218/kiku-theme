<article <?php post_class(); ?>>
  <div class="entry mdl-cell mdl-cell--12-col">
    <header>
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <?php get_template_part('partials/entry-meta'); ?>
    </header>
    <div class="entry-content">
      <?php the_content(); ?>
    </div>
    <footer>
      <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
    </footer>
  </div>
</article>
