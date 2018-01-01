<?php while (have_posts()) : the_post(); ?>
<div class="container">
  <article class="entry">
    <header class="entry-header">
      <h1 class="entry-title"><?php echo esc_html(get_the_title()); ?></h1>
      <div class="entry-meta">
        <?php get_template_part('partials/entry-time'); ?>
        <?php get_template_part('partials/entry-category'); ?>
      </div>
    </header>
    <section class="entry-content">
      <?php the_content(); ?>
    </section>
    <?php get_template_part('partials/entry-paginated'); ?>
    <amazon-product :amazon_product="amazon_product"></amazon-product>
    <footer>
      <?php get_template_part('partials/entry-breadcrumb'); ?>
      <?php get_template_part('partials/entry-tag'); ?>
      <?php get_template_part('partials/entry-share'); ?>
    </footer>
  </article>
</div>
<aside class="attached-info">
  <section class="related">
    <entry-related :relateds="relateds"></entry-related>
  </section>

  <div class="pager">
    <entry-pager :pagers="pagers"></entry-pager>
  </div>
</aside>
<?php endwhile; ?>
