<?php if (have_posts()) : ?>
  <entry-home></entry-home>
<?php else : ?>
  <div class="container">
    <div class='alert alert-warning'>
      <?php echo __('No results found.'); ?>
    </div>
  </div>
<?php endif; ?>
