<?php while (have_posts()) : the_post(); ?>
<?php
global $Schema;
$Schema->make_blog_posting();
?>
<article class="entry">
  <header>
    <h1 class="entry-title"><?= esc_html(get_the_title()); ?></h1>
    <?php get_template_part('partials/entry/meta'); ?>
  </header>
  <section class="entry-content">
    <?= get_the_post_thumbnail(null, 'full', ['class' => 'eyecatch']); ?>
    <?php the_content(); ?>
  </section>
  <footer>
    <?php get_template_part('partials/entry/paginated'); ?>
    <?php get_template_part('partials/entry/breadcrumb'); ?>
    <?php get_template_part('partials/entry/tag'); ?>
    <?php Kiku\Components\the_share(); ?>
  </footer>
</article>
<?php endwhile; ?>
