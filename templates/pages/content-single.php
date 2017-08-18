<?php
global $Schema;
$Schema->make_blog_posting();
?>
<template v-if="loaded === false">
  <article class="entry">
    <?php get_template_part('partials/placeholder-single'); ?>
  </article>
</template>

<?php while (have_posts()) : the_post(); ?>
<article class="entry" v-cloak v-show="loaded">
  <header>
    <h1 class="entry-title"><?php echo esc_html(get_the_title()); ?></h1>
    <div class="entry-meta">
      <?php get_template_part('partials/entry-time'); ?>
      <?php get_template_part('partials/entry-category'); ?>
    </div>
  </header>
  <section class="entry-content">
    <?php the_content(); ?>
  </section>
  <?php get_template_part('partials/amazon-product'); ?>
  <footer>
    <?php get_template_part('partials/entry-breadcrumb'); ?>
    <?php get_template_part('partials/entry-tag'); ?>
    <?php get_template_part('partials/entry-share'); ?>
  </footer>
</article>

<aside id="article-attached-info">
  <?php get_template_part('partials/entry-related'); ?>
  <?php get_template_part('partials/entry-pager'); ?>
</aside>
<?php endwhile; ?>
