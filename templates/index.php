<?php if (!have_posts()) : ?>
<div class="column  mdl-card">
  <?php Kiku\Components\the_alert('alert-warning', __('No results found.'));  ?>
</div>
<?php else: ?>
  <?php get_template_part('partials/content', 'home'); ?>
<?php endif; ?>
