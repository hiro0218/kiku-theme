<?php if (!have_posts()) : ?>
<div class="mdl-card mdl-color--transparent">
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
</div>
<?php endif; ?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('partials/content-search'); ?>
<?php endwhile; ?>
