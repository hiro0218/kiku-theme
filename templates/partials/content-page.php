<?php while (have_posts()) : the_post(); ?>
<article class="entry card">
  <header>
    <h1 class="entry-title"><?= esc_html(get_the_title()); ?></h1>
    <?php get_template_part('partials/entry/meta'); ?>
  </header>
  <div class="entry-content">
    <?php the_content(); ?>
  </div>
  <footer>
    <?php get_template_part('partials/entry/breadcrumb'); ?>
  </footer>
</article>
<?php endwhile; ?>
