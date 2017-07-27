<?php if (have_posts()) : ?>
  <?php get_template_part('partials/content', 'home'); ?>
  <?php get_template_part('partials/pagination'); ?>
<?php else: ?>
  <div class="column">
    <?php Kiku\Components\the_alert('alert-warning', __('No results found.'));  ?>
  </div>
<?php endif; ?>
