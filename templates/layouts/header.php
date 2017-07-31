<header class="header-navigation">
  <div class="container">
    <div class="header-title">
      <a href="<?= BLOG_URL; ?>"><?php bloginfo('name'); ?></a>
    </div>
    <?php if (App\display_sidebar()) : ?>
    <div class="header-menu">
      <input id="drawer-trigger" class="drawer-checkbox" type="checkbox">
      <label for="drawer-trigger" class="drawer-trigger">
        <i class="material-icons">menu</i>
      </label>
    </div>
    <?php endif; ?>
  </div>
</header>

<label for="drawer-trigger" class="drawer-overlay"></label>
<aside class="sidebar drawer" data-comes-from="left">
<?php get_template_part('layouts/sidebar'); ?>
</aside>
