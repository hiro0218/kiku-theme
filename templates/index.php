<?php if (have_posts()) : ?>
  <?php get_template_part('partials/content', 'home'); ?>
<?php else: ?>
  <div class='alert alert-warning'>
    <?php echo __('No results found.'); ?>
  </div>
<?php endif; ?>
