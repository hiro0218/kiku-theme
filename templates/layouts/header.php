<header class="header-navigation">
  <div class="container columns">
    <div class="header-title column is-11">
      <a href="<?= BLOG_URL; ?>"><?php bloginfo('name'); ?></a>
    </div>
    <?php if (App\display_sidebar()) : ?>
    <div class="column">
      <input id="off-canvas-trigger" class="off-canvas-checkbox" type="checkbox">
      <label for="off-canvas-trigger" class="off-canvas-trigger">
        <i class="material-icons">menu</i>
      </label>
    </div>
    <?php endif; ?>
  </div>
</header>

<label for="off-canvas-trigger" class="off-canvas-overlay"></label>
<aside class="sidebar off-canvas" data-comes-from="left">
<?php get_template_part('layouts/sidebar'); ?>
</aside>
