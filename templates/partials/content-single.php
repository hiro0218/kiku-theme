<?php
global $Schema;
$Schema->make_blog_posting();
?>
<article class="entry">
  <template v-if="loaded">
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
  </template>
  <template v-else>
    <?php get_template_part('partials/placeholder-single'); ?>
  </template>
</article>

<aside id="article-attached-info">
  <?php get_template_part('partials/entry-related'); ?>
  <?php get_template_part('partials/entry-pager'); ?>
</aside>
