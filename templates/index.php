<?php if (!have_posts()) : ?>
<div class="mdl-cell mdl-cell--12-col mdl-card mdl-color--transparent">
  <?php Kiku\Components\the_alert('alert-warning', 'Sorry, no results were found.', 'kiku');  ?>
</div>
<?php else: ?>
  <?php get_template_part('partials/content', 'home'); ?>
<?php endif; ?>
