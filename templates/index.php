<?php if (have_posts()) : ?>
  <?php get_template_part('pages/content', 'home'); ?>
<?php else : ?>
  <div class="container">
    <div class='alert alert-warning'>
      <?php echo __('No results found.'); ?>
    </div>
  </div>
<?php endif; ?>
