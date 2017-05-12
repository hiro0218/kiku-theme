<?php get_template_part('components/page-header'); ?>
<div class="entry-home card">
  <?php while (have_posts()) : the_post(); ?>
  <article class="entry-container">
    <a href="<?php the_permalink(); ?>">
      <?php get_template_part('partials/entry/thumbnail'); ?>
      <div class="entry-body">
        <header>
          <h2 class="entry-title"><?= esc_html(get_the_title()); ?></h2>
        </header>
        <div class="entry-summary"><?php the_excerpt(); ?></div>
        <footer>
          <?php get_template_part('partials/entry/meta'); ?>
        </footer>
      </div>
    </a>
  </article>
  <?php endwhile; ?>
</div>
