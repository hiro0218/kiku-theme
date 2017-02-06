<header class="header-navigation nav">
  <div class="header-title nav-left">
    <a class="nav-item" href="<?= BLOG_URL; ?>"><?php bloginfo('name'); ?></a>
  </div>
  <?php if (App\display_sidebar()) : ?>
  <div class="header-menu nav-center">
    <div class="nav-item">
      <input id="drawer-trigger" class="drawer-checkbox" type="checkbox">
      <label for="drawer-trigger" class="drawer-trigger">
        <i class="material-icons">menu</i>
      </label>
    </div>
  </div>
  <?php endif; ?>
</header>

<label for="drawer-trigger" class="drawer-overlay"></label>
<aside class="sidebar drawer" data-comes-from="left">
<?php get_template_part('layouts/sidebar'); ?>
</aside>
