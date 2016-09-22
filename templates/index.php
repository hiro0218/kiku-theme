<?php if (!have_posts()) : ?>
  <div class="mdl-cell mdl-cell--12-col mdl-card mdl-color--transparent">
    <div class="alert alert-warning">
      <?php _e('Sorry, no results were found.', 'sage'); ?>
    </div>
  </div>
<?php else: ?>
  <div class="article-container mdl-cell mdl-cell--12-col">
    <?php get_template_part('partials/page-header'); ?>
    <?php while (have_posts()) : the_post(); ?>
      <?php get_template_part('partials/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
    <?php endwhile; ?>
  </div>
<?php endif; ?>
