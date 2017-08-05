<?php if (have_posts()) : ?>
  <?php get_template_part('partials/content', 'home'); ?>
  <?php get_template_part('partials/pagination', 'home'); ?>
<?php else: ?>
  <?php Kiku\Components\the_alert('alert-warning', __('No results found.'));  ?>
<?php endif; ?>
