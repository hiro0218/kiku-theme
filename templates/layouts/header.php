<header class="header-navigation">
  <div class="container">
    <div class="header-title">
      <a href="<?php echo BLOG_URL; ?>"><?php bloginfo('name'); ?></a>
    </div>
    <?php if (App\display_sidebar()) : ?>
    <div class="header-menu">
      <input id="drawer-trigger" class="drawer-checkbox" type="checkbox">
      <label for="drawer-trigger" class="drawer-trigger">
        <span class="icon-menu"></span>
      </label>
    </div>
    <?php endif; ?>
  </div>
</header>
